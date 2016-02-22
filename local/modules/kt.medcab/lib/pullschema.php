<?
namespace KT\Medcab;

class PullSchema
{
	public static function OnGetDependentModule()
	{
		return Array(
            'MODULE_ID' => "kt.medcab",
            'USE' => Array("PUBLIC_SECTION")
		);
	}
}
?>