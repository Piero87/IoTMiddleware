<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	$iot_manager = new IoT_Manager();
	
	$rules = $iot_manager->get_rules();
	
	foreach ($rules as $rule)
	{
		?>
		<div style="background-color: white; margin-bottom: 10px; padding: 10px 30px 10px 30px;">
			<div class="row">
				<h3>Rule #<?=$rule->id?></h3>
			</div>
			<div class="row">
				<table class="table">
	            	<thead>
	                	<tr>
							<th>Topic</th>
							<th>Key</th>
							<th>Condition</th>
							<th>Condition Value</th>
							<th>Hold Timer</th>
							<th>GPS Checked</th>
							<th>GPS Position</th>
	                	</tr>
	            	</thead>
					<tbody>
						<tr>
							<td><?=$rule->topic_name?></td>
							<td><?=$rule->key_name?></td>
							<td><?=$rule->condition_type?></td>
							<td><?=$rule->condition_value?></td>
							<td><?=$rule->hold_timer?></td>
							<td><?=$rule->gps_checked == 0 ? 'No' : 'Yes'?></td>
							<td><?=$rule->gps_value == '' ? '-' : $rule->gps_value?></td>
						</tr>
	            	</tbody>
				</table>
			</div>
			<div class="row">
				<i class="fa fa-arrow-down col-sm-12 col-xs-12" style="font-size: 35px !important; text-align: center; margin-bottom: 20px;"></i>
			</div>
			<div class="row">
				<table class="table">
	            	<thead>
	                	<tr>
							<th>Topic</th>
							<th>Key</th>
							<th>Key Type</th>
							<th>Key Value</th>
	                	</tr>
	            	</thead>
					<tbody>
						<tr>
							<td><?=$rule->topic_name_result?></td>
							<td><?=$rule->key_name_result?></td>
							<td><?=$rule->key_type_result?></td>
							<td><?=$rule->key_value_result?></td>
						</tr>
	            	</tbody>
				</table>
			</div>
			<div class="row">
				<button type="button" class="btn btn-danger col-sm-1" style="width: 50px; float: right;" onclick="show_alert('rule','<?=$rule->id?>')"><i class="fa fa-trash-o"></i></button>
			</div>
		</div>
		<?php
	}