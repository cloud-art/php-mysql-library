<?php
    require_once("../../database.php");
    $keyword = $_POST["keyword"];
    $books = R::findAll('books','YEAR(writing_date) > 1989 AND YEAR(writing_date) < 2000');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <title>5_6</title>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-5">
                <p>
                    <?php
                        foreach($books as $row){ ?>
                        <ul>
                            <li> <?php echo $row->book_name ?> - <?php echo $row->writing_date ?></li>
                        </ul>
                            <?php
                        } ?>
                        
            </div>
            
            <div class="col-1">
                
            <a href="../queries.php" type="button" class="btn btn-info" style="margin-top: 5vh;">Назад</a>
               
            </div>
            
        </div>
    </div>

</body>
</html>