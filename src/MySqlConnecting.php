<?php


class MySqlConnecting {
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