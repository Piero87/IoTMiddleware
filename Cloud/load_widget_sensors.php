<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	$iot_manager = new IoT_Manager();
	
	$sensors = $iot_manager->getSensors();

	$publish_topic_found = false;
	
	if (count($sensors) != 0) {
		?>
		<h3>Sensors</h3>
		<?php
		foreach ($sensors as $sensor) {
			
			foreach ($sensor->topics as $topic) {
				
				if (strcmp($topic->type, "publish") == 0) {
					
			        foreach ($topic->keys as $key) {
				        
				        $data = $iot_manager->getLastSensorData($key->id);
				        
				        if (is_numeric($data)) {
					        $data = number_format((float)$data, 2, '.', '');
				        }
				        
				        if ($data !== false) {
					        
					        $publish_topic_found = true;
					        ?>
					        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
					            <div class="tile-stats">
					            	<div class="icon"><i class="fa fa-sun-o"></i>
					            	</div>
									<div class="count" id="<?="keyID_".$key->id?>"><?=$data?></div>
									<br>
									<h3><?=$sensor->name." Key: ".$key->name?></h3>
					            </div>
					        </div>
					        <?php
				        }
					}
				}
			}
		}
		
		if ($publish_topic_found === false) {
			?>
			<p>No sensor data found.</p>
			<?php
		}
	}
?>