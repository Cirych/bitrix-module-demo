<?
namespace KT\Medcab;

use Bitrix\Main\Entity;

class TalksTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'mc_talks';
	}
	
	public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\DatetimeField('START_DATE'),
        );
    }
}
?>