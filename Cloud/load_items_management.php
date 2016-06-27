<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	$iot_manager = new IoT_Manager();
	
	$gateways = $iot_manager->getCompleteGateways();
	
	foreach ($gateways as $gateway)
	{
		?>
		<div class="panel">
            <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" href="#<?='gateway_'.$gateway->name?>" aria-expanded="false" aria-controls="<?='gateway_'.$gateway->name?>">
	            <div class="row">
	            	<h4 class="panel-title col-sm-11 vcenter"><?=$gateway->name?></h4>
					<button type="button" class="btn btn-danger col-sm-1 vcenter" style="width: 50px; float: right;" onclick="show_alert('gateway','<?=$gateway->id?>')"><i class="fa fa-trash-o"></i></button>
	            </div>
            	
            </a>
            <div id="<?='gateway_'.$gateway->name?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            	<div class="panel-body">
	            	<?php
		            	if (count($gateway->sensors) != 0 || count($gateway->actuators) != 0) {
			            	
			            	?>
			            	<table class="table table-striped">
				            	<thead>
		                        	<tr>
										<th>Type</th>
										<th>Name</th>
										<th>Delete Sensor</th>
										<th>Topic</th>
										<th>Topic Type</th>
										<th>Keys</th>
										<th>Delete Topic</th>
		                        	</tr>
		                      	</thead>
		                      	<tbody>
			            	<?php
			            	foreach ($gateway->sensors as $sensor) {  	

				            	if (count($sensor->topics) != 0) {
									
									$label_check = true;
									
					            	foreach ($sensor->topics as $topic) {
						            ?>
						            	<tr>
						            	
						            	<?php
							            	if ($label_check) {
								            	$label_check = false;
								            	?>
								            	<td><b>Sensor</b></td>
								            	<td><b><?=$sensor->name?></b></td>
								            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('sensor_actuator','<?=$sensor->id?>')"><i class="fa fa-trash-o"></i></button></td>
								            	<?php
							            	} else {
								            	?>
								            	<td></td>
								            	<td></td>
								            	<td></td>
								            	<?php
							            	}
							            ?>
										<td><?=$topic->name?></td>
										<td><?= (strcmp($topic->type, 'subscribe') == 0) ? "Subscribe" : "Publish"?></td>
						            	<?php
							            
							            if (count($topic->keys) != 0) {
								            ?>
								            <td>
								            <?php
							            } else {
								            ?>
								            <td></td>
								            <?php
							            }
							            
							            $index = 0;
							            
						            	foreach ($topic->keys as $key) {
							            	$index++;
							            	?>
											<?=$key->name?>
											<?php
											if ($index != count($topic->keys)) {
												?>
												<br>
												<?php
											} else {
												?>
												</td>
												<?php
											}
							            }
							            
							            ?>
							            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('topic','<?=$topic->id?>')"><i class="fa fa-trash-o"></i></button></td>
							            </tr>
							            <?php
						            }
				            	} else {
					            	?>
					            	<tr>
					            	<td><b>Sensor</b></td>
									<td><b><?=$sensor->name?></b></td>
					            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('sensor_actuator','<?=$sensor->id?>')"><i class="fa fa-trash-o"></i></button></td>
					            	<td></td>
					            	<td></td>
					            	</tr>
					            	<?php
				            	}
				            	?>
				            	</tr>
				            	<?php
				            	
				            }
				            
				            foreach ($gateway->actuators as $actuator) {  	

				            	if (count($actuator->topics) != 0) {
									
									$label_check = true;
									
					            	foreach ($actuator->topics as $topic) {
						            ?>
						            	<tr>
						            	<?php
							            	if ($label_check) {
								            	$label_check = false;
								            	?>
								            	<td><b>Actuator</b></td>
								            	<td><b><?=$actuator->name?></b></td>
								            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('sensor_actuator','<?=$actuator->id?>')"><i class="fa fa-trash-o"></i></button></td>
								            	<?php
							            	} else {
								            	?>
								            	<td></td>
								            	<td></td>
								            	<td></td>
								            	<?php
							            	}
							            ?>
										<td><?=$topic->name?></td>
										<td><?= (strcmp($topic->type, 'subscribe') == 0) ? "Subscribe" : "Publish"?></td>
						            	<?php
							            
							            if (count($topic->keys) != 0) {
								            ?>
								            <td>
								            <?php
							            } else {
								            ?>
								            <td></td>
								            <?php
							            }
							            
							            $index = 0;
							            
						            	foreach ($topic->keys as $key) {
							            	$index++;
							            	?>
											<?=$key->name?>
											<?php
											if ($index != count($topic->keys)) {
												?>
												<br>
												<?php
											} else {
												?>
												</td>
												<?php
											}
							            }
							            
							            ?>
							            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('topic','<?=$topic->id?>')"><i class="fa fa-trash-o"></i></button></td>
							            </tr>
							            <?php
						            }
				            	} else {
					            	?>
					            	<tr>
					            	<td><b>Actuator</b></td>
									<td><b><?=$actuator->name?></b></td>
					            	<td><button type="button" class="btn btn-danger" style="margin-left: 5px; margin-top: 6px;" onclick="show_alert('sensor_actuator','<?=$actuator->id?>')"><i class="fa fa-trash-o"></i></button></td>
					            	<td></td>
					            	<td></td>
					            	</tr>
					            	<?php
				            	}
				            	?>
				            	</tr>
				            	<?php
				            	
				            }
				            
				            ?>
		                      	</tbody>
			            	</table>
				            <?php

		            	} else {
			            	?>
			            	<p><strong>Gateway empty.</strong></p>
			            	<?php
		            	}
		            ?>
            	</div>
            </div>
        </div>
		
		<?php
	}
?>