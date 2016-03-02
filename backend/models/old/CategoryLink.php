<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "mg_category_link".
 *
 * @property string $cl_pid
 * @property string $cl_catid
 */
class CategoryLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_category_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cl_pid', 'cl_catid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cl_pid' => Yii::t('app', 'Cl Pid'),
            'cl_catid' => Yii::t('app', 'Cl Catid'),
        ];
    }
}
