<?php
session_start();
require_once 'db.php';
require_once 'delete.php';
?>

<!DOCTYPE html>
<html lang='en'>

<head>
<meta charset='UTF-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='viewport' content="width=device-width initial-scale=1.0">
<title>CRUD-app</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id='addForm' action='insert.php' method='post'>
            <label for="title" class="col-form-label">Subject/Title:</label>
            <div class="input-group">
                <select class='btn btn-outline-secondary' required name='subject'>
                    <option value=''>Choose...</option>
                    <option value="Biology">Biology</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Physics">Physics</option>
                    <option value="Mathematics">Mathematics</option>
                </select>
                <div class="input-group-append">
                    <input type="text" required class="form-control" name='title'>
                </div>
            </div>
            <!-- <div class="mb-3">
                <label for="title" class="col-form-label">Title:</label>
                <input type="text" required class="form-control" name='title'>
            </div> -->
            <div class="mb-3">
                <label for="price" class="col-form-label">Price:</label>
                <div class='input-group'>
                    <div class="input-group-prepend">
                        <span class="input-group-text">฿</span>
                    </div>
                    <input type="number" required min='0' max='10000' step='100' class="form-control" name='price'>
                </div>
            </div>
            <div class="mb-3">
                <label for="hour" class="col-form-label">Hour:</label>
                <input type="number" required min='0' max='100' class="form-control" name='hour'>
            </div>
            <div class="mb-3">
                <label for="lecturer" class="col-form-label">Lecturer:</label>
                <input type="text" required class="form-control" name='lecturer'>
            </div>
            <div class="mb-3">
                <label for="description" class="col-form-label">Description:</label>
                <textarea class="form-control" name='description' rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name='submit' class="btn btn-success">submit</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    </div>
    <div class='container mt-5'>
        <div class='row'>
            <div class='col-md-6'>
                <h1>Courses</h1>
            </div>
            <div class='col-md-6 d-flex justify-content-end'>
                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#courseModal' onclick='resetForm()'>Add Course</button>
            </div>
        </div>
        <hr>

        <p>Type something in the input field to search the table:</p>  
        <input class="form-control" id="myInput" type="text" placeholder="Search.."><br>

        <?php if (isset($_SESSION['success'])) { ?>
            <div class='alert alert-success response'>
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class='alert alert-danger'>
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
    </div>
    <div class='container' style='max-width: 1900px'>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Subject</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Hour</th>
            <th scope="col">Lecturer</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php
                $stmt = $conn->query('SELECT * FROM courses');
                $stmt->execute();
                $courses = $stmt->fetchAll();

                if (!$courses) {
                    echo "<tr><td colspan=8 class='text-center'>No courses found</td></tr>";
                }else{
                    foreach ($courses as $course) {
                        ?>
                        <tr>
                        <th scope="row"><?= $course['id']?></th>
                        <td><?= $course['subject']?></td>
                        <td><?= $course['title']?></td>
                        <td><?= $course['price']?> ฿</td>
                        <td><?= $course['hour']?></td>
                        <td><?= $course['lecturer']?></td>
                        <td style="word-wrap: break-word;min-width: 200px;max-width: 300px;"><?= $course['description']?></td>
                        <td width='150px'>
                            <a href='edit.php?id=<?= $course['id']; ?>' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='?delete=<?= $course['id']; ?>' class='btn btn-danger btn-sm' onclick="return confirm('Are you sure you want to delete?');" >Delete</a>
                        </td>
                        </tr>
                        <?php
                    }
                } 
            ?>
        </tbody>
    </table>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function resetForm() {
        document.getElementById("addForm").reset();
        }
    </script>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        $(".response").delay(1000).hide(1000);
    </script>

</body>

</html>