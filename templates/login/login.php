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
session_start();
require_once('../../database.php');
$table_name = 'Users';
// $last_url = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $remember = $_POST['remember'];
    $login  = $_POST['login'];
    $password = $_POST['password'];
    $query = $library_db->query_get_user_by_pass($table_name, $login, $password);

    if ($query){
        $user= mysqli_fetch_assoc($query);
        $_SESSION['user']=[
            "id"=>$user['id'],
            "login"=>$user['login'],
            "email"=>$user['email'],
            "admin"=>$user['admin']
        ];
        if ($remember){
            setcookie('login', $login, time()+3600*24*7,'/');
            setcookie('password', $password, time()+3600*24*7,'/');
        }
        header('Location: ../index.php');
        
    }
    else{
        $failmsg = 'Неверный логин или пароль';
    }
}
?>

    <div class="container-fluid">
        <div class="row" style="padding-top: 200px;">
            <div class="col-5"></div>
            <div class="col-2">
                <?=$last_url ?>
                <form method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
                    <?php if(isset($failmsg)){?><div class="alert alert-danger" role="alert"> <?php echo $failmsg;?> </div> <?php }?>
                    <div class="form-group">
                    <label>Введите логин</label>
                    <input type="text" class="form-control" name="login">
                    <label>Введите пароль</label>
                    <input type="password" class="form-control" name="password">
                    <br>
                    </div>
                    <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label">Запомнить меня</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 loginBtn">Войти</button>
                    <a href="./registration.php">Зарегистрироваться</a> <br>
                    <a href="../index.php" >Войти как гость</a>
                </form>
            </div>
            <div class="col-5"></div>
        </div>
    </div>
</body>
</html>