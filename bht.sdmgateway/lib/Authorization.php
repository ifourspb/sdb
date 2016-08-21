<?php
namespace sdmGateway;

class Authorization extends ApiAbstract {
  public $customer;
  public $card;
  public $money;
  protected $_description;
  protected $_tracking_id;
  protected $_notification_url;
  protected $_return_url;

  public function __construct() {
    $this->customer = new Customer();
    $this->money = new Money();
    $this->card = new Card();
    $this->_language = Language::getDefaultLanguage();
  }

  public function setDescription($description) {
    $this->_description = $description;
  }
  public function getDescription() {
    return $this->_description;
  }

  public function setTrackingId($tracking_id) {
    $this->_tracking_id = $tracking_id;
  }
  public function getTrackingId() {
    return $this->_tracking_id;
  }

  public function setNotificationUrl($notification_url) {
    $this->_notification_url = $notification_url;
  }
  public function getNotificationUrl() {
    return $this->_notification_url;
  }

  public function setReturnUrl($return_url) {
    $this->_return_url = $return_url;
  }
  public function getReturnUrl() {
    return $this->_return_url;
  }

  protected function _buildRequestMessage() {
    $request = array(
      'request' => array(
        'amount' => $this->money->getCents(),
        'currency' => $this->money->getCurrency(),
        'description' => $this->getDescription(),
        'tracking_id' => $this->getTrackingId(),
        'notification_url' => $this->getNotificationUrl(),
        'return_url' => $this->getReturnUrl(),
        'language' => $this->getLanguage(),
        'credit_card' => array(
          'number' => $this->card->getCardNumber(),
          'verification_value' => $this->card->getCardCvc(),
          'holder' => $this->card->getCardHolder(),
          'exp_month' => $this->card->getCardExpMonth(),
          'exp_year' => $this->card->getCardExpYear(),
          'token' => $this->card->getCardToken(),
          'skip_three_d_secure_verification' => $this->card->getSkip3D(),
        ),
        'customer' => array(
          'ip' => $this->customer->getIP(),
          'email' => $this->customer->getEmail(),
        ),
        'billing_address' => array(
          'first_name' => $this->customer->getFirstName(),
          'last_name' => $this->customer->getLastName(),
          'country' => $this->customer->getCountry(),
          'city' => $this->customer->getCity(),
          'state' => $this->customer->getState(),
          'zip' => $this->customer->getZip(),
          'address' => $this->customer->getAddress(),
          'phone' => $this->customer->getPhone()
        )
      )
    );

    Logger::getInstance()->write($request, Logger::DEBUG, get_class() . '::' . __FUNCTION__);

    return $request;
  }

}
?>
