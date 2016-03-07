<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user_description}}".
 *
 * @property string $id
 * @property string $user
 * @property string $name
 * @property string $soname
 * @property string $adress
 * @property string $code
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $phone
 * @property string $fax
 * @property string $icq
 * @property string $skape
 * @property string $agent
 * @property string $ip
 *
 * @property User $user0
 */
class UserDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user'], 'required'],
            [['user'], 'integer'],
            [['name', 'soname', 'adress', 'code', 'city', 'region', 'country', 'phone', 'fax', 'icq', 'skape', 'agent', 'ip'], 'string', 'max' => 255],
            [['user'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'name' => Yii::t('app', 'Имя'),
            'soname' => Yii::t('app', 'Фамилия'),
            'adress' => Yii::t('app', 'Адресс'),
            'code' => Yii::t('app', 'Код'),
            'city' => Yii::t('app', 'Город'),
            'region' => Yii::t('app', 'Регион'),
            'country' => Yii::t('app', 'Область'),
            'phone' => Yii::t('app', 'Телефон'),
            'fax' => Yii::t('app', 'Fax'),
            'icq' => Yii::t('app', 'Icq'),
            'skape' => Yii::t('app', 'Skype'),
            'agent' => Yii::t('app', 'Разное'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
