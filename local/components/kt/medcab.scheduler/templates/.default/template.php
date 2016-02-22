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
CJSCore::RegisterExt('dhtmlxscheduler', array(
	'js' => array(
				$templateFolder.'/dhtmlxscheduler.js',
				$templateFolder.'/ext/dhtmlxscheduler_minical.js',
				$templateFolder.'/ext/dhtmlxscheduler_limit.js',
				(LANGUAGE_ID=="ru"?$templateFolder.'/locale_ru.js':""),
				),
	'css' => $templateFolder.'/dhtmlxscheduler.css',
	//'lang' => $this->getPath().'/lang/'.LANGUAGE_ID.'/js_demo_webrtc.php',
	//'rel' => array('webrtc'),
	'skip_core' => true
));
CJSCore::Init('dhtmlxscheduler');
?>
<div id="scheduler" class="dhx_cal_container" style='width:80%; height:400px; padding:10px;'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
    </div>
    <div class="dhx_cal_header"></div>
    <div class="dhx_cal_data"></div>       
</div>
<?
foreach($arResult as $key => $value)
{
$arEvents[] = array("id"=> $value['ID'], "start_date" => $value['START_DATE']->toString(), "end_date" => $value['END_DATE']->toString(), "text" => $value['TEXT'], "color" => $value['COLOR']);
}
?>
<script>
var arEvents = <?echo json_encode($arEvents)?>;
scheduler.config.xml_date="%d.%m.%Y %H:%i:%s";
scheduler.config.limit_start = new Date(<?echo date("Y, m, d", strtotime("-1 month"));?>);
scheduler.config.limit_end = new Date (2100,0,1);
scheduler.blockTime(new Date(2015, 01, 06), "fullday");
scheduler.config.check_limits = false;
//scheduler.config.display_marked_timespans = false;

scheduler.config.first_hour = 10;
scheduler.config.last_hour = 20;

//scheduler.load("/bitrix/tools/medcab_sheduler.php","json");
scheduler.init('scheduler', new Date(),"month");
scheduler.parse(arEvents, "json");

var dp = new dataProcessor("/bitrix/tools/medcab_sheduler.php");
dp.init(scheduler);
dp.attachEvent("onAfterUpdate", function(ids, action, response){
     //alert(response.getAttribute(ids));
	 //alert("action");
	 //alert(messages);
});
//scheduler.config.readonly = true;
scheduler.addMarkedTimespan({ // blocks each Sunday, Monday, Wednesday
    days:  [0], 
    zones: "fullday",
    type:  "dhx_time_block", 
    css:   "blue_section" 
});
scheduler.deleteMarkedTimespan({ 
    days:  [new Date(2015, 01, 06)],
    zones: [12*60,15*60,17*60,18*60]
});

function show_minical(){
    if (scheduler.isCalendarVisible()){
        scheduler.destroyCalendar();
    } else {
        scheduler.renderCalendar({
            position:"dhx_minical_icon",
            date:scheduler._date,
            navigation:true,
            handler:function(date,calendar){
                scheduler.setCurrentView(date);
                scheduler.destroyCalendar()
            }
        });
    }
}
</script>