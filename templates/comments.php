<?php
    session_start();

    require_once("../database.php");

    $book_id=$_GET['id'];
    $book = $library_db->get_row_by_id('Books', $book_id);

    $comments = $library_db->get_comments_by_book_id($book_id);
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
                            <a href="./authors.php" class="nav-link text-white" aria-current="page">
                                <svg class="bi me-2" width="16" height="16"></svg>
                                Authors
                            </a>
                        </li>
                        <li>
                            <a href="./books.php" class="nav-link active">
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
            <table class="table">
                <thead>
                    <tr>
                        <th>Комментарии к книге: <?=$book['book_name'];?></th>

                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach($comments as $comment){
                ?>
                    <tr>
                        <td><?= $comment[1]?></td>
                        <td width="70%"><?= $comment[3]?></td>
                        <td>
                            <?php
                            if ($_SESSION['user']['admin'] == 1 or $_SESSION['user']['login']==$comment[1]){
                            ?> 
                                <a type="button" class="btn btn-danger" href="../scripts/comments/delete_comments.php?comment_id=<?= $comment[0]?>&book_id=<?= $book_id?>">Удалить</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            </div>

            <div class="col-1" style="margin-top: 4vh;">
                <!-- Button trigger modal update -->
                <?php
                if ($_SESSION['user']){
                ?>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAdd">
                    Добавить
                </button>
                            <!-- Modal Update -->
                <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="col-md-12">

                                <form method="POST" action="../scripts/comments/add_comments.php?book_id=<?=$book_id?>">

                                    <div style="text-align: center;"><h3>Комментарий</h3></div>
                                    <textarea class="form-control" name="comment" rows="5"></textarea> <br>

                                    <input type="submit" value="Save"/>
                                </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>
    </div>




</body>
</html>