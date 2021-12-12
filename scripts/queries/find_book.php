<?php 
    function find_book($link, $genre_id, $author_id){
        $query="SELECT books.id, genre_name, full_name, book_name FROM books LEFT JOIN genre ON books.genre=genre.id LEFT JOIN authors ON books.author=authors.id WHERE genre='$genre_id' AND author='$author_id'";
        $answers = mysqli_query($link, $query);
        $answers = mysqli_fetch_all($answers);
        return $answers;
    }
?>
