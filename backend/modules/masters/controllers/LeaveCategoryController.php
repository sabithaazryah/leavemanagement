<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\LeaveCategory;
use common\models\LeaveCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeaveCategoryController implements the CRUD actions for LeaveCategory model.
 */
class LeaveCategoryController extends Controller {

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
         * Lists all LeaveCategory models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new LeaveCategorySearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single LeaveCategory model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new LeaveCategory model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new LeaveCategory();

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Leave category Added Successfully');
                        return $this->redirect(['index']);
                }
                return $this->renderAjax('create', [
                            'model' => $model,
                ]);
        }

        /**
         * Updates an existing LeaveCategory model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Leave category Updated Successfully');
                        return $this->redirect(['index']);
                }
                return $this->renderAjax('update', [
                            'model' => $model,
                ]);
        }

        /**
         * Deletes an existing LeaveCategory model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDel($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the LeaveCategory model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return LeaveCategory the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = LeaveCategory::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionBranch() {
                if (Yii::$app->request->isAjax) {
                        $country = $_POST['country'];
                        $branch = \common\models\Branch::find()->where(['country' => $country])->all();
                        $options = "<option value=''>-Select-</option>";
                        foreach ($branch as $branch) {
                                $options .= "<option value='" . $branch->id . "'>" . $branch->branch_name . " </option>";
                        }
                        return $options;
                }
        }

}
