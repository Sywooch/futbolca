<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_link_basics".
 *
 * @property string $lb_id
 * @property string $lb_id_basics
 * @property string $lb_id_tovar
 * @property string $pr_basics_in_sp
 */
class LinkBasics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_link_basics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lb_id_basics', 'lb_id_tovar', 'pr_basics_in_sp'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lb_id' => Yii::t('app', 'Lb ID'),
            'lb_id_basics' => Yii::t('app', 'Lb Id Basics'),
            'lb_id_tovar' => Yii::t('app', 'Lb Id Tovar'),
            'pr_basics_in_sp' => Yii::t('app', 'Pr Basics In Sp'),
        ];
    }
}
