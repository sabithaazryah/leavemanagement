<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ForgotPasswordTokens;
use common\models\Employee;
use common\models\AdminPost;
use common\models\LeaveConfiguration;

/**
 * Site controller
 */
class SiteController extends Controller {

        /**
         * @inheritdoc
         */
        public function behaviors() {
                return [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                [
                                'actions' => ['login', 'error', 'index', 'home', 'forgot', 'new-password', 'exception', 'setleaves'],
                                'allow' => true,
                            ],
                                [
                                'actions' => ['logout', 'index'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'logout' => ['post'],
                        ],
                    ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function actions() {
                return [
                    'error' => [
                        'class' => 'yii\web\ErrorAction',
                    ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex() {
                if (!Yii::$app->user->isGuest) {
                        return $this->redirect(array('site/home'));
                }
                $this->layout = 'login';
                $model = new Employee();
                $model->scenario = 'login';
                if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

                        return $this->redirect(array('site/home'));
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Set Session.
         *
         * @return Session Array
         */
        public function setSession() {
                $post = AdminPost::findOne(Yii::$app->user->identity->post_id);
                if (!empty($post)) {
                        Yii::$app->session['post'] = $post->attributes;
                        Yii::$app->session['encrypted_user_id'] = Yii::$app->EncryptDecrypt->Encrypt('encrypt', Yii::$app->user->identity->post_id);
                        return true;
                } else {
                        return FALSE;
                }
        }

        public function actionHome() {
                if (isset(Yii::$app->user->identity->id)) {
                        if (Yii::$app->user->isGuest) {
                                return $this->redirect(array('site/index'));
                        }
                        return $this->render('index', [
                        ]);
                } else {
                        throw new \yii\web\HttpException(2000, 'Session Expired.');
                }
        }

        /**
         * Login action.
         *
         * @return string
         */
        public function actionLogin() {
                if (!Yii::$app->user->isGuest) {
                        return $this->goHome();
                }

                $this->layout = 'login';
                $model = new Employee();
                $model->scenario = 'login';
                if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

                        return $this->redirect(array('site/home'));
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Logout action.
         *
         * @return string
         */
        public function actionLogout() {
                Yii::$app->user->logout();

                return $this->goHome();
        }

        public function actionForgot() {
                $this->layout = 'login';
                $model = new Employee();
                if ($model->load(Yii::$app->request->post())) {
                        $check_exists = Employee::find()->where("user_name = '" . $model->user_name . "' OR email = '" . $model->user_name . "'")->one();

                        if (!empty($check_exists)) {
                                $token_value = $this->tokenGenerator();
                                $token = $check_exists->id . '_' . $token_value;
                                //$val = base64_encode($token);
                                $val = Yii::$app->EncryptDecrypt->Encrypt('encrypt', $token);

                                $token_model = new ForgotPasswordTokens();
                                $token_model->user_id = $check_exists->id;
                                $token_model->token = $token_value;
                                $token_model->save();

                                $this->sendMail($val, $check_exists);
                                Yii::$app->getSession()->setFlash('success', 'A verification email has been sent to your mail, please check the spam box if you can not find the mail in your inbox.');
                        } else {
                                Yii::$app->getSession()->setFlash('error', 'Invalid username');
                        }
                        return $this->render('forgot-password', [
                                    'model' => $model,
                        ]);
                } else {
                        return $this->render('forgot-password', [
                                    'model' => $model,
                        ]);
                }
        }

        public function tokenGenerator() {



                $length = rand(1, 1000);
                $chars = array_merge(range(0, 9));
                shuffle($chars);
                $token = implode(array_slice($chars, 0, $length));
                return $token;
        }

        public function sendMail($val, $model) {

                $to = $model->email;
                $subject = 'Change password';
                $message = $this->renderPartial('forgot_mail', ['model' => $model, 'val' => $val]);
// To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                        "From: noreplay@eleave.com";
                mail($to, $subject, $message, $headers);
        }

        public function actionNewPassword($token) {
                $this->layout = 'login';
                $data = Yii::$app->EncryptDecrypt->Encrypt('decrypt', $token);
                $values = explode('_', $data);
                $token_exist = ForgotPasswordTokens::find()->where("user_id = " . $values[0] . " AND token = " . $values[1])->one();
                if (!empty($token_exist)) {
                        $model = Employee::find()->where("id = " . $token_exist->user_id)->one();
                        if (Yii::$app->request->post()) {
                                if (Yii::$app->request->post('new-password') == Yii::$app->request->post('confirm-password')) {
                                        Yii::$app->getSession()->setFlash('success', 'password changed successfully');
                                        $model->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirm-password'));
                                        $model->update();
                                        $token_exist->delete();
                                        $this->redirect('index');
                                } else {
                                        Yii::$app->getSession()->setFlash('error', 'Password mismatch  ');
                                }
                        }
                        return $this->render('new-password', [
                        ]);
                } else {

                }
        }

        public function actionException() {
                return $this->render('exception');
        }

        public function actionSetleaves() {
                if (\Yii::$app->request->post()) {

                        if (isset($_POST['carry-forward'])) {
                                $this->CarryForward();
                        } else if (isset($_POST['transfer-leaves'])) {
                                $this->TransferLeaves();
                        }
                }
                return $this->render('set-leaves', [
                ]);
        }

        public function CarryForward() {
                $current_year = date('Y');
                $employess = Employee::find()->all();
                foreach ($employess as $employes) {
                        $employee_years = LeaveConfiguration::find()->where(['employee_id' => $employes->id])->select(['year'])->distinct()->orderBy(['year' => SORT_DESC])->limit(1)->one();
                        $employee_latest_leaves = LeaveConfiguration::find()->where(['employee_id' => $employes->id, 'year' => $employee_years->year])->all();
                        foreach ($employee_latest_leaves as $latest_leaves) {

                                $previous_year_leave = LeaveConfiguration::find()->where(['employee_id' => $latest_leaves->employee_id, 'year' => $latest_leaves->year - 1, 'leave_type' => $latest_leaves->leave_type])->one();
                                if (isset($previous_year_leave)) {
                                        $latest_leaves->carry_forward = $previous_year_leave->available_days;
                                        $previous_year_leave->available_days = 0;
                                        $latest_leaves->available_days = $latest_leaves->available_days + $latest_leaves->carry_forward;
                                        if ($latest_leaves->save(FALSE)) {
                                                $previous_year_leave->save(FALSE);
                                        }
                                }
                        }
                }
        }

        public function TransferLeaves() {
                $current_year = date('Y');
                $employess = Employee::find()->all();
                foreach ($employess as $employes) {
                        $employee_leaves = LeaveConfiguration::find()->where(['employee_id' => $employes->id, 'year' => $current_year])->all();
                        if (count($employee_leaves) > 0) {
                                foreach ($employee_leaves as $leaves) {
                                        $nxt_year_leaves = LeaveConfiguration::find()->where(['employee_id' => $employes->id, 'year' => $current_year + 1, 'leave_type' => $leaves->leave_type])->exists();
                                        if (!$nxt_year_leaves) {
                                                $new_leaves = new LeaveConfiguration;
                                                $new_leaves->employee_id = $leaves->employee_id;
                                                $new_leaves->leave_type = $leaves->leave_type;
                                                $new_leaves->entitlement = $leaves->entitlement;
                                                $new_leaves->carry_forward = 0;
                                                $new_leaves->available_days = $leaves->no_of_days;
                                                $new_leaves->year = $leaves->year + 1;
                                                $new_leaves->save();
                                        }
                                }
                        }
                }
        }

}
