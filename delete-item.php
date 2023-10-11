<?php
    session_start();
    require "connection.php";

    $id = $_GET['id'];

    $item = getItem($id);

    function getItem($id)
    {
        $conn = connection();
        $sql = "SELECT * FROM items WHERE id = $id";

        if($result = $conn->query($sql)) {
            return $result->fetch_assoc();
        }else {
            die("Error in retrieving item details. " . $conn->error);
        }
    }

    if(isset($_POST['btn_delete'])) {
        $id = $_GET['id'];

        deleteItem($id);
    }

    function deleteItem($id)
    {
        $conn = connection();
        $sql = "DELETE FROM items WHERE id = $id";

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
    <title>Delete Item</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        // include('main-nav.php');
    ?>
   
   <main class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-3">
            <div class="mb-3 text-center">
                <i class="fa-solid fa-triangle-exclamation text-warning display-4"></i>
                <h2 class="fw-light mb-3 text-center fw-bold">Delete Item</h2>
                <p class="mb-0 fw-bold">Are you sure you want to delete "<span class="text-danger h4"><?=$item['item_name']?></span>"?</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="view-items.php" class="btn btn-outline-secondary w-100">Cancel</a>
            </div>
            <div class="col">
                <form action="#" method="post">
                    <button type="submit" name="btn_delete" class="btn btn-danger w-100">Delete</button>
                </form>
            </div>
        </div>
    </div>
    </main>

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>