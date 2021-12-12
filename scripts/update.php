<?php
    require_once("../database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $last_url = $_POST['last_url'];
        $table_name = $_POST['table_name'];
        $id = $_POST['id'];

        $query = $library_db->query_update_row($table_name, $id);
        
        $res = mysqli_query($library_db->link, $query);
        if($res){            
            header("Location: ".$last_url);
        }else die("Error: ".mysqli_error($library_db->link));
    }
?>
