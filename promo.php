<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HotelEase - Promotions</title>
    <style>
    body,
    html {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f5f5;
    }

    .page-wrapper {
        padding: 60px 20px;
        max-width: 1200px;
        margin: auto;
    }

    .main-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 40px;
        color: #333;
    }

    /* Grid Layout */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    /* Promo Card */
    .promo-card {
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s;
    }

    .promo-card:hover {
        transform: translateY(-5px);
    }

    .promo-image {
        height: 200px;
        background-size: cover;
        background-position: center;
    }

    .promo-content {
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }

    .promo-content h2 {
        font-size: 1.5rem;
        color: #222;
        margin-bottom: 10px;
    }

    .highlight {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .btn {
        background-color: #ffb300;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        width: fit-content;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #ffa000;
    }

    footer {
        margin-top: 60px;
        text-align: center;
        font-size: 0.9rem;
        color: #999;
    }

    .promo-content p {
        margin: 5px 0;
        color: #444;
    }

    .promo-list {
        list-style: disc;
        padding-left: 20px;
        margin: 10px 0 20px;
        color: #555;
    }

    .promo-list li {
        margin-bottom: 5px;
    }

    .back-btn-wrapper {
        padding: 20px;
    }

    .back-btn {
        background-color: #f5f5f5;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        color: #333;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background-color: #e2e2e2;
    }
    </style>
</head>

<body>
    <div class="back-btn-wrapper">
        <button onclick="history.back()" class="back-btn">
            ← Back
        </button>
    </div>

    <div class="page-wrapper">
        <h1 class="main-title">🏨 Exclusive Hotel Promotions</h1>
        <div class="card-grid">

            <!-- Summer Getaway -->
            <div class="promo-card">
                <div class="promo-image" style="background-image: url('./images/gallery-mix/pool.jpg');"></div>
                <div class="promo-content">
                    <h2>☀️ Summer Getaway Sale</h2>
                    <p><strong>Booking:</strong> Until June 30, 2025<br>
                        <strong>Stay:</strong> May 1 – July 15, 2025
                    </p>
                    <p class="highlight">Up to <strong>30% OFF</strong> on all Deluxe Rooms with breakfast for 2 and
                        access to the infinity pool.</p>
                    <ul class="promo-list">
                        <li>Deluxe Room Accommodation</li>
                        <li>Daily Buffet Breakfast</li>
                        <li>Access to Fitness Center & Pool</li>
                    </ul>
                    <a href="Reserve.php" class="btn">Book Now</a>
                </div>
            </div>

            <!-- Rainy Day Retreat -->
            <div class="promo-card">
                <div class="promo-image" style="background-image: url('./images/gallery/2.webp');"></div>
                <div class="promo-content">
                    <h2>🌧️ Rainy Day Retreat</h2>
                    <p><strong>Booking:</strong> June 1 – July 30, 2025<br>
                        <strong>Stay:</strong> June 10 – August 31, 2025
                    </p>
                    <p class="highlight">Book <strong>2 nights</strong>, get <strong>1 night FREE</strong>. Warm drinks
                        and rainy views included.</p>
                    <ul class="promo-list">
                        <li>Stay 3 nights, pay for 2</li>
                        <li>Complimentary Afternoon Tea</li>
                        <li>Late Checkout (until 2PM)</li>
                    </ul>
                    <a href="Reserve.php" class="btn">Reserve Today</a>
                </div>
            </div>

            <!-- Holiday Special -->
            <div class="promo-card">
                <div class="promo-image" style="background-image: url('./images/gallery-square/3.webp');"></div>
                <div class="promo-content">
                    <h2>🎁 Holiday Special</h2>
                    <p><strong>Booking:</strong> Nov 1 – Dec 31, 2025<br>
                        <strong>Stay:</strong> December 20 – January 5, 2026
                    </p>
                    <p class="highlight">Celebrate the holidays with <strong>Free Breakfast</strong> & <strong>Late
                            Checkout</strong> included.</p>
                    <ul class="promo-list">
                        <li>Festive Welcome Drink</li>
                        <li>Daily Buffet Breakfast for 2</li>
                        <li>Late Checkout until 3PM</li>
                    </ul>
                    <a href="Reserve.php" class="btn">Claim Offer</a>
                </div>
            </div>



        </div>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> HotelEase. All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>