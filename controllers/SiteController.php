<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\RegistrationForm;
use app\models\ForgotPasswordForm;
use app\models\User;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration() {
        $model = new RegistrationForm();

        if (isPost()) { 
            if ($model->load(post()) && $model->validate()) {
                
                /*if (User::findByUsername($model->username)) {
                    session()->addFlash('danger', 'Уже есть такой пользователь: '. $model->username);
                }

                if (User::findByEmail($model->email)) {
                    session()->addFlash('danger', 'Пользователь с такой почтой уже существует: '. $model->email);
                }*/

                if (!User::findByUsername($model->username) && !User::findByEmail($model->email)) {
                    if ($user = $model->registration()) {
                        user()->login($user, 3600*24*30);

                        session()->addFlash('success', 'Успешно зарегистрирован новый пользователь: '. $model->username);
                    }
                }
            }
        }
        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('registration', [
                'model' => $model,
            ]);
        // } else {
            // return ;
        // }
    }

    public function actionForgotPassword() {
        $model = new ForgotPasswordForm;

        if (isPost()) { 
            if ($model->load(post()) && $model->validate()) {
                $user = User::findByEmail($model->email);
                if ($user) {
                    $password = $user->resetPassword();

                    app()->mailer->compose()
                        ->setFrom('stalker-nikko@yandex.ru')
                        ->setTo($model->email)
                        ->setSubject('Forgot password')
                        ->setHtmlBody('<b>New password: '. $password .'</b>')
                        ->send();

                } else {
                    session()->addFlash('danger', 'Нет такого пользователя с почтой: '. $model->email);
                }
            }
        }

        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
