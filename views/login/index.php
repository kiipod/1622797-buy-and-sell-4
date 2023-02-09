<?php

/** @var yii\web\View $this
 * @var LoginForm $loginForm
 */

use app\models\forms\LoginForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Вход на сайт';
?>

<section class="login">
    <h1 class="visually-hidden">Логин</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['class' => 'login__form form'],
        'errorCssClass' => 'form__field--invalid',
        'fieldConfig' => [
            'template' => '{input}{label}{error}',
            'options' => ['class' => 'form__field login__field'],
            'errorOptions' => ['tag' => 'span'],
            ]
    ]);
?>
        <div class="login__title">
            <a class="login__link" href="<?= Url::toRoute('/register') ?>">Регистрация</a>
            <h2>Вход</h2>
        </div>
        <?= $form->field($loginForm, 'email')->textInput(['class' => 'js-field']);?>
        <?= $form->field($loginForm, 'password')->passwordInput(['class' => 'js-field']);?>

        <button class="login__button btn btn--medium js-button" type="submit" disabled="">Войти</button>

        <a class="btn btn--small btn--flex btn--white" href="#">
            Войти через
            <span class="icon icon--vk"></span>
        </a>
    <?php ActiveForm::end(); ?>
</section>
