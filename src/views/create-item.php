<?php
$title = 'Nuevo item';

ob_start();
?>

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="card-title mb-1">Crear nuevo item</h1>
                    <p class="text-muted mb-4">Completá los datos para registrar un nuevo item.</p>

                    <div id="alertBox"></div>

                    <form id="createItemForm">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                class="form-control"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="qty" class="form-label">Cantidad</label>
                            <input 
                                type="number" 
                                id="qty"
                                name="qty" 
                                class="form-control"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label">Precio</label>
                            <input 
                                type="text" 
                                id="price"
                                name="price" 
                                class="form-control"
                            >
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                Guardar
                            </button>

                            <a href="/AppItems/items" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/AppItems/public/js/create-item.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';