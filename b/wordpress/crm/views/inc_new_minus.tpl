
<form class="form-signin" method="POST">
		
		<input type="hidden" name="action" value="minus" />

        <h2 class="form-signin-heading">Новое списание</h2>
      
	  <div id="serv_cont">     
			<div id="service_block" style="padding-top: 20px">
			  <label for="operation" >Операция</label>
			
				<select id="operation" class="form-control" name="operation[]" onchange="operationSelect(minusOp, this);">
					<option value=""></option>
					<?php foreach ($minusOp as $d) {?>
						<option value="<?php echo $d['name'];?>"><?php echo $d['name'];?></option>
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
					operationSelect(minusOp, $("#operation"));		
});
				</script>
				

				<label for="sum">Сумма</label>
				<input type="text" id="sum" class="form-control required" placeholder="" name="sum[]">
				<br/>

				<label for="money">Откуда деньги</label>
				<select class="form-control place" name="money[]">
					<option value=""></option>
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

		<a href="#" onclick="addService(); return false;" id="addService">Добавить расход</a>
		
		<br>
		<br>
			

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