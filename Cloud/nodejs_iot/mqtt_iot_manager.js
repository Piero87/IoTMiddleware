var mysql_client = require('./node_modules/mysql');
var mqtt    = require('mqtt');
var mqtt_client  = mqtt.connect('mqtt://localhost:1883');
var Worker = require('./node_modules/webworker-threads').Worker;

var timers = {};

var mysql = mysql_client.createConnection({
  host     : 'localhost',
  user     : 'piero',
  password : 'pierino87',
  database : 'iot_tesi'
});

//Connect to database
mysql.connect(function(err) {
  if (err) {
    console.log('Error Connecting MySQL: ' + err);
    return;
  } else {
	  console.log("MySQL Connected.");
  }
  
});

mqtt_client.on('connect', function() {
    console.log('MQTT Connected.');
    
    mysql.query('SELECT name FROM topics WHERE `type` = "publish"', function (error, results, fields) {
	    
	    results.forEach(function(row){
			mqtt_client.subscribe(row['name']);
		});
	});
    
});

var io = require('./node_modules/socket.io').listen(5000);

io.sockets.on('connection', function (socket) {
	
	console.log('User connected to Socket.io.');
	
	socket.on('publish_key', function (data) {
		var post = {};
		post[data.key] = "";
		publish(data.topic,post);
    });
    
    socket.on('publish_key_with_value', function (data) {
        console.log('Publishing to '+data.topic+' with Key: '+data.key+' and Value: '+data.key_val);
        
		var post = {};
		post[data.key] = data.key_val;

        publish(data.topic,post);
    });
    
});

function check_condition_rule(obj, row) {
	
	if (row['condition_type'] == 'none') {
	    //Esegui subito la regola
	    var post = {};
		post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];

		publish(row['topic_name_result'],post);
				
    } else {

	    var value_to_check = 0;
	    
	    if (row['gps_checked'] == 0) {
		    value_to_check = parseFloat(obj[row['key_name']]);
	    } else {
		    value_to_check = haversineDistance(row['gps_value'].split(";"), obj[row['key_name']].split(";"));
	    }
	    
		if (row['condition_type'] == '<') {
		    
		    if (value_to_check < parseFloat(row['condition_value'])) {
			    
			    if (row['enabled'] == 1) {
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
				
						publish(row['topic_name_result'],post);
						enableDisableRule(0,row['id_rule']);
				        
				    } else {
					    //Esegui con timer, se non esiste il worker crearlo
					    addTimerRule (obj,row);
				    }
			    }
			    
			    
		    } else {
			    
			    enableDisableRule(1,row['id_rule']);
			    
			    if (row['hold_timer'] != 0) {
				    
				    //Eliminare worker se esiste, perchè la condizione non è più soddisfatta
				    deleteTimerRule (obj,row);
				}
		    }
		    
	    } else if (row['condition_type'] == '>') {
		    
		    if (value_to_check > parseFloat(row['condition_value'])) {
			    
			    if (row['enabled'] == 1) {
				    
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
						
				        publish(row['topic_name_result'],post);
				        enableDisableRule(0,row['id_rule']);
				        
				    } else {
					    //Esegui con timer
					    addTimerRule (obj,row);
				    }
			    }
		    } else {
			    
			    enableDisableRule(1,row['id_rule']);
			    
			    if (row['hold_timer'] != 0) {
				    
				    //Eliminare worker se esiste, perchè la condizione non è più soddisfatta
				    deleteTimerRule (obj,row);
				}
		    }
		    
	    } else if (row['condition_type'] == '=') {
		    
		    if (value_to_check == parseFloat(row['condition_value'])) {
			    
			    if (row['enabled'] == 1) {
				    
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
						
						publish(row['topic_name_result'],post);
						enableDisableRule(0,row['id_rule']);
				    } else {
					    //Esegui con timer
					    addTimerRule (obj,row);
				    }
			    }
		    } else {
			    
			    enableDisableRule(1,row['id_rule']);
			    
			    if (row['hold_timer'] != 0) {
				    
				    //Eliminare worker se esiste, perchè la condizione non è più soddisfatta
				    deleteTimerRule (obj,row);
				}
		    }
	    }
	}
}

function enableDisableRule(enable,id_rule) {
		
	var query = mysql.query('UPDATE rules SET enabled = ? WHERE id = ?', [enable,id_rule], function(err, result) {
		
	});
}

function haversineDistance(coords1, coords2) {
  function toRad(x) {
    return x * Math.PI / 180;
  }

  var lat1 = coords1[0];
  var lon1 = coords1[1];

  var lat2 = coords2[0];
  var lon2 = coords2[1];

  var R = 6371; // km

  var x1 = lat2 - lat1;
  var dLat = toRad(x1);
  var x2 = lon2 - lon1;
  var dLon = toRad(x2)
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c;

  console.log("Distanza calcolata: "+d*1000);
  //In Meter
  return d*1000;
}

function addTimerRule (obj,row) {
	
	if (!(row['id_rule'] in timers)) {
				    
	    console.log("Creo regola timer");
	    
	    timers[row['id_rule']] = setTimeout(function(){
			console.log('regola eseguita');
			var post = {};
			post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
				
			publish(row['topic_name_result'],post);
			enableDisableRule(0,row['id_rule']);
			
			delete timers[row['id_rule']];
			
		}, row['hold_timer'] * 1000);			    
	}
}

function deleteTimerRule (obj,row) {
	
	if (row['id_rule'] in timers) {
	    console.log("Worker eliminato");
	    clearTimeout(timers[row['id_rule']]);
	    delete timers[row['id_rule']];
    }
}

function publish(topic,data) {
	
	console.log('Publishing to '+topic+' only Key: '+data);
	
	mysql.query('SELECT T1.id as id_topic, T1.name as topic_name,K1.id as id_key, K1.name as key_name,T2.id as id_topic_result, T2.name as topic_name_result,K2.id as id_key_result, K2.name as key_name_result,R.condition_type, R.condition_value, R.hold_timer, R.key_type_result, R.key_value_result, R.gps_checked, R.gps_value, R.enabled FROM topics as T1, topics as T2, table_keys as K1, table_keys as K2, rules as R WHERE T1.id = R.id_topic AND K1.id = R.id_key AND T2.id = R.id_topic_result AND K2.id = R.id_key_result AND T1.type = "subscribe" AND T1.name = ?',topic, function (error, results, fields) {
    
    	results.forEach(function(row){
	    	
	    	check_condition_rule(data, row);
	    });
	    
	});
		
	var post_json = JSON.stringify(data)
    mqtt_client.publish(topic,post_json);
}


mqtt_client.on('message', function(topic, payload) {
	
	console.log('message', topic, payload.toString());
	

	var obj = JSON.parse(payload);
	
	//Qui arrivano i topic di tipo publish
	mysql.query('SELECT T1.id as id_topic, T1.name as topic_name,K1.id as id_key, K1.name as key_name,T2.id as id_topic_result, T2.name as topic_name_result,K2.id as id_key_result, K2.name as key_name_result, R.id as id_rule, R.condition_type, R.condition_value, R.hold_timer, R.key_type_result, R.key_value_result, R.gps_checked, R.gps_value, R.enabled FROM topics as T1, topics as T2, table_keys as K1, table_keys as K2, rules as R WHERE T1.id = R.id_topic AND K1.id = R.id_key AND T2.id = R.id_topic_result AND K2.id = R.id_key_result AND T1.type = "publish" AND T1.name = ?',topic, function (error, results, fields) {
	    
	    results.forEach(function(row){
		    
		    check_condition_rule(obj, row);
			
		});
	});
	
   	mysql.query('SELECT K.id,K.name FROM topics as T, table_keys as K WHERE T.type = "publish" AND T.name = ? AND K.id_topic = T.id',topic, function (error, results, fields) {
	   	
	   	results.forEach(function(row){
			
			if (row['name'] in obj) {
				
				var post  = {id_key: row['id'], value: obj[row['name']]};
		
				var query = mysql.query('INSERT INTO sensors_actuators_data SET ?', post, function(err, result) {
					
					
				});
			}
		});
	    
	}); 
    
//Non lo uso perchè deve rimanere sempre aperta
//mysql.end();
});