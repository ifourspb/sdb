<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Vorobushek CRM</title>

    <!-- Bootstrap -->
    <link href="/crm/css/bootstrap.min.css" rel="stylesheet">
    <link href="/crm/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		.print .container{
			margin: 0;
			width: 400px;
		}
		.print {
			font-size: 13px;
		}
		.print .form-control {
			font-size: 13px;
			height: 22px;
			padding:0;
		}
		<?php if ($_GET['print']==1){?>
		br
		{   content: "A" !important;
			display: block !important;
			margin-bottom: 0.15em !important;
		}
		hr {
		  border:none;
		  border-top:1px dotted black;
		  color:#fff;
		  background-color:#fff;
		  height:1px;
		  width:50%;
		}
		<?php } ?>
	</style>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/crm/css/jquery.min.js"></script>

	<link rel="stylesheet" href="/crm/css/jquery-ui.css">
	<script src="/crm/css/jquery-ui.js"></script>
  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/crm/css/bootstrap.min.js"></script>

	<script>
		var plusOp = new Array();
		var minusOp = new Array();
		<?php 
		foreach ($plusOp as $id => $arr)
		{
			echo 'var tmp = {"name": "' . $arr['name'] . '"};';
			echo 'tmp.childs = new Array();';
			if ($arr['childs']){		
				foreach ($arr['childs'] as $k => $name){
					echo 'tmp.childs.push("' . $name . '");';
				}
			}
			echo 'plusOp.push(tmp);';
		}
		?>
		<?php 
		foreach ($minusOp as $id => $arr)
		{
			echo 'var tmp = {"name": "' . $arr['name'] . '"};';
			echo 'tmp.childs = new Array();';
			if ($arr['childs']){		
				foreach ($arr['childs'] as $k => $name){
					echo 'tmp.childs.push("' . $name . '");';
				}
			}
			echo 'minusOp.push(tmp);';
		}
		?>
		
		function newClient() {
			//$("#newclient").attr('src', '/crm/index.php?action=new_client&frame=1');
			$("#newclient").show();
			//window.open(,'','width=980,height=600');
			return false;
		}

		function closeNewClient(name, id){ 
			//$("#newclient").attr('src', '/crm/index.php?action=new_client&frame=1');
			$("#newclient").hide();
			//alert('1');
		}

	</script>
	<script>

	function operationSelect(ops, w, subop) {
		var op = $(w).val();
		var html = '<option value=""></option>';
		for(i=0; i<ops.length; i++){
			if (ops[i].name == op) {
				for (j=0; j<ops[i].childs.length; j++) {
					html += '<option value="' + ops[i].childs[j] + '"';
					if (subop == ops[i].childs[j])
					{
						html += ' selected ';
					}
					html += '>' + ops[i].childs[j] + '</option>';
				}
				if (op == 'Фотосессия' 
					|| op == 'Фото с мероприятия'
					|| op == 'Видео'
					|| op == 'Фото-книга'
					|| op == 'Фото-магнит'
					|| op == 'Паспарту'
					|| op == 'Прочее'
					|| op == 'Холст')
				{
						$(w).parent().children(".date_cont").show();
						$(w).parent().children(".place_cont").show();
				}else {
						//console.log('*');
						$(w).parent().children(".place_cont").hide();
						$(w).parent().children(".date_cont").hide();
				}
			}
		}
		//alert(html);
		$(w).parent().children(".suboperation").html(html);
		
	}

</script>
	<style>
		.ui-datepicker-year {
			color: black;
		}
		.ui-datepicker-month {
			color: black;
		}
	</style>
  </head>
  <body<?php if ($_GET['print']==1){?> class="print"<?php } ?>>
	
  <div class="container">
  <?php if ($_GET['print']!=1 && !$_GET['frame']) {?>
  <a href="/crm/index.php"><img src="/crm/i/logo1.png"></a>
  <?php } ?>

<?php if ($_GET['action'] == 'new_transfer'){ ?>
	<?php include "views/new_transfer.tpl"; ?>
<?php }elseif ($_GET['action'] == 'new_client'){ ?>
	<?php include "views/inc_new_client.tpl"; ?>
<?php }elseif ($_GET['action'] == 'clients' && isset($_GET['id'])){ ?>
	<?php include "views/inc_client.tpl"; ?>
<?php }elseif ($_GET['action'] == 'clients'){ ?>
	<?php include "views/inc_clients.tpl"; ?>
<?php }elseif ($_GET['action'] == 'new_order'){ ?>
	<?php include "views/inc_new_order.tpl"; ?>
<?php }elseif ($_GET['action'] == 'new_minus'){ ?>
	<?php include "views/inc_new_minus.tpl"; ?>
<?php }elseif ($_GET['action'] == 'order_view') {?>
	<?php include "views/inc_order_view.tpl"; ?>
<?php }else {?>
	
		<br/>
		<br/>
		<a href="/crm/index.php?action=new_order&type=plus" class="btn btn-success">Новый заказ</a> &nbsp;&nbsp;&nbsp;<a href="/crm/index.php?action=new_minus" class="btn btn-primary">Расход</a> &nbsp;&nbsp;&nbsp; <a href="/crm/index.php?action=new_transfer" class="btn btn-primary">Трансфер</a> &nbsp;&nbsp;&nbsp; <a href="/crm/index.php?action=clients">Клиенты</a>
		<br/>
		<br/>
	<form class="form-signin" method="get">
		<input type="text" name="view_id" class="form-control" style="width: 30%; float: left;" placeholder="Номера операции через запятую">
		<input type="submit" class="btn btn-warning" value="Искать" style="float: left; margin-left: 10px;" />
		<div style="clear: both;"></div>
	</form>
	<br/>
	<form class="form-signin" method="get">
		<input type="text" name="client" class="form-control" style="width: 30%; float: left;" placeholder="Фамилия клиента" value="<?=$_GET['client']?>">
		<input type="submit" class="btn btn-warning" value="Искать" style="float: left; margin-left: 10px;" />
		<div style="clear: both;"></div>
	</form>
	<br/>
	<form class="form-signin" method="get">
		<label for="date1" style="float: left;">Дата заказа ОТ:&nbsp;&nbsp;</label><input id="date1" type="text" name="date1" class="form-control date"  value="<?=$_GET['date1']?>" style="width: 100px; float: left;">
		<label for="date2" style="float: left;">&nbsp;&nbsp;Дата заказа ДО:&nbsp;&nbsp;</label><input id="date2" type="text" name="date2" class="form-control date" value="<?=$_GET['date2']?>" style="width: 100px; float: left;">
		<input type="submit" class="btn btn-warning" value="Искать" style="margin-left: 10px; float: left;" />
		<div style="clear: both;"></div>
	</form>
	<hr>
	<h2>Последние операции:</h2>
	<a href="https://docs.google.com/spreadsheets/d/1pj9BlNNvTvdoJioNrRbigZZOK7_DTKz1RiLqII7j2co/edit" target="_blank">GOOGLE TABLE</a>
	<br/>
	<br/>
	<style>
		.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
			border: 1px solid #BDB76B;
		}
	</style>
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
		//$list = ($list);
		foreach ($list as $k => $rec) {?>
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
					   echo '<a target="_blank" href="/crm/index.php?action=clients&id=' . $rec['номерклиента'] . '">' . $clientsBase[$rec['номерклиента']]['фио'] . ' | ' . $clientsBase[$rec['номерклиента']]['телефон'] . '</a>';
				}?>
				<td><?php echo $rec['сотрудник']; ?></td>
				<td><?php echo $rec['сумма']?></td>
				<td><?php echo $rec['долг']?></td>
				<td><?php echo $rec['комментарий']?></td>

			</tr>
		<?php } ?>
	</table>

<?php } ?>
    


</div>	
 
  <script>
	var serviceBlock = $("#service_block").clone();
	function addService() {
		var tmp = serviceBlock.prop('outerHTML');
		$("#serv_cont").append( tmp );
	}
	function addChild() {
		var tmp = serviceBlock.prop('outerHTML');
		$("#serv_cont").append( tmp );
		init_date();
	}
</script>
    <script>
	function init_date() {
		   $( ".date" ).datepicker({
			 monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
			'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
			'Октябрь', 'Ноябрь', 'Декабрь'],
			monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель',
			'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
			'Октябрь', 'Ноябрь', 'Декабрь'],
			 dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			 firstDay: 1,
				 changeMonth: true,
				  yearRange: '1940:2016',
					changeYear: true,
				 dateFormat: 'dd.mm.yy'
			});
	}
  $(function() {
	init_date();
	});
  </script>
  </body>
</html>