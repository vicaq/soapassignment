<?php
ini_set("soap.wsdl_cache_enabled", "0"); // Disable WSDL cache

class BantuLodgesService {
    public function checkRoomAvailability($roomID) {
        // Dummy logic for room availability (1 = Booked, 0 = Free)
        $rooms = [
            101 => 1, // Room 101 is booked
            102 => 0, // Room 102 is free
            103 => 1  // Room 103 is booked
        ];
        return isset($rooms[$roomID]) ? $rooms[$roomID] : -1; // -1 means Room ID not found
    }

    public function bookRoom($clientID, $roomID, $checkInDate, $checkOutDate) {
        // Dummy confirmation response
        return "Room $roomID successfully booked for Client $clientID from $checkInDate to $checkOutDate.";
    }
}

// Create a SOAP Server
$wsdl = "http://localhost:1925"; // WSDL file location
$options = ['uri' => "http://localhost:1925/soap_server.php"];
$server = new SoapServer($wsdl, $options);
$server->setClass('BantuLodgesService');
$server->handle();
?>
