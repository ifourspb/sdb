<br/>
		<a href="/crm/index.php?action=clients">Клиенты</a> &nbsp;&nbsp;&nbsp;
		<br>
<form class="form-signin" method="POST">
		
		<input type="hidden" name="action" value="new_client" />
		<?php if ($_GET['frame'] == 1) {?>
			<input type="hidden" name="frame" value="1" />
		<?php } ?>


        <h2 class="form-signin-heading">Новый клиент</h2>
      
	

				<label for="name">ФИО</label>
				<input type="text" id="name" class="form-control required" placeholder="" name="client[name]">
				<br/>

				<label for="phone">Телефон</label>
				<input type="text" id="phone" class="form-control required" placeholder="" name="client[phone]">
				<br/>

				<label for="email">Email</label>
				<input type="text" id="email" class="form-control required" placeholder="" name="client[email]">
				<br/>

				<label for="bd">Дата рождения</label>
				<input type="text" id="bd" class="form-control required date" placeholder="" name="client[bd]">
				<br/>

				<label for="where">Откуда узнали</label>
				<select id="where" class="form-control" name="client[where]">
				<option value=""></option>
								
				<?php foreach ($whereOp as $name) {?>
					<?php 
					echo '<option value="' . $name . '"';
					echo '>' . $name . '</option>';
				} ?>
				</select>
				<br/>


				<label for="comment">Комментарий</label>
				<textarea id="comment" class="form-control" name="client[comment]"></textarea>
				<br>

			<h2>Дети</h2>
			<div id="serv_cont">     
			<div id="service_block" style="padding-top: 20px">
			 	<label for="name">ФИО</label>
				<input type="text" class="form-control required" placeholder="" name="child_name[]">
				<br/>
				<label for="bd">Дата рождения</label>
				<input type="text" class="form-control required date" placeholder="" name="child_bd[]">
				<br/>
				<label>Пол</label>
				<select name="child_sex[]" class="form-control" style="width: 100px;">
					<option value="М">М</option>
					<option value="Ж">Ж</option>
				</select>
				<br>
				
				
				<label for="comment">Комментарий</label>
				<textarea class="form-control" name="child_comment[]"></textarea>
				<br>
			
			</div>
		</div>
		<br/>
		<a href="#" onclick="addChild(); return false;" id="addService">Добавить ребенка</a>
		<br/>
		<br/>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
      </form>