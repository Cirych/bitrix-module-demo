<?
namespace KT\Medcab;

use Bitrix\Main\Entity;

class EventsTable extends Entity\DataManager
{
	const COLOR = array('RED', 'GREEN', 'BLUE', 'YELLOW', 'PINK', 'BLACK', 'GREY');
	const EVENT_TYPE = array('WORK', 'TEST', 'MEET', 'REMIND');
	
	public static function getTableName()
	{
		return 'mc_events';
	}
	
	public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\DatetimeField('START_DATE'),
			new Entity\DatetimeField('END_DATE'),
			new Entity\StringField('TEXT'),
			new Entity\EnumField('COLOR', array(
			'values' => self::COLOR,
			'save_data_modification' => function () {
											return array(
												function ($value) {return array_flip(self::COLOR)[$value];}
											);
										},
			'fetch_data_modification' => function () {
											return array(
												function ($value) {return self::COLOR[$value];}
											);
										},
			'default_value' => array_flip(self::COLOR)['GREY']
			)),
			new Entity\EnumField('EVENT_TYPE', array(
			'values' => self::EVENT_TYPE,
			'save_data_modification' => function () {
											return array(
												function ($value) {return array_flip(self::EVENT_TYPE)[$value];}
											);
										},
			'fetch_data_modification' => function () {
											return array(
												function ($value) {return self::EVENT_TYPE[$value];}
											);
										},
			//'default_value' => array_flip(self::EVENT_TYPE)['GREY']
			)),
			new Entity\StringField('DETAILS'), // x3
			new Entity\TextField('REC_TYPE'), // ressurect
			new Entity\IntegerField('EVENT_LENGHT'), // ressurect
			new Entity\IntegerField('EVENT_PID'), // ressurect
			new Entity\IntegerField('LINK_ID'), // link to works or else
			new Entity\IntegerField('SECURE_ID'), // for security
        );
    }
}
?>