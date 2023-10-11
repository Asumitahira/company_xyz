<?php
    session_start();
    require "connection.php";

    // function getAllSections()
    // {
    //     $conn = connection();
    //     $sql = "SELECT * FROM sections";
    //     if ($result = $conn->query($sql)) {
    //         return $result;
    //     }else {
    //         die("Unable to retrieved records " . $conn->error);
    //     }
    // }

    if (isset($_POST['btn_add'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        addItem($name, $price, $quantity);
    }

    function addItem($name, $price, $quantity)
    {
        $conn = connection();
        $sql = "INSERT INTO items(`item_name`, `item_price`, `quantity`) VALUE('$name', '$price', '$quantity')";
    

        if ($conn->query($sql)) {
            header("location: view-items.php");
            exit;
        }else {
            die("Error in adding new items. " . $conn->error);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Items</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        include('main-nav.php');
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="fw-light mb-2 fw-bold"><i class="fa-solid fa-plus"></i> Add Item</h2>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold">Item Name:</label>
                        <input type="text" name="name" id="name" class="form-control" max="50" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Item Price:</label>
                        <div class="input-group">
                            <div class="input-group-text">$</div>
                            <input type="number" name="price" id="price" step="any" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label small fw-bold">Item Quantity:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-primary fw-bold px-5">
                    <i class="fa-solid fa-plus"></i> Add
                    </button>
                </form>
            </div>
        </div>
    </main>

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>