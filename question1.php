<?php
function isValidPhoneNumber($phone_number, $customer_id, $api_key) {
    $api_url = "https://rest-ww.telesign.com/v1/phoneid/$phone_number";
    
    $headers = [
        "Authorization: Basic " . base64_encode("$customer_id:$api_key"),
        "Content-Type: application/x-www-form-urlencoded"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true); // Should be POST method
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code !== 200) {
        return false; // API request failed
    }
    
    $data = json_decode($response, true);
    print_r($data);
    //if (!isset($data['numbering']['phone_type'])) {
    if (!isset($data['phone_type'])) { //phone_type is not under numbering
        return false; // Unexpected API response
    }
    
    //$valid_types = ["FIXED_LINE", "MOBILE", "VALID"];
    //return in_array(strtoupper($data['numbering']['phone_type']), $valid_types);

    //https://developer.telesign.com/enterprise/docs/codes-languages-and-time-zones#phone-type-codes
    $valid_type_codes = [1, 2, 10];
    return in_array($data['phone_type']['code'], $valid_type_codes); //phone_type is not under numbering and better to using number code.
}

// Usage example
$phone_number = "1234567890"; // Replace with actual phone number
$customer_id = "your_customer_id";
$api_key = "your_api_key";
$result = isValidPhoneNumber($phone_number, $customer_id, $api_key);
var_dump($result);