<?php

namespace console\models;

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
            [['user'], 'unique'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'soname' => Yii::t('app', 'Soname'),
            'adress' => Yii::t('app', 'Adress'),
            'code' => Yii::t('app', 'Code'),
            'city' => Yii::t('app', 'City'),
            'region' => Yii::t('app', 'Region'),
            'country' => Yii::t('app', 'Country'),
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'icq' => Yii::t('app', 'Icq'),
            'skape' => Yii::t('app', 'Skape'),
            'agent' => Yii::t('app', 'Agent'),
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
