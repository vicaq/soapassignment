<?php
// Define the SOAP endpoint
$url = "https://www.w3schools.com/xml/tempconvert.asmx";

// Fahrenheit value from user input
$fahrenheit = $_GET['fahrenheit'];
// var_dump($fahrenheit);die();
// $fahrenheit = isset($_GET['fahrenheit']) ? $_GET['fahrenheit'] : '100';
// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: text/xml; charset=utf-8",
    "SOAPAction: \"https://www.w3schools.com/xml/FahrenheitToCelsius\""
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, createSoapRequest($fahrenheit));

// Execute request and get response
$response = curl_exec($ch);
// var_dump($response);die();
// Check for errors
if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
} else {
    // Extract XML response
    $xml = new SimpleXMLElement($response);
    var_dump($xml);die();
    $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
    $result = $xml->xpath("//FahrenheitToCelsiusResult");
var_dump($result);die();
    // Display the result
    header("Content-Type: application/json");
    echo json_encode([
        "Fahrenheit" => $fahrenheit,
        // "Celsius" => (string) $result[0]
    ]);
}

// Close cURL session
curl_close($ch);
// Define the SOAP request message
function createSoapRequest($fahrenheit)
{
    return <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xmlns:xsd="http://www.w3.org/2001/XMLSchema"
               xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <FahrenheitToCelsius xmlns="https://www.w3schools.com/xml/">
      <Fahrenheit>{$fahrenheit}</Fahrenheit>
    </FahrenheitToCelsius>
  </soap:Body>
</soap:Envelope>
XML;
}


?>