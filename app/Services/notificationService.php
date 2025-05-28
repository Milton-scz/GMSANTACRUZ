<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$response = $client->request('POST', 'https://waapi.app/api/v1/instances/70360/client/action/send-message', [
  'body' => '{"chatId":"59163526464@c.us","message":"hola"}',
  'headers' => [
    'accept' => 'application/json',
    'authorization' => 'Bearer CevSfvCD6aVpcde6dYSluLcsqCTlb6lNeSVfGFgR999b507f',
    'content-type' => 'application/json',
  ],
]);

echo $response->getBody();
