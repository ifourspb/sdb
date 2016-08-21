<br/>
		<a href="/crm/index.php?action=clients">Клиенты</a> &nbsp;&nbsp;&nbsp;
		<br/><br>

<?php
$client = array();
$childs = array();
foreach ($clientsBase as $a) {
	if ($a['id'] == $_GET['id']) {
		$client = $a;
		$sessionToken = json_decode($_SESSION['token']);
		$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
		$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
		$spreadsheetChild = $spreadsheetFeed->getById('https://spreadsheets.google.com/feeds/spreadsheets/private/full/1goC1TDKiCEptm7UicBXdqpGLAXzp48kchQcRqXd4xtE');
		$worksheetFeedChild = $spreadsheetChild->getWorksheets();
		$worksheetChild = $worksheetFeedChild->getFirst();
		$listFeedChild = $worksheetChild->getListFeed();
		$entriesChild = $listFeedChild->getEntries();
		foreach ($entriesChild as $child) {
			$a2 = $child->getValues();
			if ($a2['parentid'] == $_GET['id']) {
				$childs[] = $a2;
			}
		}
		
		break;
	}
}

$fo = file_get_contents('./files/orders');
$entries = unserialize($fo);
$orders = array();
foreach ($entries as $entry) {
	if ($entry['номерклиента'] == $_GET['id']) {
		$entry['id'] = $entry['номероперации'];
		$orders[] = $entry;
	}
}
$orders = array_reverse($orders);

//var_dump($childs); die();
?>
<form class="form-signin" method="POST">
		
		<input type="hidden" name="action" value="update_client" />
		<input type="hidden" name="id" value="<?=$_GET['id']?>" />

		<?php if ($_GET['frame'] == 1) {?>
			<input type="hidden" name="frame" value="1" />
		<?php } ?>


        	<label for="name">ФИО</label>
				<input type="text" id="name" class="form-control required" placeholder="" name="client[name]" value="<?=$client['фио']?>">
				<br/>

				<label for="phone">Телефон</label>
				<input type="text" id="phone" class="form-control required" placeholder="" name="client[phone]" value="<?=$client['телефон']?>">
				<br/>

				<label for="email">Email</label>
				<input type="text" id="email" class="form-control required" placeholder="" name="client[email]" value="<?=$client['email']?>">
				<br/>

				<label for="bd">Дата изменения</label>
				<input type="text" class="form-control" disabled value="<?=$client['датазаведения']?>">
				<br/>
				
				<label for="bd">Дата рождения</label>
				<input type="text" id="bd" class="form-control required date" placeholder="" name="client[bd]" value="<?=$client['датарождения']?>">
				<br/>

				<label for="where">Откуда узнали</label>
				<select id="where" class="form-control" name="client[where]">
				<option value=""></option>
								
				<?php foreach ($whereOp as $name) {?>
					<?php 
					echo '<option value="' . $name . '"';
					if ($name == $client['откуда']) {
						echo ' selected';
					}
					echo '>' . $name . '</option>';
				} ?>
				</select>
				<br/>

				<label for="comment">Комментарий</label>
				<textarea id="comment" class="form-control" name="client[comment]"><?=$client['комментарий']?></textarea>
				<br>

			<h2>Дети</h2>
			<?php if ($childs) {?>
				<div>
					<?php foreach ($childs as $child) {?>
						<div id="service_block" style="padding-top: 20px">
							<label>Удалить</label>
							<input type="checkbox" name="remove[<?=$child['id']?>]">
							<br/>
							
							<label for="name">ФИО</label>
							<input type="text" class="form-control required" placeholder="" name="child_name[<?=$child['id']?>]" value="<?=$child['фио']?>">
							<br/>
							
							<label for="bd">Дата рождения</label>
							<input type="text" class="form-control required date" placeholder="" name="child_bd[<?=$child['id']?>]"  value="<?=$child['датарождения']?>">
							<br/>
							
							<label>Пол</label>
							<select name="child_sex[<?=$child['id']?>]" class="form-control" style="width: 100px;">
								<option value="М"<?php if ($child['пол']=='М'){?> selected<?php } ?>>М</option>
								<option value="Ж"<?php if ($child['пол']=='Ж'){?> selected<?php } ?>>Ж</option>
							</select>
							<br>

							

							<label for="comment">Комментарий</label>
							<textarea class="form-control" name="child_comment[<?=$child['id']?>]"><?=$child['комментарий']?></textarea>
							<br>			
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<div id="serv_cont">  
				<h3>Добавить</h3>
				<div id="service_block" style="padding-top: 20px">
					<label for="name">ФИО</label>
					<input type="text" class="form-control required" placeholder="" name="child_name_new[]">
					<br/>
					<label for="bd">Дата рождения</label>
					<input type="text" class="form-control required date" placeholder="" name="child_bd_new[]">
					<br/>
					<label>Пол</label>
					<select name="child_sex_new[]" class="form-control" style="width: 100px;">
						<option value="М">М</option>
						<option value="Ж">Ж</option>
					</select>
					<br>
					
					
					<label for="comment">Комментарий</label>
					<textarea class="form-control" name="child_comment_new[]"></textarea>
					<br>			
				</div>
			</div>
		<br/>

		<a href="#" onclick="addChild(); return false;" id="addService">Добавить ребенка</a>
		<br/>
		<br/>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
      </form>
		
		<?php if ($orders) {?>
		<h3>Заказы</h3>
			<table class="table table-bordered table-striped">
			<tr>
				<th>Номер операции</th>
				<th>Дата создания</th>
				<th>Дата выдачи</th>
				<th>Операция</th>
				<th>Клиент</th>
				<th>Сотрудник</th>
				<th>Сумма</th>
				<th>Долг</th>
				<th>Комментарий</th>
			</tr>
		<?php
			foreach ($orders as $k => $rec) {?>
				<?php $url = '/crm/index.php?action=order_view&id=' . $rec['id']; ?>
				<tr<?php if ($rec['операциядохода']){?> style="background-color: #A9F5BC" <?php }else {?>  style="background-color: #F6CECE" <?php } ?>>
					<td><?php echo '<a href="' . $url . '">' . $rec['id'] . '</a>'; ?></td>
					<td><?php echo '<a href="' . $url . '">' . $rec['дата'] . '</a>';?></td>
					<td><?php echo '<a href="' . $url . '">' . $rec['датавыдачи'] . '</a>';?></td>
					<td><?php if ($rec['операциядохода']) {
								echo $rec['операциядохода'];
							   }else {
								echo $rec['операциярасхода'];
							   }?>
						<?php if ($rec['подоперация']) echo '<Br>(' . $rec['подоперация'] . ')'; ?>
					</td>
					<td><?php 
					if ($rec['номерклиента']) {
					   echo $clientsBase[$rec['номерклиента']]['фио'] . ' | ' . $clientsBase[$rec['номерклиента']]['телефон'];
					}?>
					<td><?php echo $rec['сотрудник']; ?></td>
					<td><?php echo $rec['сумма']?></td>
					<td><?php echo $rec['долг']?></td>
					<td><?php echo $rec['комментарий']?></td>

				</tr>
			<?php
			}
			echo '</table>';
		}
		?>

		