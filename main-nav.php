<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Nav</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary" style="margin-bottom: 80px;">
        <div class="container">
            <!-- Brand -->
            <a href="view-items.php" class="navbar-brand fw-bolder">Company XYZ</a>

            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item"><a href="view-items.php" class="nav-link"><i class="fa-solid fa-tag"></i> Items</a></li>
                <li class="nav-item"><a href="cart.php" class="nav-link"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="#" class="nav-link"><i class="fa-solid fa-user"></i> <?= $_SESSION['username'] ?></a></li>
                <li class="nav-item"><a href="sign-out.php" class="nav-link"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a></li>
            </ul>
        </div>
    </nav>
    
<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>