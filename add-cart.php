<?php
    require "connection.php";
    session_start();
    $id = $_GET['id'];
    $user_id = $_SESSION['id'];
    $cart_item_total_qty = 0;

    //retrieved every records in carts table
    function getAllItems($id)
    {
        $conn = connection();
        $sql = "SELECT * FROM items WHERE id = $id";
        if ($result = $conn->query($sql)) {
            return $result;
        }else {
            die("Could not retrieved items. " . $conn->error);
        }
    }

    //run this function when btn_purchase is clicked
    if (isset($_POST['btn_purchase'])) {
        $cart_user_id = $user_id;
        $cart_item_id = $id;
        $cart_product_name = $_POST['name'];
        $cart_product_price = $_POST['price'];
        $cart_product_qty = $_POST['quantity'];

        insertProductItems($cart_item_id, $cart_user_id, $cart_product_qty);

        getSoldItem($user_id, $id);

    }

    
    function insertProductItems($cart_item_id, $cart_user_id, $cart_product_qty)
    {
        $conn = connection();
        $sql = "INSERT INTO carts(`quantity`, `item_id`, `user_id`) VALUES('$cart_product_qty', '$cart_item_id', '$cart_user_id')";

        if ($conn->query($sql)) {
            $conn = connection();
            $sqlUpdate = "UPDATE items SET quantity = quantity - $cart_product_qty WHERE id = $cart_item_id"; //3 -- orange
            if ($conn->query($sqlUpdate)) {
                header("location: view-items.php");    
            }else {
                die("Error in updating the quantity. " . $conn->error);
            }
            
        }else {
            die("Error in inserting cart items. " . $conn->error);
        }
    }

    function getSoldItem($user_id, $id)
    {
        $conn = connection();
        $sql = "SELECT * FROM carts WHERE carts.user_id = $user_id AND item_id = $id";
        
        if($result = $conn->query($sql)) {
            return $result;
        }else {
            die("Error in retrieving all the carts " . $conn->error);
        }

    }

    // function getSoldItem($user_id)
    // {
    //     $conn = connection();
    //     $sql = "SELECT * FROM carts WHERE carts.user_id = $user_id";
        
    //     if($result = $conn->query($sql)) {
    //         return $result;
    //     }else {
    //         die("Error in retrieving all the carts " . $conn->error);
    //     }

    // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cart</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- <?php
        //include('main-nav.php');
    ?> -->

    <main class="row justify-content-center">
        <div class="row mt-5 ">
            <div class="col-5 mx-auto">
                <h2 class="fw-bold mb-3"><i class="fa-solid fa-cart-arrow-down"></i> Add Cart</h2>
    
                <form action="#" method="post">
                    <?php
                        $cart_product_items = getAllItems($id);
                        while ($cartItems = $cart_product_items->fetch_assoc()) {
                    ?>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small">Item Name:</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $cartItems['item_name'] ?>" max="50" required readonly>
                     </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Item Price: <span class="fw-lighter"> ※Per Item</span></label>
                        <input type="number" name="price" id="price" step="any" class="form-control" value="<?= $cartItems['item_price'] ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label small fw-bold">Item Quantity:</label>
                        <input type="number" name="quantity" id="quantity" step="any" class="form-control" required autofocus>
                    </div>
                    <?php
                        }
                    ?>
                    
                    <a href="view-items.php" class="btn btn-outline-primary w-25">Cancel</a>
                    <button type="submit" name="btn_purchase" class="btn btn-primary fw-bold w-50"><i class="fa-solid fa-plus"></i> Purchase</button>
                </form>
            </div>
            <div class="col-5 mx-auto">
            <table class="table table-hover align-middle border">
                <thead class="small table-primary text-center">
                    <tr class="h5">
                        <th>Date</th>
                        <th>Sold Quantity</th>
                    </tr>
                </thead>
                <?php
                    $cart_items = getSoldItem($user_id, $id);
                    while ($cart_item = $cart_items->fetch_assoc()) {
                ?>
                <tbody>
                    <tr class="text-center">
                            <td><?=$cart_item['date_time_sold']?></td>
                            <td><?=$cart_item['quantity']?></td>
                    </tr>
                </tbody>
                <?php
                    $cart_item_qty = $cart_item['quantity'];
                    $cart_item_total_qty += $cart_item_qty;
                }
                ?>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-center">Total Sold Item :  <span class="text-danger h5 fw-bolder">
                            <?php
                                echo $cart_item_total_qty
                            ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>    
    </main>


    

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>