<?
namespace KT\Medcab;

use Bitrix\Main\Type;

class DateConverter extends \Bitrix\Main\Text\Converter
{
	public function encode($text, $textType = "")
	{
		if ($text instanceof \Bitrix\Main\Type\DateTime)
			return $text->format('Y-m-d H:i:s');

		return \Bitrix\Main\Text\String::htmlEncode($text);
	}

	public function decode($text, $textType = "")
	{
		if (is_object($text))
			return $text;

		return \Bitrix\Main\Text\String::htmlDecode($text);
	}
}
?>