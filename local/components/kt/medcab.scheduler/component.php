<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);

if(!\Bitrix\Main\Loader::includeModule('kt.medcab'))
	return;
$arFilter =(array(
	'select' => array(
				'ID',
				'START_DATE',
				'END_DATE',
				'COLOR',
				'TEXT'
				),
	'filter' => array($arFor)
//	'order' => array('WORK_EVENT.START_DATE') //link to eventstable
));
$arResult = KT\Medcab\EventsTable::getList($arFilter)->fetchAll();

$this->IncludeComponentTemplate();
?>