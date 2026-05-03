<?php
// src/routes/api-items.php

require_once __DIR__ . '/../models/Item.php';

use App\Models\Item;

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function jsonResponse(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function getJsonBody(): array
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        jsonResponse([
            'ok' => false,
            'error' => 'JSON inválido'
        ], 400);
    }

    return $data;
}

function validateApiItem(array $data): array
{
    $errors = [];

    $name = trim($data['name'] ?? '');
    $qty = $data['qty'] ?? null;
    $price = $data['price'] ?? null;

    if ($name === '') {
        $errors[] = 'El nombre es obligatorio';
    }

    if (!is_numeric($qty) || (int)$qty < 0 || (int)$qty > 9999) {
        $errors[] = 'La cantidad debe estar entre 0 y 9999';
    }

    if (is_string($price)) {
        $price = str_replace(',', '.', $price);
    }

    if (!is_numeric($price) || (float)$price < 0) {
        $errors[] = 'El precio debe ser válido';
    }

    return $errors;
}

// GET /api/items
// GET /api/items?id=1
// GET /api/items?q=nombre
if ($method === 'GET') {
    try {
        $id = $_GET['id'] ?? null;
        $q = trim($_GET['q'] ?? '');

        if ($id) {
            $item = Item::find($id);

            if (!$item) {
                jsonResponse([
                    'ok' => false,
                    'error' => 'Item no encontrado'
                ], 404);
            }

            jsonResponse([
                'ok' => true,
                'data' => $item
            ], 200);
        }

        if ($q !== '') {
            $items = Item::where('name', 'LIKE', '%' . $q . '%')->get();

            jsonResponse([
                'ok' => true,
                'data' => $items
            ], 200);
        }

        $items = Item::all();

        jsonResponse([
            'ok' => true,
            'data' => $items
        ], 200);

    } catch (\Throwable $e) {
        jsonResponse([
            'ok' => false,
            'error' => 'Error al traer los items'
        ], 500);
    }
}

// POST /api/items
if ($method === 'POST') {
    try {
        $data = getJsonBody();
        $errors = validateApiItem($data);

        if (!empty($errors)) {
            jsonResponse([
                'ok' => false,
                'errors' => $errors
            ], 400);
        }

        $price = is_string($data['price'])
            ? str_replace(',', '.', $data['price'])
            : $data['price'];

        $item = Item::create([
            'name'  => trim($data['name']),
            'qty'   => (int) $data['qty'],
            'price' => (float) $price
        ]);

        jsonResponse([
            'ok' => true,
            'message' => 'Item creado correctamente',
            'data' => $item
        ], 201);

    } catch (\Throwable $e) {
        jsonResponse([
            'ok' => false,
            'error' => 'Error al guardar el item'
        ], 500);
    }
}

// PUT /api/items?id=1
if ($method === 'PUT') {
    try {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            jsonResponse([
                'ok' => false,
                'error' => 'ID es requerido'
            ], 400);
        }

        $item = Item::find($id);

        if (!$item) {
            jsonResponse([
                'ok' => false,
                'error' => 'Item no encontrado'
            ], 404);
        }

        $data = getJsonBody();
        $errors = validateApiItem($data);

        if (!empty($errors)) {
            jsonResponse([
                'ok' => false,
                'errors' => $errors
            ], 400);
        }

        $price = is_string($data['price'])
            ? str_replace(',', '.', $data['price'])
            : $data['price'];

        $item->update([
            'name'  => trim($data['name']),
            'qty'   => (int) $data['qty'],
            'price' => (float) $price
        ]);

        jsonResponse([
            'ok' => true,
            'message' => 'Item actualizado correctamente',
            'data' => $item
        ], 200);

    } catch (\Throwable $e) {
        jsonResponse([
            'ok' => false,
            'error' => 'Error al actualizar el item'
        ], 500);
    }
}

// DELETE /api/items?id=1
if ($method === 'DELETE') {
    try {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            jsonResponse([
                'ok' => false,
                'error' => 'ID es requerido'
            ], 400);
        }

        $item = Item::find($id);

        if (!$item) {
            jsonResponse([
                'ok' => false,
                'error' => 'Item no encontrado'
            ], 404);
        }

        $item->delete();

        jsonResponse([
            'ok' => true,
            'message' => 'Item eliminado correctamente'
        ], 200);

    } catch (\Throwable $e) {
        jsonResponse([
            'ok' => false,
            'error' => 'Error al eliminar el item'
        ], 500);
    }
}

jsonResponse([
    'ok' => false,
    'error' => 'Método no permitido'
], 405);