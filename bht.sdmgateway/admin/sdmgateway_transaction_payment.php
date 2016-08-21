<?
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
		//svar_dump($algo, $opad, $pack, $data); die('key');

		$output = $algo($opad.pack($pack, $algo($ipad.$data))); 

		return ($raw_output) ? pack($pack, $output) : $output; 
	} 
}


function sdm_curl_post($url, $data) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				http_build_query($data));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);

	return $server_output;
}

$module_id = "bht.sdmgateway";

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/$module_id/include.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/$module_id/prolog.php");


use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$gr = explode("|", \Bitrix\Main\Config\Option::get( $module_id, "group_ids" ));
$in = array_intersect($gr,CUser::GetUserGroupArray());
$has_access = false;
if(!empty($in))
	$has_access = true;

\Bitrix\Main\Loader::includeModule("sale");
\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "N"); //Костыль из - за совместимости битрикс с ядром D7
try
{
	$ID = (int)$ID;
	if( $ID <= 0)
		throw new Exception( Loc::getMessage("BHT_SDMGATEWAY_NOT_CORRECT_ID") );
	
	$ps_id = (int)\Bitrix\Main\Config\Option::get( $module_id, "payment_system_id" );
	
	if( $ps_id <= 0 )
		throw new Exception( Loc::getMessage( "BHT_SDMGATEWAY_PS_NOT_FOUND" ) );

	$order = CSaleOrder::GetList(
								array("ID" => "ASC"),
								array("ID" => $ID, "PAY_SYSTEM_ID" => $ps_id),
								false,
								false,
								array( "ID", "USER_ID", "PS_STATUS_DESCRIPTION", "PS_STATUS", "PRICE", "CURRENCY" )
							)->Fetch();
	
	if( $order["ID"] <= 0 )
		throw new Exception( Loc::getMessage("BHT_SDMGATEWAY_ORDER_NOT_FOUND") );
	

	$data = new stdClass;;
	if ($order["PS_STATUS_DESCRIPTION"]) {
		$data = json_decode($order["PS_STATUS_DESCRIPTION"]);
	}
	//var_dump($data);
	
	
	\sdmGateway\Settings::$shopId = (int)\Bitrix\Main\Config\Option::get( $module_id, "shop_id" );
	\sdmGateway\Settings::$shopKey = \Bitrix\Main\Config\Option::get( $module_id, "shop_key" );
	\sdmGateway\Settings::$shopTerminal = \Bitrix\Main\Config\Option::get( $module_id, "shop_terminal" );
	
	$order_id = $ID;

	if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 1) {
		$order_id += 77777777;
	}

	if (\Bitrix\Main\Config\Option::get( $module_id, "test_mode" ) == 0) {
		$formUrl = \sdmGateway\Settings::$gatewayBase;
	}else {
		$formUrl = \sdmGateway\Settings::$gatewayTest;
	}

	$trtype = 14;  
	$country = ""; 
	$merch_gmt = ""; 
	$time = ""; 
	$currency = "643";
	$var = unpack("H*r", ToUpper(substr(md5(uniqid(30)), 0, 8))); 
	$nonce = $var[r];
	$key = pack("H*", \sdmGateway\Settings::$shopKey);   
	$time = gmdate("YmdHis", time());
	$m_name = $_SERVER['SERVER_NAME'];
	$m_url = $_SERVER['SERVER_NAME'];
	$merchant = \sdmGateway\Settings::$shopId;
	$terminal = \sdmGateway\Settings::$shopTerminal;	
	$backref = "http://" . $_SERVER['HTTP_HOST'] . "/backsdm.php";
	
	if(
		$_SERVER["REQUEST_METHOD"] == "POST" &&
		strlen($refund) > 0 &&
		strlen($amount) > 0 &&
		md5($merchant.$ID) === $hash &&
		check_bitrix_sessid() &&
		$has_access === true
	)
	{
				///AMOUNT, CURRENCY, ORDER, TERMINAL, TRTYPE, TIMESTAMP, NONCE, BACKREF, RRN,INT_REF
				
				$amount = number_format(floatval($amount), 2, ".", "");
				$org_amount = number_format(floatval($order['PRICE']), 2, ".", "");
				$dataRefundSign = 	(strlen($amount) > 0 ? strlen($amount).$amount : "-").
										(strlen($currency) > 0 ? strlen($currency).$currency : "-").
										(strlen($order_id) > 0 ? strlen($order_id).$order_id : "-").
										(strlen($terminal) > 0 ? strlen($terminal).$terminal : "-").
										(strlen($trtype) > 0 ? strlen($trtype).$trtype : "-").
										(strlen($time) > 0 ? strlen($time).$time : "-").
										(strlen($nonce) > 0 ? strlen($nonce).$nonce : "-").
										(strlen($backref) > 0 ? strlen($backref).$backref : "-").
										(strlen($data->rrn) > 0 ? strlen($data->rrn).$data->rrn : "-").
										(strlen($data->int_ref) > 0 ? strlen($data->int_ref).$data->int_ref : "-");
				
				$sign = bx_hmac("sha1", $dataRefundSign, $key); 

				//var_dump($dataRefundSign, \sdmGateway\Settings::$shopKey, $sign); die();
				
				$post = array();
				$post['AMOUNT'] = $amount;
				$post['ORG_AMOUNT'] = $org_amount;
				$post['CURRENCY'] = 643;
				$post['ORDER'] = $order_id;
				$post['TERMINAL'] = $terminal;
				$post['RRN'] = $data->rrn;
				$post['INT_REF'] = $data->int_ref;
				$post['TIMESTAMP'] = $time;
				$post['MERCH_GMT'] = "";
				$post['TRTYPE'] = $trtype;
				$post['BACKREF'] = $backref;
				$post['NONCE'] = $nonce;
				$post['P_SIGN'] = $sign;
				
				echo '<html><form action="' . $formUrl . '" method="POST" id="form">';
				foreach ($post as $k=>$v) {
					echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
				}
				echo 'Loading...';
				echo '</form><script type="text/javascript">document.getElementById("form").submit();</script></html>';
				exit;	
	}

	if(
		$_SERVER["REQUEST_METHOD"] == "POST" &&
		strlen($cancel) > 0 &&
		md5($merchant.$ID) === $hash &&
		check_bitrix_sessid() &&
		$has_access === true
	)
	{
				//AMOUNT, CURRENCY, ORDER, TERMINAL, TRTYPE, TIMESTAMP, NONCE, BACKREF, RRN,INT_REF
				$org_amount = number_format(floatval($order['PRICE']), 2, ".", "");
				$amount = number_format(floatval($order['PRICE']), 2, ".", "");
					
				$dataCancelSign = 	(strlen($amount) > 0 ? strlen($amount).$amount : "-").
										(strlen($currency) > 0 ? strlen($currency).$currency : "-").
										(strlen($order_id) > 0 ? strlen($order_id).$order_id : "-").
										(strlen($terminal) > 0 ? strlen($terminal).$terminal : "-").
										(strlen($trtype) > 0 ? strlen($trtype).$trtype : "-").
										(strlen($time) > 0 ? strlen($time).$time : "-").
										(strlen($nonce) > 0 ? strlen($nonce).$nonce : "-").
										(strlen($backref) > 0 ? strlen($backref).$backref : "-").
										(strlen($data->rrn) > 0 ? strlen($data->rrn).$data->rrn : "-").
										(strlen($data->int_ref) > 0 ? strlen($data->int_ref).$data->int_ref : "-");

				$sign = bx_hmac("sha1", $dataCancelSign, $key); 

				$post = array();
				$post['AMOUNT'] = $org_amount;
				$post['CURRENCY'] = 643;
				$post['ORDER'] = $order_id;
				$post['TERMINAL'] = $terminal;
				$post['RRN'] = $data->rrn;
				$post['INT_REF'] = $data->int_ref;
				$post['TIMESTAMP'] = $time;
				$post['MERCH_GMT'] = "";
				$post['TRTYPE'] = $trtype;
				$post['NONCE'] = $nonce;
				$post['P_SIGN'] = $sign;
				$post['BACKREF'] = $backref;
				
				
				echo '<html><form action="' . $formUrl . '" method="POST" id="form">';
				foreach ($post as $k=>$v) {
					echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
				}
				echo 'Loading...';
				echo '</form><script type="text/javascript">document.getElementById("form").submit();</script></html>';
				
		
		
	}
		
	$result = array();
	$result["order_id"] = $order["ID"];
	$result["amount"] = array("price" => $order["PRICE"], "currecy" => $order["CURRENCY"]);
	$user = CUser::GetList(
						($by="id"),
						($o="desc"),
						array("ID" => $order["USER_ID"]),
						array("FIELDS" => array("ID", "NAME", "LAST_NAME"))
				   )->Fetch();

	if($user["ID"] > 0)
	{
		$result["user"] = $user["NAME"] ." ". $user["LAST_NAME"];
	}	

	$tabs = array(
				  array("DIV" => "edit1", "TAB" => Loc::getMessage("BHT_SDMGATEWAY_TAB_TITLE"), "ICON"=>"main_user_edit", "TITLE" => Loc::getMessage("BHT_SDMGATEWAY_TITLE_DESC")),
			  );
	
	$o_tab = new CAdminTabControl("tab_control", $tabs);
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	
	$o_tab->Begin();
	$o_tab->BeginNextTab();
	
	foreach($result as $key => $val)
	{
		if( $key == "order_id" )
		{
?>
			<tr>
				<td width="40%"><?echo Loc::getMessage("BHT_SDMGATEWAY_ORDER_ID_TITLE")?>:</td>
				<td><?= $val?></td>
			</tr>
<?
		}
		else
			if($key == "amount")
			{
?>
				<tr>
					<td width="40%"><?echo Loc::getMessage("BHT_SDMGATEWAY_AMOUNT_TITLE")?>:</td>
					<td><?= $val["price"]." ".$val["currecy"]?></td>
				</tr>
<?
			}
			else
				if($key == "user")
				{
?>
					<tr>
						<td width="40%"><?echo Loc::getMessage("BHT_SDMGATEWAY_USER_TITLE")?>:</td>
						<td><?= $val?></td>
					</tr>
<?
				}
				
	}
	if($has_access === true)
	{
?>
		<form method="POST" action="<?echo POST_FORM_ACTION_URI?>" name="post_form">
			<?echo bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?= $ID?>">
			<input type="hidden" name="lang" value="<?= LANG?>">

			<?php
			if ($data->refund_amount) {?>
				<tr>
					<td width="50%"><?echo Loc::getMessage("BHT_SDMGATEWAY_REFUND_AMOUNT")?>: </td><td><?=$data->refund_amount?> <?=$order["CURRENCY"]?></td>
				</tr>
			<?php } ?>
			<?php if ($data->refund_amount < $order["PRICE"]) {?>
				<tr>
					<td width="40%"><input type="submit" name="refund" value="<?echo Loc::getMessage("BHT_SDMGATEWAY_REFUND")?>"></td>
					<td><input type="text" name="amount" value="">&nbsp;<small><?echo Loc::getMessage("BHT_SDMGATEWAY_REFUND_DESCR")?></small></td>
				</tr>
			<?php } ?>

			<tr>
				<td width="50%"><?= Loc::getMessage("BHT_SDMGATEWAY_NOTIFY_DESC")?></td>
			</tr>
			<input type="hidden" name="parent_uid" value="<?= $parent_uid?>">	
			<input type="hidden" name="hash" value="<?= md5($merchant.$ID)?>">	
	</form>

	<form method="POST" action="<?echo POST_FORM_ACTION_URI?>" name="post_form">
			<?echo bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?= $ID?>">
			<input type="hidden" name="lang" value="<?= LANG?>">

			

			<?php if ($data->refund_amount < $order["PRICE"]) {?>
				<tr>
					<td width="40%"><input type="submit" name="cancel" value="<?echo Loc::getMessage("BHT_SDMGATEWAY_CANCEL")?>"></td>
					<td></td>
				</tr>
			<?php } ?>

			<tr>
				<td width="50%"><?= Loc::getMessage("BHT_SDMGATEWAY_NOTIFY_DESC")?></td>
			</tr>
			<input type="hidden" name="parent_uid" value="<?= $parent_uid?>">	
			<input type="hidden" name="hash" value="<?= md5($merchant.$ID)?>">	
	</form>
<?
	}
	$o_tab->End();

}catch(Exception $e){
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	CAdminMessage::ShowMessage(array("MESSAGE" => $e->getMessage(), "TYPE"=>"ERROR"));
}
\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
