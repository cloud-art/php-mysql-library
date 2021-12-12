<?php

require "rb.php";


R::setup('mysql:host=localhost; dbname=LIBRARY', 'kirill', '0609');

if (!R::testConnection()){
    exit ('Нет соединения с базой данных');

}

$genre = R::dispense("genre");


$genre->genre_name = "newganre";

R::store( $genre );

// $genre->genre_name = "новый жанр";

// R::store($book);



?>
