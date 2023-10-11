<!-- cart.php -->
<?php
    require "connection.php";
    session_start();

    $user_id = $_SESSION['id'];

    $item_ids = checkItemId($user_id);
    #print_r($item_ids);

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
    //     $sql = "UPDATE items SET quantity = quantity - $carts_quantity WHERE id = $ite_ids";
    //     $conn->query($sql);
    // }

    function updateItems ($item_ids, $carts_quantity){
        $conn = connection();
        $sql = "SELECT item_id FROM carts";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $test = $row['item_id'];
                $sql = "UPDATE items SET quantity = quantity - $carts_quantity WHERE item_id = $test";
                $conn->query($sql);
            }
        }
    } 

    // function updateItems ($item_ids, $carts_quantity, $user_id){
    //     $conn = connection();
    //     $sql = "SELECT * FROM carts WHERE user_id = $user_id";
    //     $result = $conn->query($sql);

    //     if($result->num_rows > 0){
    //         while($item_id = $item_ids->fetch_assoc()){
    //             $sql = "UPDATE items SET quantity = quantity - $carts_quantity WHERE item_id = $item_id";
    //             $conn->query($sql);
    //         }
    //     }
    // } 

    function checkItemId($user_id){
        $conn = connection();
        $sql = "SELECT item_id FROM carts WHERE user_id = $user_id";
        if($result = $conn->query($sql)) {
            $ids = [];
            while ($row = $result->fetch_assoc()) {
                $ids[] = $row;
            }
            return $ids;
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


<!-- add cart.php -->
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

    if(isset($_POST['btn_add'])) {
        $quantity = $_POST['quantity'];
        $item_id = $_GET['id'];
        $user_id = $_SESSION['id'];

        addItem ($quantity, $item_id, $user_id);
    }

    function addItem ($quantity, $item_id, $user_id)
    {
        $conn = connection();
        $sql = "INSERT INTO carts(`quantity`, `item_id`, `user_id`) VALUE('$quantity', '$item_id', '$user_id')";

        if ($conn->query($sql)) {
            header("location: cart.php");
            exit;
        }else {
            die("Error in adding item details. " . $conn->error);
        }
    }  
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
    <?php
        include('main-nav.php');
    ?>

    <main class="row justify-content-center">
            <div class="col-4">
                <h2 class="fw-bold mb-3"><i class="fa-solid fa-cart-arrow-down"></i> Add Cart</h2>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small">Item Name:</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="<?=$item['item_name']?>" max="50" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Item Price: <span class="fw-lighter"> ※Per Item</span></label>
                        <input type="number" name="price" id="price" step="any" class="form-control" value="<?=$item['item_price']?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label small fw-bold">Item Quantity:</label>
                        <input type="number" name="quantity" id="quantity" step="any" class="form-control" value="1" required autofocus>
                    </div>
                    <a href="view-items.php" class="btn btn-outline-primary">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-primary fw-bold w-50"><i class="fa-solid fa-plus"></i> Add</button>
                </form>
            </div>
        </main>


    

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


<!-- add-cart 最新 -->
<?php
    require "connection.php";
    session_start();

    $id = $_GET['id'];
    $user_id = $_SESSION['id'];
    $item = getItem($id);
    $cart_item = getCartsItem($user_id);

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

    if(isset($_POST['btn_add'])) {
        $quantity = $_POST['quantity'];
        $item_id = $_GET['id'];
        $user_id = $_SESSION['id'];

        addItem ($quantity, $item_id, $user_id);
    }

    function addItem ($quantity, $item_id, $user_id)
    {
        $conn = connection();
        $sql = "INSERT INTO carts(`quantity`, `item_id`, `user_id`) VALUE('$quantity', '$item_id', '$user_id')";

        if (!$conn->query($sql)) {
            die("Error in adding item details. " . $conn->error);
        }
    } 
    
    function getCartsItem($user_id)
    {
        $conn = connection();
        $sql = "SELECT quantity, add_item_date FROM carts WHERE user_id = $user_id";
        
        if($result = $conn->query($sql)) {
            return $result->fetch_assoc();
        }else {
            die("Error in retrieving all the items " . $conn->error);
        }
    }

    if (isset($_POST['btn_purchase'])) {
        deleteCart ($user_id);

        $id = $item['item_id'];
        $carts_quantity = $cart_item['quantity']; 
        updateItem($id, $carts_quantity);
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

    function updateItems ($id, $carts_quantity)
    {
        $conn = connection();
        $sql = "UPDATE items SET quantity = quantity - $carts_quantity WHERE id = $id";
        $conn->query($sql);
    }
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
    <?php
        include('main-nav.php');
    ?>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="fw-bold mb-3"><i class="fa-solid fa-cart-arrow-down"></i> Add Cart</h2>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small">Item Name:</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="<?=$item['item_name']?>" max="50" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Item Price: <span class="fw-lighter"> ※Per Item</span></label>
                        <input type="number" name="price" id="price" step="any" class="form-control" value="<?=$item['item_price']?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label small fw-bold">Item Quantity:</label>
                        <input type="number" name="quantity" id="quantity" step="any" class="form-control" value="1" required autofocus>
                    </div>
                    <a href="view-items.php" class="btn btn-outline-primary">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-primary fw-bold w-50"><i class="fa-solid fa-plus"></i> Add</button>
                </form>
            </div>

            <?php
                if (isset($_POST['btn_add'])) {
                    getCartsItem($user_id);
            ?>
                <div class="col-4 mt-4 ">
                    <table class="table table-hover align-middle">
                        <thead class="small table-primary text-center">
                            <tr>
                                <th>Date</th>
                                <th>Stock Quantity</th>
                                <th>Sold Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><?=$cart_item['add_item_date']?></td>
                                <td><?=$item['quantity']?></td>
                                <td><?=$cart_item['quantity']?></td>
                            </tr>
                            <?php
                                // $total_price = $item['item_price'] * $_POST['quantity'];
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php
                                    $total_price = $item['item_price'] * $cart_item['quantity'];
                                ?>
                                <th></th>
                                <th colspan="2" class="text-center">Total Price:  $<span class="text-danger h5 fw-bolder"><?=$total_price?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="#" method="post" class="text-center">
                        <button type="submit" name="btn_purchase" class="btn btn-primary fw-bold w-50">Purchase</button>
                    </form>
                </div>      
            <?php      
                }
            ?>
            
        </div>
     </main>


    

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>