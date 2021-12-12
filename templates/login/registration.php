<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- static -->
    <link rel="stylesheet" href="../static/style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <title>Main</title>


</script>
</head>
<body>

<?php
require("../../database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["email"])){
        $errors=array();

        if(trim($_POST['login']) == '')
        {
            $errors[]='Поле для логина не может быть пустым';
        }
        if(trim($_POST['email']) == '')
        {
            $errors[]='Введите для почты не должно быть пустым';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)
        {
            $errors[]='Введите корректный Email!';
        }
        if(trim($_POST['password']) == '')
        {
            $errors[]='Поле для пароля не может быть пустым';
        }
        if(mb_strlen($_POST['password']) <= 4)
        {
            $errors[]='Пароль должен содержать минимум 5 символов';
        }
        if (!(preg_match("/[A-Z]+/", ($_POST['password']))))
        {
            $errors[]='В пароле отсутствуют буквы верхнего регистра';
        }
        if (!(preg_match("/[a-z]+/", ($_POST['password']))))
        {
            $errors[]='В пароле отсутствуют буквы нижнего регистра';
        }
        if (!(preg_match("/[0-9]+/", ($_POST['password']))))
        {
            $errors[]='В пароле отсутствуют цифры';
        }
        
        $logincheck=$_POST['login'];
        $check = mysqli_query($link, "SELECT * FROM `Users` WHERE `login`='$logincheck'");
            if (mysqli_num_rows($check)>0)
            {
                $errors[]='Пользователь с таким логином существует';
        }

        if (empty($errors)){
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // $query="INSERT INTO `Users` (`login`, `email`, `password`) VALUES ('$login', '$email', '$password');";
            $query = $library_db->query_add_newuser($login, $email, $password);

            if($query){
                $succmsg = "Вы успешно зарегестрировались";
            } else {
                $errors[]="Ошибка";}
        }   
    }
}
    ?>

    <div class="container-fluid">
        <div class="row" style="padding-top: 200px;">
            <div class="col-5"></div>
            <div class="col-2">
                <form method="POST">
                <?php if(isset($succmsg)){?><div class="alert alert-success" role="alert"> <?php echo $succmsg;?> </div> <?php }?>
                <?php if(isset($errors)){?><div class="alert alert-danger" role="alert"> 
                <?php foreach ($errors as $row){
                    echo $row . "<br>\r\n";
                }?> </div> <?php }?>
                
                <div class="form-group">
                  <label>Введите логин</label>
                  <input type="text" class="form-control" name="login">
                  <label>Введите email</label>
                  <input type="email" class="form-control" name="email">
                  <label>Введите пароль</label>
                  <input type="password" class="form-control" name="password">
                  <br>
                </div>
                <button type="submit" class="btn btn-primary w-100 loginBtn" name="sign_up">Зарегестрироваться</button>
                <a href="./login.php">Войти в аккаунт</a>
                </form>
            </div>
            <div class="col-5"></div>
        </div>
    </div>
</body>
</html>