<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UserDescription $description0
 */

// $2y$13$zMx1jhNbJ1h9To0g9FJM2.5AkOFnMkaUIf8mmbr2jFe0A/4sb9a3W = 111111

class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeValidate()
    {

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'created_at', 'updated_at'], 'required'],
            [['role'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            ['password_hash', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Ф.И.О.'),
            'role' => Yii::t('app', 'Роль'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Пароль'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Дата регистрации'),
            'updated_at' => Yii::t('app', 'Последнее обновление'),
        ];
    }

    public static function listStatus(){
        return [
            10 => Yii::t('app', 'Активный'),
            20 => Yii::t('app', 'Забанен'),
        ];
    }

    public static function getStatusName($id){
        return isset(self::listStatus()[$id]) ? self::listStatus()[$id] : null;
    }

    public static function listRole(){
        return [
            'user' => Yii::t('app', 'Пользователь'),
            'moderator' => Yii::t('app', 'Модератор'),
            'admin' => Yii::t('app', 'Админ'),
        ];
    }

    public static function getRoleName($id){
        return isset(self::listRole()[$id]) ? self::listRole()[$id] : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription0()
    {
        return $this->hasOne(UserDescription::className(), ['user' => 'id']);
    }
}
