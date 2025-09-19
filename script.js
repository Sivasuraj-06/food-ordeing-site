let order = [];
function addToOrder(itemName, itemPrice) {
    const existingItem = order.find(item => item.name === itemName);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        order.push({ name: itemName, price: itemPrice, quantity: 1 });
    }

    updateOrderSummary();
}
function updateOrderSummary() {
    const orderList = document.getElementById('order-list');
    orderList.innerHTML = '';

    order.forEach(item => {
        const li = document.createElement('p');
        li.textContent = `${item.name} - Rs.${item.price} x ${item.quantity}`;
        orderList.appendChild(li);
    });
}
function redirectToDetails() {
    localStorage.setItem('order', JSON.stringify(order));
    window.location.href = 'finalize.php';
}

