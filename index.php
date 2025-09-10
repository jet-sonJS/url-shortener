<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$destinationUrl = $data['destination'];

$payload = json_encode([
  "destination" => $destinationUrl
]);

$ch = curl_init('https://api.rebrandly.com/v1/links');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'apikey: d4493bbba3c942baad65f39d4f5d0b70'
]);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$shortUrl = $responseData['shortUrl'] ?? 'No short URL found';

echo json_encode(['shortUrl' => $shortUrl]);

?>
