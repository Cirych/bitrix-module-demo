<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"FOR" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage('CALENDAR_COMPONENT_FOR_PARAM'),
			"TYPE" => "LIST",
			"VALUES" => array(
						"CLIENT" => GetMessage('CALENDAR_COMPONENT_CLIENT_PARAM'),
						"SPEC" => GetMessage('CALENDAR_COMPONENT_SPEC_PARAM')
			)
		),
		"READONLY" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage('CALENDAR_COMPONENT_READONLY_PARAM'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
			)
		),
);
?>
