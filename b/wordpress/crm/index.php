<?php
//phpinfo(); die();
$redirectUrl = 'http://vorobiova.ru';
set_include_path('/var/www/b/wordpress/crm/Google');
require '/var/www/b/wordpress/crm/Google/autoload.php';
require '/var/www/b/wordpress/crm/Google/Client.php';

if ($_GET['view_id']) {
	header('Location: /crm/index.php?action=order_view&id=' . $_GET['view_id']);
	exit;
}


//07.01 5768
//12.01 5779
//16.01 5791
//18.01 5801



session_start();

if ($_GET['test']==1){
	unset($_COOKIE["refresh_token"]); 
}

require 'inc_auth.php';

require 'vendor/autoload.php';
	
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

if ($_GET['flush']) {
	file_put_contents('./files/orders', '');
	file_put_contents('./files/child' , '');
	file_put_contents('./files/clients' , '');
}



$sessionToken = json_decode($_SESSION['token']);
$serviceRequest = new DefaultServiceRequest($sessionToken->access_token);
ServiceRequestFactory::setInstance($serviceRequest);

$f = file_get_contents('./files/clients');
setlocale(LC_ALL, 'UTF-8');
if (!$f) {
	$sessionToken = json_decode($_SESSION['token']);
	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();
	$entries = $listFeed->getEntries();
	$clientsBase = array();

	foreach ($entries  as $entry) {
		$a = $entry->getValues();
		if (empty($a['фио'])) {
			$entry->delete();
		}else {
			$clientsBase[(int)$a['id']] = $a;
		}
	}
	usort($clientsBase, 'cmp');
	$tmp = array();
	foreach ($clientsBase as $k => $a) {
		$tmp[$a['id']] = $a;
	}
	$clientsBase = $tmp;
	//var_dump($clientsBase); die();
	
	file_put_contents('./files/clients', serialize($clientsBase));	
}else {
	$clientsBase = unserialize($f);
}


$f2 = file_get_contents('./files/child');
if (!$f2) {
	$sessionToken = json_decode($_SESSION['token']);
	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();

	$spreadsheetChild = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1goC1TDKiCEptm7UicBXdqpGLAXzp48kchQcRqXd4xtE');
	$worksheetFeedChild = $spreadsheetChild->getWorksheets();
	$worksheetChild = $worksheetFeedChild->getFirst();
	$listFeedChild = $worksheetChild->getListFeed();
	$entriesChild = $listFeedChild->getEntries();

	$childsBase = array();

	foreach ($entriesChild  as $entry) {
		$a = $entry->getValues();
		if (empty($a['фио'])) {
			$entry->delete();
		}else {
			$childsBase[$a['parentid']][] = $a;
		}
	}

	file_put_contents('./files/child', serialize($childsBase));	
}else {
	$childsBase = unserialize($f2);
}

if ($_GET['client']) {
	$searchIds = array();

	$sessionToken = json_decode($_SESSION['token']);
	$serviceRequest = new DefaultServiceRequest($sessionToken->access_token);
	ServiceRequestFactory::setInstance($serviceRequest);

	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();

	$entries = $listFeed->getEntries();

	$needle = mb_strtolower(trim(urldecode($_GET['client'])), 'utf-8');

	foreach ($entries as $entry) {
		$a = $entry->getValues();
		$client = mb_strtolower(trim($clientsBase[$a['номерклиента']]['фио']), 'utf-8');
		$pos = strpos($client, $needle);
		if ($pos !== false) {
			$searchIds[] = $a['номероперации'];
		}
	}
}

function cmp($a, $b)
{
    return strcmp($a["фио"], $b["фио"]);
}

if ($_GET['sync'] == '1') {
	set_time_limit(0);
	$spreadsheetService1 = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed1 = $spreadsheetService1->getSpreadsheets();
	$spreadsheet1 = $spreadsheetFeed1->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co');
	$worksheetFeed1 = $spreadsheet1->getWorksheets();
	$worksheet1 = $worksheetFeed1->getFirst();
	$listFeed1 = $worksheet1->getListFeed();
	$entries1 = $listFeed1->getEntries();


	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();
	$entries = $listFeed->getEntries();
	
	$id = count($entries)+1;
	$tmp = array();
	foreach ($entries1 as $entry) {
		$a = $entry->getValues();
		if (!$a['клиент'] || $a['операция']!='Доход') continue;
		if ($a['номерклиента']) continue;
		//echo '<br>' . $a['клиент']; flush();
		if (!$tmp[$a['клиент']]) {
			$newClientRow = array(
				'id' => $id,
				'фио' => $a['клиент'],
				'телефон' => $a['телефонклиента'],
				'откуда' => $a['откудапришли'],
				'датазаведения' => date("d.m.Y", strtotime($a['отметкавремени'])),
				'комментарий' => ''
			);
			$operation = $listFeed->insert($newClientRow);
			$a['номерклиента'] = $id;
			$tmp[$a['клиент']] = $id;
			$id++;
		}else {
			$a['номерклиента'] = $tmp[$a['клиент']];
		}
		$entry->update($a);
		//die('1');
	}
	die('&');
}

if ($_GET['action'] == 'delete_client' && isset($_GET['id'])) {
	$sessionToken = json_decode($_SESSION['token']);
	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();
	$entries = $listFeed->getEntries();
	
	$spreadsheetChild = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1goC1TDKiCEptm7UicBXdqpGLAXzp48kchQcRqXd4xtE');
	$worksheetFeedChild = $spreadsheetChild->getWorksheets();
	$worksheetChild = $worksheetFeedChild->getFirst();
	$listFeedChild = $worksheetChild->getListFeed();
	$entriesChild = $listFeedChild->getEntries();

	foreach ($entries as $entry) {
		$a = $entry->getValues();
		if ($a['id'] == $_GET['id']) {
			$entry->update(array('фио'=>''));
			$entry->delete();
			break;
		}
	}

	foreach ($entriesChild as $centry) {	
		$a3 = $centry->getValues();
		//echo "<br>" . $a3['parentid'] . " " . $_GET['id'];
		if ($a3['parentid'] == $_GET['id']) {
			$centry->update(array('фио'=>''));
			$z = $centry->delete();
		}
	}
	file_put_contents('./files/clients', '');	
	file_put_contents('./files/child', '');	
	header('Location: /crm/index.php?action=clients');
	exit;
}


if ($_POST['action'] == 'update_client') {
	$sessionToken = json_decode($_SESSION['token']);
	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();
	$entries = $listFeed->getEntries();
	
	$spreadsheetChild = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1goC1TDKiCEptm7UicBXdqpGLAXzp48kchQcRqXd4xtE');
	$worksheetFeedChild = $spreadsheetChild->getWorksheets();
	$worksheetChild = $worksheetFeedChild->getFirst();
	$listFeedChild = $worksheetChild->getListFeed();
	$entriesChild = $listFeedChild->getEntries();

	foreach ($entries as $entry) {
		$a = $entry->getValues();
		if ($a['id'] == $_POST['id']) {
			$updateRow = array(
				'фио' => $_POST['client']['name'],
				'телефон' => $_POST['client']['phone'],
				'email' => $_POST['client']['email'],
				'откуда' => $_POST['client']['where'],
				'датарождения' => $_POST['client']['bd'],
				'датазаведения' => date('d.m.Y'),
				'комментарий' => $_POST['client']['comment']
			);
			$entry->update($updateRow);
			break;
		}
	}

	//var_dump($_POST['child_new'], $_POST['child_name']); die();

	if ($_POST['child_name']) {
		foreach ($_POST['child_name'] as $k => $cname) {				
					foreach ($entriesChild as $centry) {	
						$a3 = $centry->getValues();
						if ($a3['id'] == $k) {
							if (isset($_POST['remove'][$k])) {
								$centry->update(array('фио'=>''));
								$centry->delete();
							}else {
								$updateChildRow = array(
									'фио' => $_POST['child_name'][$k],
									'пол' => $_POST['child_sex'][$k],
									'датарождения' => $_POST['child_bd'][$k],
									'комментарий' => $_POST['child_comment'][$k]
								);
								$centry->update($updateChildRow);
							}
						}
					}				
		}
	}

	if ($_POST['child_name_new']) {
		$newChildId = count($entriesChild) + 1;
		foreach ($_POST['child_name_new'] as $k => $cname) {
				if (!empty($cname)) {
					$newChildRow = array(
						'id' => $newChildId,
						'parentid' => $_POST['id'],
						'фио' => $cname,
						'пол' => $_POST['child_sex_new'][$k],
						'датарождения' => $_POST['child_bd_new'][$k],
						'комментарий' => $_POST['child_comment_new'][$k]
					);
					$operation = $listFeedChild->insert($newChildRow);
					$newChildId++;
				}
				
		}
	}

	file_put_contents('./files/clients', '');	
	file_put_contents('./files/child', '');	

	header('Location: /crm/index.php?action=clients&id=' . $_POST['id']);
	exit;
}


if ($_POST['action'] == 'new_client') {
	$sessionToken = json_decode($_SESSION['token']);
	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();
	$entries = $listFeed->getEntries();
	
	$spreadsheetChild = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1goC1TDKiCEptm7UicBXdqpGLAXzp48kchQcRqXd4xtE');
	$worksheetFeedChild = $spreadsheetChild->getWorksheets();
	$worksheetChild = $worksheetFeedChild->getFirst();
	$listFeedChild = $worksheetChild->getListFeed();
	$entriesChild = $listFeedChild->getEntries();
	
	$newId = 0;
	foreach ($entries as $entry) {
		$a = $entry->getValues();
		$newId = $a['id'] + 1;
	}

	$newClientRow = array(
		'id' => $newId,
		'фио' => $_POST['client']['name'],
		'телефон' => $_POST['client']['phone'],
		'email' => $_POST['client']['email'],
		'откуда' => $_POST['client']['where'],
		'датарождения' => $_POST['client']['bd'],
		'датазаведения' => date('d.m.Y'),
		'комментарий' => $_POST['client']['comment']
	);
	$operation = $listFeed->insert($newClientRow);

	if ($_POST['child_name']) {
		
		$newChildId = 0;
		foreach ($entriesChild as $entry) {
			$a = $entry->getValues();
			$newChildId = $a['id'] + 1;
		}

		foreach ($_POST['child_name'] as $k => $cname) {
				if (!empty($cname)) {
					$newChildRow = array(
						'id' => $newChildId,
						'parentid' => $newId,
						'фио' => $cname,
						'пол' => $_POST['child_sex'][$k],
						'датарождения' => $_POST['child_bd'][$k],
						'комментарий' => $_POST['child_comment'][$k]
					);
					$operation = $listFeedChild->insert($newChildRow);
					$newChildId++;
				}
				
		}
	}
	file_put_contents('./files/clients', '');	

	if ($_POST['frame'] == 1) {
		echo '<script>window.parent.$("#client").append(\'<option value="' . $newId . '">' . str_replace("'",'"', $_POST['client']['name']) . ' | ' .  str_replace("'",'"', $_POST['client']['phone']) . '</option>\');</script>';
		echo '<script>window.parent.$("#client").val(' . $newId . ');</script>';
		echo '<script>window.parent.closeNewClient();</script>';
		exit;
	}

	header('Location: /crm/index.php?action=clients&id=' . $newId);
	exit;
}

if ($_POST) {
	$sessionToken = json_decode($_SESSION['token']);
	$serviceRequest = new DefaultServiceRequest($sessionToken->access_token);
	ServiceRequestFactory::setInstance($serviceRequest);

	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();

	$entries = $listFeed->getEntries();
	
	if ($_POST['action'] == 'new_order') {
		$maxOrderId = 0;
		foreach ($entries as $entry) {
			//var_dump($entry);
			$a = $entry->getValues();
			if ($a['номероперации']>0){
				$maxOrderId = $a['номероперации'];
			}
		}
		$maxOrderId++;
		$date = date("d.m.Y H:i:s");
		$ids = array();
		
		
		foreach ($_POST['operation'] as $num => $operationName) {
			//var_dump($listFeed); die();
			$plusRow = array('отметкавремени'=>$date, 
					'операция'=>'Доход', 
					'операциядохода'=>$operationName,
					'сумма'=>$_POST['sum'][$num],
					'долг'=>$_POST['dolg'][$num],
					'комментарий'=>$_POST['comment'][$num],
					'сотрудник'=>$_POST['staff'],
					'номерклиента'=>$_POST['client'],
					'телефонклиента'=>phone($_POST['phone']),
					'откудапришли'=>$_POST['where'],
					'номероперации' => $maxOrderId,
					'дата' => date('d.m.Y'),
					'местохранения' => $_POST['place'][$num],
					'датаготовности' => $_POST['dater'][$num],
					'датавыдачи' => $_POST['date'][$num],
					'выбор' => $_POST['choose'][$num],
					'обработка' => $_POST['process'][$num],
					'источник' => $_POST['money'][$num]
			);
			$plusRow['подоперация'] = $_POST['suboperation'][$num];
			
			$ids[] = $maxOrderId;
			$maxOrderId++;
			$operation = $listFeed->insert($plusRow);
		}
		file_put_contents('./files/orders', '');
		header('Location: /crm/index.php?action=order_view&id=' . join(',',$ids));
		exit;
	
	}elseif ($_POST['action'] == 'minus') {
	
			
		$maxOrderId = 0;
		foreach ($entries as $entry) {
			$a = $entry->getValues();
			if ($a['номероперации']>0){
				$maxOrderId = $a['номероперации'];
			}
		}
		$maxOrderId++;
		$date = date("d.m.Y H:i:s");

		foreach ($_POST['operation'] as $num => $operationName) {
			$minusRow = array('отметкавремени'=>$date, 
					'операция'=>'Расход', 
					'операциярасхода'=>$operationName,
					'сумма'=>'-'.$_POST['sum'][$num],
					'сотрудникзп' => $_POST['staffzp'][$num],
					'комментарий'=>$_POST['comment'][$num],
					'сотрудник'=>$_POST['staff'],
					'номероперации' => $maxOrderId,
					'дата' => date('d.m.Y'),
					'источник' => $_POST['money'][$num]
			);
			$minusRow['подоперация'] = $_POST['suboperation'][$num];
			
			$ids[] = $maxOrderId;
			$maxOrderId++;
			$operation = $listFeed->insert($minusRow);
		}
		file_put_contents('./files/orders', '');
		header('Location: /crm/index.php?action=order_view&id=' . join(',',$ids));
		exit;
	}elseif($_POST['action']=='transfer') {

		$maxOrderId = 0;
		foreach ($entries as $entry) {
			$a = $entry->getValues();
			if ($a['номероперации']>0){
				$maxOrderId = $a['номероперации'];
			}
		}
		$maxOrderId++;
		$date = date("d.m.Y H:i:s");

		foreach ($_POST['operation'] as $num => $operationName) {
			$minusRow = array('отметкавремени'=>$date, 
					'операция'=>'Трансфер', 
					'операциярасхода'=>$operationName,
					'сумма'=>''.$_POST['sum'][$num],
					'комментарий'=>$_POST['comment'][$num],
					'сотрудник'=>$_POST['staff'],
					'номероперации' => $maxOrderId,
					'дата' => date('d.m.Y')
			);
			
			$ids[] = $maxOrderId;
			$maxOrderId++;
			$operation = $listFeed->insert($minusRow);
		}
	
		header('Location: /crm/index.php?action=order_view&id=' . join(',',$ids));
		exit;

	}elseif ($_POST['action'] == 'update_order') {
		$ids = array();
		foreach ($_POST['order'] as $num => $value) {
			$ids[] = $num;

			if ($_POST['type'][$num] == 'plus') {
				$updateRow = array(
						'операциядохода'=>$_POST['operation'][$num],
						'сумма'=>$_POST['sum'][$num],
						'долга'=>$_POST['dolg'][$num],
						'комментарий'=>$_POST['comment'][$num],
						'сотрудник'=>$_POST['staff'][$num],
						'номерклиента'=>$_POST['client'][$num],
						'телефонклиента'=>phone($_POST['phone'][$num]),
						'откудапришли'=>$_POST['where'][$num],
						'датавыдачи' => $_POST['date'][$num],
						'датаготовности' => $_POST['dater'][$num],
						'местохранения' => $_POST['place'][$num],
						'выбор' => $_POST['choose'][$num],
						'обработка' => $_POST['process'][$num],
						'источник' => $_POST['money'][$num]
				);
			}else {
				$updateRow = array(
					'операциярасхода'=>$_POST['operation'][$num],
					'сумма'=>$_POST['sum'][$num],
					'комментарий'=>$_POST['comment'][$num],
					'сотрудник'=>$_POST['staff'][$num]
				);
			}
			$updateRow['подоперация'] = $_POST['suboperation'][$num];
			
			foreach ($entries as $entry) {
				$a = $entry->getValues();
				$findId = $a['номероперации'];
				if ($findId == $num) {
					$entry->update($updateRow);
					break;
				}
			}
		}
		file_put_contents('./files/orders', '');
		header('Location: /crm/index.php?action=order_view&id=' . join(',',$ids));
		exit;
	
	}

}

if ($_GET['action'] == 'order_view' && $_GET['id']) {
	
	$sessionToken = json_decode($_SESSION['token']);
	$serviceRequest = new DefaultServiceRequest($sessionToken->access_token);
	ServiceRequestFactory::setInstance($serviceRequest);

	$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
	$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
	$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co');
	$worksheetFeed = $spreadsheet->getWorksheets();
	$worksheet = $worksheetFeed->getFirst();
	$listFeed = $worksheet->getListFeed();

	$entries = $listFeed->getEntries();
	
	$ids = explode(',', $_GET['id']);
	foreach ($ids as $k=>$v){
		$ids[$k] = trim($v);
	}

	$printUrl = '/crm/index.php?print=1&action=order_view&id=' . join(',', $ids);

	foreach ($entries as $entry) {
		$a = $entry->getValues();
		$orderId = $a['номероперации'];
		if (in_array($orderId, $ids)) {
			$a['id'] = $orderId;
			$orders[] = $a;
		}
	}
}



if (!$_GET['action']) {

	
	if ($_GET['client'] && !$searchIds) {
		$entries = array();
	}else {
		$fo = file_get_contents('./files/orders');
		if (!$fo) {
			$sessionToken = json_decode($_SESSION['token']);
			$serviceRequest = new DefaultServiceRequest($sessionToken->access_token);
			ServiceRequestFactory::setInstance($serviceRequest);

			$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
			$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
			$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co');
			$worksheetFeed = $spreadsheet->getWorksheets();
			$worksheet = $worksheetFeed->getFirst();
			$listFeed = $worksheet->getListFeed();
			$entries = $listFeed->getEntries();
			$tmp = array();
			foreach ($entries  as $entry) {
				$a = $entry->getValues();
				//var_dump($childsBase[442]); die();
				$tmp[] = $a;
			}
			file_put_contents('./files/orders', serialize($tmp));
			$entries = $tmp;
		}else {
			$entries = unserialize($fo);
		}
	}
	//var_dump($entries); die();
	$i = 0;
	$list = array();
	if ($entries) {
		$entries = array_reverse($entries);
	}
	foreach ($entries as $k => $a) {
		//$a = $entry->getValues();
		$a['id'] = $a['номероперации'];
		
		if ($searchIds) {
			if (!in_array($a['id'], $searchIds)) {
				continue;
			}
		}
		
		

		if ($_GET['date1'] || $_GET['date2']) {
			$date = strtotime($a['дата']);
			if ($_GET['date1'] && $_GET['date2']) {
				if ($date>=strtotime($_GET['date1']) && $date<=strtotime($_GET['date2'])) {
				}else {
					continue;
				}
			}elseif ($_GET['date1']) {
				if ($date>=strtotime($_GET['date1'])) {
				}else {
					continue;
				}
			}else {
				if ($date<=strtotime($_GET['date2'])) {
				}else {
					continue;
				}
			}
		}
		$i++;
		$list[] = $a;

		if ($_GET['date1'] || $_GET['date2']) {
		
		}elseif ($i == 1000 && !$searchIds) {
			break;
		}
	}

	

}




function phone($v) {
	$v = str_replace(array('+',')','(', ' '), '', $v);
	return $v;
}

include "views/index.tpl";
