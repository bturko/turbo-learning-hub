<?php

namespace TLH\Logs;

/**
 * Class Logs
 * @package src
 */
class Logs
{
    public function v($user_id, $text, $pdo){
        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql="SELECT `login`, `password`, `fio`, `admin`  FROM `users` LIMIT 0, 999; ";
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $message
     * @param string $type
     */
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