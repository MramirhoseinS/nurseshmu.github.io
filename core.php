<?php
define('BOT_TOKEN','6701705119:AAHgXN0_zTTY9nfwLM-SG7hjbjAGmRIs5Hs');
DEFINE('API_URL','https://api.telegram.org/bot'.BOT_TOKEN.'/');

function MessageRequestJson($method, $parameters) {
    if (!$parameters) {
        $parameters = array();
}

    $parameters["method"] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $result = curl_exec($handle);
    return $result;
}

?>