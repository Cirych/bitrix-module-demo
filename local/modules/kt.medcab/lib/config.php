<?
namespace KT\Medcab;

use Bitrix\Main\Entity;

class ConfigTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'mc_config';
	}
	
	public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true
            )),
            new Entity\StringField('VALUE')
        );
    }
}
?>