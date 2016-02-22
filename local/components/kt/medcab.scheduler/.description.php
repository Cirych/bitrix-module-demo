<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

$arComponentDescription = array(
	"NAME" => GetMessage("CALENDAR_NAME"),
	"DESCRIPTION" => GetMessage("CALENDAR_DESC"),
	"ICON" => "/images/calendar.gif",
	"SORT" => 40,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "medcab",
		"NAME" => GetMessage("MEDCAB_NAME"),
		"CHILD" => array(
			"ID" => "sheduler",
			"NAME" => GetMessage("CALENDAR_GROUP"),
			"SORT" => 10,
		)
	),
);

?>
