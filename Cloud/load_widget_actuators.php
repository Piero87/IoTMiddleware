<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	$iot_manager = new IoT_Manager();
	
	$actuators_topic = $iot_manager->getActuatorsWithSingleTopic();
	$multiple_topics = $iot_manager->getMultipleSubscribeTopics();
	
	$btn_color = array("default","primary","success","info","warning","danger","dark");
	$btn_index = 0;
	$index = 0;
	
	if (count($actuators_topic) != 0) {
		
		?>
		<div class="row top_tiles">
		<h3>Single Topic</h3>
		<?php
		foreach ($actuators_topic as $actuator_topic) {
					
			?>
			<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-lightbulb-o"></i>
                  </div>
                  <div class="count"><?=$actuator_topic['actuator_name']?></div>
                  <h3 style="margin-bottom: 10px;"><?=$actuator_topic['topic']->name?></h3>
            <?php
	        foreach ($actuator_topic['topic']->keys as $key) {
		        $index++;
		        
		        if ($actuator_topic['topic']->widget_view == 0) {
	        	?>
	                <button type="button" class="btn btn-<?=$btn_color[$btn_index]?>" style="margin-left: 5px; margin-top: 6px;" onclick="publish_key('<?=$actuator_topic['topic']->name?>','<?=$key->name?>')"><?=$key->name?></button>
				<?php

					if ($btn_index < count($btn_color)-1) {
						$btn_index++;
					} else {
						$btn_index = 0;
					}
					
					if ($index == count($actuator_topic['topic']->keys)) {
						$index = 0;
						$btn_index = 0;
					}
				} else if ($actuator_topic['topic']->widget_view == 1) {
					?>
					<form class="form-horizontal" role="form">
					    <div class="form-group">
					        <label for="inputType" class="col-sm-1 control-label"><?=$key->name?>:</label>
					        <div class="col-sm-4">
					            <input type="text" class="form-control" placeholder="Default Input" id="ValuekeyID_<?=$key->id?>">
					        </div>
					        <div class="col-sm-3">
					            <button type="button" class="btn btn-primary" style="margin-left: 5px;" onclick="publish_key_with_value('<?=$actuator_topic['topic']->name?>','<?=$key->name?>','<?=$key->id?>')">Send</button>
					        </div>
					    </div>
					</form>

					<?php
				}
			}
			?>
				</div>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
	
	if (count($multiple_topics) != 0) {
		
		?>
		<div class="row top_tiles">
		<h3>Multiple Topics</h3>
		<?php
		foreach ($multiple_topics as $topic) {
					
			?>
			<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-lightbulb-o"></i>
                  </div>
                  <div class="count"><?=$topic->name?></div>
            <?php
	        foreach ($topic->keys as $key) {
		        $index++;
		        
		        if ($topic->widget_view == 0) {
	        	?>
	                <button type="button" class="btn btn-<?=$btn_color[$btn_index]?>" style="margin-left: 5px; margin-top: 6px;" onclick="publish_key('<?=$topic->name?>','<?=$key->name?>')"><?=$key->name?></button>
				<?php

					if ($btn_index < count($btn_color)-1) {
						$btn_index++;
					} else {
						$btn_index = 0;
					}
					
					if ($index == count($topic->keys)) {
						$index = 0;
						$btn_index = 0;
					}
				} else if ($topic->widget_view == 1) {
					?>
					<form class="form-horizontal" role="form">
					    <div class="form-group">
					        <label for="inputType" class="col-sm-1 control-label"><?=$key->name?>:</label>
					        <div class="col-sm-4">
					            <input type="text" class="form-control" placeholder="Default Input" id="ValuekeyID_<?=$key->id?>">
					        </div>
					        <div class="col-sm-3">
					            <button type="button" class="btn btn-primary" style="margin-left: 5px;" onclick="publish_key_with_value('<?=$topic->name?>','<?=$key->name?>','<?=$key->id?>')">Send</button>
					        </div>
					    </div>
					</form>

					<?php
				}
			}
			?>
				</div>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
?>