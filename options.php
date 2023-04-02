<?php

global $USER;
global $APPLICATION;

if (!$USER->IsAdmin()) {
    return;
}

use Bitrix\Main\Loader;
use Bx\Options\Form\Element\Field\SelectField;
use Bx\Options\Form\Element\Field\TextField;
use Bx\Options\Form\Element\UI\Divider;
use Bx\Options\Form\Element\UI\Notice;
use Bx\Options\Form\Render\JsonRender;
use Bx\Options\Form\Element\Tab;
use Bx\Options\Form\TabbedForm;
use Bx\Options\Form\Validator\NotEmpty;

Loader::includeModule('bx.options');

$cityVariant = [
  "1" => "Москва",
  "2" => "Москва 2",
  "3" => "Москва 3",
  "4" => "Москва 4",
];


$form = new TabbedForm(
    "",
    new Tab(
        "Общие настройки",
        (new TextField("some_setting", "Название"))
        ->setValidator(new NotEmpty()),
        new TextField("some_setting1", "Название 1"),
        new Divider("Разделитель"),
        new TextField("some_setting2", "Название 2"),
        new TextField("some_setting3", "Название 3"),
        new SelectField("some_select", "Город", $cityVariant)
    ),
    new Tab(
        "Логирование",
        new Notice("Заголовок", "Текст", "info"),
        new TextField("some_setting123", "Название2"),
        new SelectField("some_select2", "Город2", $cityVariant, true),
        new Divider("Разделитель2"),
    )
);

$APPLICATION->IncludeComponent("bx.options:option.form", "vue_app", [
  "UI_OBJECT" => $form,
  "NAMESPACE" => "bx.options",
]);
