<?
define("STOP_STATISTICS", true);
define("NO_KEEP_STATISTIC", true);
define('NO_AGENT_CHECK', true);
define("NO_AGENT_STATISTIC", true);
//define("NOT_CHECK_PERMISSIONS", true);
define('DisableEventsCheck', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
if(($EventIDs = explode(",",$_POST["ids"])) && \Bitrix\Main\Loader::includeModule('kt.medcab'))
{
	foreach($EventIDs as $key => $EventID)
	{
		$EventUpdate = array(
				'START_DATE' => new Bitrix\Main\Type\DateTime($_POST[$EventID.'_start_date']),
				'END_DATE' => new Bitrix\Main\Type\DateTime($_POST[$EventID.'_end_date']),
				'COLOR' => $_POST[$EventID.'_color'],
				'TEXT' => $_POST[$EventID.'_text']
				);
		$result = KT\Medcab\EventsTable::update($EventID, $EventUpdate);
		//if (!$result->isSuccess()) $response = array("action"=>"error","sid"=>$EventID,"tid"=>$EventID,"text"=>$result->getErrorMessages());
		if (!$result->isSuccess()) $response = array("action"=>"error","ids"=>($response["id"]?$response["id"].",".$EventID:$EventID));
		else $response=array("action"=>"updated","ids"=>($response["id"]?$response["id"].",".$EventID:$EventID));
	}
echo json_encode($response);
}
//print_r($response);
?>