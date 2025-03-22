<?php
// WSDL URL
$wsdl = "https://www.w3schools.com/xml/tempconvert.asmx?WSDL";

try {
    // Initialize SOAP client
    $client = new SoapClient($wsdl, [
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'exceptions' => 1,
    ]);

    // Check if parameters are set in the URL
    if (isset($_GET['fahrenheit'])) { 
        //var_dump($_GET['fahrenheit']);die();
        $fahrenheit = $_GET['fahrenheit'];
        $response = $client->FahrenheitToCelsius(['Fahrenheit' => $fahrenheit]);
        $result = [
            'Fahrenheit THIS IS MY RESULT' => $fahrenheit,
            'Celsius THIS IS MY RESULT' => $response->FahrenheitToCelsiusResult
        ];
        header('Content-Type: application/json');
    echo json_encode($result);
        die();
    } elseif (isset($_GET['celsius'])) {
        $celsius = $_GET['celsius'];
        $response = $client->CelsiusToFahrenheit(['Celsius' => $celsius]);
        $result = [
            'Celsius' => $celsius,
            'Fahrenheit' => $response->CelsiusToFahrenheitResult
        ];
        header('Content-Type: application/json');
    echo json_encode($result);
    die();
    } else {
        $result = ['error' => 'Please provide either fahrenheit or celsius in the URL'];
        header('Content-Type: application/json');
    echo json_encode($result);
    }

    // Set JSON response header
    header('Content-Type: application/json');
    echo json_encode($result);

} catch (SoapFault $fault) {
    // Handle SOAP errors
    header('Content-Type: application/json');
    echo json_encode(['error' => $fault->getMessage()]);
}
?>