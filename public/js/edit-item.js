document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editItemForm');
    const itemIdInput = document.getElementById('itemId');
    const nameInput = document.getElementById('name');
    const qtyInput = document.getElementById('qty');
    const priceInput = document.getElementById('price');
    const alertBox = document.getElementById('alertBox');

    const API_URL = '/AppItems/api/items';

    function showAlert(message, type = 'danger') {
        alertBox.innerHTML = `
            <div class="alert alert-${type}">
                ${message}
            </div>
        `;
    }

    function clearAlert() {
        alertBox.innerHTML = '';
    }

    function getIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    async function cargarItem() {
        const id = getIdFromUrl();

        if (!id) {
            showAlert('ID no encontrado en la URL.');
            return;
        }

        try {
            const res = await fetch(`${API_URL}?id=${id}`);
            const result = await res.json();

            if (!res.ok || !result.ok) {
                throw new Error(result.error || 'Error al cargar el item.');
            }

            const item = result.data;

            itemIdInput.value = item.id;
            nameInput.value = item.name;
            qtyInput.value = item.qty;
            priceInput.value = item.price;

        } catch (error) {
            showAlert(`<strong>Error:</strong> ${error.message}`);
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        clearAlert();

        const id = itemIdInput.value;

        const data = {
            name: nameInput.value.trim(),
            qty: qtyInput.value.trim(),
            price: priceInput.value.trim()
        };

        // ✅ 1) Validación FRONTEND: antes del PUT
        const qtyNumber = Number(data.qty);
        const priceNumber = Number(data.price);

        if (data.name === '') {
            showAlert('El nombre es obligatorio.');
            return;
        }

        if (data.qty === '' || isNaN(qtyNumber) || qtyNumber < 0 || qtyNumber > 9999) {
            showAlert('La cantidad debe ser un número entre 0 y 9999.');
            return;
        }

        if (data.price === '' || isNaN(priceNumber) || priceNumber < 0) {
            showAlert('El precio debe ser un número válido mayor o igual a 0.');
            return;
        }

        // ✅ 2) Si pasó la validación frontend, manda al backend
        try {
            const res = await fetch(`${API_URL}?id=${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            // ✅ 3) Si el backend valida mal y devuelve 400, se muestra acá
            if (!res.ok || !result.ok) {
                const errors = result.errors
                    ? result.errors.join('<br>')
                    : result.error || 'Error al actualizar el item.';

                throw new Error(errors);
            }

            showAlert(result.message, 'success');

            setTimeout(() => {
                window.location.href = '/AppItems/items';
            }, 800);

        } catch (error) {
            showAlert(`<strong>Error:</strong><br>${error.message}`);
        }
    });

    cargarItem();
});