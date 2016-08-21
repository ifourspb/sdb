<style>
.verticalText {
    -moz-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    writing-mode: tb-rl;
    width: 300px;
    height: 200px;

}
</style>

<?php if ($_GET['print']!=1){?>
		<!--a href="<?php echo $printUrl?>" class="btn btn-lg btn-success" style="margin-left: 100px;">Печать</a-->
<?php } ?>
<br/>
		<br/>
		<a href="/crm/index.php?action=new_order&type=plus" class="btn btn-success">Новый заказ</a> &nbsp;&nbsp;&nbsp;<a href="/crm/index.php?action=new_minus" class="btn btn-primary">Расход</a> &nbsp;&nbsp;&nbsp; <a href="/crm/index.php?action=new_transfer" class="btn btn-primary">Трансфер</a> &nbsp;&nbsp;&nbsp; <a href="/crm/index.php?action=clients">Клиенты</a>

		<br/><br>

<form class="form-signin" method="POST">
<input type="hidden" name="action" value="update_order" />
<?php
foreach ($orders as $order) {?>
<div id="order_<?php echo $order['id']; ?>">
	<?php if ($_GET['print']==1){?>
		<a href="/crm/index.php"><img src="/crm/i/logo1.png"  style="float: left;"></a>
		<span style="float: right;"><b>+7-978-787-60-48</b><br/>https://vk.com/stydia.vorobyshek<br>www.vorobushek.com </span>
		<div style="clear: both;"></div>
		<div>
			<b>Номер заказа:</b> <?php echo $order['id']; ?><br/>
			<b>Дата создания заказа:</b> <?php echo $order['дата']?><br/>
			<?php if ($order['датавыдачи']){?>
			<b>Дата выдачи заказа:</b> <?php echo $order['датавыдачи']?> <br/>
			<?php } ?>
			<b>Сумма:</b> <?php echo $order['сумма']?><br/>
			<b>Сотрудник</b> <?php echo $order['сотрудник']; ?>
			<hr />
		</div>
	<?php }?>
	
	<?php if ($order['операция'] == 'Доход') {?>
		<?php if ($_GET['print']==1){ ?>
			<label for="client_<?php echo $order['id']; ?>" style="float: left;">Клиент:&nbsp;</label>
			<span style="float: left;"><?php echo $order['клиент']?> (<?php echo $order['телефонклиента']?>)</span>
			<b style="float: left;">&nbsp;&nbsp;Номер заказа: </b><span style="float: left;">&nbsp;<?php echo $order['id']?></span>
			<div style="clear: both;"></div>

		<?php } ?>
	<?php } ?>
	
	<?php if ($_GET['print']!=1){ ?>
		<label for="id_<?php echo $order['id']; ?>">Номер <?php if ($_GET['print']==1){ echo 'заказа'; }else{ echo 'операции'; } ?></label>
		<input type="text" name="order[<?php echo $order['id']; ?>]" id="id_<?php echo $order['id']; ?>" class="form-control" readonly value="<?php echo $order['id']?>" />
	<?php } ?>

	<?php if ($_GET['print'] == 1){?> 
		<b style="float: left;">Дата заказа:&nbsp;&nbsp;&nbsp;</b><span style="float: left;"><?php echo $order['отметкавремени']?></span>
		<div style="clear: both;"></div>
	<?php }else{ ?>
	<br>
		<label for="date1_<?php echo $order['id']; ?>">Дата</label>
		<input type="text" id="date1_<?php echo $order['id']; ?>" class="form-control" readonly value="<?php echo $order['отметкавремени']?>" />
		<br>
	<?php }?>

	<?php if ($order['операция'] == 'Доход') {?>
		<input type="hidden" name="type[<?php echo $order['id']?>]" value="plus" >
		<label for="operation_<?php echo $order['id']; ?>">Операция</label>
		<select id="operation_<?php echo $order['id']; ?>" class="form-control" name="operation[<?php echo $order['id']?>]" onchange="operationSelect(plusOp, this);">
			<option value=""></option>
			
			<?php foreach ($plusOp as $d) {?>
			<?php 
			echo '<option value="' . $d['name'] . '"';
			if ($d['name'] == $order['операциядохода']) {
				echo ' selected';
			}
			echo '>' . $d['name'] . '</option>';
			} ?>
		</select>
		<br>

		<label for="suboperation">Под-операция</label>
				<select id="suboperation" class="form-control suboperation" name="suboperation[<?php echo $order['id']?>]">
						
				</select>	
				<br/>
			
				<script>
				 $(document).ready(function () 
{
					operationSelect(plusOp, $("#operation_<?php echo $order['id']; ?>"), '<?php echo $order['подоперация']?>');		
});
				</script>
		
		<div class="place_cont">
			<label for="place_<?php echo $order['id']; ?>">Место хранения на компьютере</label>
			<input type="text" id="place_<?php echo $order['id']; ?>" class="form-control" name="place[<?php echo $order['id']?>]" value="<?php echo $order['местохранения']?>" />
			<br>
		</div>
		
		<?php if ($_GET['print'] == 1) {?>
			<b style="float: left;">Дата готовности:</b><span style="float: left;">&nbsp;<?php echo $order['датаготовности']?></span>
			<b style="float: left; padding-left: 7px;">Дата выдачи:</b><span style="float: left;">&nbsp;<?php echo $order['датаготовности']?></span>
		<?php }else {?>
			<div class="date_cont">
				<label for="dater_<?php echo $order['id']; ?>">Дата готовности</label>
				<input type="text" id="dater_<?php echo $order['id']; ?>" class="form-control date" name="dater[<?php echo $order['id']?>]" value="<?php echo $order['датаготовности']?>" />
				<br>
			</div>
			<div class="date_cont">
				<label for="date_<?php echo $order['id']; ?>">Дата выдачи</label>
				<input type="text" id="date_<?php echo $order['id']; ?>" class="form-control date" name="date[<?php echo $order['id']?>]" value="<?php echo $order['датавыдачи']?>" />
				<br>
			</div>
				<div id="choose_cont" class="place_cont">
					<label for="choose_<?php echo $order['id']; ?>">Выбор</label>
					<select class="form-control place" name="choose[<?php echo $order['id']?>]">
					<option value=""></option>
						<?php foreach ($choose as $c) {?>
							<option value="<?=$c?>"<?php if ($c == $order['выбор']){?> selected<?php } ?>><?=$c?></option>
						<?php } ?>
					</select>
					<br>
				</div>
				<div id="process_cont" class="place_cont">
					<label for="process_<?php echo $order['id']; ?>">Обработка</label>
					<select class="form-control place" name="process[<?php echo $order['id']?>]">
						<option value=""></option>
						<?php foreach ($mastering as $c) {?>
							<option value="<?=$c?>"<?php if ($c == $order['обработка']){?> selected<?php } ?>><?=$c?></option>
						<?php } ?>
					</select>
					<br>
				</div>
		<?php } ?>

		<label for="sum_<?php echo $order['id']; ?>">Сумма</label>
		<input type="number" id="sum_<?php echo $order['id']; ?>" class="form-control" name="sum[<?php echo $order['id']?>]" value="<?php echo $order['сумма']?>" />
		<br>

		<label for="dolg_<?php echo $order['id']; ?>">Долг</label>
		<input type="number" id="dolg_<?php echo $order['id']; ?>" class="form-control" name="dolg[<?php echo $order['id']?>]" value="<?php echo $order['долг']?>" />
		<br>

		<label for="money_<?php echo $order['id']; ?>">Откуда</label>
		<select class="form-control place" name="money[<?php echo $order['id']; ?>]" id="money_<?php echo $order['id']; ?>">
			<?php foreach ($money as $c) {?>
				<option value="<?=$c?>"<?php if ($c == $order['источник']){?> selected<?php } ?>><?=$c?></option>
			<?php } ?>
		</select>
		<br/>

		<label for="comment_<?php echo $order['id']; ?>">Комментарий</label>
		<textarea id="comment_<?php echo $order['id']; ?>" name="comment[<?php echo $order['id']?>]" class="form-control" style="height: 100px;"><?php echo $order['комментарий']?></textarea>
		<br>

		<?php if ($_GET['print']!=1){ ?>
			<label for="client_<?php echo $order['id']; ?>">Клиент</label>
			<?php 
			/*
			<input type="text" class="form-control" id="client_<?php echo $order['id']; ?>" name="client[<?php echo $order['id']?>]" value="<?php echo $order['клиент']?>" />
			*/
			?>
			<select name="client[<?php echo $order['id']; ?>]" class="form-control" id="client_<?php echo $order['id']; ?>">
				<option value=""></option>
				<?php
					foreach ($clientsBase as $client) {
						echo '<option value="' . $client['id'] . '"';
						if ($order['номерклиента'] == $client['id']) {
							echo ' selected';
						}
						echo '>' . $client['фио'] . ' | ' . $client['телефон'] . '</option>';
					}
				?>
			</select>
			<br>
		<?php } ?>
		
		<?php if (false){ ?>
			<label for="phone_<?php echo $order['id']; ?>">Телефон клиента</label>
			<input type="text" class="form-control" id="phone_<?php echo $order['id']; ?>" name="phone[<?php echo $order['id']?>]" value="<?php echo $order['телефонклиента']?>" />
			<br/>
		<?php } ?>

		
		<br/>

		<?php if ($_GET['print'] == 1){ ?>
			<label for="sign_<?php echo $order['id']; ?>">Не возражаю против использования наших фото в качестве рекламы студии</label>
			<input type="text" class="form-control" id="sign_<?php echo $order['id']; ?>" value="" />
			<br/>
		<?php } ?>
		
	<?php }elseif ($order['операция'] == 'Трансфер') {?>

		<label for="operation_<?php echo $order['id']; ?>">Операция</label>
		<select id="operation_<?php echo $order['id']; ?>" class="form-control" name="operation[<?php echo $order['id']?>]">
			<option value=""></option>
			
			<?php foreach ($transferOp as $d) {?>
			<?php 
				echo '<option value="' . $d . '"';
				if ($d == $order['операциярасхода']) {
					echo ' selected';
				}
				echo '>' . $d . '</option>';
			} ?>
		</select>
		<br>
		
		
		<label for="sum_<?php echo $order['id']; ?>">Сумма</label>
		<input type="text" id="sum_<?php echo $order['id']; ?>" class="form-control" name="sum[<?php echo $order['id']?>]" value="<?php echo $order['сумма']?>" />
		<br>

		<label for="comment_<?php echo $order['id']; ?>">Комментарий</label>
		<textarea id="comment_<?php echo $order['id']; ?>" class="form-control" name="comment[<?php echo $order['id']?>]"><?php echo $order['комментарий']?></textarea>
		<br>

	<?php }else{ ?>
		
		
		<label for="operation_<?php echo $order['id']; ?>">Операция</label>
		<select id="operation_<?php echo $order['id']; ?>" class="form-control" name="operation[<?php echo $order['id']?>]" onchange="operationSelect(minusOp, this);">
			<option value=""></option>
			
			<?php foreach ($minusOp as $d) {?>
			<?php 
				echo '<option value="' . $d['name'] . '"';
				if ($d['name'] == $order['операциярасхода']) {
					echo ' selected';
				}
				echo '>' . $d['name'] . '</option>';
			} ?>
		</select>
		<br>

		<label for="suboperation">Под-операция</label>
		<select id="suboperation" class="form-control suboperation" name="suboperation[<?php echo $order['id']?>]">
						
		</select>	
		<br/>

			<script>
				 $(document).ready(function () 
{
					operationSelect(minusOp, $("#operation_<?php echo $order['id']; ?>"), '<?php echo $order['подоперация']?>');		
});
				</script>

		<label for="sum_<?php echo $order['id']; ?>">Сумма</label>
		<input type="text" id="sum_<?php echo $order['id']; ?>" class="form-control" name="sum[<?php echo $order['id']?>]" value="<?php echo $order['сумма']?>" />
		<br>

		<label for="comment_<?php echo $order['id']; ?>">Комментарий</label>
		<textarea id="comment_<?php echo $order['id']; ?>" class="form-control" name="comment[<?php echo $order['id']?>]"><?php echo $order['комментарий']?></textarea>
		<br>
	
	<?php } ?>
		<label for="staff_<?php echo $order['id']; ?>">Сотрудник</label>
		<select id="staff_<?php echo $order['id']; ?>" class="form-control" name="staff[<?php echo $order['id']?>]">
			<option value=""></option>
			<?php foreach ($staffOp as $name) {?>
			<?php 
			echo '<option value="' . $name . '"';
			if ($name == $order['сотрудник']) {
				echo ' selected';
			}
			echo '>' . $name . '</option>';
		} ?>
		</select>
<?php if (count($orders)>1){?>
		<hr>	
<?php } ?>
</div>
<?php } ?>
<br>
<?php if ($_GET['print']!=1){?>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
<?php } ?>
</form>

	  <script>
  $(function() {
    $( ".date" ).datepicker({
 monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
'Октябрь', 'Ноябрь', 'Декабрь'],
 dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
 firstDay: 1,
	 dateFormat: 'dd.mm.yy'
});
});
  </script>