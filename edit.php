<?php
session_start();
require_once 'db.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $subject = $_POST['subject'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $hour = $_POST['hour'];
    $lecturer = $_POST['lecturer'];
    $description = $_POST['description'];

    $sql = $conn->prepare("UPDATE courses SET subject = :subject, title = :title, price = :price, hour = :hour, lecturer = :lecturer, description = :description WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->bindParam(':subject', $subject);
    $sql->bindParam(':title', $title);
    $sql->bindParam(':price', $price);
    $sql->bindParam(':hour', $hour);
    $sql->bindParam(':lecturer', $lecturer);
    $sql->bindParam(':description', $description);
    $sql->execute();
    
    if ($sql){
        $_SESSION['success'] = 'Updated successfully';
        header('location: index.php');
    }else {
        $_SESSION['error'] = 'Updated successfully';
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
<meta charset='UTF-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='viewport' content="width=device-width initial-scale=1.0">
<title>CRUD-app</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
    .container {
        max-width: 550px;
    }
</style>
</head>

<body>
    <div class='container mt-5'>
        <h1>Edit Data</h1>
        <hr>
        <form action='edit.php' method='post'>
            <?php
                if (isset($_GET['id']));
                $id = $_GET['id'];
                $stmt = $conn->query("SELECT * FROM courses WHERE id = $id");
                $stmt->execute();
                $data = $stmt->fetch();
            ?>
            <input hidden value='<?= $data['id']; ?>' name='id'>
            <label for="title" class="col-form-label">Subject/Title:</label>
            <div class="input-group">
                <select class='btn btn-outline-secondary' required name='subject'>
                    <option selected value='<?= $data['subject']; ?>'><?= $data['subject']; ?></option>
                    <option value="Biology">Biology</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Physics">Physics</option>
                    <option value="Mathematics">Mathematics</option>
                </select>
                <div class="input-group-append">
                    <input type="text" required value='<?= $data['title']; ?>' class="form-control" name='title'>
                </div>
            </div>
            <div class="mb-3">
                <label for="price" required class="col-form-label">Price:</label>
                <div class='input-group'>
                    <div class="input-group-prepend">
                        <span class="input-group-text">฿</span>
                    </div>
                    <input type="number" required value='<?= $data['price']; ?>' min='0' max='10000' step='100' class="form-control" name='price'>
                </div>
            </div>
            <div class="mb-3">
                <label for="hour" class="col-form-label">Hour:</label>
                <input type="number" required value='<?= $data['hour']; ?>' min='0' max='100' class="form-control" name='hour'>
            </div>
            <div class="mb-3">
                <label for="lecturer" class="col-form-label">Lecturer:</label>
                <input type="text" required value='<?= $data['lecturer']; ?>' class="form-control" name='lecturer'>
            </div>
            <div class="mb-3">
                <label for="description" class="col-form-label">Description:</label>
                <textarea class="form-control" name='description' rows="5"><?= $data['description']; ?></textarea>
            </div>
         
            <div class="modal-footer">
                <a class="btn btn-secondary" href='index.php'>Go Back</a>
                <button type="submit" name='update' class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
