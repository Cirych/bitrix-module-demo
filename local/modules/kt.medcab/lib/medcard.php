<?
namespace KT\Medcab;

use Bitrix\Main\Type;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class MedCard
{
	function MedcardFromOrder($ID, $val)
	{
	//test for medcards need.
		$arval = array("Y", "M", "P");
		if(in_array($val,$arval) && \Bitrix\Main\Loader::includeModule('sale'))
		{
			$arOrder = \CSaleOrder::GetByID($ID);
			$dbBasketItems = \CSaleBasket::GetList(
				array(
					"NAME" => "ASC",
					"ID" => "ASC"
				),
				array(
					"ORDER_ID" => intval($ID)
				),
				false,
				false,
				array("PRODUCT_ID", "QUANTITY", "WEIGHT", "NAME")
			);
			while ($arItems = $dbBasketItems->Fetch())
			{
				$arBasketItems[] = $arItems;
			}
			MedCard::WorksInOrder(array(
			'ORDER_ID' => intval($ID),
			'CLIENT_ID' => $arOrder["USER_ID"],
			'CLIENT_COMMENTS' => $arOrder["COMMENTS"],
			'WORKS' => $arBasketItems
			));
		}
	
	}
	
	function WorksInOrder($arParams)
	{
	//$arParams: ORDER_ID, CLIENT_ID, CLIENT_COMMENTS, WORKS
	// test each goods in order for digital
		if(\Bitrix\Main\Loader::includeModule('iblock'))
		{
				foreach($arParams["WORKS"] as $key => $value)
				{
					$res = \CIBlockElement::GetByID($value["PRODUCT_ID"])->GetNext();
					$IBID = $res["IBLOCK_ID"]; $workname = $res["NAME"];
					if($res = \CIBlockElement::GetProperty($IBID, $value["PRODUCT_ID"], Array("sort" => "asc"), Array("CODE"=>"MEDCARD"))->GetNext())
					{
						MedCard::CreateMedcard(array(
						'ORDER_ID' => $arParams["ORDER_ID"],
						'CLIENT_ID' => $arParams["CLIENT_ID"],
						'SPEC_ID' => \CIBlockElement::GetProperty($IBID, $value["PRODUCT_ID"], Array("sort" => "asc"), Array("CODE"=>"SPEC"))->GetNext()[VALUE],
						'WORK_ID' => $value["PRODUCT_ID"],
						'WORKTIME' => \CIBlockElement::GetProperty($IBID, $value["PRODUCT_ID"], Array("sort" => "asc"), Array("CODE"=>"WORKTIME"))->GetNext()[VALUE],
						'TESTTIME' => \CIBlockElement::GetProperty($IBID, $value["PRODUCT_ID"], Array("sort" => "asc"), Array("CODE"=>"TESTTIME"))->GetNext()[VALUE],
						'CARD_TYPE' => \CIBlockElement::GetProperty($IBID, $value["PRODUCT_ID"], Array("sort" => "asc"), Array("CODE"=>"CARD_TYPE"))->GetNext()[VALUE_XML_ID],
						'CLIENT_COMMENTS' => $arParams["CLIENT_COMMENTS"],
						'WORK_NAME' => $workname
						));
					}
				}
		}
	}
	
	function CreateMedcard($arParams)
	{
	//$arParams: ORDER_ID, CLIENT_ID, SPEC_ID, WORK_ID, WORKTIME, TESTTIME, 'CARD_TYPE', CLIENT_COMMENTS, 'WORK_NAME'
	// test for work_id unique
		//$medcard_id = "MC-".$arParams["SPEC"]."-".$arParams["CLIENT"]."-".$arParams["ORDER_ID"]."-".$arParams["WORK_ID"]; // if more then one - additional id!!!
		$medcard_id = $arParams["SPEC_ID"].$arParams["CLIENT_ID"].$arParams["ORDER_ID"].$arParams["WORK_ID"];
		if(WorksTable::getRowById($medcard_id)) die();

	//add work
		$medcard = WorksTable::add(array(
		'ID' => $medcard_id,
		'CLIENT' => $arParams["CLIENT_ID"],
		'SPEC' => $arParams["SPEC_ID"],
		'WORK_ID' => $arParams["WORK_ID"], // id of goods
		'STATUS' => 'ACCEPTED',
		'WORK_EVENT_ID' => MedCard::AddEvent(array(
							'START_DATE' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("now")),
							'END_DATE' => (isset($arParams["WORKTIME"])?
										\Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("+".$arParams["WORKTIME"]." days")):
										\Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("+1 hours"))),
							'TEXT' => Loc::getMessage('MEDCARD_WORK_EVENT_ID_INTRO').$medcard_id.Loc::getMessage('MEDCARD_WORK_EVENT_ID_CLIENT').implode(" ", array_intersect_key(\CUser::GetByID($arParams["CLIENT_ID"])->Fetch(), array_flip(array ('NAME', 'LAST_NAME')))).Loc::getMessage('MEDCARD_WORK_EVENT_ID_WORK_NAME').$arParams["WORK_NAME"],
							'COLOR' => "YELLOW",
							'EVENT_TYPE' => "WORK",
							'DETAILS' => $arParams["CLIENT_COMMENTS"],
							'LINK_ID'=>$medcard_id,
							'SECURE_ID'=>$arParams["SPEC_ID"]
							)),
		'TEST_EVENT_ID' => (isset($arParams["TESTTIME"])?
							MedCard::AddEvent(array(
							'START_DATE' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("+".$arParams["WORKTIME"]." days")),
							'END_DATE' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("+".$arParams["WORKTIME"]+$arParams["TESTTIME"]." days")),
							'TEXT' => Loc::getMessage('MEDCARD_TEST_EVENT_ID_INTRO').$medcard_id,
							'COLOR' => "GREY",
							'EVENT_TYPE' => "TEST",
							'LINK_ID'=>$medcard_id,
							'SECURE_ID'=>$arParams["SPEC_ID"]
							))
							: ""),
		'CARD_TYPE' => (isset($arParams["CARD_TYPE"])?$arParams["CARD_TYPE"]:""),
		));
		if ($medcard->isSuccess())
		{
			//$medcard_id = $medcard->getId();
			//add user to clients
			MedCard::AddClientToGroup($arParams["CLIENT_ID"]);
			MedCard::AddOrderProp(array(
			'ORDER_ID' => $arParams["ORDER_ID"],
			'MEDCARD_ID' => $medcard_id
			));
		}
	}
	
	function AddEvent($arParams)
	{ // $arParams: 'START_DATE', 'END_DATE', 'TEXT', 'COLOR', 'EVENT_TYPE', 'DETAILS', 'LINK_ID', 'SECURE_ID'
		$event = EventsTable::add(array(
		'START_DATE' => $arParams["START_DATE"],
		'END_DATE' => $arParams["END_DATE"],
		'TEXT' => $arParams["TEXT"],
		'COLOR' => $arParams["COLOR"],
		'EVENT_TYPE' => (isset($arParams["EVENT_TYPE"])?$arParams["EVENT_TYPE"]:""),
		'DETAILS' => (isset($arParams["DETAILS"])?$arParams["DETAILS"]:""),
		'LINK_ID' => $arParams["LINK_ID"],
		'SECURE_ID' => $arParams["SECURE_ID"]
		));
		if ($event->isSuccess())
		{
			$event_id = $event->getId();
			// KT\Medcab\Sync($event_id); /sync to google
			return $event_id;
		}
	}
	
	function AddClientToGroup($user_id)
	{
		$ClientGroupCode = "begin_clients"; // move to config
		$rsGroup = \CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $ClientGroupCode))->Fetch();
		$rsGroups = \CUser::GetUserGroup($user_id);
		if(!in_array($rsGroup["ID"], $rsGroups))
		\CUser::SetUserGroup($user_id, array_merge($rsGroups, array($rsGroup["ID"])));
	}
	
	function AddOrderProp($arParams) // $arParams: ORDER_ID, MEDCARD_ID
	{
		\Bitrix\Main\Loader::includeModule('sale');
		if($arProp = \CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $arParams[ORDER_ID], "CODE"=>"MEDCARD"))->Fetch())
		\CSaleOrderPropsValue::Update($arProp['ID'], array("VALUE"=>$arProp['VALUE'].', '.$arParams[MEDCARD_ID]));
		elseif ($arProp = \CSaleOrderProps::GetList(array(), array('CODE' => "MEDCARD"))->Fetch())
		{
			\CSaleOrderPropsValue::Add(array(
				   'NAME' => $arProp['NAME'],
				   'CODE' => $arProp['CODE'],
				   'ORDER_PROPS_ID' => $arProp['ID'],
				   'ORDER_ID' => $arParams[ORDER_ID],
				   'VALUE' => $arParams[MEDCARD_ID]
			));
		}
	}
}
?>