<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config/database.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

$path = preg_replace('#^/AppItems(/public)?#', '', $path);
$path = '/' . ltrim((string)$path, '/');

if ($path === '//') {
    $path = '/';
}

// GET / → Dashboard
if ($method === 'GET' && $path === '/') {
    require __DIR__ . '/../src/routes/home.php';
    exit;
}

// GET /health → JSON healthcheck
if ($method === 'GET' && $path === '/health') {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    echo json_encode([
        'status'      => 'ok',
        'timestamp'   => date('Y-m-d H:i:s'),
        'php_version' => phpversion(),
        'server'      => $_SERVER['SERVER_SOFTWARE'] ?? 'Apache'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    exit;
}

// GET /items → Vista principal de items
if ($method === 'GET' && $path === '/items') {
    require __DIR__ . '/../src/views/items.php';
    exit;
}

// GET /items/new → Vista crear item
if ($method === 'GET' && $path === '/items/new') {
    require __DIR__ . '/../src/views/create-item.php';
    exit;
}

// GET /items/edit → Vista editar item
if ($method === 'GET' && $path === '/items/edit') {
    require __DIR__ . '/../src/views/edit-item.php';
    exit;
}

// API /api/items
if (str_starts_with($path, '/api/items')) {
    require __DIR__ . '/../src/routes/api-items.php';
    exit;
}


// 404
header('Content-Type: application/json; charset=utf-8');
http_response_code(404);

echo json_encode([
    'error' => 'Not Found',
    'path'  => $path
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);