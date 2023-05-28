<?php
include 'connection.php';
$conn = openConnection();
global $conn;
global $results;
$query = 'select * from categories';
$stm = $conn->prepare($query);
$stm->execute();
$results = $stm->fetchAll();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $status = $_REQUEST['status'];
    $nameError = '';
    $statusError = '';
    if (!$namError && !$statusError) {
        try {
            $query = "insert into categories (name,description,status) values (:name,:description,:status)";
            $stm = $conn->prepare($query);
            $result = $stm->execute([":name" => $name, ":description" => $description, ":status" => $status]);
            if (!empty($result)) {
                header('location:index.php');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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
    <div class="container mx-auto row mt-5">
        <div class="col-md-4 border  rounded border-4 py-3">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="5"> </textarea>
                </div>
                <select class="form-select mb-3" aria-label="Default select example" name="status">
                    <option selected>Choose One</option>
                    <option value="0">Active</option>
                    <option value="1">Inactive</option>
                </select>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-8" >
            <table class="table table-success table-striped">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php

                    for ($i = 0; $i < count($results); $i++) {
                        echo "<tr>";
                        echo "<td>" . $results[$i]["id"] . "</td>";
                        echo "<td>" . $results[$i]["name"] . "</td>";
                        echo "<td>" . $results[$i]["description"] . "</td>";
                        echo "<td>" . (($results[$i]["status"] == 0) ? '<button class="btn btn-sm bg-success text-white rounded">Active</button>' : '<button class="btn btn-sm bg-danger text-white rounded">Inactive</button>') . "</td>";
                        echo '<td><a href="edit.php?id=' . htmlspecialchars($results[$i]['id']) . '" class="btn btn-info mx-1">Edit</a> <a class="btn btn-danger"  href="index.php?delete_id=' . htmlspecialchars($results[$i]['id']) . '"  >  Delete</a></td>';
                        echo "</tr>";
                    }
                    ?>
                    <tr></tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
    if(isset($_GET['delete_id'])){
       $id = $_GET['delete_id'];
       $query = "DELETE FROM categories WHERE id=:id";
       $statement = $conn->prepare($query);
       $data = [':id' => $id];
       $statement->execute($data);
       header('location:index.php');
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>