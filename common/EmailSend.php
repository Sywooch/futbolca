<?php
namespace common;

use Yii;

class EmailSend{

    public static function send($setTo, $subject, $compose, $attr = []){
        return Yii::$app->mail->compose(['html' => $compose.'-html', 'text' => $compose.'-text'], $attr)
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['adminName']])
            ->setTo($setTo)
            ->setSubject($subject)
            ->send();
    }
}