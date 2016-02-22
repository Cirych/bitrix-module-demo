<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<?
$data = array(
array("id"=> "1", "start_date" =>"27/01/2015 14:00", "end_date" =>"27/01/2015 17:00"),
array("id"=> "2", "start_date"=>"28/01/2015 12:00", "end_date" =>"29/01/2015 19:00")
);
if($_POST[ids]){
//$response=array("status"=>"ok");
$response=array("action"=>"updated","sid"=>$_POST[ids],"tid"=>$_POST[ids]);
echo json_encode($response);
}
else{
echo json_encode($data);
//die(json_encode($response));
}
?>