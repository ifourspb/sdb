<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<section>
		<?php if ($arResult['PS_STATUS'] != 'Y') {?>
			<div id="uid-transaction"><?= Loc::getMessage("BHT_SDMGATEWAY_STATUS")?>: <?= Loc::getMessage("BHT_SDMGATEWAY_FAIL_TITLE")?> </div>
		<?php } else {?>
			<div id="uid-transaction"><?= Loc::getMessage("BHT_SDMGATEWAY_STATUS")?>: <?= Loc::getMessage("BHT_SDMGATEWAY_SUCCESS_TITLE")?> </div>
		<?php } ?>
	
	<div id="uid-transaction"><?= Loc::getMessage("BHT_SDMGATEWAY_INFO_ORDER_ID")?> <span><?= $arResult['ID']?></span></div>
	
	<?php if ($arResult['PRICE']>0) {?>
		<div id="amount"><?= Loc::getMessage("BHT_SDMGATEWAY_INFO_AMOUNT")?> <span><?= $arResult['PRICE']?></span> <span><?= $arResult['CURRENCY'] ?></span></div>
	<?php } ?>
	<?php if ($arResult['REFUND_AMOUNT']>0) {?>
		<div id="amount"><?= Loc::getMessage("BHT_SDMGATEWAY_REFUND_AMOUNT")?> <span><?= $arResult['REFUND_AMOUNT']?></span> <span><?= $arResult['CURRENCY'] ?></span></div>
	<?php } ?>
	
	<?php if ($arResult['PS_STATUS'] != 'Y') {?>
		<div id="uid-transaction"><?= Loc::getMessage("BHT_SDMGATEWAY_INFO_UID")?> <span><?= $arResult['PS_STATUS_DESCRIPTION']?></span></div>
		<div id="uid-transaction"><?= Loc::getMessage("BHT_SDMGATEWAY_FAIL_REJECTION_REASON")?> <span><?= $arResult['PS_STATUS_CODE']?></span></div>
	<?php } ?>
	
	<br/><br/>
</section>
