<?php

IncludeModuleLangFile(__FILE__);
if (class_exists("kt_medcab"))
	return;

class kt_medcab extends CModule
{
	var $MODULE_ID = "kt.medcab";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function kt_medcab()
	{
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("MEDCAB_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("MEDCAB_MODULE_DESCRIPTION");
		$this->PARTNER_NAME = "Ki-Tec";
		$this->PARTNER_URI = "http://www.ki-tec.ru";
	}

	function GetModuleTasks()
	{
		return array();
	}

	function InstallDB($arParams = array())
	{
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		// Database tables creation
		if (!$DB->Query("SELECT 'x' FROM mc_works WHERE 1=0", true))
		{
			$this->errors = $DB->RunSQLBatch(dirname(__FILE__)."/db/".strtolower($DB->type)."/install.sql");
		}
		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else
		{
			$this->InstallTasks();
			RegisterModule("kt.medcab");
			//CModule::IncludeModule("kt.medcab");
			\Bitrix\Main\Loader::includeModule("kt.medcab");

			//RegisterModuleDependences("sale", "OnSalePayOrder", "kt.medcab", '\KT\Medcab\MedCard', "OnSalePayOrder");
			//RegisterModuleDependences("sale", "OnSaleStatusOrder", "kt.medcab", '\KT\Medcab\MedCard', "OnSaleStatusOrder");
			$eventManager = \Bitrix\Main\EventManager::getInstance();
			$eventManager->registerEventHandler("sale","OnSalePayOrder","kt.medcab","\KT\Medcab\MedCard","MedcardFromOrder");
			$eventManager->registerEventHandler("sale","OnSaleStatusOrder","kt.medcab","\KT\Medcab\MedCard","MedcardFromOrder");
			$eventManager->registerEventHandler("pull","OnGetDependentModule","kt.medcab","\KT\Medcab\PullSchema","OnGetDependentModule");
		}
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		if (!array_key_exists("save_tables", $arParams) || $arParams["save_tables"] != "Y")
		{
			// remove medcab system data
			$this->errors = $DB->RunSQLBatch(dirname(__FILE__)."/db/".strtolower($DB->type)."/uninstall.sql");
		}

		UnRegisterModule("kt.medcab");

		//UnRegisterModuleDependences("main", "OnBeforeUserTypeAdd", "highloadblock", '\Bitrix\Highloadblock\HighloadBlockTable', "OnBeforeUserTypeAdd");
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->unRegisterEventHandler("sale","OnSalePayOrder","kt.medcab","\KT\Medcab\MedCard","MedcardFromOrder");
		$eventManager->unRegisterEventHandler("sale","OnSaleStatusOrder","kt.medcab","\KT\Medcab\MedCard","MedcardFromOrder");
		$eventManager->unRegisterEventHandler("pull","OnGetDependentModule","kt.medcab","\KT\Medcab\PullSchema","OnGetDependentModule");

		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles(dirname(__FILE__)."/admin/", $_SERVER["DOCUMENT_ROOT"]."/local/admin");
		CopyDirFiles(dirname(__FILE__)."/themes/", $_SERVER["DOCUMENT_ROOT"]."/local/themes/", true, true);
		CopyDirFiles(dirname(__FILE__)."/components/", $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
		CopyDirFiles(dirname(__FILE__)."/tools/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles(dirname(__FILE__)."/admin/", $_SERVER["DOCUMENT_ROOT"]."/local/admin");
		DeleteDirFiles(dirname(__FILE__)."/themes/.default/", $_SERVER["DOCUMENT_ROOT"]."/local/themes/.default");
		DeleteDirFiles(dirname(__FILE__)."/tools/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools");
		DeleteDirFilesEx("/bitrix/themes/.default/icons/kt.medcab/");
		return true;
	}

	function DoInstall()
	{
		global $USER, $APPLICATION;

		if ($USER->IsAdmin())
		{
			if ($this->InstallDB())
			{
				$this->InstallEvents();
				$this->InstallFiles();
			}
			$GLOBALS["errors"] = $this->errors;
			$APPLICATION->IncludeAdminFile(GetMessage("MEDCAB_INSTALL_TITLE"), dirname(__FILE__)."/step.php");
		}
	}

	function DoUninstall()
	{
		global $USER, $APPLICATION, $step;
		if ($USER->IsAdmin())
		{
			$step = IntVal($step);
			if ($step < 2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage("MEDCAB_UNINSTALL_TITLE"), dirname(__FILE__)."/unstep1.php");
			}
			elseif ($step == 2)
			{
				$this->UnInstallDB(array(
					"save_tables" => $_REQUEST["save_tables"],
				));
				//message types and templates
				if ($_REQUEST["save_templates"] != "Y")
				{
					$this->UnInstallEvents();
				}
				$this->UnInstallFiles();
				$GLOBALS["errors"] = $this->errors;
				$APPLICATION->IncludeAdminFile(GetMessage("MEDCAB_UNINSTALL_TITLE"), dirname(__FILE__)."/unstep2.php");
			}
		}
	}
}
