<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("BHT_SDMGATEWAY_COMP_NAME"),
	"DESCRIPTION" => Loc::getMessage("BHT_SDMGATEWAY_COMP_DESC"),
	"ICON" => "",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "bht",
		"NAME" => Loc::getMessage("BHT_SDMGATEWAY_BHT_SERVICE")
	),
);
?>