
<?php
require_once __DIR__ . "/db.php";

// Fetch products from database
$sql = "SELECT * FROM `fruits&veggies`";
$result = mysqli_query($conn, $sql);

// Get database values safely, regardless of capitalization
function getProductValue($row, $possibleNames, $default = "")
{
    foreach ($possibleNames as $name) {
        foreach ($row as $key => $value) {
            if (strcasecmp($key, $name) === 0) {
                return $value;
            }
        }
    }

    return $default;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MARKET Kiosk | Fresh Fruits & Vegetables</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #faf8f5;
            color: #3d3028;
        }

        /* NAVIGATION */
        .navbar {
            background: #ffffff;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            color: #795438;
        }

        .logo span {
            color: #b68b64;
        }

        .nav-links {
            display: flex;
            gap: 28px;
        }

        .nav-links a {
            text-decoration: none;
            color: #594638;
            font-size: 14px;
            font-weight: bold;
        }

        .nav-links a:hover {
            color: #a77950;
        }

        /* HERO SECTION */
        .hero {
            min-height: 350px;
            padding: 70px 8%;
            display: flex;
            align-items: center;
            background: #eee4d9;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 42px;
            color: #5b402e;
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 16px;
            line-height: 1.7;
            color: #6c5848;
            margin-bottom: 25px;
        }

        .hero-btn {
            display: inline-block;
            background: #795438;
            color: white;
            padding: 13px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .hero-btn:hover {
            background: #5d402c;
        }

        /* GENERAL SECTION */
        .section {
            padding: 60px 7%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 35px;
        }

        .section-title h2 {
            font-size: 30px;
            color: #5b402e;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #8a796b;
            font-size: 14px;
        }

        /* PRODUCT GRID */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
            transition: 0.3s;
            border: 1px solid #eee6de;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.10);
        }

        .product-image {
            width: 100%;
            height: 190px;
            background: #f2eee9;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            color: #927d6b;
            font-size: 13px;
        }

        .product-info {
            padding: 18px;
        }

        .product-info h3 {
            color: #503b2d;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .product-price {
            color: #946b48;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .order-btn {
            display: block;
            text-align: center;
            background: #795438;
            color: white;
            text-decoration: none;
            padding: 11px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
        }

        .order-btn:hover {
            background: #5d402c;
        }

        /* ORDER FORM */
        .order-section {
            background: #eee4d9;
            padding: 55px 7%;
        }

        .order-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .order-container h2 {
            text-align: center;
            color: #5b402e;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #594638;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d9c9bb;
            border-radius: 6px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #795438;
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
            border: none;
            background: #795438;
            color: white;
            font-size: 15px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #5d402c;
        }

        /* ABOUT SECTION */
        .about {
            text-align: center;
            max-width: 800px;
            margin: auto;
            line-height: 1.8;
            color: #766454;
        }

        /* FOOTER */
        footer {
            background: #503b2d;
            color: white;
            padding: 30px 7%;
            text-align: center;
        }

        footer p {
            font-size: 13px;
            line-height: 1.8;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero {
                padding: 55px 7%;
            }

            .hero h1 {
                font-size: 32px;
            }

            .section {
                padding: 45px 5%;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .product-image {
                height: 140px;
            }

            .product-info {
                padding: 12px;
            }

            .product-info h3 {
                font-size: 14px;
            }

            .product-price {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVIGATION -->
    <nav class="navbar">
        <div class="logo">MARKET <span>KiosK.</span></div>

        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#products">Products</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Fresh Choices, Better Living.</h1>

            <p>
                Discover fresh fruits and vegetables at MARKET Kiosk.
                Browse our available products and enjoy convenient shopping
                with affordable prices.
            </p>

            <a href="#products" class="hero-btn">Explore Products</a>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="section" id="products">

        <div class="section-title">
            <h2>Our Products</h2>
            <p>Fresh fruits and vegetables available in our store.</p>
        </div>

        <div class="product-grid">

            <?php if ($result && mysqli_num_rows($result) > 0): ?>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <?php
                    $productId = getProductValue(
                        $row,
                        ["Productid", "PRODUCTId", "ProductID", "id"]
                    );

                    $productName = getProductValue(
                        $row,
                        ["FRUIT", "Fruit", "ProductName", "name"],
                        "Product"
                    );

                    $price = getProductValue(
                        $row,
                        ["PRICE", "Price", "price"],
                        "0"
                    );

                    $image = trim(getProductValue(
                        $row,
                        ["Image", "IMAGE", "image"]
                    ));

                    // Use the imgs folder
                    $imagePath = "";

                    if ($image !== "") {
                        $imagePath = "imgs/" . ltrim($image, "/\\");

                        // Add extension only if database value has none
                        if (!preg_match('/\.(png|jpe?g|webp|gif)$/i', $imagePath)) {
                            $imagePath .= ".png";
                        }
                    }
                    ?>

                    <div class="product-card">

                        <div class="product-image">

                            <?php if ($imagePath !== ""): ?>

                                <img
                                    src="<?php echo htmlspecialchars($imagePath); ?>"
                                    alt="<?php echo htmlspecialchars($productName); ?>"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                >

                                <span class="no-image" style="display:none;">
                                    Image unavailable
                                </span>

                            <?php else: ?>

                                <span class="no-image">
                                    No image available
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="product-info">

                            <h3>
                                <?php echo htmlspecialchars($productName); ?>
                            </h3>

                            <p class="product-price">
                                ₱<?php echo htmlspecialchars(number_format((float)$price, 2)); ?>
                            </p>

                            <a
                                href="#order"
                                class="order-btn"
                                onclick="selectProduct(
                                    '<?php echo htmlspecialchars(addslashes($productId), ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars(addslashes($productName), ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars((string)$price, ENT_QUOTES); ?>'
                                )"
                            >
                                Order Now
                            </a>

                        </div>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p>No products found. Please check your database.</p>

            <?php endif; ?>

        </div>
    </section>

    <!-- ORDER FORM -->
    <section class="order-section" id="order">

        <div class="order-container">

            <h2>Place Your Order</h2>

            <form action="insert.php" method="GET">

                <div class="form-group">
                    <label for="product_id">Product ID</label>
                    <input
                        type="text"
                        id="product_id"
                        name="product_id"
                        required
                        readonly
                        placeholder="Select a product first"
                    >
                </div>

                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input
                        type="text"
                        id="product_name"
                        readonly
                        placeholder="Selected product"
                    >
                </div>

                <div class="form-group">
                    <label for="Price">Price (₱)</label>
                    <input
                        type="number"
                        id="Price"
                        name="Price"
                        step="0.01"
                        required
                        readonly
                        placeholder="Product price"
                    >
                </div>

                <div class="form-group">
                    <label for="QNTTY">Quantity</label>
                    <input
                        type="number"
                        id="QNTTY"
                        name="QNTTY"
                        min="1"
                        required
                        placeholder="Enter quantity"
                    >
                </div>

                <div class="form-group">
                    <label for="USER">Customer Name</label>
                    <input
                        type="text"
                        id="USER"
                        name="USER"
                        required
                        placeholder="Enter your name"
                    >
                </div>

                <div class="form-group">
                    <label for="CONTACT">Contact Number</label>
                    <input
                        type="tel"
                        id="CONTACT"
                        name="CONTACT"
                        required
                        placeholder="Enter your contact number"
                    >
                </div>

                <button type="submit" class="submit-btn">
                    Submit Order
                </button>

            </form>

        </div>
    </section>

    <!-- ABOUT -->
    <section class="section" id="about">

        <div class="section-title">
            <h2>About MARKET Kiosk</h2>
        </div>

        <div class="about">
            <p>
                MARKET Kiosk provides customers with a convenient way
                to browse available fruits and vegetables. Our goal is
                to make product selection and ordering simple and easy
                for everyone.
            </p>
        </div>

    </section>

    <!-- CONTACT -->
    <section class="section" id="contact">

        <div class="section-title">
            <h2>Contact Us</h2>
            <p>Thank you for visiting MARKET Kiosk!</p>
        </div>

    </section>

    <!-- FOOTER -->
    <footer>
        <p>© <?php echo date("Y"); ?> MARKET Kiosk. All Rights Reserved.</p>
        <p>Fresh Choices, Better Living.</p>
    </footer>

    <!-- JAVASCRIPT -->
    <script>
        function selectProduct(id, name, price) {
            document.getElementById("product_id").value = id;
            document.getElementById("product_name").value = name;
            document.getElementById("Price").value = price;

            document.getElementById("order").scrollIntoView({
                behavior: "smooth"
            });
        }
    </script>

</body>
</html>
