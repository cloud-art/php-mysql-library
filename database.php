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

require "rb.php";

R::setup('mysql:host=localhost; dbname=LIBRARY', 'kirill', '0609');

if (!R::testConnection()){
    exit ('Нет соединения с базой данных');

}



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
        $query =    "SELECT books.id, book_name, specs, writing_date, authors.full_name as book_author, genre.genre_name as book_genre 
                    FROM `books` INNER JOIN authors on books.author=authors.id INNER JOIN genre on books.genre=genre.id;";
        $table = mysqli_query($this->link,$query);
        $table = mysqli_fetch_all($table);
        return $table;

    }

    public function get_books_fields(){
        $query =    "SELECT books.id, book_name, specs, writing_date, authors.full_name as book_author, genre.genre_name as book_genre 
                    FROM `books` INNER JOIN authors on books.author=authors.id INNER JOIN genre on books.genre=genre.id;";
        $table = mysqli_query($this->link,$query);
        $table = mysqli_fetch_fields($table);
        return $table;
    }

    public function get_comments_by_book_id($book_id){
        $query = "SELECT comments.id, login, book_id, comment FROM comments WHERE book_id='$book_id'";
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
            $table = R::dispense("$table_name");
            
            if ($table_name == 'authors'){
                $table->full_name = $_POST['full_name'];
                $table->birthday = $_POST['birthday'];
                $table->death_day = $_POST['death_day'];

                
            }else if ($table_name == 'books'){
                $table->book_name = $_POST['book_name']; 
                $table->specs = $_POST['specs'];
                $table->writing_date = $_POST['writing_date'];
                $table->author = $_POST['author']; 
                $table->genre = $_POST['genre']; 

                    
            }else if ($table_name == 'genre'){
                $table->genre_name = $_POST['genre_name'];


            }
            $res = R::store($table);
            if($res){            
                header("Location: ".$_SERVER['REQUEST_URI']);
            }else{
                echo "Error";   
            }
        }
    }

    public function query_delete_row($table_name, $id){
        $table = R::load("$table_name", $id);
        $res = R::trash($table);
        return $res;
    }

    public function query_update_row($table_name, $id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $table = R::load("$table_name", $id);
            if ($table_name == 'authors'){

                $table->full_name = $_POST['full_name'];
                $table->birthday = $_POST['birthday'];
                $table->death_day = $_POST['death_day'];

            }else if ($table_name == 'books'){

                $table->book_name = $_POST['book_name']; 
                $table->specs = $_POST['specs'];
                $table->writing_date = $_POST['writing_date'];
                $table->author = $_POST['author']; 
                $table->genre = $_POST['genre']; 
            }else if ($table_name == 'genre'){

                $table->genre_name = $_POST['genre_name'];
            }
        }

            
        $res = R::store($table);
        return $res;
    }

    public function query_add_newuser($login, $email, $password){
        $query = "INSERT INTO `Users` (`login`, `email`, `password`) VALUES ('$login', '$email', '$password');";
        $query= mysqli_query($this->link, $query);
        return $query;
    }

    public function query_add_comment($login, $book_id, $comment){
        $id = $this->query_select_last_id("comments");
        $id = $id[0][0]+1;
        $query="INSERT INTO `comments` (`id`, `login`, `book_id`, `comment`) VALUES ('$id', '$login', '$book_id','$comment');";
        $query = mysqli_query($this->link, $query);
        return $query;
    }

    public function query_select_last_id($table_name){
        $query="SELECT id FROM `$table_name` ORDER BY id DESC LIMIT 0,1;";
        $query = mysqli_query($this->link, $query);
        $query = mysqli_fetch_all($query);
        return $query;
    }

    public function print_comments_link($id){
        ?>
            <a href="//localhost/lab2/templates/comments.php?id=<?= $id?>" style="padding-right: 20px;">Комментарии</a>
        <?php
    }

    public function print_table($table_name){
        if ($table_name == "books"){
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
                        
                        if ($table_name == "books"){ ?>
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
        $id = $this->query_select_last_id($table_name);
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
                                <input name="<?=$field->name?>" value="<?=$id[0][0]+1 ?>" readonly> <br>
                                <?php
                                }else if($field->name == "specs"){
                                    ?>
                                    <label for="#"><?=$field->name ?></label>
                                    <textarea class="form-control" name="<?=$field->name ?>" rows="5" id="<?=$field->name ?>"></textarea> <br>
                                    <?php
                                }else if($table_name == "books" && ($field->name == "author") or ($field->name == "genre")){
                                    if ($field->name == "author"){
                                        $rows = $this->get_table_fetch_all("authors");
                                    }else if ($field->name == "genre"){
                                        $rows = $this->get_table_fetch_all("genre");
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
                }else if($table_name == "books" && ($field->name == "author") or ($field->name == "genre")){
                    if ($field->name == "author"){
                        $tmprows = $this->get_table_fetch_all("authors");
                    }else if ($field->name == "genre"){
                        $tmprows = $this->get_table_fetch_all("genre");
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