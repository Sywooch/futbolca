<?php
namespace frontend\controllers;

use backend\models\Country;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\Item;
use frontend\models\Marker;
use frontend\models\Region;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Item::find()->with(['element0', 'itemWatermarks'])->where("home = :home AND active = :active", [
            ':home' => 1,
            ':active' => 1
        ])->orderBy('position desc, id desc')->limit(12)->all();
        return $this->render('index', [
            'models' => $models
        ]);
    }

    public function actionRss()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        $key = md5(Url::canonical());
        $timeCache = 60;
        $items = Yii::$app->cache->get($key);
        if($items === false) {
            $items = Item::find()->with([
                'itemMarkers',
                'itemCategories'
            ])->where("active = 1")->orderBy('id desc')->limit(200)->all();
            Yii::$app->cache->set($key, $items, $timeCache);
        }
        return $this->renderPartial('rss', [
            'items' => $items,
        ]);
    }

    public function actionSitemap()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        $categories = Category::find()->orderBy('position desc, id desc')->all();
        $tags = Marker::find()->orderBy('position desc, id desc')->all();
        $key = md5(Url::canonical());
        $timeCache = 60;
        $items = Yii::$app->cacheFile->get($key);
        if($items === false) {
            $items = Item::find()->where("active = 1")->orderBy('position desc, id desc')->limit(4000)->all();
            Yii::$app->cacheFile->set($key, $items, $timeCache);
        }
        return $this->renderPartial('sitemap', [
            'categories' => $categories,
            'tags' => $tags,
            'items' => $items,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest()
    {
//        Yii::$app->mail->compose()
//            ->setTo('php-shaman@yandex.ru')
//            ->setFrom([Yii::$app->params['siteEmail'] => Yii::$app->params['siteNameForEmail']])
//            ->setSubject('Test')
//            ->setTextBody('тестовая отправка мыла')
//            ->send();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionAutoregion()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        $search = Yii::$app->request->post('term');
        if(!$search){
            throw new BadRequestHttpException(Yii::t('app', 'Not search text'));
        }
        $search = $search.'%';
        Yii::$app->response->format = 'json';
        $country = Country::find()->where("name = :name", [':name' => 'Украина'])->one();
        $model = Region::find();
        $model->where("name LIKE :name", [':name' => $search]);
        if($country){
            $model->andWhere("country = :country", [':country' => $country->id]);
        }
        $model->orderBy('name asc');
        $model = $model->all();
        return ArrayHelper::map($model, 'name', 'name');
    }

    public function actionAutocity()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        $search = Yii::$app->request->post('term');
        if(!$search){
            throw new BadRequestHttpException(Yii::t('app', 'Not search text'));
        }
        $search = $search.'%';
        Yii::$app->response->format = 'json';
        $country = Country::find()->where("name = :name", [':name' => 'Украина'])->one();
        $region = Region::find()->where("name = :name", [':name' => Yii::$app->request->post('region')])->one();
        $model = City::find();
        $model->where("name LIKE :name", [':name' => $search]);
        if($country){
            $model->andWhere("country = :country", [':country' => $country->id]);
        }
        if($region){
            $model->andWhere("region = :region", [':region' => $region->id]);
        }
        $model->orderBy('name asc');
        $model = $model->all();
        return ArrayHelper::map($model, 'name', 'name');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset() // $2y$13$zMx1jhNbJ1h9To0g9FJM2.5AkOFnMkaUIf8mmbr2jFe0A/4sb9a3W
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Проверьте свою электронную почту для получения дальнейших инструкций.'));

                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'К сожалению, мы не можем сбросить пароль для электронной почты'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetpassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Новый пароль был сохранен.'));

            return $this->redirect(Url::toRoute(['site/login']));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
