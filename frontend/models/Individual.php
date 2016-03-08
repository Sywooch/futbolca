<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%individual}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $admintext
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property string $img4
 * @property string $created
 */
class Individual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%individual}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['status'], 'integer'],
            [['comment', 'admintext'], 'string'],
            [['created'], 'safe'],
            [['name', 'phone', 'email', 'img1', 'img2', 'img3', 'img4'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Comment'),
            'admintext' => Yii::t('app', 'Admintext'),
            'img1' => Yii::t('app', 'Img1'),
            'img2' => Yii::t('app', 'Img2'),
            'img3' => Yii::t('app', 'Img3'),
            'img4' => Yii::t('app', 'Img4'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
