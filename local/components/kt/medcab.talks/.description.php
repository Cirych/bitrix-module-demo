<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MEDCARD_TALKS_NAME"),
	"DESCRIPTION" => GetMessage("MEDCARD_TALKS_DESCRIPTION"),
	"ICON" => "/images/mctalks.gif",
	"PATH" => array(
		"ID" => "medcab",
		"NAME" => GetMessage("MEDCAB_NAME"),
		"CHILD" => array(
			"ID" => "talks",
			"NAME" => GetMessage("TALKS_GROUP"),
			"SORT" => 10,
		)
	),
);
?>