<?php
// define("MYSQL_SERVER", "localhost");
// define("MYSQL_USER","kirill");
// define("MYSQL_PASSWORD","0609");
// define("MYSQL_DB","LIBRARY");
// function db_connect(){
//     $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
//     or die("Error: ".mysqli_error($link));
//     return $link;
// }

class Database{
    public string $db_server = "localhost";
    public string $db_user = "kirill";
    public string $db_password = "0609";
    public string $db_name = "LIBRARY";
    public $link;

    public function __construct($db_server, $db_user, $db_password, $db_name){
        $this->db_server = $db_server;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
        $this->db_name = $db_name;
        $this->link = mysqli_connect($this->db_server, $this->db_user, $this->db_password, $this->db_name)
    or die("Error: ".mysqli_error($this->link));
    }

    public function get_table_fetch_all($table_name){
        $table = mysqli_query($this->link,"SELECT * FROM $table_name" );
        $table = mysqli_fetch_all($table);
        return $table;
    }

    public function get_table_fetch_assoc($table_name){
        $table = mysqli_query($this->link,"SELECT * FROM $table_name" );
        $table = mysqli_fetch_assoc($table);
        return $table;
    }

    public function get_table_fields($table_name){
        $table = mysqli_query($this->link,"SELECT * FROM $table_name" );
        $table = mysqli_fetch_fields($table);
        return $table;
    }

    public function get_row_by_id($table_name, $id){
        $row = mysqli_query($this->link,"SELECT * FROM $table_name WHERE `id`=$id" );
        $row = mysqli_fetch_assoc($row);
        return $row;
    }

    public function get_books_fetch_all(){
        $query =    "SELECT Books.id, book_name, specs, writing_date, Authors.full_name as book_author, Genre.genre_name as book_genre 
                    FROM `Books` INNER JOIN Authors on Books.author=Authors.id INNER JOIN Genre on Books.genre=Genre.id;";
        $table = mysqli_query($this->link,$query);
        $table = mysqli_fetch_all($table);
        return $table;

    }

    public function get_books_fields(){
        $query =    "SELECT Books.id, book_name, specs, writing_date, Authors.full_name as book_author, Genre.genre_name as book_genre 
                    FROM `Books` INNER JOIN Authors on Books.author=Authors.id INNER JOIN Genre on Books.genre=Genre.id;";
        $table = mysqli_query($this->link,$query);
        $table = mysqli_fetch_fields($table);
        return $table;
    }

    public function get_comments_by_book_id($book_id){
        $query = "SELECT Comments.id, login, book_id, comment FROM Comments WHERE book_id='$book_id'";
        $comments = mysqli_query($this->link, $query);
        $comments = mysqli_fetch_all($comments);
        return $comments;

    }

    public function query_get_user_by_pass($table_name, $login, $password){
        $query = "SELECT * FROM `$table_name` WHERE `login`='$login' AND `password`='$password'";
        $query = mysqli_query($this->link, $query);
        return $query;
    }

    public function query_add_row($table_name){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if ($table_name == 'Authors'){
                $id = $_POST['id'];
                $full_name = $_POST['full_name'];
                $birthday = $_POST['birthday'];
                $death_day = $_POST['death_day'];

                $query="INSERT INTO `$table_name` (`id`, `full_name`, `birthday`, `death_day`) VALUES ('$id', '$full_name', '$birthday', '$death_day');";
            }else if ($table_name == 'Books'){
                $id = $_POST['id'];
                $book_name = $_POST['book_name']; 
                $specs = $_POST['specs'];
                $writing_date = $_POST['writing_date'];
                $author = $_POST['author']; 
                $genre = $_POST['genre']; 

                $query="INSERT INTO `$table_name` (`id`, `book_name`, `specs`,`writing_date`,`author`,`genre`) VALUES ('$id', '$book_name','$specs','$writing_date','$author','$genre');";    
            }else if ($table_name == 'Genre'){
                $id = $_POST['id'];
                $genre_name = $_POST['genre_name'];

                $query="INSERT INTO `$table_name` (`id`, `genre_name`) VALUES ('$id', '$genre_name');";
            }
            $res = mysqli_query($this->link, $query);
            if($res){            
                header("Location: ".$_SERVER['REQUEST_URI']);
            }else die("Error: ".mysqli_error($this->link));
        }
    }

    public function query_delete_row($table_name, $id){
        $query="DELETE FROM $table_name WHERE id='$id';";
        $query = mysqli_query($this->link, $query);
        return $query;
    }

    public function query_update_row($table_name, $id){
        $query = "";
        if ($table_name == 'Authors'){
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $birthday = $_POST['birthday'];
            $death_day = $_POST['death_day'];

            $query="UPDATE `$table_name` SET `id`='$id' ,`full_name` = '$full_name',`birthday`='$birthday',`death_day`='$death_day' WHERE `$table_name`.`id` = '$id'";
        }else if ($table_name == 'Books'){
            $id = $_POST['id'];
            $book_name = $_POST['book_name']; 
            $specs = $_POST['specs'];
            $writing_date = $_POST['writing_date'];
            $author = $_POST['author']; 
            $genre = $_POST['genre']; 
            // echo $id;
            // echo $book_name;
            // echo $specs;
            // echo $writing_date;
            // echo $author;
            // echo $genre;

            $query = "UPDATE `$table_name` SET `id`='$id' ,`book_name` = '$book_name',`specs`='$specs',`writing_date`='$writing_date',`author`='$author',`genre`='$genre' WHERE `$table_name`.`id` = '$id'";
        }else if ($table_name == 'Genre'){
            $id = $_POST['id'];
            $genre_name = $_POST['genre_name'];

            $query="UPDATE `$table_name` SET `id`='$id' ,`genre_name` = '$genre_name' WHERE `$table_name`.`id` = '$id'";
        }

            
        return $query;
    }

    public function query_add_newuser($login, $email, $password){
        $query = "INSERT INTO `Users` (`login`, `email`, `password`) VALUES ('$login', '$email', '$password');";
        $query= mysqli_query($this->link, $query);
        return $query;
    }

    public function query_add_comment($login, $book_id, $comment){
        $query="INSERT INTO `Comments` (`login`, `book_id`, `comment`) VALUES ('$login', '$book_id','$comment');";
        $query = mysqli_query($this->link, $query);
        return $query;
    }

    public function print_comments_link($id){
        ?>
            <a href="//localhost/lab2/templates/comments.php?id=<?= $id?>" style="padding-right: 20px;">Комментарии</a>
        <?php
    }

    public function print_table($table_name){
        if ($table_name == "Books"){
            $table = $this->get_books_fetch_all();
            $fields = $this->get_books_fields();
        }else{
            $table = $this->get_table_fetch_all($table_name);
            $fields = $this->get_table_fields($table_name);
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                <?php
                foreach ($fields as $field){
                    ?>
                        <td> <?= $field->name?> </td>
                    <?php
                }
                ?>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach($table as $row){
                ?>
                    <tr>
                        <?php for($i=0; $i <= count($row); $i++){ ?>
                            <td><?= $row[$i]?></td>
                        <?php
                        }
                        
                        if ($table_name == "Books"){ ?>
                            <td> <?php $this->print_comments_link($row[0]) ?> </td>
                        <?php
                        }

                        if ($_SESSION['user']['admin'] == 1){
                        ?>
                        <td>
                            <a type="button" class="btn btn-success" href="//localhost/lab2/templates/update.php?id=<?= $row[0]?>&table_name=<?= $table_name?>">Изменить</a>
                            <a type="button" class="btn btn-danger" href="//localhost/lab2/scripts/delete.php?id=<?= $row[0]?>&table_name=<?= $table_name?>">Удалить</a>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
                <?php
                
                ?>
            </tbody>
        </table>
        <?php
    }

    public function print_add_form($table_name){
        $table = $this->get_table_fetch_all($table_name);
        $fields = $this->get_table_fields($table_name);
        ?>
        <!-- Button trigger modal update -->
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAdd">
            Добавить
        </button>
        <!-- Modal Update  -->
        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-md-3">

                            </div>
                        <div class="col-md-4">
                        <form method="POST" action="<?=$_SERVER['PHP_SELF'] ?>">
                            <label>Table</label>
                            <input name="table_name" value="<?=$table_name ?>" readonly>

                            <?php
                            foreach ($fields as $field){
                                if ($field->name == "id"){
                            ?>
                                <label> <?= $field->name?></label>
                                <input name="<?=$field->name?>" value="<?=count($table)+1 ?>"> <br>
                                <?php
                                }else if($field->name == "specs"){
                                    ?>
                                    <label for="#"><?=$field->name ?></label>
                                    <textarea class="form-control" name="<?=$field->name ?>" rows="5" id="<?=$field->name ?>"></textarea> <br>
                                    <?php
                                }else if($table_name == "Books" && ($field->name == "author") or ($field->name == "genre")){
                                    if ($field->name == "author"){
                                        $rows = $this->get_table_fetch_all("Authors");
                                    }else if ($field->name == "genre"){
                                        $rows = $this->get_table_fetch_all("Genre");
                                    }

                                    ?>
                                    <label for="#"><?=$field->name?></label>
                                    <select name="<?=$field->name?>" id="<?=$field->name?>">
                                        <?php
                                        foreach($rows as $row){
                                        ?>
                                            <option value="<?= $row[0]?>"><?= $row[1]?></option>
                                        <?php
                                        }
                                        ?>
                                    </select> <br>
                                    <?php
                                }else{
                                ?>
                                <label> <?= $field->name?></label>
                                <input name="<?=$field->name?>" value="" type="<?php
                                                                                if ($field->name == "birthday" or 
                                                                                $field->name == "death_day" or
                                                                                $field->name == "writing_date"){
                                                                                    echo "date";
                                                                                }
                                                                                ?>">
                                    <br>   
                                <?php
                                }
                            }
                            ?>
                            

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

    public function print_update_form($table_name, $id){
        $row = $this->get_row_by_id($table_name, $id);
        $fields = $this->get_table_fields($table_name);
        $last_url = $_SERVER['HTTP_REFERER'];
        ?>

        <form method="POST" action="//localhost/lab2/scripts/update.php">
            <label>Table</label>
            <input name="table_name" value="<?=$table_name ?>" readonly> <br>
            <?php
            foreach ($fields as $field){
                if($field->name == "specs"){
                    ?>
                    <label for="#"><?=$field->name ?></label>
                    <textarea class="form-control" name="<?=$field->name ?>" rows="5"><?=$row[$field->name] ?></textarea> <br>
                    <?php
                }else if($table_name == "Books" && ($field->name == "author") or ($field->name == "genre")){
                    if ($field->name == "author"){
                        $tmprows = $this->get_table_fetch_all("Authors");
                    }else if ($field->name == "genre"){
                        $tmprows = $this->get_table_fetch_all("Genre");
                    }
                    ?>
                    <label for="#"><?=$field->name?></label>
                    <select name="<?=$field->name?>" id="<?=$field->name?>">
                        <?php
                        foreach($tmprows as $tmprow){
                        ?>
                            <?php if ($tmprow[0] == $row[$field->name]){?>
                                <option selected value="<?= $tmprow[0]?>"><?= $tmprow[1]?></option>
                            <?php }else{?>
                                <option value="<?= $tmprow[0]?>"><?= $tmprow[1]?></option>
                            <?php }?>
                        <?php
                        }
                        ?>
                    </select> <br>
                    <?php
                }else{
                ?>
                <label> <?= $field->name?></label>
                <input name="<?=$field->name?>" value="<?=$row[$field->name] ?>" type="<?php
                                                                if ($field->name == "birthday" or 
                                                                $field->name == "death_day" or
                                                                $field->name == "writing_date"){
                                                                    echo "date";
                                                                }
                                                                ?>">
                    <br>   
                <?php
                }
            }
            ?>
            <input type="hidden" name="last_url" value="<?=$last_url ?>" />
            <input type="submit" value="Save"/>
        </form>
        <?php
    }
    

};

$library_db = new Database("localhost", "kirill", "0609", "LIBRARY"); // если много пользователей, то для каждого на нашем сервере будет создаваться объект класса?

?>