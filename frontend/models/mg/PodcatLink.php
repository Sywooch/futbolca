<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_podcat_link".
 *
 * @property string $pl_pid
 * @property string $pl_podid
 */
class PodcatLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_podcat_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pl_pid', 'pl_podid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pl_pid' => Yii::t('app', 'Pl Pid'),
            'pl_podid' => Yii::t('app', 'Pl Podid'),
        ];
    }
}
