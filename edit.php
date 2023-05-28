<?php
include 'connection.php';
$conn = openConnection();
global $conn;
// global $results;
// $query = 'select * from categories where id=';
// $stm = $conn->prepare($query);
// $stm->execute();
// $results = $stm->fetchAll();
if (($_SERVER['REQUEST_METHOD'] == "POST")) {
    $id =  $_GET['id'];
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $status = $_REQUEST['status'];
    $query = "UPDATE `categories` SET `name`=:name,`description`=:description,`status`=:status WHERE `id` = :id";
    $pdoResult = $conn->prepare($query);
    $pdoExec = $pdoResult->execute(array(":name" => $name, ":description" => $description, ":status" => $status, ":id" => $id));

    if ($pdoExec) {
        header('location:index.php');
    } else {
        echo 'ERROR Data Not Updated';
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>PHP Project</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Form</h1>
        <div class="border  rounded border-4 py-3 col-md-6 mx-auto px-4">
         <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "SELECT * FROM categories WHERE id=:id LIMIT 1";
                $statement = $conn->prepare($query);
                $data = [':id' => $id];
                $statement->execute($data);
                $dd = $statement->fetch(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
               
               
            }
            ?> 
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $dd->name; ?>" >
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="5" value="<?= $dd->description; ?>"><?= $dd->description; ?></textarea>
                </div>
                <select class="form-select mb-3" aria-label="Default select example" name="status">
                    <option selected  value="<?= $dd->status; ?>">Choose One</option>
                    <option  value="0">Active</option>
                    <option value="1">Inactive</option>
                </select>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>