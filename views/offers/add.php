<?php

/** @var yii\web\View $this
 * @var object $offerForm
 */

use app\models\AdCategories;
use app\models\AdTypes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$categories = AdCategories::find()->all();
$types = AdTypes::find()->all();

?>

<section class="ticket-form">
    <div class="ticket-form__wrapper">
        <h1 class="ticket-form__title">Новая публикация</h1>
        <div class="ticket-form__tile">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'options' => ['class' => 'ticket-form__form form'],
                'errorCssClass' => 'form__field--invalid',
                'fieldConfig' => [
                    'template' => '{input}{label}{error}',
                    'errorOptions' => ['tag' => 'span']
                ]
            ]);
?>
                <div class="ticket-form__avatar-container js-preview-container">
                    <div class="ticket-form__avatar js-preview"></div>
                    <div class="ticket-form__field-avatar">
                        <?= $form->field($offerForm, 'image', ['template' => '{input}'])
                            ->fileInput(['class' => 'visually-hidden js-file-field', 'id' => 'avatar']); ?>
                        <label for="avatar">
                            <span class="ticket-form__text-upload">Загрузить фото…</span>
                            <span class="ticket-form__text-another">Загрузить другое фото…</span>
                        </label>
                    </div>
                </div>
                <div class="ticket-form__content">
                    <div class="ticket-form__row">
                            <?= $form->field($offerForm, 'name', [
                                'options' => [
                                    'class' => 'form__field']])->textInput(['class' => 'js-field']); ?>
                    </div>
                    <div class="ticket-form__row">
                            <?= $form->field($offerForm, 'description', [
                                'options' => ['class' => 'form__field']])
                                ->textarea(['class' => 'js-field']); ?>
                    </div>
                    <div class="ticket-form__row">
                    <?= $form->field($offerForm, 'categories')
                        ->dropDownList(ArrayHelper::map($categories, 'id', 'name'), [
                            'class' => 'form__select js-multiple-select',
                            'placeholder' => "Выбрать категорию публикации",
                            'multiple' => true])
                        ->label(false); ?>
                    </div>
                    <div class="ticket-form__row">
                            <?= $form->field($offerForm, 'price', [
                                'options' => ['class' => 'form__field form__field--price']])
                                ->input('number', ['class' => 'js-field js-price']); ?>
                            <?= $form->field($offerForm, 'typeId', ['template' => '{input}{error}'])
                                ->radioList(ArrayHelper::map($types, 'id', 'name'), ['class' => 'form__switch switch',
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return
                                            Html::beginTag('div', ['class' => 'switch__item']) .
                                            Html::radio($name, $checked, ['value' => $value,
                                                'id' => $index, 'class' => 'visually-hidden']) .
                                            Html::label($label, $index, ['class' => 'switch__button']) .
                                            Html::endTag('div');
                                }
                                ]); ?>
                    </div>
                </div>

                <button class="form__button btn btn--medium js-button" type="submit" disabled="">Опубликовать</button>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
