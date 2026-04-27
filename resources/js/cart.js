function formatMoney(number) {
    return new Intl.NumberFormat('vi-VN').format(number) + ' Ä‘';
}

function updateCartDisplay() {
    const cartForm = document.getElementById('cart-form');
    if (!cartForm) return;

    let total = 0;

    cartForm.querySelectorAll('tbody tr').forEach((row) => {
        const priceCell = row.querySelector('.item-price');
        const qtyInput = row.querySelector('.quantity-input');
        const subtotalCell = row.querySelector('.item-subtotal');

        if (!priceCell || !qtyInput || !subtotalCell) return;

        const price = parseInt(priceCell.dataset.price) || 0;
        let quantity = parseInt(qtyInput.value) || 1;

        if (quantity < 1) {
            quantity = 1;
            qtyInput.value = 1;
        }

        const subtotal = price * quantity;
        subtotalCell.dataset.subtotal = subtotal;
        subtotalCell.textContent = formatMoney(subtotal);

        total += subtotal;
    });

    const totalEl = document.getElementById('cart-total');
    if (totalEl) {
        totalEl.dataset.total = total;
        totalEl.textContent = formatMoney(total);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const cartForm = document.getElementById('cart-form');

    if (cartForm) {
        cartForm.querySelectorAll('.quantity-input').forEach((input) => {
            input.addEventListener('input', updateCartDisplay);
        });
    }

    document.querySelectorAll('.js-add-to-cart').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const button = form.querySelector('[type="submit"]');
            const originalText = button ? button.innerHTML : '';

            if (button) {
                button.disabled = true;
                button.innerHTML = 'Dang them...';
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Khong the them vao gio hang');
                }

                const cartCount = document.getElementById('cart-count');
                if (cartCount && typeof data.cart_count !== 'undefined') {
                    cartCount.textContent = data.cart_count;
                }

                showCartMessage(data.message || 'Da them vao gio hang', 'success');
            } catch (error) {
                showCartMessage(error.message || 'Co loi xay ra, vui long thu lai', 'danger');
            } finally {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }
        });
    });
});

function showCartMessage(message, type = 'success') {
    let wrapper = document.getElementById('cart-toast-wrapper');

    if (!wrapper) {
        wrapper = document.createElement('div');
        wrapper.id = 'cart-toast-wrapper';
        wrapper.className = 'position-fixed bottom-0 end-0 p-3';
        wrapper.style.zIndex = '1080';
        document.body.appendChild(wrapper);
    }

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} shadow-sm mb-2`;
    alert.setAttribute('role', 'alert');
    alert.textContent = message;
    wrapper.appendChild(alert);

    setTimeout(() => {
        alert.remove();
    }, 2500);
}

//thĂ´ng bĂ¡o 
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.classList.remove('show');
        el.classList.add('fade');
        setTimeout(() => el.remove(), 500);
    });
}, 3000);
