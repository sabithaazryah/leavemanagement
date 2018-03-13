<?php

namespace backend\modules\leave\controllers;

use Yii;
use common\models\LeaveRequest;
use common\models\LeaveRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Employee;

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

        /**
         * Lists all LeaveRequest models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new LeaveRequestSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->andWhere(['employee_id' => Yii::$app->user->identity->id]);

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
                        $model->from_date = date('Y-m-d', strtotime($model->from_date));
                        $model->to_date = date('Y-m-d', strtotime($model->to_date));
                        $model->recommender = $employee->recommender;
                        $model->approver = $employee->approver;
                        $model->status = 1;
                        if ($model->save()) {
                                return $this->redirect(['index']);
                        }
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
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
                        $employee_leaves = \common\models\LeaveConfiguration::find()->where(['employee_id' => $employee])->all();
                        $employee_leaves_list = $this->renderPartial('leaves', ['leaves' => $employee_leaves]);

                        $options = '<option value="">-Select-</option>';
                        foreach ($employee_leaves as $leave) {
                                $leav_type = \common\models\LeaveCategory::findOne($leave->leave_type);
                                $options .= "<option value='" . $leave->id . "'>" . $leav_type->leave_name . "</option>";
                        }
                        $data = ['list' => $employee_leaves_list, 'options' => $options];
                        echo json_encode($data);
                }
        }

}
