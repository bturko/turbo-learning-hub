<?php
namespace TLH\MySqlConnecting;

class MySqlConnecting {

    private $dbh;
    //private $link;

    public function getDBH(){
        return $this->dbh;
    }
    public function createDbConnection($conf, $pdo){
        //$pdo->exec("SET NAMES 'utf8';");
        $this->dbh = new \PDO('mysql:host=localhost;dbname='.$conf->db_name, $conf->db_username, $conf->db_password);
    }

    /**
     * @param $conf
     * @return PDO
     */
    public function setConnection( $conf ){
        //if( $_SERVER['HTTP_HOST']=="localhost" ){
            //$link = mysql_connect('localhost', 'root', '');
            $this->dbh = new \PDO('mysql:host=localhost;dbname='.$conf->db_name, $conf->db_username, $conf->db_password);
        //}*/

        /*if (!$link) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $db_selected = mysql_select_db('clh', $link);
        if (!$db_selected) {
            die ('Не удалось выбрать базу: ' . mysql_error());
        }
        $this->link = $link;*/
        return $this->dbh;
    }

    /**
     *
     */
    public function connClose(){
        //mysql_close($this->link);
    }

    public function checkDBConnection($sheme_name, $conf){
        $sql ="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$sheme_name."'; ";
        try {
            //
            $pdo = new \PDO('mysql:host=localhost;dbname='.$conf->db_name, $conf->db_username, $conf->db_password);
            //var_dump($pdo);
            $pdo->exec($sql);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        if($this->dbh->query($sql)->fetchColumn() < 1){
            echo "Ok";
        }
        else{
            echo "No";
        }


        /*    $result = mysql_query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  'clh'");
        if ($result) {
            if(mysql_num_rows($result) > 0)
        }
        else{
            echo "Ошибка!";
        }*/
    }
} 