<?php
session_start();
require_once 'db.php';

if (isset($_POST['submit'])) { 
    $subject = $_POST['subject'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $hour = $_POST['hour'];
    $lecturer = $_POST['lecturer'];
    $description = $_POST['description'];

    $sql = $conn->prepare("INSERT INTO courses(subject, title, price, hour, lecturer, description) VALUES(:subject, :title, :price, :hour, :lecturer, :description)");
    $sql->bindParam(':subject', $subject);
    $sql->bindParam(':title', $title);
    $sql->bindParam(':price', $price);
    $sql->bindParam(':hour', $hour);
    $sql->bindParam(':lecturer', $lecturer);
    $sql->bindParam(':description', $description);
    $sql->execute();
    if ($sql){
        $_SESSION['success'] = 'Inserted successfully';
        header('location: index.php');
    }else {
        $_SESSION['error'] = 'Inserted unsuccessfully';
        header('location: index.php');
    }
}
?>