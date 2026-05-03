document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const loading = document.getElementById('loading');
    const alertBox = document.getElementById('alertBox');
    const itemsList = document.getElementById('itemsList');

    const API_URL = '/AppItems/api/items';

    function showLoading() {
        loading.style.display = 'block';
    }

    function hideLoading() {
        loading.style.display = 'none';
    }

    function clearAlert() {
        alertBox.innerHTML = '';
    }

    function showAlert(message, type = 'danger') {
        alertBox.innerHTML = `
            <div class="alert alert-${type}">
                ${message}
            </div>
        `;
    }

    function renderItems(items) {
        itemsList.innerHTML = '';

        if (!Array.isArray(items)) {
            showAlert('Respuesta inesperada del servidor.');
            return;
        }

        if (items.length === 0) {
            showAlert('No se encontraron items.', 'warning');
            return;
        }

        const table = document.createElement('table');
        table.className = 'table table-custom table-hover align-middle';

        table.innerHTML = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        `;

        const tbody = table.querySelector('tbody');

        items.forEach(item => {
            const tr = document.createElement('tr');

            const price = Number(item.price);
            const priceText = Number.isNaN(price) ? '0.00' : price.toFixed(2);

            tr.innerHTML = `
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>$${priceText}</td>
                <td class="text-end">
                    <a href="/AppItems/items/edit?id=${item.id}" class="btn btn-sm btn-warning">
                        Editar
                    </a>

                    <button class="btn btn-sm btn-danger btn-delete">
                        Eliminar
                    </button>
                </td>
            `;

            tr.querySelector('.btn-delete').addEventListener('click', () => {
                eliminarItem(item.id);
            });

            tbody.appendChild(tr);
        });

        itemsList.appendChild(table);
    }

    async function cargarItems() {
        const query = searchInput.value.trim();
        const url = `${API_URL}?q=${encodeURIComponent(query)}`;

        clearAlert();
        showLoading();

        try {
            const res = await fetch(url);
            const result = await res.json();

            if (!res.ok || !result.ok) {
                throw new Error(result.error || 'Error al traer los items.');
            }

            renderItems(result.data);

        } catch (error) {
            showAlert(`<strong>Error:</strong> ${error.message}`);
        } finally {
            hideLoading();
        }
    }

    async function eliminarItem(id) {
        const confirmar = confirm('¿Seguro que querés eliminar este item?');

        if (!confirmar) {
            return;
        }

        clearAlert();

        try {
            const res = await fetch(`${API_URL}?id=${id}`, {
                method: 'DELETE'
            });

            const result = await res.json();

            if (!res.ok || !result.ok) {
                throw new Error(result.error || 'Error al eliminar el item.');
            }

            showAlert(result.message, 'success');
            cargarItems();

        } catch (error) {
            showAlert(`<strong>Error:</strong> ${error.message}`);
        }
    }

    searchBtn.addEventListener('click', cargarItems);

    searchInput.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            cargarItems();
        }
    });

    cargarItems();
});