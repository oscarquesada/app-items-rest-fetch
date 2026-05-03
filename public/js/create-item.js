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
            qty: qtyInput.value,
            price: priceInput.value
        };

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

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