<?php

namespace backend\modules\sales\controllers;

use Yii;
use common\models\SalesInvoiceDetails;
use common\models\SalesInvoiceDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SalesInvoiceMaster;
use common\models\SalesInvoiceMasterSearch;
use common\models\BusinessPartner;

/**
 * SalesInvoiceDetailsController implements the CRUD actions for SalesInvoiceDetails model.
 */
class SalesInvoiceDetailsController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SalesInvoiceDetails models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SalesInvoiceMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesInvoiceDetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = SalesInvoiceMaster::findOne(['id' => $id]);
        $sales_details = SalesInvoiceDetails::findAll(['sales_invoice_master_id' => $id]);
        return $this->render('view', [
                    'model' => $model,
                    'sales_details' => $sales_details,
        ]);
    }

    /**
     * Creates a new SalesInvoiceDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SalesInvoiceDetails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SalesInvoiceDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SalesInvoiceDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesInvoiceDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesInvoiceDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SalesInvoiceDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($estimate = NULL) {
        $model = new SalesInvoiceDetails();
        $model_sales_master = new SalesInvoiceMaster();
        if ($model_sales_master->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model_sales_master = $this->SaveSalesMaster($model_sales_master, $data);
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model_sales_master->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem creating new invoice. Please try again.");
            }
            return $this->redirect(['add']);
        }
        return $this->render('add', [
                    'model' => $model,
                    'model_sales_master' => $model_sales_master,
        ]);
    }

    public function SaveSalesMaster($model_sales_master, $data) {
        $model_sales_master->sales_invoice_date = date("Y-m-d H:i:s");
        $model_sales_master->po_date = date("Y-m-d", strtotime(str_replace('/', '-', $model_sales_master->po_date)));
        $model_sales_master->salesman = $data['SalesInvoiceMaster']['salesman'];
        $model_sales_master->reference = $data['SalesInvoiceMaster']['reference'];
        $model_sales_master->general_terms = $data['SalesInvoiceMaster']['general_terms'];
        if ($data['order_sub_total'] > 0) {
            $model_sales_master->amount = $data['amount_without_tax'];
            $model_sales_master->tax_amount = $data['tax_sub_total'];
            $model_sales_master->order_amount = $data['order_sub_total'];
            $model_sales_master->cash_amount = $data['cash_amount'];
            $model_sales_master->card_amount = $data['card_amount'];
            $model_sales_master->round_of_amount = $data['round_of'];
            $model_sales_master->discount_amount = $data['discount_sub_total'];
            $model_sales_master->amount_payed = $data['payed_amount'];
            $model_sales_master->due_amount = $data['balance'];
            $model_sales_master->due_date = date("Y-m-d", strtotime($data['due_date']));
        }
        $model_sales_master->status = 1;
        Yii::$app->SetValues->Attributes($model_sales_master);
        return $model_sales_master;
    }

    public function GetGoodsServiceTotal($arr) {
        $goods_total = 0;
        foreach ($arr as $val) {
            $item_datas = \common\models\ItemMaster::find()->where(['id' => $val['SalesInvoiceDetailsItem']])->one();
            if (!empty($item_datas)) {
                $qty = $val['SalesInvoiceDetailsQty'];
                if ($item_datas->item_type == 0) {
                    $goods_total += $qty * $item_datas->item_cost;
                }
            }
        }
        $datas = array('goods-total' => $goods_total);
        return $datas;
    }

    public function SaveSaleGld($model_sales_master) {
        $flag = 0;
        $gld_master = new \common\models\GldMst();
        $gld_master->journal_type = 1;
        $gld_master->voucher_type = 8;
        $gld_master->document_no = $model_sales_master->sales_invoice_number;
        $gld_master->document_date = $model_sales_master->sales_invoice_date;
        $financial_year_data = $this->GetFinancialYear($model_sales_master->sales_invoice_date);
        $gld_master->financial_year = $financial_year_data->financial_year;
        $gld_master->financial_year_id = $financial_year_data->id;
        $gld_master->debit_amount = $model_sales_master->discount_amount + $model_sales_master->order_amount + $model_sales_master->goods_total;
        $gld_master->credit_amount = $model_sales_master->amount + $model_sales_master->tax_amount + $model_sales_master->goods_total;
        $gld_master->balance_amount = $model_sales_master->due_amount;
        $gld_master->status = 0;
        Yii::$app->SetValues->Attributes($gld_master);
        if ($gld_master->save()) {
            if ($this->SaveSaleGldDetails($model_sales_master, $gld_master)) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function SaveSaleGldDetails($model_sales_master, $gld_master) {
        $flag = 0;
        $j = 0;
        $arr = array(Yii::$app->params['accounts_receivables'], Yii::$app->params['tax_payables'], Yii::$app->params['sales'], Yii::$app->params['sales_discount'], Yii::$app->params['inventory_assets'], Yii::$app->params['cost_of_goods_sold']);
        foreach ($arr as $x) {
            $j++;
            $gld_details = new \common\models\GldDtl();
            $gld_details->GLDMstID = $gld_master->id;
            $gld_details->voucher_type = $gld_master->voucher_type;
            $gld_details->document_no = $gld_master->document_no;
            $gld_details->document_date = $gld_master->document_date;
            $gld_details->pos = $j;
            $gld_details->account_id = $x;
            $chart_of_account = \common\models\ChartofAccounts::findOne(['id' => $x]);
            $gld_details->account_number = $chart_of_account->account_number;
            $gld_details->account_name = $chart_of_account->account_name;
            $gld_details->description = '';
            if ($x == Yii::$app->params['accounts_receivables']) {
                $gld_details->bp_code = $model_sales_master->busines_partner_code;
                $bp_name = \common\models\BusinessPartner::findOne(['id' => $model_sales_master->busines_partner_code])->name;
                $gld_details->bp_name = $bp_name;
                $gld_details->debit_amount = $model_sales_master->order_amount;
            } elseif ($x == Yii::$app->params['sales']) {
                $gld_details->credit_amount = $model_sales_master->amount;
            } elseif ($x == Yii::$app->params['sales_discount']) {
                $gld_details->debit_amount = $model_sales_master->discount_amount;
            } elseif ($x == Yii::$app->params['tax_payables']) {
                $gld_details->credit_amount = $model_sales_master->tax_amount;
            } elseif ($x == Yii::$app->params['inventory_assets']) {
                $gld_details->credit_amount = $model_sales_master->goods_total;
            } elseif ($x == Yii::$app->params['cost_of_goods_sold']) {
                $gld_details->debit_amount = $model_sales_master->goods_total;
            }
            $gld_details->status = 0;
            $gld_details->CB = Yii::$app->user->identity->id;
            $gld_details->UB = Yii::$app->user->identity->id;
            $gld_details->DOC = date('Y-m-d');
            if ($gld_details->save()) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function GetFinancialYear($invoice_date) {
        $sale_date = date('Y-m-d', strtotime($invoice_date));
        $financial_datas = \common\models\FinancialYears::find()->all();
        foreach ($financial_datas as $value) {
            $contractDateBegin = date('Y-m-d', strtotime($value->start_period));
            $contractDateEnd = date('Y-m-d', strtotime($value->end_period));
            if (($sale_date > $contractDateBegin) && ($sale_date < $contractDateEnd)) {
                return $value;
            }
        }
    }

    public function SaveNotification($model_sales_master, $data) {
        $notification = new Notifications();
        $notification->notification_type = 1; //Due Amount Notification
        $notification->notification_subtype = 1; //Due Amount Notification for sale invoice
        $notification->master_id = $model_sales_master->id; //Due Amount Notification sale invoice ID
        $notification->due_amount = $model_sales_master->due_amount; //Due Amount for sale invoice
        $notification->due_date = date("Y-m-d", strtotime($data['due_date'])); //Due date for sale invoice
        $notification->status = 1;
        $notification->save();
        return;
    }

    public function SaveSaleReceipt($model_sales_master, $payment_type) {
        $flag = 0;
        if ($model_sales_master->amount_payed > 0) {
            $payment_details = new PaymentMst();
            $payment_details->transaction_type = $payment_type;
            $payment_details->voucher_type = 6;
            $payment_details->document_date = $model_sales_master->sales_invoice_date;
            $data = $this->generateDocumentNo($model_sales_master->sales_invoice_date, 6);
            $payment_details->document_no = $data['document-no'];
            $payment_details->bp_code = $model_sales_master->busines_partner_code;
            $payment_details->due_amount = $model_sales_master->due_amount;
            $payment_details->payment_mode = 4;
            $payment_details->tds_amount = $model_sales_master->tax_amount;
            $payment_details->amount = $model_sales_master->amount;
            $payment_details->net_amount = $model_sales_master->amount + $model_sales_master->tax_amount;
            $payment_details->total_amount = $model_sales_master->order_amount;
            Yii::$app->SetValues->Attributes($payment_details);
            if ($payment_details->save()) {
                $aditional = new PaymentDtl();
                $this->SaveReceiptDetails($model_sales_master, $payment_details, $aditional);
                if ($aditional->save()) {
                    $voucher_series = \common\models\VoucherSeries::findOne(['voucher_type' => $payment_details->voucher_type, 'financial_year_id' => $data['financial-year-id'], 'financial_year' => $data['financial-year']]);
                    $this->UpdateSerialNo($payment_details, $voucher_series);
                    if ($this->SaveReceiptGld($payment_details, $model_sales_master)) {
                        if ($voucher_series->save()) {
                            $flag = 1;
                        }
                    }
                }
            }
        } else {
            $flag = 1;
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function SaveReceiptGld($payment_details, $model_sales_master) {
        $flag = 0;
        $gld_master = new \common\models\GldMst();
        $gld_master->journal_type = 1;
        $gld_master->voucher_type = 6;
        $gld_master->document_no = $payment_details->document_no;
        $gld_master->document_date = $payment_details->document_date;
        $financial_year_data = $this->GetFinancialYear($model_sales_master->sales_invoice_date);
        $gld_master->financial_year = $financial_year_data->financial_year;
        $gld_master->financial_year_id = $financial_year_data->id;
        $gld_master->debit_amount = $model_sales_master->cash_amount + $model_sales_master->card_amount + $model_sales_master->tax_amount + $model_sales_master->round_of_amount;
        $gld_master->credit_amount = $model_sales_master->amount + $model_sales_master->tax_amount;
        $gld_master->balance_amount = $model_sales_master->due_amount;
        $gld_master->status = 0;
        Yii::$app->SetValues->Attributes($gld_master);
        if ($gld_master->save()) {
            if ($this->SaveReceiptGldDetails($model_sales_master, $gld_master)) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function SaveReceiptGldDetails($model_sales_master, $gld_master) {
        $flag = 0;
        $j = 0;
        $inv_parameter = \common\models\InvoiceParameter::findOne(['id' => 1]);
        $arr = array($inv_parameter->cash_account, Yii::$app->params['accounts_receivables'], Yii::$app->params['tax_receivables'], Yii::$app->params['cash_discount'], $inv_parameter->card_account);
        foreach ($arr as $x) {
            $j++;
            $gld_details = new \common\models\GldDtl();
            $gld_details->GLDMstID = $gld_master->id;
            $gld_details->voucher_type = $gld_master->voucher_type;
            $gld_details->document_no = $gld_master->document_no;
            $gld_details->document_date = $gld_master->document_date;
            $gld_details->pos = $j;
            $gld_details->account_id = $x;
            $chart_of_account = \common\models\ChartofAccounts::findOne(['id' => $x]);
            $gld_details->account_number = $chart_of_account->account_number;
            $gld_details->account_name = $chart_of_account->account_name;
            $gld_details->description = '';
            if ($x == Yii::$app->params['accounts_receivables']) {
                $gld_details->bp_code = $model_sales_master->busines_partner_code;
                $bp_name = \common\models\BusinessPartner::findOne(['id' => $model_sales_master->busines_partner_code])->name;
                $gld_details->bp_name = $bp_name;
                $gld_details->credit_amount = $model_sales_master->amount + $model_sales_master->tax_amount;
            } elseif ($x == Yii::$app->params['cash_in_hand']) {
                $gld_details->debit_amount = $model_sales_master->cash_amount;
            } elseif ($x == Yii::$app->params['tax_receivables']) {
                $gld_details->debit_amount = $model_sales_master->tax_amount;
            } elseif ($x == Yii::$app->params['cash_discount']) {
                $gld_details->debit_amount = $model_sales_master->round_of_amount;
            } elseif ($x == Yii::$app->params['federal_bank_ekm']) {
                $gld_details->debit_amount = $model_sales_master->card_amount;
            }
            $gld_details->status = 0;
            $gld_details->CB = Yii::$app->user->identity->id;
            $gld_details->UB = Yii::$app->user->identity->id;
            $gld_details->DOC = date('Y-m-d');
            if ($gld_details->save()) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function SaveReceiptDetails($model_sales_master, $payment_details, $aditional) {
        $aditional->payment_mst_id = $payment_details->id;
        $aditional->invoice_no = $model_sales_master->sales_invoice_number;
        $aditional->invoice_date = $model_sales_master->sales_invoice_date;
        $aditional->invoice_amount = $model_sales_master->order_amount;
        $aditional->due_amount = $model_sales_master->due_amount;
        $aditional->paid_amount = $model_sales_master->amount_payed;
        $aditional->status = 0;
        $aditional->CB = Yii::$app->user->identity->id;
        $aditional->UB = Yii::$app->user->identity->id;
        $aditional->DOC = date('Y-m-d');
        return $aditional;
    }

    public function UpdateSerialNo($payment_details, $voucher_series) {
        $document_no = explode('/', $payment_details->document_no);
        $num = $document_no[2] + 1;
        $voucher_series->sequence_no = $num;
        return $voucher_series;
    }

    public function generateDocumentNo($purchase_date, $voucher_type) {
        $year = date("Y", strtotime(str_replace('/', '-', $purchase_date)));
        $series = \common\models\VoucherSeries::find()->where(['voucher_type' => $voucher_type, 'financial_year' => $year])->one();
        if (empty($series)) {
            $document_no = '';
        } else {
            $digit = '%0' . $series->digits . 'd';
            $document_no = $series->prefix . (sprintf($digit, $series->sequence_no));
        }
        $document_data = array('document-no' => $document_no, 'financial-year-id' => $series->financial_year_id, 'financial-year' => $series->financial_year);
        return $document_data;
    }

    public function SaveSalesDetails($model_sales_master, $data) {
        $arr = [];
        $i = 0;
        foreach ($data['SalesInvoiceDetailsItem'] as $val) {
            $arr[$i]['SalesInvoiceDetailsItem'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsQty'] as $val) {
            $arr[$i]['SalesInvoiceDetailsQty'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['sales-uom'] as $val) {
            $arr[$i]['sales-uom'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsRate'] as $val) {
            $arr[$i]['SalesInvoiceDetailsRate'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsDiscountType'] as $val) {
            $arr[$i]['SalesInvoiceDetailsDiscountType'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsDiscountValue'] as $val) {
            $arr[$i]['SalesInvoiceDetailsDiscountValue'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsTax'] as $val) {
            $arr[$i]['SalesInvoiceDetailsTax'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsLineTotal'] as $val) {
            $arr[$i]['SalesInvoiceDetailsLineTotal'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['SalesInvoiceDetailsItemComment'] as $val) {
            $arr[$i]['SalesInvoiceDetailsItemComment'] = $val;
            $i++;
        }
        return $arr;
//        $this->AddSalesDetails($arr, $model_sales_master);
    }

    public function AddSalesDetails($arr, $model_sales_master) {
        $j = 0;
        $flag = 0;
        foreach ($arr as $val) {
            $j++;
            $aditional = new SalesInvoiceDetails();
            $item_datas = \common\models\ItemMaster::find()->where(['id' => $val['SalesInvoiceDetailsItem']])->one();
            if (!empty($item_datas)) {
                $aditional->sales_invoice_master_id = $model_sales_master->id;
                $aditional->sales_invoice_number = $model_sales_master->sales_invoice_number;
                $aditional->sales_invoice_date = $model_sales_master->sales_invoice_date;
                $aditional->busines_partner_code = $model_sales_master->busines_partner_code;
                $aditional->salesman = $model_sales_master->salesman;
                $aditional->item_id = $val['SalesInvoiceDetailsItem'];
                $aditional->item_code = $item_datas->SKU;
                $aditional->item_name = $item_datas->item_name;
                $aditional->base_unit = $item_datas->base_unit_id;
                $aditional->qty = $val['SalesInvoiceDetailsQty'];
                if (isset($item_datas->hsn)) {
                    $aditional->hsn = $item_datas->hsn;
                }
                $aditional->rate = $val['SalesInvoiceDetailsRate'];
                $aditional->amount = $aditional->qty * $aditional->rate;
                $aditional->discount_type = $val['SalesInvoiceDetailsDiscountType'];
                $aditional->discount_value = $val['SalesInvoiceDetailsDiscountValue'];
                if ($aditional->discount_type == 0) {
                    $aditional->discount_amount = $val['SalesInvoiceDetailsDiscountValue'];
                } else {
                    $aditional->discount_amount = ($aditional->amount * $val['SalesInvoiceDetailsDiscountValue']) / 100;
                }
                $aditional->net_amount = $aditional->amount - $aditional->discount_amount;
                $aditional->line_total = $val['SalesInvoiceDetailsLineTotal'];
                $aditional->tax_id = $val['SalesInvoiceDetailsTax'];
                $tax = \common\models\Tax::findOne(['id' => $aditional->tax_id]);
                if ($tax->type == 1) {
                    $tax_amount = $tax->value;
                } else {
                    $tax_amount = ($aditional->net_amount * $tax->value) / 100;
                }
                $aditional->tax_amount = $tax_amount;
                $aditional->tax_type = $tax->type;
                $aditional->tax_percentage = $tax->value;
                $aditional->line_total = $val['SalesInvoiceDetailsLineTotal'];
                $aditional->comments = $val['SalesInvoiceDetailsItemComment'];
                $aditional->status = 1;
                $aditional->CB = Yii::$app->user->identity->id;
                $aditional->UB = Yii::$app->user->identity->id;
                $aditional->DOC = date('Y-m-d');
                if ($aditional->save()) {
                    if ($item_datas->item_type == 0) {
                        $stock = new StockRegister();
                        $stock = $this->AddStockRegister($aditional, $j, $stock);
                        if ($stock->save()) {
                            if ($this->AddStockView($stock)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        } else {
                            $flag = 0;
                        }
                    } else {
                        $flag = 1;
                    }
                } else {
                    $flag = 0;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Generate item code
     */
    public function generateInvoiceNo() {
        $last_item = SalesInvoiceMaster::find()->orderBy(['id' => SORT_DESC])->one();
        if (empty($last_item)) {
            $code = 'INV' . date('Y') . '-' . sprintf('%04d', 1);
        } else {
            $last = $last_item->id;
            $code = 'INV' . date('Y') . '-' . (sprintf('%04d', ++$last));
        }
        return $code;
    }

    /**
     * Get Customer Details
     */
    public function actionCustomerDetails() {
        if (Yii::$app->request->isAjax) {
            $customer_id = $_POST['id'];
            $billing_address = '';
            $delivery_address = '';
            $contact_number = '';
            $email = '';
            $customer = BusinessPartner::find()->where(['id' => $customer_id])->one();
            if (!empty($customer)) {
                $billing_address = $customer->billing_address;
                $delivery_address = $customer->shipping_address;
                $contact_number = $customer->phone_no;
                $email = $customer->email;
            }
            $arrr_variable = array('billing_address' => $billing_address, 'delivery_address' => $delivery_address, 'contact_number' => $contact_number, 'email' => $email);
            $data['result'] = $arrr_variable;
            echo json_encode($data);
        }
    }

    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $item_id = $_POST['item_id'];
            $next_row_id = $_POST['next_row_id'];
            $next = $next_row_id + 1;
            $items = \common\models\ItemMaster::find()->where(['status' => 1])->all();
            if ($item_id == '') {
                echo '0';
                exit;
            } else {
                $item_datas = \common\models\ItemMaster::find()->where(['id' => $item_id])->one();
                if (empty($item_datas)) {
                    echo '0';
                    exit;
                } else {
                    $next_row = $this->renderPartial('next_row', [
                        'next' => $next,
                        'items' => $items,
                    ]);
                    $tax = \common\models\Tax::findOne($item_datas->tax_id);
                    $arr_variable1 = array('next_row_html' => $next_row, 'next' => $next, 'item_rate' => $item_datas->MRP, 'tax_id' => $item_datas->tax_id, 'tax_type' => $tax->type, 'tax_value' => $tax->value);
                    $data1['result'] = $arr_variable1;
                    return json_encode($data1);
                }
            }
        }
    }

}
