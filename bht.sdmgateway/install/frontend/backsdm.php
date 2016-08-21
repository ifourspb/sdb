<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Процесс оплаты завершен!");
?>

<?$APPLICATION->IncludeComponent(
	"bht:sdmgateway.transaction.info",
	"info",
Array()
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>