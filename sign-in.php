<?php
    require "connection.php";
    if (isset($_POST['btn_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        login($username,$password);
    }

    function login($username,$password)
    {
        $conn = connection();
        $sql = "SELECT * FROM users WHERE username = '$username'";

        if ($result = $conn->query($sql)){
            if($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                if(password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['id']         = $user['id'];
                    $_SESSION['username']   = $user['username'];

                    header("location: view-items.php");
                    exit;
                }else {
                    echo "<div class='alert alert-danger'>Incorrect Password</div>";
                }
            }else {
                echo "<div class='alert alert-danger'>Username not found</div>";
            }
        }else {
            die("Error retrieving the user. " . $conn->error);
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
<div style="height: 100vh">
        <div class="row h-100 m-0">
            <div class="card mx-auto w-25 my-auto p-0">
                <div class="card-header text-primary bg-white">
                    <h2 class="card-title text-center mb-0">Company XYZ</h2>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="submit" name="btn_login" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="sign-up.php" class="small"><i class="fa-solid fa-plus"></i> Create Account</a>
                    </div>
                </div>
            </div>
        </div>
   </div>
<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>