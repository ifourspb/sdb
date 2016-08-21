<?php
$client = new Google_Client();
$client->setRedirectUri($redirectUrl);
$client->setAuthConfigFile('auth.json');
$client->setScopes(array('https://spreadsheets.google.com/feeds'));
$client->setApprovalPrompt('force');
$client->setAccessType('offline');
	

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
	header('Location: /crm/index.php');
	exit;
}
if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);//update token
	//json decode the session token and save it in a variable as object
	$sessionToken = json_decode($_SESSION['token']);
	//Save the refresh token (object->refresh_token) into a cookie called 'token' and make last for 1 month
	if (isset($sessionToken->refresh_token)) { //refresh token is only set after a proper authorisation
		$number_of_days = 30 ;
		$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
		setcookie('refresh_token', $sessionToken->refresh_token, $date_of_expiry);
	}
}elseif (isset($_COOKIE["refresh_token"])) {//if we don't have a session we will grab it from the cookie
	$client->refreshToken($_COOKIE["refresh_token"]);//update token
	 $_SESSION['token'] = $client->getAccessToken();
	$updT = 1;
} 

if ($client->isAccessTokenExpired() && $updT!=1 && $_COOKIE["refresh_token"]) {
	$z = $client->refreshToken($_COOKIE["refresh_token"]);
	 $_SESSION['token'] = $client->getAccessToken();
	//var_dump($_COOKIE["refresh_token"], $z); die();
}

//var_dump($client->getAccessToken(), $client->isAccessTokenExpired); die(); 

if (!$client->getAccessToken() || $client->isAccessTokenExpired()) {
    $authUrl = $client->createAuthUrl();
    print "<h2><a class='login' href='$authUrl'>Войти!</a></h2>";
	exit;
}else {
	//die('1');
}

$plusOp[0]['name'] = 'Фотосессия';

$plusOp[0]['childs'][] = 'Беременная';
$plusOp[0]['childs'][] = 'Выездная';
$plusOp[0]['childs'][] = 'Детская';
$plusOp[0]['childs'][] = 'Документы';
$plusOp[0]['childs'][] = 'Животных';
$plusOp[0]['childs'][] = 'Семейная';
$plusOp[0]['childs'][] = 'Свадебная';
$plusOp[0]['childs'][] = 'Предметная';
$plusOp[0]['childs'][] = 'Рекламная/Коммерческая';
$plusOp[0]['childs'][] = 'Художественная';

$plusOp[1]['name'] = 'Фото с мероприятия';
$plusOp[1]['childs'][] = 'Фото с утренника';
$plusOp[1]['childs'][] = 'Фото с праздника';

$plusOp[2]['name'] = 'Сертификат';

$plusOp[3]['name'] = 'Организация мероприятия';
$plusOp[3]['childs'][] = 'Утренника';
$plusOp[3]['childs'][] = 'Праздника';

$plusOp[4]['name'] = 'Видео';

$plusOp[5]['name'] = 'Товар';
$plusOp[5]['childs'][] = 'Игрушка';

$plusOp[6]['name'] = 'Фото-книга';
$plusOp[7]['name'] = 'Фото-магнит';
$plusOp[8]['name'] = 'Визаж';
$plusOp[9]['name'] = 'Паспарту';
$plusOp[10]['name'] = 'Холст';
$plusOp[11]['name'] = 'Прочее';

$whereOp[] = 'Не помню';
$whereOp[] = 'Сертификат';
$whereOp[] = 'Реклама на улице';
$whereOp[] = 'Старый клиент';
$whereOp[] = 'Интернет - поиск';
$whereOp[] = 'Соцсети';
$whereOp[] = 'Друзья рассказали';

$transferOp[] = 'Касса -> Сейф';
$transferOp[] = 'Сейф -> Касса';
$transferOp[] = 'Праздники -> Сейф';
$transferOp[] = 'Сейф -> Праздники';
$transferOp[] = 'Праздники -> Касса';
$transferOp[] = 'Касса -> Праздники';




$minusOp[0]['name'] = 'Печать';
$minusOp[0]['childs'][] = 'основная';
$minusOp[0]['childs'][] = 'большого формата';
$minusOp[0]['childs'][] = 'книги';
$minusOp[0]['childs'][] = 'сертификата';
$minusOp[0]['childs'][] = 'паспарту';
$minusOp[0]['childs'][] = 'холст';
$minusOp[0]['childs'][] = 'прочего';

$minusOp[1]['name'] = 'Утренник';

$minusOp[1]['childs'][] = 'аниматор/ведущий';
$minusOp[1]['childs'][] = 'музыка';
$minusOp[1]['childs'][] = 'питание';
$minusOp[1]['childs'][] = 'помощь';
$minusOp[1]['childs'][] = 'декор';
$minusOp[1]['childs'][] = 'подарки';
$minusOp[1]['childs'][] = 'прочее';


$minusOp[2]['name'] = 'Праздник';
$minusOp[2]['childs'][] = 'аниматор/ведущий';
$minusOp[2]['childs'][] = 'музыка';
$minusOp[2]['childs'][] = 'питание';
$minusOp[2]['childs'][] = 'помощь';
$minusOp[2]['childs'][] = 'декор';
$minusOp[2]['childs'][] = 'прочее';

$minusOp[3]['name'] = 'Реклама';
$minusOp[3]['childs'][] = 'интернет';
$minusOp[3]['childs'][] = 'печать';
$minusOp[3]['childs'][] = 'аренда площадей';
$minusOp[3]['childs'][] = 'услуги';
$minusOp[3]['childs'][] = 'акции';
$minusOp[3]['childs'][] = 'прочее';


$minusOp[4]['name'] = 'Студия';
$minusOp[4]['childs'][] = 'аренда';
$minusOp[4]['childs'][] = 'аппаратура';
$minusOp[4]['childs'][] = 'декор';
$minusOp[4]['childs'][] = 'налоги';
$minusOp[4]['childs'][] = 'проезд';
$minusOp[4]['childs'][] = 'канцтовары';
$minusOp[4]['childs'][] = 'хозтовары';
$minusOp[4]['childs'][] = 'мобильная связь';
$minusOp[4]['childs'][] = 'коммунальные платеж';
$minusOp[4]['childs'][] = 'ремонтный фонд';
$minusOp[4]['childs'][] = 'реквизит';
$minusOp[4]['childs'][] = 'прочее';


$minusOp[5]['name'] = 'Питание';
$minusOp[5]['childs'][] = 'вода';
$minusOp[5]['childs'][] = 'кофе, чай';
$minusOp[5]['childs'][] = 'еда';
$minusOp[5]['childs'][] = 'сахар';
$minusOp[5]['childs'][] = 'прочее';



$minusOp[6]['name'] = 'ЗП';
$minusOp[6]['childs'][] = 'Алла';
$minusOp[6]['childs'][] = 'Ася';
$minusOp[6]['childs'][] = 'Анжела';
$minusOp[6]['childs'][] = 'Вика';
$minusOp[6]['childs'][] = 'Визажист';
$minusOp[6]['childs'][] = 'Иван';
$minusOp[6]['childs'][] = 'Катя';
$minusOp[6]['childs'][] = 'Лариса Константиновна';
$minusOp[6]['childs'][] = 'Лена';
$minusOp[6]['childs'][] = 'Ольга';
$minusOp[6]['childs'][] = 'Ольга Шишова';
$minusOp[6]['childs'][] = 'Слава';
$minusOp[6]['childs'][] = 'Эльзара';

$minusOp[7]['name'] = 'Прочее';
$minusOp[7]['childs'][] = 'Возврат денег';
$minusOp[7]['childs'][] = 'Лена Воробьева';
$minusOp[7]['childs'][] = 'прочее';

$staffOp[] = 'Ася';
$staffOp[] = 'Вика';
$staffOp[] = 'Катя';
$staffOp[] = 'Лена';
$staffOp[] = 'Ольга';

$sources =  explode(',', 'A1(D:),A2(E:),Foto1(F:),Foto2(G:),word(H:),Белый комп word (D:),Dlink');

$choose = array();
$choose[] = 'Ася';
$choose[] = 'Катя';
$choose[] = 'Вика';
$choose[] = 'Лена';
$choose[] = 'Алла';
$choose[] = 'Анжела';
$choose[] = 'Ольга Шишова';
$choose[] = 'Эльзара';


$mastering = array();
$mastering[] = 'Алла';
$mastering[] = 'Анжела';
$mastering[] = 'Ольга Шишова';
$mastering[] = 'Эльзара';
$mastering[] = 'Ася';
$mastering[] = 'Катя';
$mastering[] = 'Вика';
$mastering[] = 'Лена';


$money = array();
$money[] = 'Касса';
$money[] = 'Сейф';
$money[] = 'Праздники';


foreach ($plusOp as $k => &$data) {
	if ($data['childs']) {
		sort($data['childs']);
	}
}
foreach ($minusOp as $k => &$data) {
	if ($data['childs']) {
		sort($data['childs']);
	}
}
