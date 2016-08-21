<h2>Клиенты</h2>

<?php
/*$sessionToken = json_decode($_SESSION['token']);
$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();

$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
$spreadsheet = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1J5zYD2aYwSex3rf9zubJ8zYkf9Dt7Mbyk2Ocpm0rxnw');

$worksheetFeed = $spreadsheet->getWorksheets();

$worksheet = $worksheetFeed->getFirst();
$listFeed = $worksheet->getListFeed();

$entries = $listFeed->getEntries();*/
$entries = array();
foreach ($clientsBase as $a) {
	if (isset($childsBase[$a['id']])) {
		$a['childs'] = $childsBase[$a['id']];
	}
	$entries[] =  $a;
}

if ($_POST['client_name']) {
	$tmp = array();
	$needle = mb_strtolower(trim(urldecode($_POST['client_name'])), 'utf-8');
	
	foreach ($entries as $a) {
		//$a = $rec->getValues();
		$fio =  mb_strtolower(trim($a['фио']), 'utf-8');
		$pos = strpos($fio, $needle);
		if ($pos !== false) {
			$tmp[] = $a;
		}
	}
	//var_dump($tmp); die();
	$entries = $tmp;
}

if ($_POST['cdate1'] || $_POST['cdate2']) {
	$tmp = array();
	foreach ($entries as $a) {
		if (!$a['датарождения']) continue;
		$date = strtotime($a['датарождения']);
		if ($_POST['cdate1'] && $_POST['cdate2']) {
			if ($date>=strtotime($_POST['cdate1']) && $date<=strtotime($_POST['cdate2'])) {
			}else {
				continue;
			}
		}elseif ($_POST['cdate1']) {
			if ($date>=strtotime($_POST['cdate1'])) {
			}else {
				continue;
			}
		}else {
			if ($date<=strtotime($_POST['cdate2'])) {
			}else {
				continue;
			}
		}
		$tmp[] = $a;
	}
	$entries = $tmp;
}

if ($_POST['ddate1'] || $_POST['ddate2']) {
	$tmp = array();
	foreach ($entries as $a) {
		if ($a['childs']) {
			foreach ($a['childs'] as $kk => $aa) {
				if (!$aa['датарождения']) continue;
				$date = strtotime($aa['датарождения']);
				if ($_POST['ddate1'] && $_POST['ddate2']) {
					if ($date>=strtotime($_POST['ddate1']) && $date<=strtotime($_POST['ddate2'])) {
					}else {
						continue;
					}
				}elseif ($_POST['ddate1']) {
					if ($date>=strtotime($_POST['ddate1'])) {
					}else {
						continue;
					}
				}else {
					if ($date<=strtotime($_POST['ddate2'])) {
					}else {
						continue;
					}
				}
				$tmp[] = $a;
				break;
			}
		}
	}
	$entries = $tmp;
}


//$entries = array_reverse($entries);

?>
		
<a href="/crm/index.php?action=new_client" class="btn btn-success">Новый клиент</a> &nbsp;&nbsp;&nbsp;
<br>

<br/>
<form class="form-signin" method="post" action="/crm/index.php?action=clients">
	<input type="text" name="client_name" class="form-control" value="<?=$_POST['client_name']?>" style="width: 30%; float: left;" placeholder="ФИО клиента">
	<div style="clear: both;"></div>
	<br>
	<label for="date1" style="float: left;">Дата рождения клиента ОТ:&nbsp;&nbsp;</label><input id="date1" type="text" name="cdate1" class="form-control date"  value="<?=$_POST['cdate1']?>" style="width: 100px; float: left;">
	
	<label for="date2" style="float: left;">&nbsp;&nbsp;Дата рождения клиента ДО:&nbsp;&nbsp;</label><input id="date2" type="text" name="cdate2" class="form-control date" value="<?=$_POST['cdate2']?>" style="width: 100px; float: left;">
		
	<div style="clear: both;"></div>

	<br>
	<label for="date1" style="float: left;">Дата рождения ребенка ОТ:&nbsp;&nbsp;</label><input id="ddate1" type="text" name="ddate1" class="form-control date"  value="<?=$_POST['ddate1']?>" style="width: 100px; float: left;">
	
	<label for="date2" style="float: left;">&nbsp;&nbsp;Дата рождения ребенка ДО:&nbsp;&nbsp;</label><input id="ddate2" type="text" name="ddate2" class="form-control date" value="<?=$_POST['ddate2']?>" style="width: 100px; float: left;">
	<div style="clear: both;"></div>
	<input type="submit" class="btn btn-warning" value="Искать" style="float: left; margin-left: 10px;" />
	<br>
</form>
<br><br>

<table class="table table-striped">
<tr>
	<th>ИД Клиента</th>
	<th>ФИО</th>
	<th>Дети</th>
	<th>Телефон</th>
	<th>Email</th>
	<th>Дата изменения</th>
	<th>Дата рождения</th>
	<th>Удалить</th>
</tr>
<?php 
foreach ($entries as $a) {
	//$a = $entry->getValues();
?>
	<tr>
		<td><a href="/crm/index.php?action=clients&id=<?php echo $a['id']; ?>"><?php echo $a['id']; ?></a></td>
		<td><a href="/crm/index.php?action=clients&id=<?php echo $a['id']; ?>"><?php echo $a['фио'] ?></a></td>
		<td><?php 
		if ($a['childs']) {
			foreach ($a['childs'] as $k2 => $child) {
				if ($k2 > 0) echo '<br>';
				echo $child['фио'] . ' ';
				echo '[' . $child['пол'] . '] ';
				if ($child['датарождения']) {
					echo '[' . $child['датарождения'] . '] ';
				}
			}
		}?></td>
		<td><?php echo $a['телефон'] ?></td>
		<td><?php echo $a['email'] ?></td>
		<td><?php echo $a['датазаведения'] ?></td>
		<td><?php echo $a['датарождения'] ?></td>
		<td><a href="/crm/index.php?action=delete_client&id=<?php echo $a['id']; ?>" style="color: red;">Удалить</td>
	</tr>
<?php
}
?>
</table>