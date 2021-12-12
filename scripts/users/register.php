<?php
        require("../../database.php");
        if (isset($_POST["username"]) && isset($_POST["password"])){
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // $query = "INSERT INTO Users (login, email, password) VALUES ('$login', '$email', '$password')";
            $query = "SELECT * FROM Users";
            $result = mysqli_query($link, $query);

            if($result){
                $succmsg = "Вы успешно зарегестрировались";
            } else {
                $failmsg = "Ошибка";
            }
        }

    ?>