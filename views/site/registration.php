<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?=
                $form->field($model, 'username')
                    ->textInput(['autofocus' => true])
                    ->label('Ваше имя')
            ?>
            <?=
                $form->field($model, 'email')
                    ->textInput()
                    ->label('Ваш Email')
            ?>

            <?=
                $form->field($model, 'password')
                    ->passwordInput()
                    ->label('Ваш пароль')
            ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Registration', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <div style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div>

        </div>
    </div>
</div>
