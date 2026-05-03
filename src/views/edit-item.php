<?php
$title = 'Editar item';

ob_start();
?>

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="card-title mb-1">Editar item</h1>
                    <p class="text-muted mb-4">Modificá los datos del item seleccionado.</p>

                    <div id="alertBox"></div>

                    <form id="editItemForm">
                        <input type="hidden" id="itemId">

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
                            <button type="submit" class="btn btn-primary">
                                Actualizar
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

<script src="/AppItems/public/js/edit-item.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';