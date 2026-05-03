document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('createItemForm');
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

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        clearAlert();

        const data = {
            name: nameInput.value.trim(),
            qty: qtyInput.value.trim(),
            price: priceInput.value.trim()
        };

        // ✅ 1) Validación FRONTEND: antes de mandar el fetch
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

        // ✅ 2) Si pasó la validación frontend, recién acá manda al backend
        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            // ✅ 3) Validación BACKEND: si PHP devuelve 400, lo mostramos acá
            if (!res.ok || !result.ok) {
                const errors = result.errors
                    ? result.errors.join('<br>')
                    : result.error || 'Error al crear el item.';

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
});