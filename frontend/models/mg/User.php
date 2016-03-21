<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_user".
 *
 * @property string $u_id
 * @property string $u_email
 * @property string $u_login
 * @property string $u_pass
 * @property string $u_last_visit
 * @property string $u_ip
 * @property integer $u_admin
 * @property string $u_name
 * @property string $u_soname
 * @property string $u_adress
 * @property string $u_index
 * @property string $u_city
 * @property string $u_region
 * @property string $u_country
 * @property string $u_phone
 * @property string $u_fax
 * @property string $u_icq
 * @property string $u_skape
 * @property string $u_agent
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_email', 'u_login', 'u_pass', 'u_last_visit', 'u_ip', 'u_name', 'u_soname', 'u_adress', 'u_index', 'u_city', 'u_region', 'u_country', 'u_phone', 'u_fax', 'u_icq', 'u_skape', 'u_agent'], 'required'],
            [['u_last_visit', 'u_admin'], 'integer'],
            [['u_ip', 'u_adress', 'u_agent'], 'string'],
            [['u_email', 'u_index', 'u_phone', 'u_fax', 'u_icq'], 'string', 'max' => 100],
            [['u_login', 'u_pass'], 'string', 'max' => 255],
            [['u_name', 'u_soname', 'u_city', 'u_region', 'u_country', 'u_skape'], 'string', 'max' => 200],
            [['u_email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => Yii::t('app', 'U ID'),
            'u_email' => Yii::t('app', 'U Email'),
            'u_login' => Yii::t('app', 'U Login'),
            'u_pass' => Yii::t('app', 'U Pass'),
            'u_last_visit' => Yii::t('app', 'U Last Visit'),
            'u_ip' => Yii::t('app', 'U Ip'),
            'u_admin' => Yii::t('app', 'U Admin'),
            'u_name' => Yii::t('app', 'U Name'),
            'u_soname' => Yii::t('app', 'U Soname'),
            'u_adress' => Yii::t('app', 'U Adress'),
            'u_index' => Yii::t('app', 'U Index'),
            'u_city' => Yii::t('app', 'U City'),
            'u_region' => Yii::t('app', 'U Region'),
            'u_country' => Yii::t('app', 'U Country'),
            'u_phone' => Yii::t('app', 'U Phone'),
            'u_fax' => Yii::t('app', 'U Fax'),
            'u_icq' => Yii::t('app', 'U Icq'),
            'u_skape' => Yii::t('app', 'U Skape'),
            'u_agent' => Yii::t('app', 'U Agent'),
        ];
    }
}
