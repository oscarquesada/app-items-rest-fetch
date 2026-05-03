<?php
$title = $title ?? 'Práctica ORM';
$content = $content ?? '';
$scripts = $scripts ?? '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="/AppItems/public/css/styles.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand text-white" href="/AppItems/">App Items</a>

        <div class="navbar-nav me-auto">
            <a class="nav-link" href="/AppItems/">Inicio</a>
            <a class="nav-link" href="/AppItems/items">Items</a>
            <a class="nav-link" href="/AppItems/items/new">Nuevo item</a>
            <a class="nav-link" href="/AppItems/health">Health</a>
        </div>

        <button id="themeToggle" class="theme-toggle" type="button">
            🌙 Modo oscuro
        </button>
    </div>
</nav>

<main class="container">
    <?= $content ?>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS del tema -->
<script src="/AppItems/public/js/theme.js"></script>

<!-- Scripts específicos de cada vista -->
<?= $scripts ?>

<footer class="text-center mt-5 mb-3">
    <small class="text-muted">
        © <?= date('Y') ?> · 
        <a href="https://github.com/oscarquesada" target="_blank" style="text-decoration: none;">
            Oscar Quesada
        </a>
    </small>
</footer>

</body>
</html>