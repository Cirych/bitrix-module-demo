<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
$this->setFrameMode(false);

// $arParams: 'FOR', 

// if(!\Bitrix\Main\Loader::includeModule('kt.medcab')) return;

if(!\Bitrix\Main\Loader::includeModule('pull')) return;

$this->arResult['ajaxLink'] = $this->getPath().'/ajax.php';
$arResult['USER_ID'] = $USER->GetID();
CPullWatch::Add($USER->GetId(), 'PULL_TEST');

$this->IncludeComponentTemplate();
?>