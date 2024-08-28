<?php

try {
    require_once __DIR__ . '/../bootstrap/bootstrap.php';
}catch (\Slim\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found'], JSON_UNESCAPED_UNICODE);
}catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error'], JSON_UNESCAPED_UNICODE);
}
