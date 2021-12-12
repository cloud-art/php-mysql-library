<?php
    function get_table_users($link){
        $users = mysqli_query($link,"SELECT * FROM `authors`" );
        $users = mysqli_fetch_all($users);
        return $users;
    }
?>