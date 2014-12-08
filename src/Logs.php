<?php

//namespace src;

/**
 * Class Logs
 * @package src
 */
class Logs
{
    public function v($user_id, $text){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("INSERT INTO `logs`(`date`, `user_id`, `text`) VALUES (NOW(), $user_id, '$text')");
        if ($result) {

        }
        else{
            //echo "Ошибка!";
        }
    }

    public function showNotification($message, $type="normal"){
        $str="";
        switch($type){
            case "normal":
                $str = '<div class="alert alert-danger">'.str_replace("'","",htmlspecialchars($message)).'</div>';
                break;
            case "error":
                $str = '<div class="alert alert-danger"><strong>Ошибка!</strong> '.str_replace("'","",htmlspecialchars($message)).'</div>';
                break;
        }
        echo $str . PHP_EOL;
    }

}
?>