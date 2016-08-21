<?

$classes = array(
				"\sdmGateway\ApiAbstract" => "lib/ApiAbstract.php",
				"\sdmGateway\Authorization" => "lib/Authorization.php",
				"\sdmGateway\Capture" => "lib/Capture.php",
				"\sdmGateway\Card" => "lib/Card.php",
				"\sdmGateway\CardToken" => "lib/CardToken.php",
				"\sdmGateway\ChildTransaction" => "lib/ChildTransaction.php",
				"\sdmGateway\Credit" => "lib/Credit.php",
				"\sdmGateway\Customer" => "lib/Customer.php",
				"\sdmGateway\GatewayTransport" => "lib/GatewayTransport.php",
				"\sdmGateway\GetPaymentToken" => "lib/GetPaymentToken.php",
				"\sdmGateway\Language" => "lib/Language.php",
				"\sdmGateway\Logger" => "lib/Logger.php",
				"\sdmGateway\Money" => "lib/Money.php",
				"\sdmGateway\Payment" => "lib/Payment.php",
				"\sdmGateway\QueryByToken" => "lib/QueryByToken.php",
				"\sdmGateway\QueryByTrackingId" => "lib/QueryByTrackingId.php",
				"\sdmGateway\QueryByUid" => "lib/QueryByUid.php",
				"\sdmGateway\Refund" => "lib/Refund.php",
				"\sdmGateway\Response" => "lib/Response.php",
				"\sdmGateway\ResponseBase" => "lib/ResponseBase.php",
				"\sdmGateway\ResponseCardToken" => "lib/ResponseCardToken.php",
				"\sdmGateway\ResponseCheckout" => "lib/ResponseCheckout.php",
				"\sdmGateway\Settings" => "lib/Settings.php",
				"\sdmGateway\Void" => "lib/Void.php",
				"\sdmGateway\Webhook" => "lib/Webhook.php",
		   );

CModule::AddAutoloadClasses("bht.sdmgateway", $classes);