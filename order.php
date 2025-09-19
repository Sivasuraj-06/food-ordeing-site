<?php
include 'session.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="order.css">
    <title>Zwiggy - Order Page</title>
</head>
<body class="order-bg">
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="images/logo.png" alt="Zwiggy Logo" class="logo">
                <h1>Zwiggy-Order from Your Favorite Restaurants</h1>
            </div>
            <div class="logout-container">
                <a href="logout.php" class="logout-button">Logout</a>
            </div>

        </div>
        
        <h1>OFFER ALERTTTT!!!!</h1>
        <h1>10% OFF ON ORDERS ABOVE Rs.500!!!</h1>
        <div id="restaurant-list">
            <div class="restaurant">
                <img src="images/restaurant-1.jpg" alt="Restaurant 1" class="restaurant-logo">
                <h3>Italian Den</h3>
                <p>Delicious Italian cuisine with a variety of pasta and pizza options.</p>
                <img src="images/sm.jpg" alt="Spaghetti & Meatball" class="food-image">
                <button onclick="addToOrder('Spaghetti & Meatball', 359)">Order Spaghetti & Meatball - Rs.359</button>
                <img src="images/istockphoto-1280329631-612x612.jpg" alt="Margherita Pizza" class="food-image">
                <button onclick="addToOrder('Margherita Pizza', 299)">Order Margherita Pizza - Rs.299</button>
                <img src="images/pasta.jpg" alt="Cheesy Pasta" class="food-image">
                <button onclick="addToOrder('Cheesy Pasta', 199)">Order Cheesy Pasta - Rs.199</button>
                <img src="images/Tiramisu.jpg" alt="Tiramisu" class="food-image">
                <button onclick="addToOrder('Tiramisu', 519)">Order Tiramisu- Rs.519</button>

                
            </div>
            <div class="restaurant">
                <img src="images/restaurant-2.jpg" alt="Restaurant 2" class="restaurant-logo">
                <h3>Mexicano</h3>
                <p>Authentic Mexican dishes that bring the flavors of Mexico to your table.</p>
                <img src="images/istockphoto-459396345-612x612.jpg" alt="Tacos" class="food-image">
                <button onclick="addToOrder('Tacos', 459)">Order Tacos - Rs.459</button>
                <img src="images/AS-Burrito-vzhk-superJumbo.jpg" alt="Burrito" class="food-image">
                <button onclick="addToOrder('Burrito', 299)">Order Burrito - Rs.299</button>
                <img src="images/chimi.jpg" alt="Chimichangas" class="food-image">
                <button onclick="addToOrder('Chimichangas', 489)">Order Chimichangas - Rs.489</button>
                <img src="images/churros.jpg" alt="Churros" class="food-image">
                <button onclick="addToOrder('Churros', 159)">Order Churros - Rs.159</button>
            </div>
            <div class="restaurant">
                <img src="images/restaurant-3.jpg" alt="Restaurant 3" class="restaurant-logo">
                <h3>Sushi Soul</h3>
                <p>Fresh and tasty sushi rolls made with the finest ingredients.</p>
                <img src="images/cr.jpg" alt="California Roll" class="food-image">
                <button onclick="addToOrder('California Roll', 399)">Order California Roll - Rs.399</button>
                <img src="images/1-Salmon-Sashimi-with-Ponzu-3-1-of-1.jpg" alt="Salmon Sashimi" class="food-image">
                <button onclick="addToOrder('Salmon Sashimi', 639)">Order Salmon Sashimi - Rs.639</button>
                <img src="images/temaki.jpg" alt="Temaki" class="food-image">
                <button onclick="addToOrder('Temaki', 459)">Order Temaki - Rs.459</button>
                <img src="images/Hamachi.jpg" alt="Hamachi" class="food-image">
                <button onclick="addToOrder('Hamachi', 530)">Order Hamachi - Rs.530</button>
            </div>
            <div class="restaurant">
                <img src="images/restaurant-4.jpg" alt="Restaurant 4" class="restaurant-logo">
                <h3>Indian Nation</h3>
                <p>Authentic Indian flavors with every bite.</p>
                <img src="images/biriyani.jpg" alt="Hyderabadi Biriyani" class="food-image">
                <button onclick="addToOrder('Hyderabadi Biriyani', 299)">Order Hyderabadi Biriyani - Rs.299</button>
                <img src="images/paratha.jpg" alt="Paratha" class="food-image">
                <button onclick="addToOrder('Paratha', 35)">Order Paratha - Rs.35</button>
                <img src="images/chicken.jpg" alt="Butter Masala" class="food-image">
                <button onclick="addToOrder('Chicken Masala', 399)">Order Chicken Masala - Rs.399</button>
                <img src="images/gj.jpg" alt="Gulab Jamun" class="food-image">
                <button onclick="addToOrder('Gulab Jamun', 99)">Order Gulab Jamun - Rs.99</button>
            </div>
        </div>
        
        <h2>Your Order</h2>
        <div id="order-summary">
            <p id="order-list"></p>
            <button onclick="redirectToDetails()">Proceed to Delivery Details</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
