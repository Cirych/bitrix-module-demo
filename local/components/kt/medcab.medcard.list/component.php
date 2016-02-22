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

if(!\Bitrix\Main\Loader::includeModule('kt.medcab'))
	return;
if(!$USER->IsAdmin())$arFor = array($arParams['FOR'] => $USER->GetID());
$arFilter =(array(
	'select' => array(
				'ID',
				'SPEC',
				'STATUS',
				'START_DATE' => 'WORK_EVENT.START_DATE',
				'END_DATE' => 'WORK_EVENT.END_DATE',
				'COLOR' => 'WORK_EVENT.COLOR',
				'TEXT' => 'WORK_EVENT.TEXT'
				),
	'filter' => array($arFor)
//	'order' => array('WORK_EVENT.START_DATE') //link to eventstable
));
$arResult['LIST'] = KT\Medcab\WorksTable::getList($arFilter)->fetchAll();

///////////////////////

	$arGroups = $USER->GetUserGroupArray();

	// check whether current user has access to view list
	if ($USER->IsAdmin() || is_array($arGroups) && is_array($arParams["GROUPS"]) && count(array_intersect($arGroups, $arParams["GROUPS"])) > 0)
	{
		$bAllowAccess = true;
	}
	elseif ($USER->GetID() > 0 && $arParams["ELEMENT_ASSOC"] != "N")
	{
		$bAllowAccess = true;
	}
	else
	{
		$bAllowAccess = false;
	}

	// if user has access
	if ($bAllowAccess)
	{
		$arResult["CAN_EDIT"] = $arParams["ALLOW_EDIT"] == "Y" ? "Y" : "N";
		$arResult["CAN_DELETE"] = $arParams["ALLOW_DELETE"] == "Y" ? "Y" : "N";

		if ($USER->GetID())
		{
			$arResult["NO_USER"] = "N";

		}
		else
		{
			$arResult["NO_USER"] = "Y";
		}

		$arResult["MESSAGE"] = htmlspecialcharsex($_REQUEST["strIMessage"]);

		$this->IncludeComponentTemplate();
	}
	else
	{
		$APPLICATION->AuthForm("");
	}
?>