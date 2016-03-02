<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "mg_order".
 *
 * @property string $or_id
 * @property string $or_data_start
 * @property string $or_data_finish
 * @property string $or_u_id
 * @property string $or_u_name
 * @property string $or_u_soname
 * @property string $or_u_email
 * @property string $or_u_phone
 * @property string $or_u_adress
 * @property string $or_u_index
 * @property string $or_u_city
 * @property string $or_u_country
 * @property integer $or_payment
 * @property string $or_dostavkainajax
 * @property string $or_u_agent
 * @property string $or_u_region
 * @property string $or_u_fax
 * @property string $or_u_icq
 * @property string $or_u_skape
 * @property string $or_nabor_tovara
 * @property integer $or_status
 * @property string $or_coment_admin
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['or_data_start', 'or_data_finish', 'or_u_id', 'or_payment', 'or_dostavkainajax', 'or_status'], 'integer'],
            [['or_u_name', 'or_u_soname', 'or_u_email', 'or_u_phone', 'or_u_adress', 'or_u_index', 'or_u_city', 'or_u_country', 'or_u_agent', 'or_u_region', 'or_u_fax', 'or_u_icq', 'or_u_skape', 'or_nabor_tovara', 'or_coment_admin'], 'required'],
            [['or_u_adress', 'or_u_agent', 'or_nabor_tovara', 'or_coment_admin'], 'string'],
            [['or_u_name', 'or_u_soname', 'or_u_email', 'or_u_city', 'or_u_country', 'or_u_region'], 'string', 'max' => 255],
            [['or_u_phone', 'or_u_skape'], 'string', 'max' => 200],
            [['or_u_index', 'or_u_fax', 'or_u_icq'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'or_id' => Yii::t('app', 'Or ID'),
            'or_data_start' => Yii::t('app', 'Or Data Start'),
            'or_data_finish' => Yii::t('app', 'Or Data Finish'),
            'or_u_id' => Yii::t('app', 'Or U ID'),
            'or_u_name' => Yii::t('app', 'Or U Name'),
            'or_u_soname' => Yii::t('app', 'Or U Soname'),
            'or_u_email' => Yii::t('app', 'Or U Email'),
            'or_u_phone' => Yii::t('app', 'Or U Phone'),
            'or_u_adress' => Yii::t('app', 'Or U Adress'),
            'or_u_index' => Yii::t('app', 'Or U Index'),
            'or_u_city' => Yii::t('app', 'Or U City'),
            'or_u_country' => Yii::t('app', 'Or U Country'),
            'or_payment' => Yii::t('app', 'Or Payment'),
            'or_dostavkainajax' => Yii::t('app', 'Or Dostavkainajax'),
            'or_u_agent' => Yii::t('app', 'Or U Agent'),
            'or_u_region' => Yii::t('app', 'Or U Region'),
            'or_u_fax' => Yii::t('app', 'Or U Fax'),
            'or_u_icq' => Yii::t('app', 'Or U Icq'),
            'or_u_skape' => Yii::t('app', 'Or U Skape'),
            'or_nabor_tovara' => Yii::t('app', 'Or Nabor Tovara'),
            'or_status' => Yii::t('app', 'Or Status'),
            'or_coment_admin' => Yii::t('app', 'Or Coment Admin'),
        ];
    }
}
