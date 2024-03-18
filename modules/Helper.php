<?php

// namespace modules;

use Yii;
use yii\helpers\VarDumper;

if (!function_exists('dump')) {
    function dump(...$args) {
        foreach($args as $arg) {
        	echo '<pre>';
            VarDumper::dump($arg);
            echo '</pre>';
        }
    }
}

if (!function_exists('dd')) {
    function dd(...$args) {
    	dump(...$args);
        exit();
    }
}

function app() {
    return Yii::$app;
}

function user() {
    return app()->user;
}

function getUser() {
    return app()->getUser();
}

function request() {
    return app()->request;
}

function post() {
    return request()->post();
}

function isPost() {
    return request()->isPost;
}

function session() {
    return app()->session;
}