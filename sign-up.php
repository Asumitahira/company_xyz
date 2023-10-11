<?php
    require "connection.php";

    if (isset($_POST['btn_signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password == $confirm_password) {
            addUser($username, $password, $confirm_password);
        }else {
            echo "<P class='alert alert-danger'>Password and confirm password do not matched</p>";
        }
    }

    function addUser($username, $password, $confirm_password)
    {
        $conn = connection();
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(`username`, `password`) VALUES('$username', '$password')";

        if($conn->query($sql)) {
            header("location: sign-in.php");
            exit;
        }else {
            die("There is an error signing up. " . $conn->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-light">
    <div style="height: 100vh;">
        <div class="row h-100 m-0">
            <div class="card mx-auto w-25 my-auto p-0">
                <div class="card-header text-primary">
                    <h1 class="card-title h2 mb-0">Create Your Account</h1>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" maxlength="15" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password:</label>
                            <input type="password" name="password" id="password" class="form-control mb-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="confirm-password" class="form-label small fw-bold">Confirm Password:</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control" required>
                        </div>
                        <button type="submit" name="btn_signup" class="btn btn-primary w-100">Sign Up</button>
                    </form>
                    <div class="text-center p-3">
                        <p class="small">Already have an account? <a href="sign-in.php"><br><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
   
   

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>