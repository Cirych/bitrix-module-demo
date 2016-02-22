<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"FOR" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage('MCLIST_COMPONENT_FOR_PARAM'),
			"TYPE" => "LIST",
			"VALUES" => array(
						"CLIENT" => GetMessage('MCLIST_COMPONENT_CLIENT_PARAM'),
						"SPEC" => GetMessage('MCLIST_COMPONENT_SPEC_PARAM')
			)
		),
		"SEF_MODE" => Array(
			"news" => array(
				"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS"),
				"DEFAULT" => "",
				"VARIABLES" => array(),
			),
			"section" => array(
				"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS_SECTION"),
				"DEFAULT" => "",
				"VARIABLES" => array("SECTION_ID"),
			)
		),
		"AJAX_MODE" => array(),
	),
);
?>