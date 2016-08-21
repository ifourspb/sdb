<?php

use Bitrix\Main\Localization\Loc;

if( ! IsModuleInstalled("sale") ||
	! function_exists("curl_init") ||
	! function_exists("json_decode") ||
	! function_exists("mb_detect_encoding") ) return;

Loc::loadMessages(__FILE__);

class bht_sdmGateway extends CModule
{
	public $MODULE_ID = "bht.sdmgateway";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_GROUP_RIGHTS = "N";

	public $namespaceFolder = "bht";

    function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = Loc::getMessage("BHT_SDMGATEWAY_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("BHT_SDMGATEWAY_MODULE_NAME");
		$this->PARTNER_NAME = "bytehand";
	}

    public function DoInstall()
    {
		$this->installFiles();
		\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
		return true;
    }

    public function DoUninstall()
    {
		$this->uninstallFiles();
		Bitrix\Main\Config\Option::delete( $this->MODULE_ID );
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
		return true;
    }

    public function installFiles()
    {
		CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/frontend/",
            $_SERVER["DOCUMENT_ROOT"]."/",
            true, true
        );
		CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/sale_payment/",
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment",
            true, true
        );
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/components/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/",
			true, true
		);
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/admin/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/admin",
			true, true
		);
        return true;
    }

    public function uninstallFiles()
    {

		DeleteDirFilesEx("/bitrix/components/".$this->namespaceFolder);
		DeleteDirFilesEx("/bitrix/php_interface/include/sale_payment/bht.sdmgateway");
		DeleteDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID ."/install/admin/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/admin"
		);
		return true;
    }
}
