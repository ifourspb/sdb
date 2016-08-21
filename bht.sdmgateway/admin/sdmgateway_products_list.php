<?
$module_id = "bht.sdmgateway";

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/$module_id/include.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/$module_id/prolog.php");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::includeModule("sale");

try
{
	$ps_id = (int)\Bitrix\Main\Config\Option::get( $module_id, "payment_system_id" );
	
	if( $ps_id <= 0 )
		throw new Exception( Loc::getMessage( "BHT_SDMGATEWAY_PS_NOT_FOUND" ) );
	
	$table_id = "order_list";
	$o_sort = new CAdminSorting($table_id, "DATE_INSERT", "DESC");
	$o_table = new CAdminList($table_id, $o_sort);
	
	
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "N"); //Костыль из - за совместимости битрикс с ядром D7
	$db_orders = CSaleOrder::GetList(
								array($by => $order),
								array("PAY_SYSTEM_ID" => $ps_id, "PAYED" => "Y"),
								false,
								false,
								array("ID", "USER_ID", "DATE_INSERT", "STATUS_ID", "PS_STATUS", "PS_STATUS_DESCRIPTION")
							);
	
	\Bitrix\Main\Config\Option::set("main", "~sale_converted_15", "Y");
	
	$db_orders = new CAdminResult($db_orders, $table_id);
	
	$db_orders->NavStart();
	$o_table->NavText($db_orders->GetNavPrint(Loc::getMessage("BHT_SDMGATEWAY_NAV_TITLE")));
	
	$o_table->AddHeaders(array(
							array(
								"id" => "ID",
								"content" => Loc::getMessage("BHT_SDMGATEWAY_COL_ID_MESSAGE"),
								"sort" => "id",
								"default" => true	
							),
							array(
								"id" => "USER_ID",
								"content" => Loc::getMessage("BHT_SDMGATEWAY_COL_USER_ID_MESSAGE"),
								"sort" => "user_id",
								"default" => true	
							),
							array(
								"id" => "DATE_INSERT",
								"content" => Loc::getMessage("BHT_SDMGATEWAY_COL_DATE_INSERT_MESSAGE"),
								"sort" => "date_insert",
								"default" => true	
							),
							array(
								"id" => "PS_STATUS",
								"content" => Loc::getMessage("BHT_SDMGATEWAY_COL_STATUS_ID_MESSAGE"),
								"default" => true	
							)
						)
			  );
	
	$cache_users = array();
	while($arr_order = $db_orders->NavNext(true, "var_") )
	{
		
		if( !isset( $cache_users[$arr_order["USER_ID"]] ) )
		{
			$user = CUser::GetList(
								($by="id"),
								($order="desc"),
								array("ID" => $arr_order["USER_ID"]),
								array("FIELDS" => array("ID", "NAME", "LAST_NAME"))
						   )->Fetch();

			if($user["ID"] > 0)
			{
				$cache_users[$arr_order["USER_ID"]] = $user["NAME"] ." ". $user["LAST_NAME"];
				$arr_order["USER_ID"] = $cache_users[$arr_order["USER_ID"]];
			}
		}
		else
			$arr_order["USER_ID"] = $cache_users[$arr_order["USER_ID"]];
		
		$row = &$o_table->AddRow($var_ID, $arr_order);
		
		$name = Loc::getMessage("BHT_SDMGATEWAY_ORDER_TITLE").$arr_order["ID"];
		$row->AddViewField("ID", "<a href=\"sdmgateway_transaction_payment.php?ID=".$var_ID."&lang=".LANG."\" >".$name."</a>");
	
		if ($arr_order['PS_STATUS'] == 'Y') {
			$s =  Loc::getMessage("BHT_SDMGATEWAY_COL_STATUS_PAYED");
		}else {
			$s =  Loc::getMessage("BHT_SDMGATEWAY_COL_STATUS_NOTPAYED");
		}
		$row->AddViewField("PS_STATUS", $s);
		
	
	}
	
	$o_table->AddAdminContextMenu();
	$o_table->CheckListMode();
	$APPLICATION->SetTitle(Loc::getMessage("BHT_SDMGATEWAY_TITLE"));
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	
	$o_table->DisplayList();
	
}catch(Exception $e){
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	CAdminMessage::ShowMessage(array("MESSAGE" => $e->getMessage(), "TYPE"=>"ERROR"));
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");