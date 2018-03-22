<?php

namespace backend\modules\admin\controllers;

use Yii;
use common\models\Employee;
use common\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\LeaveConfiguration;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller {

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
         * Lists all Employee models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new EmployeeSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single Employee model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new Employee model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new Employee();
                $model->setScenario('create');

                if ($model->load(Yii::$app->request->post())) {
                        $model->password = Yii::$app->security->generatePasswordHash($model->password);
                        $files = UploadedFile::getInstance($model, 'photo');
                        if (!empty($files)) {
                                $model->photo = $files->extension;
                        }
                        if ($model->validate() && $model->save()) {
                                if (!empty($files)) {
                                        $this->upload($model, $files);
                                }
                                Yii::$app->session->setFlash('success', "New Employee added Successfully");
                                $model = new Employee();
                                $model_upload = '';
                        }
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
        }

        /**
         * Upload Material photos.
         * @return mixed
         */
        public function Upload($model, $files) {
                if (isset($files) && !empty($files)) {
                        $files->saveAs(Yii::$app->basePath . '/../uploads/employee/' . $model->id . '.' . $files->extension);
                }
                return TRUE;
        }

        /**
         * Updates an existing Employee model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);
                $model->setScenario('update');
                $searchModel = new \common\models\LeaveConfigurationSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $model_leave = new LeaveConfiguration();
                $photo_ = $model->photo;

                if ($model->load(Yii::$app->request->post())) {
                        $files = UploadedFile::getInstance($model, 'photo');
                        if (empty($files)) {
                                $model->photo = $photo_;
                        } else {
                                $model->photo = $files->extension;
                        }
                        if ($model->save()) {
                                if (!empty($files)) {
                                        $this->upload($model, $files);
                                }
                                Yii::$app->session->setFlash('success', "Employee Details Updated Successfully");
                                return $this->redirect(['update', 'id' => $model->id]);
                        }
                } elseif ($model_leave->load(Yii::$app->request->post())) {
                        $check_exist = LeaveConfiguration::find()->where(['leave_type' => Yii::$app->request->post()['LeaveConfiguration']['leave_type'], 'employee_id' => $model->id])->one();

                        if (!empty($check_exist)) {

                                if (Yii::$app->request->post()['LeaveConfiguration']['leave_type'] == 1) {

                                        $check_exist->available_days = $check_exist->available_days + $model_leave->no_of_days;
                                        $check_exist->no_of_days = $check_exist->no_of_days + $model_leave->no_of_days;
                                        $check_exist->save();
                                } elseif (Yii::$app->request->post()['LeaveConfiguration']['leave_type'] == 2) {
                                        $check_exist->available_days = $check_exist->available_days - Yii::$app->request->post()['LeaveConfiguration']['adjustments'];
                                        $check_exist->no_of_days = $check_exist->no_of_days - Yii::$app->request->post()['LeaveConfiguration']['adjustments'];
                                        $check_exist->save();
                                }
                        } else {
                                $model_leave->employee_id = $model->id;
                                $model_leave->available_days = $model_leave->no_of_days;
                                $model_leave->save();
                        }
                        return $this->redirect(['update', 'id' => $model->id]);
                }return $this->render('update', [
                            'model' => $model,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'model_leave' => $model_leave,
                                // 'carry_date' => $carry_date,
                ]);
        }

        public function actionLeaveTypeDays() {
                if (Yii::$app->request->isAjax) {
                        if (!empty($_POST['leave_type'])) {
                                $leave_model = \common\models\LeaveCategory::find()->where(['id' => $_POST['leave_type'], 'status' => 1])->one();
                                $data_exist = LeaveConfiguration::find()->where(['leave_type' => $_POST['leave_type'], 'employee_id' => $_POST['employee_id']])->one();
                                if (!empty($leave_model) && empty($data_exist)) {
                                        echo $leave_model->no_of_days;
                                } elseif (!empty($leave_model) && !empty($data_exist)) {
                                        echo $data_exist->available_days;
                                }
                        } else {
                                echo 0;
                        }
                }
        }

        /**
         * Deletes an existing Employee model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the Employee model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Employee the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = Employee::findOne($id)) !== null) {
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
