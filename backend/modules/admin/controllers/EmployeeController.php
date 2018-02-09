<?php

namespace backend\modules\admin\controllers;

use Yii;
use common\models\Employee;
use common\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\EmployeeUploads;

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
        if (Yii::$app->session['post']['admin'] != 1) {
            Yii::$app->getSession()->setFlash('exception', 'You have no permission to access this page');
            $this->redirect(['/site/exception']);
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
        $model_upload = '';
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
                $this->Imageupload($model);
                Yii::$app->session->setFlash('success', "New Employee added Successfully");
                $model = new Employee();
                $model_upload = '';
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'model_upload' => $model_upload,
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

    /*
     * to upload multiple documents
     *  */

    public function Imageupload($model) {
        if (isset($_POST['creates']) && $_POST['creates'] != '') {


            $arrs = [];
            $i = 0;

            foreach ($_FILES['creates'] ['name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $arrs[$i]['name'] = $value;
                    $i++;
                }
            }
            $i = 0;
            foreach ($_FILES['creates'] ['tmp_name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $arrs[$i]['tmp_name'] = $value;
                    $i++;
                }
            }
            $i = 0;

            foreach ($_FILES['creates'] ['name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                    $arrs[$i]['extension'] = $ext;
                    $i++;
                }
            }
            $i = 0;
            foreach ($_POST['creates']['file_name'] as $val) {
                $arrs[$i]['file_name'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($_POST['creates']['expiry_date'] as $val) {
                $arrs[$i]['expiry_date'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($_POST['creates']['description'] as $val) {
                $arrs[$i]['description'] = $val;
                $i++;
            }
            if (!empty($arrs)) {
                $this->SaveAttachment($model, $arrs);
            }
        }
        return;
    }

    /*
     * to save the employee document details
     */

    public function SaveAttachment($model, $arrs) {
        foreach ($arrs as $val) {
            $model_upload = new EmployeeUploads();
            $model_upload->employee_id = $model->id;
            if (isset($val['file_name']) && $val['file_name'] != '') {
                $model_upload->document_title = $val['file_name'];
            }
            if (isset($val['expiry_date']) && $val['expiry_date'] != '') {
                $model_upload->expiry_date = $val['expiry_date'];
            }
            if (isset($val['name']) && $val['name'] != '') {
                $model_upload->file = $val['name'];
            }
            if (isset($val['description']) && $val['description'] != '') {
                $model_upload->description = $val['description'];
            }
            $model_upload->upload_category = 1;
            if ($model_upload->document_title != '' && $model_upload->file != '') {
                $allowed = array('pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'msg', 'zip', 'eml', 'jpg', 'jpeg', 'png');
                if (in_array($val['extension'], $allowed)) {
                    if (Yii::$app->SetValues->Attributes($model_upload) && $model_upload->save()) {
                        $file_name = $val['name'];
                        $root = Yii::$app->basePath . '/../uploads/employee/documents/' . $model_upload->id;
                        if (!is_dir($root)) {
                            mkdir($root);
                        }
                        move_uploaded_file($val['tmp_name'], $root . '/' . $file_name);
                    }
                }
            }
        }
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
        $model_upload = EmployeeUploads::find()->where(['employee_id' => $model->id, 'upload_category' => 1])->all();
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
                $this->Imageupload($model);
                Yii::$app->session->setFlash('success', "Employee Details Updated Successfully");
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } return $this->render('update', [
                    'model' => $model,
                    'model_upload' => $model_upload,
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

    /**
     * Append one row to the document add form
     */
    public function actionAttachment() {
        if (Yii::$app->request->isAjax) {
            $data = $this->renderPartial('_form_add_attachment');
            echo $data;
        }
    }

    /**
     * Remove employee attachments
     */
    public function actionAttachmentDelete($id) {
        $model = EmployeeUploads::find()->where(['id' => $id])->one();
        if (!empty($model)) {
            if ($model->delete()) {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/employee/documents/' . $model->id;
                $file_name = $dirPath . '/' . $model->file;
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
                if (is_dir($dirPath)) {
                    rmdir($dirPath);
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}
