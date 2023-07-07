<?php

require 'vendor/autoload.php'; // Include the Guzzle autoloader

$apiToken = '';
$dealUpdateWebhookUrl = ''; // Replace with your webhook handler URL

$client = new GuzzleHttp\Client();

try {
    $response = $client->post('https://api.pipedrive.com/v1/webhooks', [
        'query' => ['api_token' => $apiToken],
        'json' => [
            'subscription_url' => $dealUpdateWebhookUrl,
            'event_action' => 'updated',
            'event_object' => 'deal',
        ],
    ]);

    $webhookData = json_decode($response->getBody(), true);
    $webhookId = $webhookData['data']['id'];
    echo 'Webhook created with ID: ' . $webhookId;
} catch (GuzzleHttp\Exception\RequestException $e) {
    echo 'Error creating webhook: ' . $e->getMessage();
}
