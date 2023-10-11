<?php
    require "connection.php";
    session_start();
    $user_id = $_SESSION['id'];

    $item_ids = checkItemId($user_id);
    //print_r($item_ids);

    $all_items = getAllCarts($user_id);

    if(isset($_POST['btn_purchase'])) {
        foreach ($all_items as $item) {
            $carts_quantity = $item['quantity'];
            $item_id = $item['item_id'];
            $cart_id = $item['cart_id'];
            
            updateItems ($item_ids, $carts_quantity);
            deleteCart ($user_id);
            // checkItemId($user_id);
        }
        header("location: view-items.php");
    }

    function getAllCarts($user_id)
    {
        $conn = connection();
        $sql = "SELECT items.item_name, items.item_price, carts.quantity, carts.id AS cart_id, items.id AS item_id FROM carts INNER JOIN items ON carts.item_id = items.id WHERE carts.user_id = $user_id";
        
        if($result = $conn->query($sql)) {
            return $result;
        }else {
            die("Error in retrieving all the items " . $conn->error);
        }
    }

    // function updateItems ($item_id, $carts_quantity)
    // {
    //     $conn = connection();
    //     $sql = "UPDATE items SET quantity = quantity - $carts_quantity WHERE id = $item_id";
    //     $conn->query($sql);
    // }
    

    # The "$item_ids" came from the result of "checkItemId($user_id)" function
    function updateItems ($item_ids_rows, $carts_quantity){
        $conn = connection();
        foreach ($item_ids_rows as $k => $v) {
            $sql = "UPDATE SET quantity = quantity - $carts_quantity FROM carts WHERE item_id = $v";
            if ($result = $conn->query($sql))
            {
                echo "Success!";
            }    
        }
    }

    # Get all the item ids and quantity from carts table
    function checkItemId($user_id){
        $conn = connection();
        $sql = "SELECT quantity, item_id FROM carts WHERE user_id = $user_id";
        if($result = $conn->query($sql)) {
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        }else {
            die("Error in retrieving item id " . $conn->error);
        }
    }

    function deleteCart($user_id)
    {
        $conn = connection();
        $sql = "DELETE FROM carts WHERE user_id = $user_id";

        if ($conn->query($sql)) {
            header ("location: view-items.php");
            exit;
        }else {
            die("There is an error deleting the item. " . $conn->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
                <h2 class="fw-bold"><i class="fa-solid fa-cart-arrow-down"></i> Cart Items</h2>
            </div>
            <div class="col text-end">
                <a href="view-items.php" class="btn btn-primary"><i class="fa-solid fa-bag-shopping"></i></i> Continue Shopping</a>
            </div>
        </div>

        <table class="table table-hover align-middle border">
            <thead class="small table-primary">
                <tr>
                    <th style="width:300px;"> Item Name</th>
                    <th style="width:200px;">Item Quantity</th>
                    <th style="width:200px;">Item Price</th>
                    <th style="width: 130px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total_item_num = 0;
                    $total_price = 0;
                    $all_carts = getAllCarts($user_id);
                        while($items = $all_carts->fetch_assoc()){
                        #print_r($items);
                ?>
                    <tr>
                        <td><?=$items['item_name']?></td>
                        <td><?=$items['quantity']?></td>
                        <td><?=$items['item_price']?></td>
                        <td>
                            <a href="edit-cart.php?id=<?=$items['cart_id']?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a href="cart-delete-item.php?id=<?=$items['cart_id']?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    
                <?php
                    $total_item_num += $items['quantity'];
                    $total_price += $items['item_price'] * $items['quantity'];
                        }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Total quantity:  <span class="text-danger h5 fw-bolder"><?=$total_item_num?></span></th>
                    <th>Total Price:  $<span class="text-danger h5 fw-bolder"><?=$total_price?></th>
                </tr>
            </tfoot>
        </table>
        <form action="#" method="post">
            <div class="text-center">
                <input type="submit" value="Purchase" name="btn_purchase" class="btn btn-primary form-control w-50 text-center">
            </div>
        </form>
    </main>
<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" zintegrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>