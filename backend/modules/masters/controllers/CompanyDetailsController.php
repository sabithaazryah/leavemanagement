<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\CompanyDetails;
use common\models\CompanyDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanyDetailsController implements the CRUD actions for CompanyDetails model.
 */
class CompanyDetailsController extends Controller {

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
         * Lists all CompanyDetails models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new CompanyDetailsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single CompanyDetails model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new CompanyDetails model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new CompanyDetails();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                        return $this->render('create', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Updates an existing CompanyDetails model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);
                $photo_ = $model->logo;

                if ($model->load(Yii::$app->request->post())) {
                        $model->company_established = date('Y-m-d', strtotime($model->company_established));
                        $files = UploadedFile::getInstance($model, 'logo');
                        if (empty($files)) {
                                $model->logo = $photo_;
                        } else {
                                $model->logo = $files->extension;
                        }
                        if ($model->save()) {
                                if (!empty($files)) {
                                        $this->upload($model, $files);
                                }
                                Yii::$app->session->setFlash('success', "Updated Successfully");
                                return $this->redirect(['update', 'id' => $model->id]);
                        }
                }
                return $this->render('update', [
                            'model' => $model,
                ]);
        }

        public function Upload($model, $files) {
                if (isset($files) && !empty($files)) {
                        $files->saveAs(Yii::$app->basePath . '/../uploads/company/' . $model->id . '.' . $files->extension);
                }
                return TRUE;
        }

        /**
         * Deletes an existing CompanyDetails model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the CompanyDetails model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return CompanyDetails the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = CompanyDetails::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

}
