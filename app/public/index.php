<?php

try {
    require_once __DIR__ . '/../bootstrap/bootstrap.php';
}catch (\Slim\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Route not found'], JSON_UNESCAPED_UNICODE);
}catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Internal crucial server error'], JSON_UNESCAPED_UNICODE);
}
