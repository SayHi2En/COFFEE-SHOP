<?php
require_once('config.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = 1; // Assuming a logged-in user with ID 1 for this example

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);

        if ($stmt->execute()) {
            $message = "Product added to cart successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Products - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;display=swap">
</head>

<body style="background:linear-gradient(rgba(47, 23, 15, 0.65), rgba(47, 23, 15, 0.65)), url('assets/img/bg.jpg');">
    <h1 class="text-center text-white d-none d-lg-block site-heading"><span class="site-heading-lower">Coffee Shop</span></h1>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark py-lg-4" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-uppercase d-lg-none text-expanded" href="#">Brand</a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navbarResponsive">
                <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_to_cart.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="store.php">Store</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="page-section">
        <div class="container">
            <div class="product-item">
                <div class="d-flex product-item-title">
                    <div class="d-flex me-auto bg-faded p-5 rounded">
                        <h2 class="section-heading mb-0"><span class="section-heading-upper">Blended to Perfection</span><span class="section-heading-lower">Latte macchiatos</span></h2>
                    </div>
                </div>
                <img class="img-fluid d-flex mx-auto product-item-img mb-3 mb-lg-0 rounded" src="assets/img/products-01.jpg">
                <div class="bg-faded p-5 rounded">
                    <p class="mb-0">We take pride in our work, and it shows. Every time you order a beverage from us, we guarantee that it will be an experience worth having.</p>
                    <p class="mb-0"><strong>Price: $4.50</strong></p>
                    <form action="add_to_cart.php" method="post">
                        <div class="d-flex mt-3">
                            <input type="hidden" name="product_id" value="1">
                            <input type="number" class="form-control me-2" name="quantity" value="1" min="1" max="10">
                            <button type="submit" class="btn btn-primary">Oder Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Repeat similar sections for other products -->
    <footer class="text-center footer text-faded py-5">
        <div class="container">
            <p class="m-0 small">Copyright © Brand 2024</p>
        </div>
    </footer>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/current-day.js"></script>

    <!-- JavaScript to display alert with the message -->
    <script>
        var message = "<?php echo $message; ?>";
        if (message) {
            alert(message);
        }
    </script>
</body>

</html>
