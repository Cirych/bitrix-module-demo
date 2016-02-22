<?
namespace KT\Medcab;

use Bitrix\Main\Entity;

class WorksTable extends Entity\DataManager
{
	const CARD_TYPE = array('MODEL', 'CARDS', 'SOME', 'HORO', 'NO');
	const STATUS = array('ACCEPTED', 'STARTED', 'WORKING', 'PROBLEM', 'CLOSED');
	
	public static function getTableName()
	{
		return 'mc_works';
	}
	
	public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true
            )),
            new Entity\IntegerField('CLIENT_ID'),
			new Entity\ReferenceField(
				'CLIENT',
				'Bitrix\Main\User',
				array('=this.CLIENT_ID' => 'ref.ID')
			),
			new Entity\IntegerField('SPEC_ID'),
			new Entity\ReferenceField(
				'SPEC',
				'Bitrix\Main\User',
				array('=this.SPEC_ID' => 'ref.ID')
			),
			new Entity\IntegerField('WORK_ID'),
			new Entity\ReferenceField(
				'WORK',
				'Bitrix\Iblock\Element',
				array('=this.WORK_ID' => 'ref.ID')
			),
			new Entity\EnumField('STATUS', array(
			'values' => self::STATUS,
			'save_data_modification' => function () {
											return array(
												function ($value) {return array_flip(self::STATUS)[$value];}
											);
										},
			'fetch_data_modification' => function () {
											return array(
												function ($value) {return self::STATUS[$value];}
											);
										},
			'default_value' => array_flip(self::STATUS)['ACCEPTED']
			)),
			new Entity\IntegerField('WORK_EVENT_ID'),
			new Entity\ReferenceField(
				'WORK_EVENT',
				'KT\Medcab\Events',
				array('=this.WORK_EVENT_ID' => 'ref.ID')
			),
			new Entity\IntegerField('TEST_EVENT_ID'),
			new Entity\ReferenceField(
				'TEST_EVENT',
				'KT\Medcab\Events',
				array('=this.TEST_EVENT_ID' => 'ref.ID')
			),
			new Entity\EnumField('CARD_TYPE', array(
			'values' => self::CARD_TYPE,
			'save_data_modification' => function () {
											return array(
												function ($value) {return array_flip(self::CARD_TYPE)[$value];}
											);
										},
			'fetch_data_modification' => function () {
											return array(
												function ($value) {return self::CARD_TYPE[$value];}
											);
										},
			'default_value' => array_flip(self::CARD_TYPE)['NO']
			)),
			new Entity\StringField('DATA', array(
			'serialized' => true
			)),
			new Entity\StringField('SPEC_REPORT')
        );
    }
}
?>