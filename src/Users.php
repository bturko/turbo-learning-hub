<?php
namespace TLH\Users;
/**
 * Class Users
 * @package TLH\Users
 */
class Users {


    /**
     *
     */
    public function getCrenditles($pdo){
        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql="SELECT `login`, `password`, `fio`, `admin`  FROM `users` LIMIT 0, 999; ";
            $crenditles = "[ ";
            foreach($pdo->query($sql) as $row){
                $crenditles .= '{"login": "'.$row['login'].'", "fio": "'.$row['fio'].'", "password": "'.$row['password'].'", "role": "'.$row['admin'].'"},';
            }
            $crenditles = substr($crenditles, 0, strlen($crenditles ) - 1);
            $crenditles .= "]";
            $res = '{"status": "Ok", "message": "", "crenditles": '.$crenditles.'}';
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }


         /*   $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `login`, `password`, `fio`, `admin`  FROM `users` LIMIT 0, 999;");
        if ($result) {
            $crenditles = "[ ";
            while($row = mysql_fetch_array($result)){
                $crenditles .= '{"login": "'.$row['login'].'", "fio": "'.$row['fio'].'", "password": "'.$row['password'].'", "role": "'.$row['admin'].'"},';
            }
            $crenditles = substr($crenditles, 0, strlen($crenditles ) - 1);
            $crenditles .= "]";
            $res = '{"status": "Ok", "message": "", "crenditles": '.$crenditles.'}';
        }
        else{
            $res = '{"status": "error", "message": "sql error"}';
        }*/
        return $res;
    }

    /**
     * @param $_REQUEST
     */
    public function createUser($_REQUESTs){
        $login = htmlspecialchars($_REQUESTs["login"]);
        $password = htmlspecialchars($_REQUESTs["password"]);
        $fio = htmlspecialchars($_REQUESTs["fio"]);

        $result = mysql_query("SELECT count(*) AS CNT FROM `users` WHERE `login`= '$login' ;");
        $row = mysql_fetch_array($result);
        if ($row['CNT'] > 0) {
            echo '{"status": "Error", "message": "Пользователь с таким логином уже существует"}';
            //mysql_close($link);
            return;
        }

        if($login=="" || $password==""){
            echo '{"status": "Error", "message": "Не переданы все данные!"}';
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("INSERT INTO `users` (`login`, `password`, `fio`, `creation_date`) VALUES ('".$login."','".sha1($password)."', '$fio', NOW());");
            if ($result) {
                echo '{"status": "Ok", "message": "Ok"}';;
            }
            else{
                echo '{"status": "Error", "message": "Возникла ошибка при сохранении в базу данных!"}';
            }
        }
    }

    public function getUsersList(){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `login`, `password`, `fio`, `admin` FROM `users` ; ");
        if ($result) {
            echo '<table class="table table-striped" style="border: 1px solid white"><tr>
                   <th width="5%">№</th>
                   <th>Логин</th>
                   <th>ФИО</th>
                   <th>Действия</th>
               </tr>';
            $i=0;
            $admin_str = '&nbsp;<div href="#" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-user"></span> админ</div>';
            while ($row = mysql_fetch_array($result)) {
                $i++;
                echo  '<tr>
                   <td width="5%">'.$i.'</td>
                   <td>'.$row["login"];
                if($row["admin"] > 0) echo $admin_str;
                echo '</td>
                   <td>'.$row["fio"].'</td>
                   <td width="220px">
                    <a onclick="userVM.get_user('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать вопрос"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                    <a onclick="remove_user('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить вопрос"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                   </td>
               </tr>';
            }
            echo '</table>';
        }
        else{
            echo "Ошибка!";
        }
    }

    public function removeUser($_REQUESTs){
        $user_id = htmlspecialchars($_REQUESTs["user_id"]);

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("DELETE FROM `users` WHERE `id`= ".$user_id." ;");
        if ($result) {
            echo '{"status": "removed"}';
        }
        else{
            echo '{"status": "error"}';
        }
    }

    public function updateUser($_REQUESTs){
        $user_id = htmlspecialchars($_REQUESTs["user_id"]);
        $login = htmlspecialchars($_REQUESTs["login"]);
        $password = htmlspecialchars($_REQUESTs["password"]);
        $fio = htmlspecialchars($_REQUESTs["fio"]);

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("UPDATE  `users` SET `login`='".$login."', `password`='".sha1($password)."', `fio`='".$fio."' WHERE `id` = ".$user_id." ;");
        if ($result) {
             $this->getUsersList();
        }
        else{
            //echo '{"status": "error"}';
        }
    }


    public function getUser($user_id){

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `login`, `password`, `fio`, `admin` FROM `users` WHERE `id` = ".$user_id." ;");
        if ($result) {
            $row = mysql_fetch_array($result);
            echo '{"status": "success", "login": "'.$row['login'].'", "password": "'.$row['password'].'", "fio": "'.$row['fio'].'", "admin": "'.$row['admin'].'"}';
        }
        else{
            echo '{"status": "error"}';
        }
    }

    public function getUserByLogin($login, $log, $pdo)
    {
        if($login==""){
            echo "Не передан параметр";
        }
        else{
            try{
                $pdo->exec("SET NAMES 'utf8';");
                $sql="SELECT * FROM `users` WHERE `login`='".$login."';";
                foreach($pdo->query($sql) as $row){
                    $res =  '{"status": "success", "login": "'.$row['login'].'", "role": "'.$row['admin'].'", "user_fio": "'.$row['fio'].'", "user_id": "'.$row['id'].'"}';
                }
               $log->v($row['id'], "sign in", $pdo);
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }

            /*$result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query(");
            if ($result) {
                $row = mysql_fetch_array($result);
                echo '{"status": "success", "login": "'.$row['login'].'", "role": "'.$row['admin'].'", "user_fio": "'.$row['fio'].'", "user_id": "'.$row['id'].'"}';
                $log->v($row['id'], "sign in");
            }
            else{
                echo '{"status": "error"}';
            }*/
            return $res;
        }
    }
} 