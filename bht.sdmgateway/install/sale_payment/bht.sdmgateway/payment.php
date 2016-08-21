<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

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
		//var_dump($algo, $opad, $pack, $data); die('key');
		$output = $algo($opad.pack($pack, $algo($ipad.$data))); 
		//var_dump($output); die('key');
		return ($raw_output) ? pack($pack, $output) : $output; 
	} 
}



$module_id = "bht.sdmgateway";
if( ! \Bitrix\Main\Loader::includeModule($module_id) || ! $GLOBALS["USER"]->IsAuthorized() ) return;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\sdmGateway\Settings::$shopId = (int)\Bitrix\Main\Config\Option::get( $module_id, "shop_id" );
\sdmGateway\Settings::$shopKey = \Bitrix\Main\Config\Option::get( $module_id, "shop_key" );
\sdmGateway\Settings::$shopTerminal = \Bitrix\Main\Config\Option::get( $module_id, "shop_terminal" );


$out_summ = number_format(floatval($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"]), 2, ".", "");
$currency = "643";

$order_id =  IntVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]);
$APPLICATION->set_cookie("LAST_ORDER_ID", $order_id);

if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 1) {
	$order_id += 77777777;
}

$backref = "http://" . SITE_SERVER_NAME . "/backsdm.php";

if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 0) {
	$formUrl = \sdmGateway\Settings::$gatewayBase;
}else {
	$formUrl = \sdmGateway\Settings::$gatewayTest;
}

//Получаем информацию о клиенте из профиля
$firstName = $_SESSION["SESS_AUTH"]["FIRST_NAME"];
$lastName = $_SESSION["SESS_AUTH"]["LAST_NAME"];
$email = $_SESSION["SESS_AUTH"]["EMAIL"];

if( \Bitrix\Main\Loader::includeModule( "sale" ) )
{
	$db_prop_order_vals = CSaleOrderPropsValue::GetList(
								array("SORT" => "ASC"),
								array(
									"ORDER_ID" => $order_id,
									"CODE" => array(
												"CITY",
												"ZIP",
												"PHONE",
												"ADDRESS"
											  )
									),
								false,
								false,
								array("CODE", "ID", "VALUE")
						  );
	while( $val = $db_prop_order_vals->Fetch() )
	{
		if( !empty( $val["VALUE"]  ) )
			${strtolower( $val["CODE"] )} = $val["VALUE"];
	}
}

$trtype = 1;  
$country = ""; 
$merch_gmt = ""; 
$time = ""; 

$var = unpack("H*r", ToUpper(substr(md5(uniqid(30)), 0, 8))); 
$nonce = $var[r];
$key = pack("H*", \sdmGateway\Settings::$shopKey);   

$time = gmdate("YmdHis", time());

$m_name = $_SERVER['SERVER_NAME'];
$m_url = $_SERVER['SERVER_NAME'];
$merchant = \sdmGateway\Settings::$shopId;
$terminal = \sdmGateway\Settings::$shopTerminal;

$desc = "Order " . $order_id . " " . $m_name;


$data = 	(strlen($out_summ) > 0 ? strlen($out_summ).$out_summ : "-").
		(strlen($currency) > 0 ? strlen($currency).$currency : "-").
		(strlen($order_id) > 0 ? strlen($order_id).$order_id : "-").
		(strlen($desc) > 0 ? strlen($desc).$desc : "-").
		(strlen($m_name) > 0 ? strlen($m_name).$m_name : "-").
		(strlen($m_url) > 0 ? strlen($m_url).$m_url : "-").
		(strlen($merchant) > 0 ? strlen($merchant).$merchant : "-").
		(strlen($terminal) > 0 ? strlen($terminal).$terminal : "-").
		(strlen($email) > 0 ? strlen($email).$email : "-").
		(strlen($trtype) > 0 ? strlen($trtype).$trtype : "-").
		(strlen($time) > 0 ? strlen($time).$time : "-").
		(strlen($nonce) > 0 ? strlen($nonce).$nonce : "-").
		(strlen($backref) > 0 ? strlen($backref).$backref : "-");
//$data=  '510.0036438777777918100077772141420160810113753164341374435363139-1262238508100616DE4EE36E3249A320';
$sign = bx_hmac("sha1", $data, $key);

//var_dump($data, $sign); die();


?>

<form method="POST" action="<?=$formUrl;?>">
  
	<input type="hidden" name="TRTYPE" VALUE="<?=$trtype?>">
	<input type="hidden" name="AMOUNT" value="<?=$out_summ?>"> 
	<input type="hidden" name="CURRENCY" value="<?=$currency?>"> 
	<input type="hidden" name="ORDER" value="<?=$order_id?>">  
	<input type="hidden" name="DESC" value="<?=$desc?>"> 
	<input type="hidden" name="MERCH_NAME" value="<?=$m_name?>"> 
	<input type="hidden" name="MERCH_URL" value="<?=$m_url?>"> 
	<input type="hidden" name="MERCHANT" value="<?=$merchant?>"> 
	<input type="hidden" name="TERMINAL" value="<?=$terminal?>"> 
	<input type="hidden" name="EMAIL" value="<?=$email?>"> 
	<input type="hidden" name="LANG" value=""> 
	<input type="hidden" name="BACKREF" value="<?=$backref?>"> 
	<input type="hidden" name="NONCE" value="<?=$nonce?>">
	<input type="hidden" name="P_SIGN" value="<?=$sign?>">
	<input type="hidden" name="TIMESTAMP" value="<?=$time?>">
    <input type="submit" value="<?=Loc::getMessage("BHT_SDMGATEWAY_BUY_BUTTON")?>">
</form>
