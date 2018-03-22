<?php

namespace backend\modules\leave\controllers;

use Yii;
use common\models\LeaveRequest;
use common\models\LeaveRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Employee;
use yii\db\Expression;
use common\models\LeaveRequestDetails;

/**
 * LeaveRequestController implements the CRUD actions for LeaveRequest model.
 */
class LeaveRequestController extends Controller {

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
         * Lists all LeaveRequest models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new LeaveRequestSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single LeaveRequest model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new LeaveRequest model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {


                $model = new LeaveRequest();
                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
                        $employee = Employee::findOne($model->employee_id);
                        $employee_leave = \common\models\LeaveConfiguration::findOne($model->leave_type);
                        $model->from_date = date('Y-m-d', strtotime($model->from_date));
                        $model->to_date = date('Y-m-d', strtotime($model->to_date));
                        $model->status = 1;
                        $model->recommender = $employee->recommender;
                        $model->approver = $employee->approver;
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                                if ($model->save() && $this->LeaveDetails($model)) {
                                        $transaction->commit();
                                        Yii::$app->session->setFlash('success', "Leave request submitted successfully");
                                        return $this->redirect(['create']);
                                } else {
                                        $transaction->rollBack();
                                        Yii::$app->session->setFlash('error', "There was a problem creating new user. Please try again.");
                                }
                        } catch (Exception $e) {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('error', "There was a problem creating new user. Please try again.");
                        }
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
        }

        public function LeaveDetails($model) {
                $count = $this->Leaveapplieddays($model->from_date, $model->to_date);
                $date = date('Y-m-d', strtotime($model->from_date . '-1 day'));
                $flag = 0;
                for ($x = 0; $x < $count; $x++) {
                        $date = date('Y-m-d', strtotime($date . ' +1 day'));
                        $employee_details = Employee::findOne($model->employee_id);
                        $leave_request = new LeaveRequestDetails;
                        $leave_request->leave_request_id = $model->id;
                        $leave_request->employee_id = $model->employee_id;
                        $leave_request->leave_type = $model->leave_type;
                        $leave_request->date = $date;
                        $leave_request->year = date('Y', strtotime($leave_request->date));
                        if ($date == $model->from_date) {
                                if (isset($model->from_leave_type))
                                        $leave_request->leave_day_mode = $model->from_leave_type;
                                else if (isset($model->apply_leave_type))
                                        $leave_request->leave_day_mode = $model->from_leave_type;
                        } else if ($adte == $model->to_date) {
                                if (isset($model->to_leave_type))
                                        $leave_request->leave_day_mode = $model->to_leave_type;
                        } else if ($employee_details->working_hours == 3) {
                                $startDate = new \DateTime($date);
                                if ($startDate->format('w') == 6) {
                                        $leave_request->leave_day_mode = 2;
                                } else {
                                        $leave_request->leave_day_mode = 1;
                                }
                        } else {
                                $leave_request->leave_day_mode = 1;
                        }
                        $leave_request->leave_status = $this->CheckLeave($date, $employee_details);
                        if ($leave_request->leave_status == 2) {
                                $leave_request->leave_off_reason = $this->OffReason($date, $employee_details);
                        }
                        $leave_request->status = 1;
                        if ($leave_request->save()) {
                                $flag = 1;
                        }
                }

                if ($flag == 1) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        /*
         * check the day is weekend or comapny holiday
         */

        public function CheckLeave($date, $employee_details) {
                $leave = 1;
                $startDate = new \DateTime($date);
                if ($employee_details->working_hours == 2) { /* working days 5 */
                        if ($startDate->format('w') == 6 || $startDate->format('w') == 0) {
                                $leave = 2;
                        }
                } else if ($employee_details->working_hours == 1) {/* working days 6 */
                        if ($startDate->format('w') == 0) {
                                $leave = 2;
                        }
                } else if ($employee_details->working_hours == 3) {/* working days 5.5 */
                        if ($startDate->format('w') == 0) {
                                $leave = 2;
                        }
                }
                $holiday_exist = \common\models\Holidays::find()->where(['date' => $date])->andWhere(new Expression('FIND_IN_SET(:branch, branch)'))->addParams([':branch' => $employee_details->branch])->exists();
                if ($holiday_exist)
                        $leave = 2;
                return $leave;
        }

        /*
         * Day off reason
         */

        public function OffReason($date, $employee_details) {
                $leave_reason = '';
                $startDate = new \DateTime($date);
                if ($employee_details->working_hours == 2) { /* working days 5 */
                        if ($startDate->format('w') == 6 || $startDate->format('w') == 0) {
                                $leave_reason = 'Weekend Off';
                        }
                } else if ($employee_details->working_hours == 1) {/* working days 6 */
                        if ($startDate->format('w') == 0) {
                                $leave_reason = 'Weekend Off';
                        }
                } else if ($employee_details->working_hours == 3) {/* working days 6 */
                        if ($startDate->format('w') == 0) {
                                $leave_reason = 'Weekend Off';
                        }
                }
                if ($leave_reason == '') {
                        $holiday_exist = \common\models\Holidays::find()->where(['date' => $date])->andWhere(new Expression('FIND_IN_SET(:branch, branch)'))->addParams([':branch' => $employee_details->branch])->one();
                        $leave_reason = $holiday_exist->holiday_name;
                }
                return $leave_reason;
        }

        /*
         * List leaves to the corresponding recommender
         */

        public function actionRecommend() {
                $searchModel = new LeaveRequestSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (\Yii::$app->user->identity->post_id != 1)
                        $dataProvider->query->andWhere(['recommender' => Yii::$app->user->identity->id]);
                $dataProvider->query->andWhere(['status' => 1]);
                return $this->render('recommend', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Recommended leave request by the recommender
         */
        public function actionRecommendLeave($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 2;
                        $leave->recommended_by = \Yii::$app->user->identity->id;
                        $leave->DOU = date('Y-m-d H:i:s');
                        $leave->update();
                        Yii::$app->session->setFlash('success', "Leave request recommended successfully");
                        return $this->redirect(['recommend']);
                } else {
                        return $this->redirect(Yii::$app->request->referrer);
                }
        }

        /*
         * Reject leave request by the recommender
         */

        public function actionReject($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 3;
                        $leave->DOU = date('Y-m-d H:i:s');
                        $leave->update();
                        Yii::$app->session->setFlash('error', "Leave request rejected");
                        return $this->redirect(['recommend']);
                } else {
                        return $this->redirect(Yii::$app->request->referrer);
                }
        }

        /*
         * List leaves to the corresponding approver
         */

        public function actionApprove() {
                $searchModel = new LeaveRequestSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                if (\Yii::$app->user->identity->post_id != 1)
                        $dataProvider->query->andWhere(['approver' => Yii::$app->user->identity->id]);
                $dataProvider->query->andWhere(['status' => 1]);

                return $this->render('approval', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Approve leave request by the approver
         */
        public function actionApproveleave($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 2;
                        $leave->approved_by = \Yii::$app->user->identity->id;
                        $leave->DOU = date('Y-m-d H:i:s');
                        $employee_leave = \common\models\LeaveConfiguration::findOne($leave->leave_type);
                        $employee_leave->available_days = $employee_leave->available_days - $leave->no_of_days;

                        if ($leave->update()) {
                                LeaveRequestDetails::updateAll(['status' => 2], ['leave_request_id' => $leave->id]);
                                $employee_leave->update();
                                Yii::$app->session->setFlash('success', "Leave request approved successfully");
                                return $this->redirect(['approve']);
                        }
                }
                return $this->redirect(Yii::$app->request->referrer);
        }

        /*
         * Reject leave request by the approver
         */

        public function actionRejectleave($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 3;
                        $leave->approved_by = \Yii::$app->user->identity->id;
                        $leave->DOU = date('Y-m-d H:i:s');
                        $leave->update();
                        Yii::$app->session->setFlash('error', "Leave request rejected");
                        return $this->redirect(['approve']);
                } else {
                        return $this->redirect(Yii::$app->request->referrer);
                }
        }

        /**
         * Updates an existing LeaveRequest model.
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
         * Deletes an existing LeaveRequest model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the LeaveRequest model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return LeaveRequest the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = LeaveRequest::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionEmployeeLeave() {
                if (Yii::$app->request->isAjax) {
                        $employee = Yii::$app->request->post('employee');
                        $employee_leaves = \common\models\LeaveConfiguration::find()->where(['employee_id' => $employee])->andWhere(['>', 'available_days', 0])->all();
                        $employee_leaves_list = $this->renderPartial('leaves', ['leaves' => $employee_leaves]);

                        $employee_leaves_group = \common\models\LeaveConfiguration::find()->where(['employee_id' => $employee])->andWhere(['>', 'available_days', 0])->all();
                        $options = '<option value="">-Select-</option>';
                        foreach ($employee_leaves_group as $leave) {

                                $leav_type = \common\models\LeaveCategory::findOne($leave->leave_type);
                                $options .= "<option value='" . $leave->id . "'>" . $leav_type->leave_name . '(' . $leave->year . ")</option>";
                        }
                        $data = ['list' => $employee_leaves_list, 'options' => $options];
                        echo json_encode($data);
                }
        }

        public function actionEmployeeListChange() {
                if (Yii::$app->request->isAjax) {
                        $checked = $_POST['checked'];
                        if ($checked == 0) {
                                $employees = Employee::find()->where(['status' => 1])->orWhere(['recommender' => Yii::$app->user->identity->id])->orWhere(['approver' => Yii::$app->user->identity->id])->all();
                                $options = "<option value=''>-Select-</option>";
                                foreach ($employees as $employee) {
                                        $options .= "<option value='" . $employee->id . "'>" . $employee->full_name . ' (' . $employee->employee_code . " )</option>";
                                }
                                $data = "<div class='form-group field-leaverequest-employee_id required'><label class='control-label' for='leaverequest-employee_id'>Employee</label><select id='leaverequest-employee_id' class='form-control' name='LeaveRequest[employee_id]' aria-required='true' aria-invalid='true'>$options</select><div class='help-block'></div></div>";
                                return $data;
                        }
                }
        }

        public function actionLeaves() {
                if (Yii::$app->request->isAjax) {
                        $reduce = 0;
                        $from_date = date('Y-m-d', strtotime($_POST['from_date']));
                        $to_date = date('Y-m-d', strtotime($_POST['to_date']));
                        $leave_applied_days = $this->Leaveapplieddays($from_date, $to_date);
                        $employee = $_POST['employee'];
                        $single_leave_type = $_POST['single_date_type'];
                        $from_leave_type = $_POST['from_leave_type'];
                        $to_leave_type = $_POST['to_leave_type'];
                        $employee_details = Employee::findOne($employee);
                        $weekends = $this->Weekend($from_date, $to_date, $employee_details);
                        $holidays = $this->Holidays($from_date, $to_date, $employee_details);
                        $off_days = $weekends + $holidays;
                        if ($from_date == $to_date) {
                                if ($single_leave_type == 2)
                                        $reduce += 0.5;
                        } else {
                                if ($from_leave_type == 2)
                                        $reduce += 0.5;
                                if ($to_leave_type == 2)
                                        $reduce += 0.5;
                        }
                        $total_off_days = $leave_applied_days - $weekends - $holidays - $reduce;
                        return $total_off_days;
                }
        }

        public function Leaveapplieddays($from_date, $to_date) {
                $date1 = new \DateTime($from_date);
                $date2 = new \DateTime($to_date);
                $diff = $date2->diff($date1)->format("%a") + 1;
                return $diff;
        }

        /*
         * calculate weekends
         */

        public function Weekend($from_date, $to_date, $employee_details) {

                $startDate = new \DateTime($from_date);
                $endDate = new \DateTime($to_date);
                $sundays = array();
                $saturdays = array();
                while ($startDate <= $endDate) {
                        if ($employee_details->working_hours == 2) { /* working days 5 */
                                if ($startDate->format('w') == 6 || $startDate->format('w') == 0) {
                                        $sundays[] = $startDate->format('Y-m-d');
                                }
                        } else if ($employee_details->working_hours == 1) {/* working days 6 */
                                if ($startDate->format('w') == 0) {
                                        $sundays[] = $startDate->format('Y-m-d');
                                }
                        } else if ($employee_details->working_hours == 3) {/* working days 5.5 */
                                if ($startDate->format('w') == 0) {
                                        $sundays[] = $startDate->format('Y-m-d');
                                } else if ($startDate->format('w') == 6) {
                                        $saturdays[] = $startDate->format('Y-m-d');
                                }
                        }
                        $startDate->modify('+1 day');
                }
                $offs = array_merge($sundays, $saturdays);
                $total_count = count($offs);
                if ($employee_details->working_hours == 3) {
                        $saturdays_count = count($saturdays) / 2;
                        $total_count = count($sundays) + $saturdays_count;
                }
                return $total_count;
        }

        /*
         * check holidays
         */

        public function Holidays($from_date, $to_date, $employee_details) {
                $total_holiday = 0;
                while ($from_date <= $to_date) {
                        $holidays = array();
                        $holiday_exist = \common\models\Holidays::find()->where(['date' => $from_date])->andWhere(new Expression('FIND_IN_SET(:branch, branch)'))->addParams([':branch' => $employee_details->branch])->all();
                        $count_of_holiday = count($holiday_exist);
                        $total_holiday += $count_of_holiday;
                        $from_date = date('Y-m-d', strtotime($from_date . ' +1 day'));
                }
                return $total_holiday;
        }

}
