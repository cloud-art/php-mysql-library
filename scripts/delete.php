<?php
    require_once("../database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];
    $table_name = $_GET['table_name'];

    $res = $library_db->query_delete_row($table_name, $id);
    if($res){        
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else die("Error: ".mysqli_error($this->link));
    }

?>
