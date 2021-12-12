<?php
    require_once("../database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $last_url = $_POST['last_url'];
        $table_name = $_POST['table_name'];
        $id = $_POST['id'];

        $res = $library_db->query_update_row($table_name, $id);
        
        if($res){            
            header("Location: ".$last_url);
        }else die("Error");
    }
?>
