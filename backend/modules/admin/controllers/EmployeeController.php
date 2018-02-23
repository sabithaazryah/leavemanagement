<?php

namespace backend\modules\admin\controllers;

use Yii;
use common\models\Employee;
use common\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        } return $this->render('update', [
                    'model' => $model,
        ]);
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

}
