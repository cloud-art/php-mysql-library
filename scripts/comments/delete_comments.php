<?php 
    require_once "../../database.php";

    $book_id = $_GET['book_id'];
    $comment_id = $_GET['comment_id'];
    $table_name = "comments";

    $res = $library_db->query_delete_row($table_name, $comment_id);
    if($res){
        header("Location: //localhost/lab2/templates/comments.php?id=$book_id");
    }
    else die("Error: ".mysqli_error($link));
?>
