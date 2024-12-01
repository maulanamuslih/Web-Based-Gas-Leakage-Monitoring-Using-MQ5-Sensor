#include <WiFi.h>
#include <HTTPClient.h>

#define GAS_SENSOR_PIN 34    // 
#define BUZZER_PIN 32        // 
#define SAFE_LIGHT_PIN 25    // 
#define DANGER_LIGHT_PIN 26  // 

// WiFi credentials
const char* ssid = "";       // 
const char* password = "";   // 

int GasLevel = 0;
bool Buzzer = false;
bool Safe_Light = true;
bool Danger_Light = false;

// URL for sending data
String URL = "http://yourIP/Gas_Leak_Project/send.php"; //

// Variables for timing HTTP data transmission
unsigned long previousMillis = 0;  // 
const long interval = 5000;        // 

void setup() {
  Serial.begin(115200);

  pinMode(GAS_SENSOR_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(SAFE_LIGHT_PIN, OUTPUT);
  pinMode(DANGER_LIGHT_PIN, OUTPUT);
  digitalWrite(SAFE_LIGHT_PIN, HIGH); // 

  connectWiFi();  // 
}

void loop() {
  unsigned long currentMillis = millis();  // 

  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;  // 
    sendHTTPData();  // 
  }

  Read_Gas_Sensor();  // 
}

void Read_Gas_Sensor() {
  GasLevel = analogRead(GAS_SENSOR_PIN);  // 

  if (GasLevel > 700) {  // 
    Buzzer = true;
    Safe_Light = false;
    Danger_Light = true;

    digitalWrite(BUZZER_PIN, HIGH);
    digitalWrite(DANGER_LIGHT_PIN, HIGH);
    digitalWrite(SAFE_LIGHT_PIN, LOW);
  } else {
    Buzzer = false;
    Safe_Light = true;
    Danger_Light = false;

    digitalWrite(BUZZER_PIN, LOW);
    digitalWrite(SAFE_LIGHT_PIN, HIGH);
    digitalWrite(DANGER_LIGHT_PIN, LOW);
  }
}

void sendHTTPData() {
  String postData = "GasLevel=" + String(GasLevel) +
                    "&Danger_Light=" + String(Danger_Light) +
                    "&Safe_Light=" + String(Safe_Light) +
                    "&Buzzer=" + String(Buzzer);

  HTTPClient http;
  http.begin(URL);  // 
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);  // 
  String payload = httpCode > 0 ? http.getString() : "[HTTP] POST failed, error: " + http.errorToString(httpCode);

  Serial.printf(
    "IP Address: %s\nGas Level: %d\nHTTP Code: %d\nPayload: %s\nData Sent: %s\n-----------------------------------\n",
    WiFi.localIP().toString().c_str(), GasLevel, httpCode, payload.c_str(), postData.c_str()
  );

  http.end();  // 
}

void connectWiFi() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.printf("\nConnected to WiFi, SSID: %s\nIP Address: %s\n", ssid, WiFi.localIP().toString().c_str());
}
