<?php
// Define the WSDL URL
$wsdl = "https://www.w3schools.com/xml/tempconvert.asmx?WSDL";



// Check if parameters are set in the URL
if (isset($_GET['fahrenheit'])) {
    $fahrenheit = $_GET['fahrenheit'];
    
    // SOAP request XML
    $xmlRequest = "<?xml version='1.0' encoding='utf-8'?>
    <soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>
        <soap:Body>
            <FahrenheitToCelsius xmlns='https://www.w3schools.com/xml/'>
                <Fahrenheit>$fahrenheit</Fahrenheit>
            </FahrenheitToCelsius>
        </soap:Body>
    </soap:Envelope>";

    $response = sendSoapRequest($xmlRequest, "FahrenheitToCelsius");
    header('Content-Type: text/xml');
    echo $response;

} elseif (isset($_GET['celsius'])) {
    $celsius = $_GET['celsius'];
    
    // SOAP request XML
    $xmlRequest = "<?xml version='1.0' encoding='utf-8'?>
    <soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>
        <soap:Body>
            <CelsiusToFahrenheit xmlns='https://www.w3schools.com/xml/'>
                <Celsius>$celsius</Celsius>
            </CelsiusToFahrenheit>
        </soap:Body>
    </soap:Envelope>";

    $response = sendSoapRequest($xmlRequest, "CelsiusToFahrenheit");
    header('Content-Type: text/xml');
    echo $response;

} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Please provide either fahrenheit or celsius in the URL']);
}
// Function to send SOAP request
function sendSoapRequest($xmlRequest, $action) {
    global $wsdl;
    
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $wsdl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: text/xml; charset=utf-8",
        "SOAPAction: \"https://www.w3schools.com/xml/" . $action . "\""
    ]);
    

    // Execute cURL request
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}
?>
