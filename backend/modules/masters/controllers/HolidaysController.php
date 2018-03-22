<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\Holidays;
use common\models\HolidaysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HolidaysController implements the CRUD actions for Holidays model.
 */
class HolidaysController extends Controller {

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
         * Lists all Holidays models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new HolidaysSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single Holidays model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new Holidays model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new Holidays();

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
                        if ($model->recurring_leave == 1) {
                                $count = \Yii::$app->request->post('recurring_years');
                        } else {
                                $count = 0;
                        }
                        $dates = \Yii::$app->request->post('selecteddates');
                        if (!empty($dates) && $dates != '') {
                                for ($i = 0; $i <= $count; $i++) {

                                        $selected_dates = explode(',', $dates);
                                        foreach ($selected_dates as $value) {
                                                $holiday = new Holidays();
                                                $holiday->attributes = $model->attributes;
                                                $holiday->date = date('Y-m-d', strtotime($value));
                                                if ($count > 0) {
                                                        $holiday->date = date('Y-m-d', strtotime($value . ' + ' . $i . 'years'));
                                                }
                                                if (!empty($model->country) && $model->country != '') {
                                                        $holiday->country = implode(',', $model->country);
                                                }
                                                $holiday->status = 1;
                                                $holiday->save();
                                        }
                                }
                                Yii::$app->getSession()->setFlash('success', 'Holidays Added Successfully');
                        }
                        return $this->redirect(['index']);
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
        }

        /**
         * Updates an existing Holidays model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Holidays Updated Successfully');
                        return $this->redirect(['index']);
                }
                return $this->render('update', [
                            'model' => $model,
                ]);
        }

        /**
         * Deletes an existing Holidays model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDel($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the Holidays model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Holidays the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = Holidays::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionBranch() {
                if (Yii::$app->request->isAjax) {
                        $country = $_POST['country'];
                        $branches = \common\models\Branch::find()->where(['country' => $country])->all();
                        $options = '<option value="">-Select-</option>';
                        foreach ($branches as $branch) {
                                $options .= "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
                        }
                        echo $options;
                }
        }

}
