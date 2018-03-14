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
                if (\Yii::$app->user->identity->post_id != 1)
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
                        $employee_leave = \common\models\LeaveConfiguration::findOne($model->leave_type);
                        $model->from_date = date('Y-m-d', strtotime($model->from_date));
                        $model->to_date = date('Y-m-d', strtotime($model->to_date));
                        $diff = abs(strtotime($model->to_date) - strtotime($model->from_date));
                        $days = round($diff / (60 * 60 * 24)) + 1;
                        if ($employee_leave->available_days >= $days) {
                                $model->recommender = $employee->recommender;
                                $model->approver = $employee->approver;
                                $model->status = 1;
                                if ($model->save()) {
                                        $model = new LeaveRequest();
                                        Yii::$app->session->setFlash('success', "Leave applied successfully");
                                        return $this->redirect(['create']);
                                }
                        } else {
                                Yii::$app->session->setFlash('error', "You have only " . $employee_leave->available_days . ' leaves left');
                        }
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
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
         * List leaves to the corresponding recommender
         */

        public function actionApprove() {
                $searchModel = new LeaveRequestSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                if (\Yii::$app->user->identity->post_id != 1)
                        $dataProvider->query->andWhere(['recommender' => Yii::$app->user->identity->id]);
                $dataProvider->query->andWhere(['status' => 2]);

                return $this->render('approval', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Recommended leave request by the recommender
         */
        public function actionApproveleave($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 4;
                        $leave->approved_by = \Yii::$app->user->identity->id;
                        $leave->DOU = date('Y-m-d H:i:s');
                        $employee_leave = \common\models\LeaveConfiguration::findOne($leave->leave_type);
                        $diff = abs(strtotime($leave->to_date) - strtotime($leave->from_date));
                        $days = round($diff / (60 * 60 * 24)) + 1;
                        $employee_leave->available_days = $employee_leave->available_days - $days;

                        if ($employee_leave->update()) {
                                $leave->update();
                                Yii::$app->session->setFlash('success', "Leave request approved successfully");
                                return $this->redirect(['approve']);
                        }
                }
                return $this->redirect(Yii::$app->request->referrer);
        }

        /*
         * Reject leave request by the recommender
         */

        public function actionRejectleave($id) {
                $leave = LeaveRequest::findOne($id);
                if (!empty($leave)) {
                        $leave->status = 5;
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
