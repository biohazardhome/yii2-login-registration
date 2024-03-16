<?php

namespace modules;

use Yii;
use yii\helpers\VarDumper;

function dump(...$args) {
    foreach($args as $arg) {
    	echo '<pre>';
        VarDumper::dump($arg);
        echo '</pre>';
    }
}

function dd(...$args) {
	dump(...$args);
    exit();
}

function app() {
    return Yii::$app;
}

function request() {
    return app()->request;
}