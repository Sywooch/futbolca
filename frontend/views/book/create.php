<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $author app\models\Author */

$this->title = Yii::t('app', 'Создать книгу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Книги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'author' => $author,
    ]) ?>
</div>
