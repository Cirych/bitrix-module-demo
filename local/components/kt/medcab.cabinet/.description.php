<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CABINET_NAME"),
	"DESCRIPTION" => GetMessage("CABINET_DESCRIPTION"),
	"ICON" => "/images/cabinet.gif",
	"COMPLEX" => "Y",
	"PATH" => array(
		"ID" => "medcab",
		"NAME" => GetMessage("MEDCAB_NAME"),
		"CHILD" => array(
			"ID" => "medcab_medcard",
			"NAME" => GetMessage("MEDCAB_MEDCARD_NAME"),
			"CHILD" => array(
				"ID" => "kt_medcab_cabinet",
				"NAME" => GetMessage("MEDCAB_CABINET_NAME"),
			),
		),
	),
);
?>