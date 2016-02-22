<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MEDCARD_LIST_NAME"),
	"DESCRIPTION" => GetMessage("MEDCARD_LIST_DESCRIPTION"),
	"ICON" => "/images/mclist.gif",
	"PATH" => array(
		"ID" => "medcab",
		"NAME" => GetMessage("MEDCAB_NAME"),
		"CHILD" => array(
			"ID" => "medcab_medcard",
			"NAME" => GetMessage("MEDCAB_MEDCARD_NAME"),
			"CHILD" => array(
				"ID" => "kt_medcab_medcard_list",
				"NAME" => GetMessage("MEDCAB_MEDCARD_LIST_NAME"),
			),
		),
	),
);
?>