<?php
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM courses WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        $_SESSION['success'] = 'Deleted successfully';
        header('url=index.php');        
    }
}
?>