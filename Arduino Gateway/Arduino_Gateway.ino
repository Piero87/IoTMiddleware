#include <SPI.h>
#include <Ethernet.h>
#include <PubSubClient.h>
#include <ArduinoJson.h>

byte mac[]    = {  0x90, 0xA2, 0xDA, 0x0D, 0x1E, 0x97 };

char servername[]="ec2-52-33-1-162.us-west-2.compute.amazonaws.com";

int lastTemperature;
unsigned long lastTime;
int sensorPin = 0;
int ledPin = 7;

void callback(char* topic, byte* payload, unsigned int length) {

  Serial.println(topic);

  String msg = toString(payload, length);
  Serial.println(msg);
  
  StaticJsonBuffer<200> jsonBuffer;
  JsonObject& root = jsonBuffer.parseObject(msg);

  if (root.containsKey("on")) {
    Serial.println("on recevied");
    digitalWrite(ledPin, HIGH);
  } else if (root.containsKey("off")) {
    Serial.println("off recevied");
    digitalWrite(ledPin, LOW);
  }
}

String toString(byte* payload, unsigned int length) {
  int i = 0;
  char buff[length + 1];
  for (i = 0; i < length; i++) {
    buff[i] = payload[i];
  }
  buff[i] = '\0';
  String msg = String(buff);
  return msg;
}

EthernetClient ethClient;
PubSubClient client(servername, 1883, callback, ethClient);

void setup()
{
  Serial.begin(9600);

  pinMode(ledPin, OUTPUT);
  
  if (Ethernet.begin(mac) != 0)
    {
       Serial.println("Ethernet collegato");
       if (client.connect("ArduinoGateway")) {
        
          Serial.println("MQTT connesso");
          lastTemperature=0;
          lastTime=0;
          client.subscribe("/home/light");
       }
    } else {
      Serial.println("Ethernet non collegato");
    }
}

void loop()
{
  int reading = analogRead(sensorPin);
  int temperature = reading * 0.48875;
  if (temperature != lastTemperature) {
    if(millis()>(lastTime+3000)) {

      StaticJsonBuffer<200> jsonBuffer;
      JsonObject& root = jsonBuffer.createObject();
      root["temperature"] = temperature;

      char buffer[256];
      root.printTo(buffer, sizeof(buffer));

      client.publish("/home/sensor/temperature",buffer);
      
      lastTemperature = temperature;
      lastTime = millis();
    }
  }
  client.loop();
}
