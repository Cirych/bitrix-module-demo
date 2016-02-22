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
?>
<BR>COMPLEX!<BR>
<BR>Sheduler: <BR>
<?$APPLICATION->IncludeComponent("kt:medcab.scheduler", "", $arParams, $component);?>
<BR>List: <BR>
<?
foreach($arResult['LIST'] as $key => $value)
{
echo "<a href='cab.php?CODE=".$value['ID']."'>".$value['ID']."</a> ".$value['TEXT']." ".$value['STATUS']."<BR>";
}
?>
<BR>Chat: <BR>
<?//$APPLICATION->IncludeComponent("kt:medcab.talks", "", $arParams, $component);?>
<BR>Vars: <BR>
<?
echo "<BR>-----------arParams------------<BR>";
print_r($arParams);
echo "<BR>-----------arResult------------<BR>";
print_r($arResult);
echo "<BR>-----------component-----------<BR>";
print_r($component);
?>