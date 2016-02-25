<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%element_size}}".
 *
 * @property string $id
 * @property string $element
 * @property string $size
 *
 * @property Proportion $size0
 * @property Element $element0
 */
class ElementSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%element_size}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['element', 'size'], 'required'],
            [['element', 'size'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'element' => Yii::t('app', 'Element'),
            'size' => Yii::t('app', 'Size'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize0()
    {
        return $this->hasOne(Proportion::className(), ['id' => 'size']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement0()
    {
        return $this->hasOne(Element::className(), ['id' => 'element']);
    }
}
