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
$SpecGroupCode = "begin_spec"; // !!! to config, to arParam !!!!
if(!\Bitrix\Main\Loader::includeModule('kt.medcab'))
	return;
if(!$arParams["ID"]) $arParams["ID"] = intval($_REQUEST["CODE"]);

///////////////////////
if (check_bitrix_sessid() && !empty($_REQUEST["medcard_apply"]))
{
	$medcard_update = KT\Medcab\WorksTable::update($arParams["ID"], array(
				'STATUS' => $_REQUEST["STATUS"],
				'CARD_TYPE' => $_REQUEST["CARD_TYPE"]
				)); //$arResult['TEST'] = $_REQUEST["STATUS"];
	(!$medcard_update->isSuccess() ? $arParams['UPDATED'] = $medcard_update->getErrorMessages() : $arParams['UPDATED'] = $medcard_update->getId());
}
//////////////////////

if(!$USER->IsAdmin()) $arFor = array('SPEC' => $USER->GetID());
$arFilter =(array(
	'select' => array(
				'*',
				'EVENT_' => 'WORK_EVENT.*',
				'TEST_' => 'TEST_EVENT.*',
				'SPEC_NAME' => 'SPEC.NAME',
				'SPEC_LAST_NAME' => 'SPEC.LAST_NAME',
				'WORK_NAME' => 'WORK.NAME'
				),
	'filter' => array('ID' => $arParams['ID'], $arFor)
//	'order' => array('WORK_EVENT.START_DATE') //link to eventstable
));
$arResult = KT\Medcab\WorksTable::getList($arFilter)->fetch(); //getRowByID
$arResult['CARD_TYPE_ENUM'] = KT\Medcab\WorksTable::CARD_TYPE;
$arResult['STATUS_ENUM'] = KT\Medcab\WorksTable::STATUS;
$arResult['SPEC_ENUM'] = \CGroup::GetGroupUser(CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $SpecGroupCode))->fetch()['ID']);

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