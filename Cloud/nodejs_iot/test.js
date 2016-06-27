var awsIot = require('./node_modules/aws-iot-device-sdk');
var mysql_client = require('./node_modules/mysql');

var io = require('./node_modules/socket.io').listen(5000);

io.sockets.on('connection', function (socket) {
	
	console.log('User connected to Socket.io.');
	
	socket.on('publish_key', function (data) {
        console.log('Publishing to '+data.topic+' only Key: '+data.key);
        
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

function publish(topic,data) {
	
	var post_json = JSON.stringify(data)
    device.publish(topic,post_json);
}

var device = awsIot.device({
   keyPath: './0ea2cd7eb6-private.pem.key',
  certPath: './0ea2cd7eb6-certificate.pem.crt',
    caPath: './aws-iot-rootCA.crt',
  clientId: 'ec2_subscriber_mysql',
    region: 'us-west-2' 
});

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

//Connecto to Amazon AWS IoT
device.on('connect', function() {
    console.log('AWS IoT Connected.');
    
    mysql.query('SELECT name FROM topics WHERE `type` = "publish"', function (error, results, fields) {
	    
	    results.forEach(function(row){
			device.subscribe(row['name']);
		});
	});
    
});

device.on('message', function(topic, payload) {
	
	console.log('message', topic, payload.toString());
	

	var obj = JSON.parse(payload);
	
	//Per adesso qui metto anche di tipo 'publish' anche se se aggiungo la cosa scritta qui sotto del caso per esempio di iscrivere il server alle luci bisogna pensarla in maniera diversa
	mysql.query('SELECT T1.id as id_topic, T1.name as topic_name,K1.id as id_key, K1.name as key_name,T2.id as id_topic_result, T2.name as topic_name_result,K2.id as id_key_result, K2.name as key_name_result,R.condition_type, R.condition_value, R.hold_timer, R.key_type_result, R.key_value_result FROM topics as T1, topics as T2, table_keys as K1, table_keys as K2, rules as R WHERE T1.id = R.id_topic AND K1.id = R.id_key AND T2.id = R.id_topic_result AND K2.id = R.id_key_result AND T1.type = "publish" AND T1.name = ?',topic, function (error, results, fields) {
	    
	    results.forEach(function(row){
		    
		    if (row['condition_type'] == 'none') {
			    //Esegui subito la regola
			    var post = {};
				post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
		
				publish(row['topic_name_result'],post);
						
		    } else if (row['condition_type'] == '<') {
			    
			    if (parseFloat(obj[row['key_name']]) < parseFloat(row['condition_value'])) {
				     
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
				
						publish(row['topic_name_result'],post);
				        
				    } else {
					    //Esegui con timer
				    }
			    }
			    
		    } else if (row['condition_type'] == '>') {
			    
			    if (parseFloat(obj[row['key_name']]) > parseFloat(row['condition_value'])) {
				    
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
						
				        publish(row['topic_name_result'],post);
				        
				    } else {
					    //Esegui con timer
				    }
			    }
			    
		    } else if (row['condition_type'] == '=') {
			    
			    if (parseFloat(obj[row['key_name']]) == parseFloat(row['condition_value'])) {
				    
				    if (row['hold_timer'] == 0) {
					    
					    //Esegui subito
					    var post = {};
						post[row['key_name_result']] = row['key_type_result'] == 'none' ? "" : row['key_value_result'];
						
						publish(row['topic_name_result'],post);
				    } else {
					    //Esegui con timer
				    }
			    }
		    }
			
		});
	});
	
   	mysql.query('SELECT K.id,K.name FROM topics as T, table_keys as K WHERE T.type = "publish" AND T.name = ? AND K.id_topic = T.id',topic, function (error, results, fields) {
	   	
	   	//Il dato che viene pubblicato sono sicuro che viene da un topic e non da più topic perchè nell'IoT Manager ho fatto in modo che ci può essere solo un topic con un certo nome di tipo publish
	   	//questo per avere le statistiche devo sapere da chi viene il dato, quindi qui posso vedere semplicemente se esiste una regola per questo topic, perchè so che è univoco, a differenza dei topic di subscribe a cui più attuatori
	   	//o sensori di possono iscrivere per esempio per spegnere più luci insieme, ma non possono arrivare qui, perchè arrivano i topic publish, a meno che non mi iscrivo al topic accendi spegni la luce, in quel caso però bisogna
	   	//pensare a come iscriversi, perchè se creo un regola con un topic di subscribe, mi devo iscrivere anche qui nel server (NON SERVE, LE REGOLE DI PUBLISH LE POSSO GESTORE NEL METODO PUBLISH QUINDI SOPRA SEMPLICE!)
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