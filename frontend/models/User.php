<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password
 * @property string $password_to
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UserDescription $userDescription
 */
class User extends \yii\db\ActiveRecord
{

    public $password;
    public $password_to;
    public $currentPassword;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeValidate()
    {
        $this->updated_at = time();
        $this->currentPassword = $this->currentPassword ? $this->currentPassword : $this->password_hash;
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_to'], 'filter', 'filter' => 'trim'],
            [['username', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['role'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],

            ['password', 'string', 'min' => 6, 'max' => 12],
            [['password_to'], 'compare', 'compareAttribute' => 'password'],
            [['currentPassword'], 'required'],
            [['currentPassword'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Логин'),
            'role' => Yii::t('app', 'Роль'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Хешь пароля'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Зарегистрирован'),
            'updated_at' => Yii::t('app', 'Последнее обновление'),
            'password' => Yii::t('app', 'Пароль'),
            'password_to' => Yii::t('app', 'Пароль еще раз'),
            'currentPassword' => Yii::t('app', 'Текущий пароль'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDescription()
    {
        return $this->hasOne(UserDescription::className(), ['user' => 'id']);
    }
}
