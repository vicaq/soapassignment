<?php
ini_set("soap.wsdl_cache_enabled", "0"); // Disable WSDL caching

// Handle direct WSDL requests
if ($_SERVER['REQUEST_URI'] == "/soap_service.wsdl") {
    header("Content-Type: text/xml");
    readfile("soap_service.wsdl");
    exit;
}

// SOAP Server Logic
class BantuLodgesService {
    public function checkRoomAvailability($roomID) {
        return ($roomID == 101) ? 1 : 0; // Dummy response
    }
}

$options = ['uri' => "http://localhost:1925/"];
$server = new SoapServer("http://localhost:1925/soap_service.wsdl", $options);
$server->setClass('BantuLodgesService');
$server->handle();
?>
