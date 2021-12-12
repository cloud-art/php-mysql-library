<?php 
    session_start();
    require_once "../../database.php";

    $login = $_SESSION['user']['login'];
    $book_id = $_GET['book_id'];
    $comment = $_POST['comment'];

    $res = $library_db->query_add_comment($login, $book_id, $comment);
    if($res){
        header("Location: ../../templates/comments.php?id=$book_id");
    }
    else{
        echo "Error: ".mysqli_error($link);
    }

    echo $_SESSION['user']['login'];
    echo $_GET['book_id'];
    echo $_POST['comment'];

?>
