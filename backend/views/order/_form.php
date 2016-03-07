<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'status')->dropDownList(Order::statusList()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'soname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'skape')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'icq')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'payment')->dropDownList(\backend\models\Paying::listPay()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'delivery')->dropDownList(\backend\models\Delivery::listDelivery()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agent')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'coment_admin')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerCssFile('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
$this->registerJsFile('//code.jquery.com/ui/1.11.4/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$url = \yii\helpers\Url::toRoute('user/city');
$urlRegion = \yii\helpers\Url::toRoute('user/region');
$js = <<<JS
$("#order-city").autocomplete({
  source: "{$url}",
  minLength: 2
});
$("#order-country").autocomplete({
  source: "{$urlRegion}",
  minLength: 2
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');