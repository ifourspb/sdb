<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class beTransInfoComponent extends CBitrixComponent
{
	protected $module_id = "bht.sdmgateway";

	protected function check()
	{
		global $USER;

		if( ! \Bitrix\Main\Loader::includeModule( $this->module_id ) ||
			! \Bitrix\Main\Loader::includeModule( "sale" ) ||
			! $USER->isAuthorized()
		) {
			throw new Exception( Loc::getMessage("BHT_SDMGATEWAY_NO_TRANS_INFO") );
		}
		
		 return true;
	}

	public function executeComponent()
	{
		global $APPLICATION, $USER;
		try
		{
			$check = $this->check();
			
			$order_id = $APPLICATION->get_cookie("LAST_ORDER_ID");
			\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "N"); 
			$arOrder = CSaleOrder::GetByID(IntVal($order_id));
			\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "Y"); 
			if ($USER->GetID() != $arOrder['USER_ID']) {
				throw new Exception( Loc::getMessage("BHT_SDMGATEWAY_NO_TOKEN_ACCESS") );
			}
			
			if ($arOrder['PS_STATUS'] == 'Y') {
				$arOrder['info_title'] = Loc::getMessage("BHT_SDMGATEWAY_SUCCESS_TITLE");
			}else {
				$arOrder['info_title'] = Loc::getMessage("BHT_SDMGATEWAY_FAIL_TITLE");	
			}
			if ($arOrder["PS_STATUS_DESCRIPTION"]) {
				$data = json_decode($arOrder["PS_STATUS_DESCRIPTION"]);
			}
			$arOrder['REFUND_AMOUNT'] = $data->refund_amount;

			$this->arResult = $arOrder;

			$this->IncludeComponentTemplate();

		}catch(Exception $e){
			ShowError( $e->getMessage() );
		}
	}
}
