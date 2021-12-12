<?php 
    function find_authors($link, $interval1, $interval2){
        if ($interval2 > $interval1){
            $query =    "SELECT Authors.id, full_name, birthday, COUNT(Books.id) as count 
                        FROM Authors LEFT JOIN Books on Authors.id = Books.author 
                        WHERE birthday >= '$interval1' AND birthday <= '$interval2' 
                        GROUP BY Authors.id;";
        }
        else{
            $query =    "SELECT Authors.id, full_name, birthday, COUNT(Books.id) as count 
                        FROM Authors LEFT JOIN Books on Authors.id = Books.author 
                        WHERE birthday >= '$interval2' AND birthday <= '$interval1' 
                        GROUP BY Authors.id;";
        }
        $answers = mysqli_query($link, $query);
        $answers = mysqli_fetch_all($answers);
        return $answers;
    }


?>