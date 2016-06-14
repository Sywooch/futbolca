<?php

namespace console\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%item_watermark}}".
 *
 * @property string $id
 * @property string $item
 * @property string $name
 * @property integer $position
 *
 * @property CartItem[] $cartItems
 * @property Item $item0
 * @property OrderItem[] $orderItems
 */
class ItemWatermark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_watermark}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'name'], 'required'],
            [['item', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item' => Yii::t('app', 'Item'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['watermark' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['watermark' => 'id']);
    }

    public function getImageUrl($small = false){
        if(!$this->name){
            return null;
        }
        return Url::home(true).'images/item/'.$this->item.'/'.($small ? 'mini_' : '').$this->name;
    }

    public function hasPhoto($mini = false){
        $photoName = $this->name;
        $imgDir = Yii::getAlias('@frontend/web/images/item/').$this->item.'/';
        if($mini){
            $imgDir .= 'mini_'.$photoName;
        }else{
            $imgDir .= $photoName;
        }
        return is_file($imgDir);
    }
}
