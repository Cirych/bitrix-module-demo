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
<?
foreach($arResult['LIST'] as $key => $value)
{
echo "<a href='cab.php?CODE=".$value['ID']."'>".$value['ID']."</a> ".$value['TEXT']." ".$value['STATUS']."<BR>";
}
echo "-----------------------<BR>";
print_r($arResult);
?>