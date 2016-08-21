
<form class="form-signin" method="POST">
		
		<input type="hidden" name="action" value="new_order" />
		
        <h2 class="form-signin-heading">Новый заказ</h2>

		<div id="serv_cont">      
			<div id="service_block" style="padding-top: 20px">
			   <label for="operation" >Операция</label>
				<option value=""></option>
				<select id="operation" class="form-control operation" name="operation[]" onchange="operationSelect(plusOp, this);">
					<?php foreach ($plusOp as $op) {?>
						<option value="<?php echo $op['name'];?>"><?php echo $op['name'];?></option>
					<?php }?> 
				</select>
				
				<br>

				<label for="suboperation">Под-операция</label>
				<select id="suboperation" class="form-control suboperation" name="suboperation[]">
						
				</select>	
				<br/>

				<script>
				 $(document).ready(function () 
{
					operationSelect(plusOp, $("#operation"));		
});
				</script>
				
				<div id="place_cont" class="place_cont">
					<label for="place">Место хранения в компьютере</label>
					<select class="form-control place" name="place[]">
						<option value=""></option>
						<?php foreach ($sources as $source) {?>
							<option value="<?=$source?>"><?=$source?></option>
						<?php } ?>
					</select>
					<br>
				</div>
				<div id="choose_cont" class="place_cont">
					<label for="choose">Выбор</label>
					<select class="form-control place" name="choose[]">
						<option value=""></option>
						<?php foreach ($choose as $c) {?>
							<option value="<?=$c?>"><?=$c?></option>
						<?php } ?>
					</select>
					<br>
				</div>
				<div id="process_cont" class="place_cont">
					<label for="process">Обработка</label>
					<select class="form-control place" name="process[]">
						<option value=""></option>
						<?php foreach ($mastering as $c1) {?>
							<option value="<?=$c1?>"><?=$c1?></option>
						<?php } ?>
					</select>
					<br>
				</div>
				<div id="date_ready" class="date_cont">
					<label for="dater">Дата готовности</label>
					<input type="text" id="dater" class="form-control date" placeholder="" name="dater[]">
					<br>
				</div>
				<div id="date_cont" class="date_cont">
					<label for="date">Дата выдачи</label>
					<input type="text" id="date" class="form-control date" placeholder="" name="date[]">
					<br>
				</div>
				
				<label for="sum">Сумма</label>
				<input type="number" min="0" id="sum" class="form-control required" placeholder="" name="sum[]">
				<br>

				<label for="dolg">Долг</label>
				<input type="number" min="0" id="dolg" class="form-control required" placeholder="" name="dolg[]">
				<br>

				<label for="money">Куда деньги</label>
				<select class="form-control place" name="money[]">
					<?php foreach ($money as $c) {?>
						<option value="<?=$c?>"><?=$c?></option>
					<?php } ?>
				</select>
				<br/>

				<label for="comment">Комментарий</label>
				<textarea id="comment" class="form-control" name="comment[]"></textarea>
				<br>
			</div>
		</div>

		<a href="#" onclick="addService(); return false;" class="btn btn-sm btn-success" id="addService">Добавить услугу</a>
		
		<br>
		<br>
			

        <label for="client">Клиент</label>
        <?php /*<input type="text" id="client" class="form-control" name="client" placeholder=""> */ ?>
			<select name="client" class="form-control" id="client">
				<option value=""></option>
				<?php
					foreach ($clientsBase as $client) {
						echo '<option value="' . $client['id'] . '"';
						echo '>' . $client['фио'] . '</option>';
					}
				?>
			</select>
		<br>
		<a href="#" onclick="newClient(); return false;" class="btn btn-sm btn-success" id="newClient">Новый клиент</a>
		<br><br>
		<iframe id="newclient" src="/crm/index.php?action=new_client&frame=1" style="width: 100%; height: 500px; border: 1px green solid; display: none;"></iframe>
		
		<!--label for="phone" >Телефон</label>
        <input type="tel" id="phone" class="form-control" name="phone" placeholder="">
		<br-->


		<!--label for="where" >Откуда узнали</label>
        <select id="where" class="form-control" name="where">
				<option value=""></option>
				<?php foreach ($whereOp as $name) {?>
					<option value="<?php echo $name;?>"><?php echo $name;?></option>
				<?php }?> 
			</select>
		<br-->

		 <label for="staff" >Сотрудник</label>
        <select id="staff" class="form-control" name="staff">
			<option value=""></option>
			<?php foreach ($staffOp as $name) {?>
					<option value="<?php echo $name;?>"><?php echo $name;?></option>
				<?php }?> 
		</select>	
		<br>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
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