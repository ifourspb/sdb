<?php
$file = file('db.csv');

$id = '1438';
$key = 'DFBAA8915B58458D';

foreach ($file as $k => $string) {
	if ($k == 0) {
		continue;
	}
	$a = explode(';', $string);
	$name = trim($a[0]);
	
	$phone = trim($a[1]);
	if (!$phone) continue;
	$phone = '+' . $phone;

	$name = ICONV('WINDOWS-1251', 'UTF-8', $name);
	//var_dump($name);
	
	if (mb_strlen($name)==0) {
		$msg = 'Здравствуйте! ';
	}else {
		$msg = 'Здравствуйте, ' . $name . '! ';
	}
	
	$msg .= 'Фотостудии "Воробушек" 4 года! Приходите праздновать с нами! 7 ноября, с 12.00, ДиноПарк (ул. Корчагина, конечная маршрутов 112 и 4). Телефон для связи: +7-978-068-3582 vk.com/stydia.vorobyshek';
	$bytehandFrom = 'Vorobushek';

	//$phone = '+79780683582';
	$url = 'http://bytehand.com:3800/send?id='.$id.'&key='.$key.'&to='.urlencode($phone).'&from='.urlencode($bytehandFrom).'&text='.urlencode($msg);
	$result = file_get_contents($url);
	echo "<br>" . $k . " " . $phone . ' ' . $msg . " " . $url;
	//exit;
	
}