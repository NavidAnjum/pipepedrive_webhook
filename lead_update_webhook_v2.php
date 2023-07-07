<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$apiToken = 'aa6a108d428b6a82d5625953f86205e054527d0b';
$leadUpdateWebhookUrl = 'https://javascriptphp.com/webhook2/lead.php';

$client = new Client();

try {
    $response = $client->post('https://api.pipedrive.com/v1/webhooks', [
        'query' => ['api_token' => $apiToken],
        'json' => [
            'subscription_url' => $leadUpdateWebhookUrl,
            'event_action' => 'change',
            'event_object' => 'lead',
            'version' => '2.0',
        ],
    ]);

    $webhookData = json_decode($response->getBody(), true);
    $webhookId = $webhookData['data']['id'];
    echo 'Webhook created with ID: ' . $webhookId;
} catch (RequestException $e) {
    if ($e->hasResponse()) {
        $statusCode = $e->getResponse()->getStatusCode();
        $responseBody = $e->getResponse()->getBody()->getContents();
        echo 'Error creating webhook. Status Code: ' . $statusCode . ', Response: ' . $responseBody;
    } else {
        echo 'Error creating webhook: ' . $e->getMessage();
    }
}