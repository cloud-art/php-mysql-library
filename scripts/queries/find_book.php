<?php 
    function find_book($link, $genre_id, $author_id){
        $query="SELECT Books.id, genre_name, full_name, book_name FROM Books LEFT JOIN Genre ON Books.genre=Genre.id LEFT JOIN Authors ON Books.author=Authors.id WHERE genre='$genre_id' AND author='$author_id'";
        $answers = mysqli_query($link, $query);
        $answers = mysqli_fetch_all($answers);
        return $answers;
    }
?>
