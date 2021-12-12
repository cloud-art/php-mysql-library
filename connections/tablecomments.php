<?php
    function get_table_comments($link){
        $query = "SELECT comment_id, login, book_id, comment FROM Comments";
        $comments = mysqli_query($link, $query);
        $comments = mysqli_fetch_all($comments);
        return $comments;
    }

    function get_table_comments_of_book($link, $book_id){
        $query = "SELECT comment_id, login, book_id, comment FROM Comments WHERE book_id='$book_id'";
        $comments = mysqli_query($link, $query);
        $comments = mysqli_fetch_all($comments);
        return $comments;
    }

?>