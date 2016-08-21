<?php
/*
if ($_POST) {
	$buf = serialize($_POST);
	$str = fopen("/tmp/pay", "a+");
	fwrite($str, "\n\n" . $buf . "\n\n");
	fclose($str);
}
*/


ob_start();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$b = ob_get_contents();
ob_end_clean();
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
$module_id = "bht.sdmgateway";


if( ! \Bitrix\Main\Loader::includeModule($module_id)  ) return;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\sdmGateway\Settings::$shopId = (int)\Bitrix\Main\Config\Option::get( $module_id, "shop_id" );
\sdmGateway\Settings::$shopKey = \Bitrix\Main\Config\Option::get( $module_id, "shop_key" );
\sdmGateway\Settings::$shopTerminal = \Bitrix\Main\Config\Option::get( $module_id, "shop_terminal" );


if(!function_exists("bx_hmac"))
{
	function bx_hmac($algo, $data, $key, $raw_output = false) 
	{ 
		$algo = strtolower($algo); 
		$pack = "H".strlen($algo("test")); 
		$size = 64; 
		$opad = str_repeat(chr(0x5C), $size); 
		$ipad = str_repeat(chr(0x36), $size); 

		if (strlen($key) > $size) { 
			$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00)); 
		} else { 
			$key = str_pad($key, $size, chr(0x00)); 
		} 

		$lenKey = strlen($key) - 1;
		for ($i = 0; $i < $lenKey; $i++) { 
			$opad[$i] = $opad[$i] ^ $key[$i]; 
			$ipad[$i] = $ipad[$i] ^ $key[$i]; 
		} 

		$output = $algo($opad.pack($pack, $algo($ipad.$data))); 
		return ($raw_output) ? pack($pack, $output) : $output; 
	} 
}


$p_rrn = $_POST["RRN"];
$p_int_ref = $_POST["IntRef"];
$p_terminal = \sdmGateway\Settings::$shopTerminal;
$p_trtype = $_POST["TRType"];
$p_order = $_POST["Order"];
$p_order2 = $_POST["Order"];
if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 1) {
	$p_order2  -= 77777777;
}
$p_amount = $_POST["Amount"];
$p_currency = $_POST["Currency"];
$p_result = $_POST['Result'];
$p_auth = $_POST['AuthCode'];
$p_result = $_POST['Result'];
$p_rc = $_POST['RC'];
$p_sign = $_POST["P_Sign"];

$bError = true;

$mac = \sdmGateway\Settings::$shopKey;
$arOrder = CSaleOrder::GetByID(IntVal($p_order2));

if(strlen($mac) > 0 && $arOrder = CSaleOrder::GetByID(IntVal($p_order2))) {
		
		if ($p_trtype == 1) {
			sdm_pay_process();
		}
		if ($p_trtype == 14) {
			sdm_refund_process();
		}

}

function sdm_pay_process() {
	global $arOrder, $mac, $p_amount, $p_currency, $p_order, 
		$p_trtype, $p_result, $p_rc, $p_auth, $p_rrn, $p_int_ref, $module_id, $p_sign;

	CSalePaySystemAction::InitParamArrays($arOrder, $arOrder["ID"]);
	
	$key = pack("H*", $mac);   
	$data = (strlen($p_amount) > 0 ? strlen($p_amount).$p_amount : "-").
		(strlen($p_currency) > 0 ? strlen($p_currency).$p_currency : "-").
		(strlen($p_order) > 0 ? strlen($p_order).$p_order : "-").
		(strlen($p_trtype) > 0 ? strlen($p_trtype).$p_trtype : "-").
		(strlen($p_result) > 0 ? strlen($p_result).$p_result : "-").
		(strlen($p_rc) > 0 ? strlen($p_rc).$p_rc : "-").
		(strlen($p_auth) > 0 ? strlen($p_auth).$p_auth : "-").		
		(strlen($p_rrn) > 0 ? strlen($p_rrn).$p_rrn : "-").
		(strlen($p_int_ref) > 0 ? strlen($p_int_ref).$p_int_ref : "-");

	$sign = ToUpper(bx_hmac("sha1", $data, $key));


	$strPS_STATUS_DESCRIPTION =  json_encode(array('int_ref'=>$p_int_ref, 'rrn'=>$p_rrn));

	$arFields = array(
			"PS_STATUS" => "N",
			"PS_STATUS_CODE" => $p_result,
			"PS_STATUS_DESCRIPTION" => $strPS_STATUS_DESCRIPTION,
			"PS_STATUS_MESSAGE" => "",
			"PS_SUM" => $p_amount,
			"PS_CURRENCY" => $p_currency,
			"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
		);
	if(strlen($p_result ) > 0)
		$arFields["PS_STATUS_MESSAGE"] .= $p_result . ' ';

	if($sign == $p_sign)
	{	
			
			if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 1) {
				//$success = true;
				$success = ($p_result == 0 );
			}else {
				$success = ($p_result == 0 );
			}
			if ( !$success) {
				$arFields["PS_STATUS_MESSAGE"] .= 'err_status;';
			}else	if(DoubleVal($p_amount) == DoubleVal($arOrder["PRICE"])) {
				
				$bError = false;
				$arFields["PS_STATUS"] = "Y";
				
				if($arOrder["PAYED"] != "Y")
					CSaleOrder::PayOrder($arOrder["ID"], "Y", true, true);
				if($arOrder["ALLOW_DELIVERY"] != "Y" && $ALLOW_DELIVERY == "Y")
					CSaleOrder::DeliverOrder($arOrder["ID"], "Y");
			}else {
				$arFields["PS_STATUS_MESSAGE"] .= 'err_sum;';
			}
		
	}
	else
		$arFields["PS_STATUS_MESSAGE"] .= 'err_sign;';
		
	if($bError)
		echo 'ERROR';
		
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "N");
	CSaleOrder::Update($arOrder["ID"], $arFields);
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "Y");
	
	$str = fopen("/tmp/pay", "a+");
	fwrite($str, "\n\n" . serialize($arFields) . "\n\n");
	fclose($str);
}


function sdm_refund_process() {
	global $arOrder, $mac, $p_amount, $p_currency, $p_order, 
		$p_trtype, $p_result, $p_rc, $p_auth, $p_rrn, $p_int_ref, $module_id, $p_sign;

	CSalePaySystemAction::InitParamArrays($arOrder, $arOrder["ID"]);
	
	$key = pack("H*", $mac);   
	$data = (strlen($p_amount) > 0 ? strlen($p_amount).$p_amount : "-").
		(strlen($p_currency) > 0 ? strlen($p_currency).$p_currency : "-").
		(strlen($p_order) > 0 ? strlen($p_order).$p_order : "-").
		(strlen($p_trtype) > 0 ? strlen($p_trtype).$p_trtype : "-").
		(strlen($p_result) > 0 ? strlen($p_result).$p_result : "-").
		(strlen($p_rc) > 0 ? strlen($p_rc).$p_rc : "-").
		(strlen($p_auth) > 0 ? strlen($p_auth).$p_auth : "-").		
		(strlen($p_rrn) > 0 ? strlen($p_rrn).$p_rrn : "-").
		(strlen($p_int_ref) > 0 ? strlen($p_int_ref).$p_int_ref : "-");

	$sign = ToUpper(bx_hmac("sha1", $data, $key));
	
	if ($arOrder["PS_STATUS_DESCRIPTION"]) {
		$data = json_decode($arOrder["PS_STATUS_DESCRIPTION"]);
	}else {
		$data = new stdClass();
	}
	

	if($sign == $p_sign)
	{	
			
			if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 1) {
				//$success = true;
				$success = ($p_result == 0 );
			}else {
				$success = ($p_result == 0 );
			}
			if ( !$success) {
				$arFields["PS_STATUS_MESSAGE"] .= 'err_refund_status;';
			}else	if(DoubleVal($p_amount) > 0) {
				$refund_amount = $p_amount;
				if (isset($data->refund_amount)) {
					$refund_amount += $data->refund_amount;
					if ($refund_amount>$arOrder["PRICE"]) {
						$refund_amount = $arOrder["PRICE"];
					}
				}
				$data->refund_amount = $refund_amount;
				
				$arFields = array(
					"PS_STATUS_DESCRIPTION" => json_encode($data)
				);
			}else {
				$arFields["PS_STATUS_MESSAGE"] .= 'err_refund_sum;';
			}
		
	}
	else
		$arFields["PS_STATUS_MESSAGE"] .= 'err_refund_sign;';
		
	if($bError)
		echo 'ERROR';
		
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "N");
	CSaleOrder::Update($arOrder["ID"], $arFields);
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "Y");
	
	/*
	$str = fopen("/tmp/pay", "a+");
	fwrite($str, "\n\n" . serialize($arFields) . "\n\n");
	fclose($str);
	*/
}

?>