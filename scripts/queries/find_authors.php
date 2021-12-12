<?php 
    function find_authors($link, $interval1, $interval2){
        if ($interval2 > $interval1){
            $query =    "SELECT authors.id, full_name, birthday, COUNT(books.id) as count 
                        FROM authors LEFT JOIN books on authors.id = books.author 
                        WHERE birthday >= '$interval1' AND birthday <= '$interval2' 
                        GROUP BY authors.id;";
        }
        else{
            $query =    "SELECT authors.id, full_name, birthday, COUNT(books.id) as count 
                        FROM authors LEFT JOIN books on authors.id = books.author 
                        WHERE birthday >= '$interval2' AND birthday <= '$interval1' 
                        GROUP BY authors.id;";
        }
        $answers = mysqli_query($link, $query);
        $answers = mysqli_fetch_all($answers);
        return $answers;
    }


?>