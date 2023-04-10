<?php

namespace Bx\Options\Components;

use Bx\Options\Form\Element\ParentElement;
use Bx\Options\Form\FormResult;
use Bx\Options\Form\Interfaces\FormElementInterface;
use Bx\Options\Form\Render\JsonRender;
use Bx\Options\Form\TreeFilter;
use Bx\Options\Manager;

class OptionForm extends \CBitrixComponent
{

    private $installComponentPath;

    private ParentElement $form;

    public function __construct($component = null)
    {
        $this->installComponentPath = $_SERVER['DOCUMENT_ROOT'].'/local/modules/bx.options/install/components/bx.options/option.form/';
        parent::__construct($component);
    }

    public function onPrepareComponentParams($arParams)
    {
        if ($arParams['UI_OBJECT'] instanceof ParentElement) {
            $this->form = $arParams['UI_OBJECT'];
        } else {
            \CAdminMessage::ShowMessage("в параметр UI_OBJECT должен быть передан объект имплементирующий интерфейс ParentElement");
        }

        return $arParams;
    }

    private function fillFormValue(ParentElement $element)
    {
        $filter = new TreeFilter(function ($element) {
            return $element instanceof FormElementInterface;
        });
        $elements = $filter->filter($element);
        $optionsManager = Manager::getInstance();
        foreach ($elements as $element) {
            /** @var FormElementInterface $element */
            $value = $optionsManager->getOption($this->arParams['NAMESPACE'], $element->getName());
            if ($element->getAttribute('multiple')->getValue() === true) {
                $value = unserialize($value);
            }
            $element->setValue($value);
        }
    }


    public function executeComponent()
    {
        $this->updateConponentIfNeed();

        if ($this->request->get('update') == 'success') {
            \CAdminMessage::ShowNote("Компонент успешно обновлен");
        }
        if ($this->request->isPost()) {
            $this->processPost();
        } else {
            $this->fillFormValue($this->form);
            $this->arResult['FORM_SCHEMA'] = $this->form->render(new JsonRender());
            $this->arResult['VERSION'] = $this->getCurrentVersion();
            return $this->includeComponentTemplate();
        }
    }

    private function processPost()
    {
        $formResult = FormResult::initFromUiElement($this->form);
        $body = json_decode(file_get_contents('php://input'), true);
        if (empty($body)) {
            return;
        }
        $formResult->setValuesFromArray($body);
        $validateResult = $formResult->validate();
        if ($validateResult->isValid()) {
            $this->saveOptions($formResult->getArray());
        } else {
            $this->showJson([
              'status' => 'error',
              'message' => 'Ошибка валидации',
              'errors' => $validateResult->getErrors(),
            ], 400);
        }
    }

    private function saveOptions($options)
    {
        $optionsManager = Manager::getInstance();
        foreach ($options as $name => $value) {
            $optionsManager->setOption($this->arParams['NAMESPACE'], $name, $value);
        }
        $this->showJson([
          'status' => 'success',
          'message' => 'Настройки успешно сохранены',
        ]);
    }

    private function showJson($data, $status = 200)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }

    private function updateConponentIfNeed()
    {
        $currentVersion = $this->getCurrentVersion();
        $installerVersion = $this->getInstallerVersion();
        if ($currentVersion < $installerVersion) {
            $this->updateComponentFile();
        }
    }

    private function getCurrentVersion($toInteger = false)
    {
        $versionFilePath = __DIR__ . '/version.txt';
        try {
            return $this->getVersionFromFile($versionFilePath, $toInteger);
        } catch (\Exception $e) {
            \CAdminMessage::ShowMessage($e->getMessage());
        }
    }

    private function getInstallerVersion($toInteger = false)
    {
        $versionFilePath = $this->installComponentPath . 'version.txt';
        try {
            return $this->getVersionFromFile($versionFilePath, $toInteger);
        } catch (\Exception $e) {
            \CAdminMessage::ShowMessage($e->getMessage());
        }
    }

    /**
     * @param $filePath
     * @return string
     * @throws \Exception
     */
    private function getVersionFromFile($filePath, $toInteger = false)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("Не найден файл версии компонента");
        }
        $version = file_get_contents($filePath);
        if (empty($version)) {
            throw new \Exception("Не удалось получить версию компонента");
        }
        if ($toInteger) {
            $version = (int) $version;
            var_dump($version);
        }
        return $version;
    }

    private function updateComponentFile()
    {
        $copyResult = CopyDirFiles(
            $this->installComponentPath,
            __DIR__,
            true,
            true
        );
        if ($copyResult && $this->waitComponentUpdate()) {
            LocalRedirect($this->request->getRequestUri() . "&update=success");
        } else {
            \CAdminMessage::ShowMessage("Ошибка обновления компонента");
        }
    }

    private function waitComponentUpdate($maxTime = 20): bool
    {
        while (true) {
            $currentVersion = $this->getCurrentVersion(true);
            $installerVersion = $this->getInstallerVersion(true);
            if ($currentVersion >= $installerVersion) {
                break;
            }
            sleep(1);
            $maxTime--;
            if ($maxTime <= 0) {
                break;
            }
        }
        return $currentVersion == $installerVersion;
    }
}
