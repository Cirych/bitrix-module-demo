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
use Bitrix\Main\Localization\Loc;
?>
<DIV class="form_head">
<form name="medcard_update" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
	<?echo Loc::getMessage('MEDCARD_FORM_SPEC');?>
	<select name='SPEC'>
		<?foreach($arResult['SPEC_ENUM'] as $key => $arEnum):?>
		<option <?if($arResult['SPEC_ID']==$arEnum)echo "selected";?> value="<?echo $arEnum;?>"><?echo implode(" ", array_intersect_key(\CUser::GetByID($arEnum)->fetch(), array_flip(array ('NAME', 'LAST_NAME'))));?></option>
		<?endforeach;?>
	</select>
	<BR>
	<?echo Loc::getMessage('MEDCARD_FORM_CARD_TYPE');?>
	<select name='CARD_TYPE'>
		<?foreach($arResult['CARD_TYPE_ENUM'] as $key => $arEnum):?>
		<option <?if($arResult['CARD_TYPE']==$arEnum)echo "selected";?> value="<?echo $arEnum;?>"><?echo Loc::getMessage('MEDCARD_WORKS_CONST_CARD_TYPE_'.$arEnum);?></option>
		<?endforeach;?>
	</select>
	<BR>
	<?echo Loc::getMessage('MEDCARD_FORM_STATUS');?>
	<select name='STATUS'>
		<?foreach($arResult['STATUS_ENUM'] as $key => $arEnum):?>
		<option <?if($arResult['STATUS']==$arEnum)echo "selected";?> value="<?echo $arEnum;?>"><?echo Loc::getMessage('MEDCARD_WORKS_CONST_STATUS_'.$arEnum);?></option>
		<?endforeach;?>
	</select>
	<BR>
	
	<input type="submit" name="medcard_apply" value="<?=Loc::getMessage("MEDCARD_FORM_APPLY")?>" />
</form>
<?echo Loc::getMessage('MEDCARD_FORM_UPDATED').$arParams['UPDATED']."<BR>";?>
<?
echo Loc::getMessage('MEDCARD_FORM_TITLE').$arResult['ID']."<BR>";
echo Loc::getMessage('MEDCARD_FORM_CLIENT').$arResult['SPEC_NAME']." ".$arResult['SPEC_LAST_NAME']."<BR>";
//echo Loc::getMessage('MEDCARD_FORM_SPEC').implode(" ", array_intersect_key(\CUser::GetByID($arResult["SPEC"])->fetch(), array_flip(array ('NAME', 'LAST_NAME'))))."<BR>";
echo Loc::getMessage('MEDCARD_FORM_WORK').$arResult["WORK_NAME"]."<BR>";
echo Loc::getMessage('MEDCARD_FORM_STATUS').$arResult['STATUS']."<BR>";
echo Loc::getMessage('MEDCARD_FORM_WORK_START_DATE').$arResult['EVENT_START_DATE']."<BR>";
echo Loc::getMessage('MEDCARD_FORM_WORK_END_DATE').$arResult['EVENT_END_DATE']."<BR>";
$work_time = (new DateTime($arResult['EVENT_START_DATE']))->diff(new DateTime($arResult['EVENT_END_DATE']));
echo Loc::getMessage('MEDCARD_FORM_WORK_TIME').$work_time->format('%a '.Loc::getMessage('MEDCARD_FORM_DAYS'))."<BR>";
if($arResult['TEST_ID'])
{
echo Loc::getMessage('MEDCARD_FORM_TEST_START_DATE').$arResult['TEST_START_DATE']."<BR>";
echo Loc::getMessage('MEDCARD_FORM_TEST_END_DATE').$arResult['TEST_END_DATE']."<BR>";
$work_time = (new DateTime($arResult['TEST_START_DATE']))->diff(new DateTime($arResult['TEST_END_DATE']));
echo Loc::getMessage('MEDCARD_FORM_TEST_TIME').$work_time->format('%a '.Loc::getMessage('MEDCARD_FORM_DAYS'))."<BR>";
}
//echo Loc::getMessage('MEDCARD_FORM_CARD_TYPE').$arResult['CARD_TYPE']."<BR>";
echo Loc::getMessage('MEDCARD_FORM_DATA').$arResult['DATA']."<BR>";
echo Loc::getMessage('MEDCARD_SPEC_REPORT').$arResult['SPEC_REPORT']."<BR>";

//////////////////////////////
//echo "<BR>----------------------------arResult-----------------------------<BR>";
//print_r($arResult);
//echo "<BR>----------------------------arParams-----------------------------<BR>";
//print_r($arParams);
?>
</DIV>
<?
/////////////////////////////
//include card types
require(strtolower($arResult['CARD_TYPE']).".php");
?>