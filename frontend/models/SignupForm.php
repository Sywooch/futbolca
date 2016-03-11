<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passto;
    public $phone;
    public $verifyCode;

    public $name;
    public $soname;
    public $code;
    public $country;
    public $city;
    public $adress;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Это имя пользователя уже занято.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'string', 'min' => 6, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Этот адрес электронной почты уже занят.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 12],

            ['verifyCode', \common\recaptcha\ReCaptchaValidator::className(), 'secret' => \common\recaptcha\ReCaptcha::SECRET_KEY],

            [['passto'], 'required'],
            [['passto'], 'compare', 'compareAttribute' => 'password'],

            [['name', 'soname', 'code', 'country', 'city', 'adress'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Пароль'),
            'passto' => Yii::t('app', 'Повторите пароль'),
            'phone' => Yii::t('app', 'Телефон'),
            'verifyCode' => Yii::t('app', 'Я не робот'),
            'name' => Yii::t('app', 'Имя'),
            'soname' => Yii::t('app', 'Фамилия'),
            'code' => Yii::t('app', 'Почтовый индекс'),
            'country' => Yii::t('app', 'Область'),
            'city' => Yii::t('app', 'Город'),
            'adress' => Yii::t('app', 'Адресс'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = 'user';
        $user->created_at = time();
        $user->updated_at = time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if($user->save()){
            $description = new UserDescription();
            $description->name = $this->name;
            $description->user = $user->id;
            $description->soname = $this->soname;
            $description->code = $this->code;
            $description->country = $this->country;
            $description->city = $this->city;
            $description->adress = $this->adress;
            $description->save();
            return $user;
        }
        return null;
    }
}
