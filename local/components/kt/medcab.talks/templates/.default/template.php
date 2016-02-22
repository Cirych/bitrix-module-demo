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
CJSCore::Init(array("jquery"));
?>

<DIV id="talks" class="talks">
	<DIV id="header" class="header">
	CHAT
	</DIV>
	<DIV id="messages" class="messages">
	messages:
	</DIV>
	<DIV id="input" class="input">
	<textarea id="message_text" class="message_text" wrap="virtuals" name="message_text" placeholder="write here and press enter" ></textarea>
	<input type="button" id="send" class="send" onclick = "sendMessage()">
	</DIV>
</DIV>
<script type="text/javascript">
function h(e) {
    $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
}
$('#message_text').each(function () {
  h(this);
}).on('input', function () {
  h(this);
});

BX('message_text').onkeypress = function (e) {
        if (e.keyCode === 13) {
            sendMessage();
			return false;
        };
    };
	
function addMessage(message_text, senderId, senderName, serverTime) {
	var message_from = 'message_all';
	var message_time = new Date(serverTime);
	if(senderId==<?echo $arResult['USER_ID'];?>) message_from = 'message_my';
	var message = document.createElement('DIV');
	message.className = 'message '+message_from;
	message.innerHTML = "<b class='message_head'>"+senderName+" "+BX.date.format('H:i',message_time)+"</b><BR>"+message_text;
	messages.appendChild(message);
	messages.scrollTop = messages.scrollHeight;
};

function sendMessage()
{
	BX.ajax({
		url: '<?=$arResult['ajaxLink']?>',
		method: 'POST',
		data: {'SEND' : 'Y', 'sessid': BX.bitrix_sessid(), 'MESSAGE':BX('message_text').value}
	});
	BX('message_text').value = null;
	h('#message_text');
}

BX.ready(function(){
		BX.addCustomEvent("onPullEvent-kt.medcab", BX.delegate(function(command,params)
			{
				//BX('messages').innerHTML += 'command:'+command+' senderId: '+params.senderId+' test: '+params.message_text+'<br>';
				addMessage(params.message_text, params.senderId, params.senderName, params.serverTime);
			})
		);
	});
	
</script>
<?
/////////////////////////////////
echo "<BR>----------arResult-------------<BR>";
print_r($arResult);
echo "<BR>----------arParams-------------<BR>";
print_r($arParams);
//echo "<BR>----------component-------------<BR>";
//print_r($component);
//echo check_bitrix_sessid();
?>