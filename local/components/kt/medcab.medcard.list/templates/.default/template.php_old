<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);

$colspan = 2;
if ($arResult["CAN_EDIT"] == "Y") $colspan++;
if ($arResult["CAN_DELETE"] == "Y") $colspan++;
?>
<?
foreach ($arResult["ELEMENTS"] as $arElement):
$arMedcard[$i++]=$arElement["ID"];
endforeach;
KT::set('MyMedcard', $arMedcard); //print_r(KT::get('MyMedcard'));
?>
<?
$APPLICATION->IncludeComponent(
	"kt:news.calendar", 
	".default", 
	array(
		"IBLOCK_TYPE" => "references",
		"IBLOCK_ID" => "10",
		"MONTH_VAR_NAME" => "month",
		"YEAR_VAR_NAME" => "year",
		"WEEK_START" => "1",
		"SHOW_YEAR" => "Y",
		"SHOW_TIME" => "Y",
		"TITLE_LEN" => "0",
		"SHOW_CURRENT_DATE" => "Y",
		"SHOW_MONTH_LIST" => "Y",
		"NEWS_COUNT" => "0",
		"DETAIL_URL" => "?edit=Y&CODE=#ELEMENT_ID#",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"DATE_FIELD" => "PROPERTY_STARTWORKTIME_VALUE",
		"DATE_FIELD_SELECT" => "PROPERTY_STARTWORKTIME",
		"MEDCARD" => KT::get('MyMedcard'),
		"TYPE" => "EVENTS",
		"SET_TITLE" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
	);
?>
<?if (strlen($arResult["MESSAGE"]) > 0):?>
	<?ShowNote($arResult["MESSAGE"])?>
<?endif?>
<table class="data-table">
<?if($arResult["NO_USER"] == "N"):?>
	<thead>
		<tr>
			<td<?=$colspan > 1 ? " colspan=\"".$colspan."\"" : ""?>><?=GetMessage("IBLOCK_ADD_LIST_TITLE")?></td>
		</tr>
	</thead>
	<tbody>
	<?if (count($arResult["ELEMENTS"]) > 0):?>
		<?foreach ($arResult["ELEMENTS"] as $arElement):?>
		<tr>
			<td><!--a href="detail.php?CODE=<?=$arElement["ID"]?>"--><?=$arElement["NAME"]?><!--/a--></td>
			<td><small><?$res = CIBlockElement::GetProperty($arElement["IBLOCK_ID"], $arElement["ID"], "sort", "asc", array("CODE" => "STATUS")); if ($ob = $res->GetNext()) echo $ob ["VALUE_ENUM"];?></small></td>
			<td><small><?=is_array($arResult["WF_STATUS"]) ? $arResult["WF_STATUS"][$arElement["WF_STATUS_ID"]] : $arResult["ACTIVE_STATUS"][$arElement["ACTIVE"]]?></small></td>
			<?if ($arResult["CAN_EDIT"] == "Y"):?>
			<td><?if ($arElement["CAN_EDIT"] == "Y"):?><a href="<?=$arParams["EDIT_URL"]?>?edit=Y&amp;CODE=<?=$arElement["ID"]?>"><?=GetMessage("IBLOCK_ADD_LIST_EDIT")?><?else:?>&nbsp;<?endif?></a></td>
			<?endif?>
		</tr>
		<?endforeach?>
	<?else:?>
		<tr>
			<td<?=$colspan > 1 ? " colspan=\"".$colspan."\"" : ""?>><?=GetMessage("IBLOCK_ADD_LIST_EMPTY")?></td>
		</tr>
	<?endif?>
	</tbody>
<?endif?>
	<tfoot>
		<tr>
		<?//foter of list?>
		</tr>
	</tfoot>
</table>
<?if (strlen($arResult["NAV_STRING"]) > 0):?><?=$arResult["NAV_STRING"]?><?endif?>