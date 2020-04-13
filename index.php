<?php

$payload = json_decode(file_get_contents('php://input'), true);
if(is_array($payload) && array_key_exists('challenge', $payload)) {
    echo $payload['challenge'];
}

if ($payload['event']['type'] === 'app_mention') {
    $data = [
        'text' => 'Yes?',
        'channel' => 'random'
    ];

    if (strpos($payload['event']['text'], 'days left') !== false) {
        $date1 = new DateTime('');
        $date2 = new DateTime('2019-11-08');
        $diff = $date2->diff($date1)->format('%a');
        $days = intval($diff);
        $data['text'] = "$days days left and Kestutis will drink coffee again :)";
    }

    $accessToken = 'generated-access-token-by slack';
    $curl = curl_init('https://slack.com/api/chat.postMessage');

    $header = array();
    $header[] = 'Content-type: application/json';
    $header[] = 'Authorization: Bearer '.$accessToken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    $rest = curl_exec($curl);

    curl_close($curl);

    return;
}

echo 'Access forbidden';