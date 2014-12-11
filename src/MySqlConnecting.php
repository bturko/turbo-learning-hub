<?php


class MySqlConnecting {

    private $dbh;

    public function getDBH(){
        return$this->dbh;
    }
    public function connectDB($db_name, $user, $pass){

            $this->dbh = new PDO('mysql:host=localhost;dbname='.$db_name, $user, $pass);
            foreach($this->dbh->query('SELECT * from users LIMIT 0,1') as $row) {
                //print_r($row);
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
            $link = mysql_connect('localhost', 'clhusr', 'kzkzkzkzkz-Zcjkfcevf');
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