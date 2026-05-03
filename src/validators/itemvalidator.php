<?php

function validateItem(array $data): array {
    $errors = [];

    $name = trim($data['name'] ?? '');
    $qty = trim($data['qty'] ?? '');
    $price = trim($data['price'] ?? '');

    // Normalizar precio (coma → punto)
    $price = str_replace(',', '.', $price);

    // =========================
    // Nombre
    // =========================
    if ($name === '') {
        $errors['name'][] = 'El nombre es obligatorio.';
    } elseif (is_numeric($name)) {
        $errors['name'][] = 'El nombre no puede ser un número.';
    } elseif (strlen($name) < 3) {
        $errors['name'][] = 'Debe tener al menos 3 caracteres.';
    } elseif (!preg_match('/[a-zA-ZáéíóúÁÉÍÓÚñÑ]/', $name)) {
        $errors['name'][] = 'Debe contener al menos una letra.';
    }

    // =========================
    // Cantidad
    // =========================
    if ($qty === '') {
        $errors['qty'][] = 'La cantidad es obligatoria.';
    } elseif (!ctype_digit($qty)) {
        $errors['qty'][] = 'Debe ser un número entero positivo.';
    } elseif ((int)$qty < 0 || (int)$qty > 9999) {
        $errors['qty'][] = 'Debe estar entre 0 y 9999.';
    }

    // =========================
    // Precio
    // =========================
    if ($price === '') {
        $errors['price'][] = 'El precio es obligatorio.';
    } elseif (!is_numeric($price)) {
        $errors['price'][] = 'Debe ser un número válido.';
    } elseif ((float)$price < 0) {
        $errors['price'][] = 'No puede ser negativo.';
    }

    return $errors;
}