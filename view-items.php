<?php
    session_start();
    require "connection.php";

    if (!isset($_SESSION['id'])) {
        header("location: sign-in.php");
    }

    function getAllItems()
    {
        $conn = connection();
        $sql = "SELECT items.id AS id, items.item_name AS `name`, items.item_price AS price, items.quantity AS quantity FROM items";

        if($result = $conn->query($sql)) {
            return $result;
        }else {
            die("Error in retrieving all the items " . $conn->error);
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
        <div class="row mb-4 mt-3">
            <div class="col">
                <h2 class="fw-bold">Items</h2>
            </div>
            <div class="col text-end">
                <a href="add-item.php" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> New Product</a>
            </div>
        </div>

        <table class="table table-hover align-middle border">
            <thead class="small table-primary">
                <tr
                >
                    <th style="width:200px;">ID</th>
                    <th style="width:300px;"> Item Name</th>
                    <th style="width:200px;">Item Price</th>
                    <th style="width:200px;">Item Quantity</th>
                    <th style="width: 130px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $all_items = getAllItems();
                    while ($items = $all_items->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?=$items['id']?></td>
                        <td><?=$items['name']?></td>
                        <td><?=$items['price']?></td>
                        <td><?=$items['quantity']?></td>
                        <td>
                            <a href="edit-item.php?id=<?=$items['id']?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a href="add-cart.php?id=<?=$items['id']?>" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-cart-arrow-down"></i></a>
                            <a href="delete-item.php?id=<?=$items['id']?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php        
                    }
                ?>
            </tbody>
        </table>
    </main>
    

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>