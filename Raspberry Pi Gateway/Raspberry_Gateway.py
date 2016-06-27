#!/usr/bin/python3

#required libraries
import sys                                 
import ssl
import paho.mqtt.client as mqtt
import RPi.GPIO as gpio
import json
from time import sleep

try:

	ledPin = 20
	gpio.setmode(gpio.BCM)
	gpio.setup(ledPin, gpio.OUT)
	gpio.output(ledPin, gpio.LOW)
	
	def on_connect(client, userdata, flags, rc):
	    print("Connected with result code "+str(rc))
	    client.subscribe("topic/led_switch",1)
	    client.subscribe("topic/led_red_switch",1)
	    
	def on_message(client, userdata, msg):
	    
	    json_data = msg.payload.decode('utf-8')
	    
	    print("Message received: "+json_data)
	    
	    parsed_json = json.loads(json_data)
	    
	    if "on" in parsed_json:
	    	gpio.output(ledPin, gpio.HIGH)
	    elif "off" in parsed_json:
	    	gpio.output(ledPin, gpio.LOW)
	

	def on_subscribe(mqttc, obj, mid, granted_qos):
	    print("Subscribed: "+str(mid)+" "+str(granted_qos)+"data"+str(obj))
	            

	mqttc = mqtt.Client(client_id="RaspberryPi_Led_Red", clean_session=True)
	
	mqttc.on_connect = on_connect
	mqttc.on_message = on_message
	mqttc.on_subscribe = on_subscribe

	mqttc.connect("ec2-52-33-1-162.us-west-2.compute.amazonaws.com", port=1883)
	
	mqttc.loop_forever()

except KeyboardInterrupt:
    pass
finally:
    gpio.cleanup()