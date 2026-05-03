<?php
$title = 'Items';

ob_start();
?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Items</h1>
            <p class="text-muted mb-0">Listado y búsqueda de items con fetch.</p>
        </div>

        <a href="/AppItems/items/new" class="btn btn-primary">
            + Nuevo item
        </a>
    </div>

    <div id="alertBox"></div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-9">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="form-control" 
                        placeholder="Buscar item por nombre..."
                    >
                </div>

                <div class="col-md-3">
                    <button id="searchBtn" class="btn btn-primary w-100">
                        Buscar
                    </button>
                </div>
            </div>

            <div id="loading" class="text-center mt-3" style="display:none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>
    </div>

    <div id="itemsList"></div>

</div>

<script src="/AppItems/public/js/items.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';