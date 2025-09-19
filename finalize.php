<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zwiggy_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $paymentMethod = $_POST['paymentMethod'];
    $ecoPackaging = $_POST['ecoPackaging'];
    $totalCost = $_POST['totalCost'];
    $discount = $_POST['discount'];
    $finalCost = $_POST['finalCost'];
    $orderItems = json_decode($_POST['orderItems'], true);
    $sql = "INSERT INTO orders (user_name, address, phone, payment_method, eco_packaging, total_cost, discount, final_cost) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsddd", $name, $address, $phone, $paymentMethod, $ecoPackaging, $totalCost, $discount, $finalCost);
    $stmt->execute();
    $orderId = $conn->insert_id;
    foreach ($orderItems as $item) {
        $itemName = $item['name'];
        $itemPrice = $item['price'];
        $itemQuantity = $item['quantity'];
        
        $sqlItem = "INSERT INTO order_items (order_id, item_name, price, quantity) VALUES (?, ?, ?, ?)";
        $stmtItem = $conn->prepare($sqlItem);
        $stmtItem->bind_param("isdi", $orderId, $itemName, $itemPrice, $itemQuantity);
        $stmtItem->execute();
    }
    $stmt->close();
    $stmtItem->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Order Details</title>
</head>
<body>
    <div class="container">
        <h1>Delivery Details and Bill</h1>

        <h2>Your Order Summary</h2>
        <ul id="order-summary"></ul>

        <form id="order-form">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="address" placeholder="Delivery Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            
            <h3>Payment Method</h3>
            <label>
                <input type="radio" name="paymentMethod" value="COD" required> Cash on Delivery (COD)
            </label>
            <label>
                <input type="radio" name="paymentMethod" value="UPI" required> UPI
            </label>

            <h3>Eco-friendly Packaging</h3>
            <label>
                <input type="checkbox" name="ecoPackaging" value="Yes"> Would you like eco-friendly packaging?
            </label>

            <button type="submit">Confirm Order</button>
        </form>

        <div id="bill-section" class="bill-section hidden">
            <h2>Order Confirmation</h2>
            <p id="bill-name"></p>
            <p id="bill-address"></p>
            <p id="bill-phone"></p>
            <p id="bill-payment-method"></p>
            <p id="bill-eco-packaging"></p>
            <p>Total Cost: Rs.<span id="bill-total-cost"></span></p>
            <p>Discount: Rs.<span id="bill-discount"></span></p>
            <p>Final Cost: Rs.<span id="bill-final-cost"></span></p>
            <p id="delivery-duration"></p>
            <button id="redirect-button" onclick="redirectToOrderPage()">Go Back to Order Page</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const order = JSON.parse(localStorage.getItem('order')) || [];
            const orderList = document.getElementById('order-summary');
            let totalCost = 0;
            let totalQuantity = 0;

            order.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.name} - Rs.${item.price} x ${item.quantity}`;
                orderList.appendChild(li);
                totalCost += item.price * item.quantity;
                totalQuantity += item.quantity;
            });

            const discount = totalCost > 500 ? totalCost * 0.1 : 0;
            const finalCost = totalCost - discount;

            const deliveryDuration = calculateDeliveryDuration(totalQuantity);

            document.getElementById('order-form').addEventListener('submit', (event) => {
                event.preventDefault();

                const name = event.target.name.value;
                const address = event.target.address.value;
                const phone = event.target.phone.value;
                const paymentMethod = event.target.paymentMethod.value;
                const ecoPackaging = event.target.ecoPackaging.checked ? 'Yes' : 'No';
                const phoneRegex = /^\d{10}$/;

                if (!phoneRegex.test(phone)) {
                    alert("Please enter a valid 10-digit phone number.");
                    return;
                }

                document.getElementById('bill-name').textContent = `Name: ${name}`;
                document.getElementById('bill-address').textContent = `Address: ${address}`;
                document.getElementById('bill-phone').textContent = `Phone: ${phone}`;
                document.getElementById('bill-payment-method').textContent = `Payment Method: ${paymentMethod}`;
                document.getElementById('bill-eco-packaging').textContent = `Eco-friendly Packaging: ${ecoPackaging}`;
                document.getElementById('bill-total-cost').textContent = totalCost.toFixed(2);
                document.getElementById('bill-discount').textContent = discount.toFixed(2);
                document.getElementById('bill-final-cost').textContent = finalCost.toFixed(2);
                document.getElementById('delivery-duration').textContent = `Estimated Delivery Time: ${deliveryDuration}`;

                document.getElementById('bill-section').classList.remove('hidden');
                document.getElementById('order-form').classList.add('hidden');
                event.target.reset();
                sendOrderToDatabase(name, address, phone, paymentMethod, ecoPackaging, totalCost, discount, finalCost, deliveryDuration);

                
                setTimeout(() => {
                    alert(`Order Placed Successfully! Estimated Delivery Time: ${deliveryDuration}`);
                }, 500);
            });
        });

        function calculateDeliveryDuration(totalQuantity) {
            if (totalQuantity <= 5) {
                return "30-45 minutes";
            } else if (totalQuantity <= 15) {
                return "45-60 minutes";
            } else {
                return "60-90 minutes";
            }
        }

        function sendOrderToDatabase(name, address, phone, paymentMethod, ecoPackaging, totalCost, discount, finalCost) {
            const orderItems = JSON.parse(localStorage.getItem('order')) || [];
            const orderData = orderItems.map(item => ({
                name: item.name,
                price: item.price,
                quantity: item.quantity
            }));

            const data = new FormData();
            data.append('name', name);
            data.append('address', address);
            data.append('phone', phone);
            data.append('paymentMethod', paymentMethod);
            data.append('ecoPackaging', ecoPackaging);
            data.append('orderItems', JSON.stringify(orderData));
            data.append('totalCost', totalCost.toFixed(2));
            data.append('discount', discount.toFixed(2));
            data.append('finalCost', finalCost.toFixed(2));
            localStorage.removeItem('order');

            fetch('finalize.php', {
                method: 'POST',
                body: data
            })
            .catch(error => console.error('Error:', error));
        }
        function redirectToOrderPage() {
            window.location.href = 'order.php'; 
        }
    </script>
</body>
</html>

