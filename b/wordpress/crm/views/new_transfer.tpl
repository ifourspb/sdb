
<form class="form-signin" method="POST">
		
		<input type="hidden" name="action" value="transfer" />

        <h2 class="form-signin-heading">Новый трансфер</h2>
      
	  <div id="serv_cont">     
			<div id="service_block" style="padding-top: 20px">
			  <label for="operation" >Операция</label>
			
				<select id="operation" class="form-control" name="operation[]">
					<?php foreach ($transferOp as $d) {?>
						<option value="<?php echo $d;?>"><?php echo $d;?></option>
					<?php }?> 
				</select>
				<br>
				
				
				
				<label for="sum">Сумма</label>
				<input type="text" id="sum" class="form-control required" placeholder="" name="sum[]">
				<br/>

				<label for="comment">Комментарий</label>
				<textarea id="comment" class="form-control" name="comment[]"></textarea>
				<br>
			
			</div>
		</div>

		
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