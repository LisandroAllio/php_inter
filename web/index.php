<?php

require __DIR__ . '/../vendor/autoload.php';

if (
    isset($_SERVER['HTTP_USER_AGENT']) &&
    strpos($_SERVER['HTTP_USER_AGENT'], 'ELB-HealthChecker') !== false
) {
    // Devolver un 200 OK simple sin procesar nada más
    http_response_code(200);
    echo "OK";
    exit;
}

$lastJoinedUsers = (require "dic/users.php")->getLastJoined();

switch (require "dic/negotiated_format.php") {
    case "text/html":
        (new Views\Layout(
            "Twitter - Newcomers", new Views\Users\Listing($lastJoinedUsers), true
        ))();
        exit;

    case "application/json":
        header("Content-Type: application/json");
        echo json_encode($lastJoinedUsers);
        exit;
}

http_response_code(406);
