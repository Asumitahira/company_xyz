<?php
    require "connection.php";
    session_start();

    $id = $_GET['id'];

    $item = getItem($id);

    function getItem($id)
    {
        $conn = connection();
        $sql = "SELECT * FROM items WHERE id = $id";

        if($result = $conn->query($sql)) {
            return $result->fetch_assoc();
        }else {
            die("Error in retrieving product details. " . $conn->error);
        }
    }
     
    if(isset($_POST['btn_update'])) {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        updateItem ($id, $name, $price, $quantity);
    }

    function updateItem ($id, $name, $price, $quantity)
    {
        $conn = connection();
        $sql = "UPDATE items SET `item_name` = '$name', `item_price` = ' $price', `quantity` = '$quantity' WHERE id = $id";

        if ($conn->query($sql)) {
            header("location: view-items.php");
            exit;
        }else {
            die("Error in updating item details. " . $conn->error);
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        include('main-nav.php');
    ?>
    <main class="row justify-content-center">
        <div class="col-4">
            <h2 class="fw-bold mb-3"><i class="fa-solid fa-pen"></i> Edit Product</h2>

            <form action="#" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold small">Item Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?=$item['item_name']?>" max="50" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label small fw-bold">Item Price:</label>
                    <input type="number" name="price" id="price" step="any" class="form-control" value="<?=$item['item_price']?>" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label small fw-bold">Item Quantity:</label>
                    <input type="number" name="quantity" id="quantity" step="any" class="form-control" value="<?=$item['quantity']?>" required>
                </div>
                <a href="view-items.php" class="btn btn-outline-primary c">Cancel</a>
                <button type="submit" name="btn_update" class="btn btn-primary fw-bold"><i class="fa-regular fa-circle-check"></i> Save Changes</button>
            </form>
        </div>
    </main>

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>