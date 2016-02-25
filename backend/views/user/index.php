<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
$idEditStatus = [];
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            [
                'attribute' => 'role',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#status_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="role" data-source=\''.\yii\helpers\Json::encode(User::listRole()).'\' data-value="'.$model->role.'" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('user/role').'" id="status_edit_'.$model->id.'" data-type="select" data-title="Редактировать">'.User::getRoleName($model->role).'</a>';
                },
                'filter' =>  User::listRole(),
            ],
             'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEditStatus) {
                    $idEditStatus[] = '#ss_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="status" data-source=\''.\yii\helpers\Json::encode(User::listStatus()).'\' data-value="'.$model->status.'" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('user/status').'" id="status_edit_'.$model->id.'" data-type="select" data-title="Редактировать">'.User::getStatusName($model->status).'</a>';
                },
                'filter' =>  User::listStatus(),
            ],
            [
                'attribute' => 'created_at',
                'value'=> function ($model) {
                    return date("d/m/Y", $model->created_at);
                },
                'filter' =>  false,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php

$idEdit = join(', ', $idEdit);
$idEditStatus = join(', ', $idEditStatus);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    var ListStatusEdit = '{$idEditStatus}';
    if(ListDesc){
        $(ListDesc).editable();
    }
    if(ListStatusEdit){
        $(ListStatusEdit).editable();
    }
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
