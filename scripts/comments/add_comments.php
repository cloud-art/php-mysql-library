<?php 
    session_start();
    require_once "../../database.php";

    $login = $_SESSION['user']['login'];
    $book_id = $_GET['book_id'];
    $comment = $_POST['comment'];

    $query = $library_db->query_add_comment($login, $book_id, $comment);
    if($query){
        header("Location: ../../templates/comments.php?id=$book_id");
    }
    else die("Error: ".mysqli_error($link));

?>
