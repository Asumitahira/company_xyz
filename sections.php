<?php
    session_start();
    require "connection.php";

    if (isset($_POST['btn_submit'])) {
        $name = $_POST['name'];

        createSection($name);
    }
    function createSection($name)
    {
        $conn = connection();
        $sql = "INSERT INTO sections(`name`) VALUE('$name')";

        if ($conn->query($sql)) {
            header("refresh: 0");
        }else {
            die("Error adding new section " . $conn->error);
        }
    }

    function getAllSections()
    {
        $conn = connection();
        $sql = "SELECT * FROM sections";
        if ($result = $conn->query($sql)) {
            return $result;
        }else {
            die("Unable to retrieved records " . $conn->error);
        }
    }

    if (isset($_POST['btn_delete'])) {
        $section_id = $_POST['btn_delete'];
        deleteSection($section_id);
    }

    function deleteSection($section_id)
    {
        $conn = connection();
        $sql = "DELETE FROM sections WHERE id = $section_id";
        if ($conn->query($sql)) {
            header("refresh: 0");
        }else {
            die("Error in deleting section " . $conn->error);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections</title>
    <!-- Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        #include('main-nav.php');
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="fw-light mb-3">Sections</div>

                <div class="mb-3">
                    <!-- Form -->
                    <form action="#" method="post">
                        <div class="row gx-2">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Add a new section here..." max="50" required autofocus>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="btn_submit" class="btn btn-primary w-100 bw-bold"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </form>
                    <!-- table -->
                    <table class="table table-sm align-middle text-center mt-3">
                        <thead class="table-info">
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $all_sections = getAllSections();
                                while ($section = $all_sections->fetch_assoc()) {
                            ?>  
                                <tr>
                                    <td><?=$section['id']?></td>
                                    <td><?=$section['name']?></td>
                                    <td>
                                        <form action="#" method="post">
                                            <button type="submit" name="btn_delete" class="btn btn-outline-danger border-0" value="<?= $section['id'] ?>" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>     
                            <?php                
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    

<!-- Bootstrap  JS CDN Link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>