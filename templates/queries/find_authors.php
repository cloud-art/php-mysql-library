<?php
    require_once("../../database.php");
    require_once("../../scripts/queries/find_authors.php");

    $interval1 = $_POST["interval1"];
    $interval2 = $_POST["interval2"];
    // $interval1 = "1830-01-01";
    // $interval2 = "1940-01-01";
    $answers = find_authors($library_db->link, $interval1, $interval2);
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

    <title>find_authors</title>
</head>
<body>
    
    <div class="container-">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-5">
                <p style="font-size: large;">
                    Дата 1 = <?= $interval1?>
                    Дата 2 = <?= $interval2?>
                </p>
                <table>
                    
                        <thead>

                        <tr style="font-size:large;">
                            <th >id</td>
                            <th style="padding-left: 20px;">full_name</td>
                            <th style="padding-left: 20px;">birthday</td>
                            <th style="padding-left: 20px;">count(book_id)</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($answers as $answer){
                            ?>
                            <tr style="font-size:large;">
                            <td style=" font-size:large;"><?= $answer[0]?></td> 
                            <td style="padding-left: 20px;"><?= $answer[1]?></td> 
                            <td style="padding-left: 20px;"><?= $answer[2]?></td> 
                            <td style="padding-left: 20px;"><?= $answer[3]?></td>
                            </tr>
                        </tbody>
                    
                    <?php
                    }
                    ?>
                </table>
                <a href="../queries.php" type="button" class="btn btn-info" style="margin-top: 5vh;">Назад</a>
            </div>
        </div>
    </div>

</body>
</html>