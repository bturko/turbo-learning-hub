<?php


class MySqlConnecting {

    public function connectDB(){
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
            foreach($dbh->query('SELECT * from FOO') as $row) {
                print_r($row);
            }
            $dbh = null;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * @return resource
     */
    private $link;
    public function conn(){
        if( $_SERVER['HTTP_HOST']=="localhost" ){
            $link = mysql_connect('localhost', 'root', '');
        }
        else{
            $link = mysql_connect('localhost', '', '');
        }

        if (!$link) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $db_selected = mysql_select_db('clh', $link);
        if (!$db_selected) {
            die ('Не удалось выбрать базу: ' . mysql_error());
        }
        $this->link = $link;
        return $link;
    }

    /**
     *
     */
    public function connClose(){
        mysql_close($this->link);
    }
} 