<?php
    session_start();
    require_once("../database.php");

    $table_name = 'Authors';


?>

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

    

    <div class="container-fluid">
        <div class="row">
            <div class="col-2 p-0" style="height: 100vh">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="height: 100vh">
                    <a href="./index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32"></svg>
                        <span class="fs-4">LIBRARY</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="./authors.php" class="nav-link active" aria-current="page">
                                <svg class="bi me-2" width="16" height="16"></svg>
                                Authors
                            </a>
                        </li>
                        <li>
                            <a href="./books.php" class="nav-link text-white">
                                <svg class="bi me-2" width="16" height="16"></svg>
                                Books
                            </a>
                        </li>
                        <li>
                            <a href="./genre.php" class="nav-link text-white">
                                <svg class="bi me-2" width="16" height="16"></svg>
                                Genre
                            </a>
                        </li>
                        <li>
                            <a href="./queries.php" class="nav-link text-white">
                                <svg class="bi me-2" width="16" height="16"></svg>
                                Queries
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div> 
            </div>

            <div class="col-9">
            <?php    
                if ($_SESSION['user']['admin'] == 1){
                    $library_db->query_add_row($table_name);
                ?><?php
                }
            
                $library_db->print_table($table_name);
                ?>

            </div>
            <div class="col-1" style="margin-top: 4vh;">
                <?php
                    if ($_SESSION['user']['admin'] == 1){
                        $library_db->print_add_form($table_name)
                ?><?php
                    }
                ?>
            </div>

        </div>
    </div>




</body>
</html>