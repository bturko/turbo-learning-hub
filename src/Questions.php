<?php

namespace TLH\Questions;

/**
 * Class Questions
 */
class Questions
{

    /**
     * @param $_REQUESTs
     * @param $pdo
     */
    public function addQuestion($_REQUESTs, $pdo){
        $test_id = htmlspecialchars($_REQUESTs["test_id"]);
        $text = htmlspecialchars($_REQUESTs["text"]);
        $opened = htmlspecialchars($_REQUESTs["var0"]);
        $var1 = htmlspecialchars($_REQUESTs["var1"]);
        $var2 = htmlspecialchars($_REQUESTs["var2"]);
        $var3 = htmlspecialchars($_REQUESTs["var3"]);
        $var4 = htmlspecialchars($_REQUESTs["var4"]);
        $rig_var = htmlspecialchars($_REQUESTs["rig_var"]);

        if($text=="" || $var1 ==""){
            echo "Не переданы параметры!";
        }
        else{
            $array = array($var1, $var2);
            if( $var3 != "" ) {array_push($array, $var3);}
            if( $var4 != "" ) {array_push($array, $var4);}
            $separated = implode("|", $array);
            try {
                $pdo->exec("SET NAMES 'utf8';");      // Sets encoding UTF-8
                $sql = "INSERT INTO `questions`(`test_id`, `text`, `opened`, `answers`, `right_answer`, `date_create`) VALUES ('$test_id','$text', $opened, '$separated','$rig_var', NOW()); ";
                $pdo->exec($sql);
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @param $_REQUESTs
     * @param $pdo
     */
    public function getQuestionsList($_REQUESTs, $pdo){
        $test_id = htmlspecialchars($_REQUESTs["test_id"]);

        if($test_id < 1){
            echo 'Ошибка!';
        }
        else{
            try {
                $pdo->exec("SET NAMES 'utf8';");
                $sql = "SELECT `id`, `test_id`, `text`, `answers`, `right_answer` FROM `questions` WHERE test_id=".$test_id.";";
                echo '<table class="table table-striped" style="border: 1px white solid;">
                    <tr>
                        <th style="border-right: 1px solid grey;">Вопрос</th>
                        <th >Действие</th>
                    </tr>
                ';
                foreach($pdo->query($sql) as $row){
                    echo  '<tr>
                      <td style="border-right: 1px grey solid;">'.$row["text"].'</td>
                      <td width="230px">
                        <a onclick="edit_que('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать вопрос"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                        <a onclick="remove_question('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить вопрос"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                        </td>
                    </tr>';
                }
                if($pdo->query($sql)->fetchColumn() < 1) {echo '<tr><td colspan=2">Пока вопросов нет</td></tr>';}
                echo '</table>';
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }



     /**
      * @param $que_id
      */
    public function getQuestionForEditing($que_id, $pdo){

        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql = "SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer`, `date_create` FROM `questions` WHERE id=".$que_id." ;";
            //$pdo->exec($sql);
            //$pdo = $pdo->prepare("select id from some_table where name = :name");
           // $pdo->exec($sql);
            //$row = $pdo->fetch();
            //var_dump($row);
            foreach($pdo->query($sql) as $row) {
                echo '{"status": "Ok", "id":' . $row["id"] . ', "test_id":' . $row["test_id"] . ', "text": "' . $row["text"] . '", "opened": "' . $row["opened"] . '","answers": "' . $row["answers"] . '", "right_answer": ' . $row["right_answer"] . '}';
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $_REQUEST
     */
    public function updateQuestion($_REQUESTs, $pdo){
        $q_id = htmlspecialchars($_REQUESTs["q_id"]);
        $test_id = htmlspecialchars($_REQUESTs["test_id"]);
        $text = htmlspecialchars($_REQUESTs["text"]);
        $opened = htmlspecialchars($_REQUESTs["opened"]);
        $var1 = htmlspecialchars($_REQUESTs["var1"]);
        $var2 = htmlspecialchars($_REQUESTs["var2"]);
        $var3 = htmlspecialchars($_REQUESTs["var3"]);
        $var4 = htmlspecialchars($_REQUESTs["var4"]);
        $rig_var = htmlspecialchars($_REQUESTs["rig_var"]);

        if($q_id=="" || $text=="" || $var1==""){
            echo "Ошибка! Не передан один или более параметров";
        }
        else{
            $array = array($var1, $var2);
            if( $var3 != "" ) {array_push($array, $var3);}
            if( $var4 != "" ) {array_push($array, $var4);}
            $separated = implode("|", $array);

            try {
                $pdo->exec("SET NAMES 'utf8';");
                $sql = "UPDATE `questions` SET `text`='$text', `opened`='$opened', `answers`='$separated', `right_answer`='$rig_var', `date_edit`=NOW() WHERE id = $q_id;";
                $pdo->exec($sql);
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
         }
    }

    public function removeQuestion($_REQUESTs, $pdo){
        $que_id = htmlspecialchars($_REQUESTs["que_id"]);

        if($que_id < 1){
            echo "Не передан требуемый параметр!";
        }
        else{
            try {
                $pdo->exec("SET NAMES 'utf8';");      // Sets encoding UTF-8
                $sql = "DELETE FROM `questions` WHERE id = :questionID; ";
                $pdo = $pdo->prepare($sql);
                $pdo->bindParam(':questionID', $que_id, PDO::PARAM_INT);
                $pdo->execute();
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
   }

    /**
     * @param $_REQUESTs
     */
    public function getTestQuestions($_REQUESTs, $pdo){
        $test_id = htmlspecialchars($_REQUESTs["test_id"]);
        $login = htmlspecialchars($_REQUESTs["login"]);

        if($login=="" || $test_id < 1){
            $res = '{"title": "no_params", "description": "", "cnt": 0, "answers": [{}] }';
        }
        else{
            try {
                $pdo->exec("SET NAMES 'utf8';");
                //$sql = "SELECT id FROM `results` WHERE login = '".$login."' AND test_id = ".$test_id."; ";

                $sql="SELECT count(*) FROM `results` WHERE login = '".$login."' AND test_id = ".$test_id.";";
                $result = $pdo->query($sql);
                $row3 = $result->fetch($pdo::FETCH_NUM);
                //echo $row3[0];

                //$cnt = $pdo->query($sql)->fetchColumn();
                if($row3[0] > 0) {
                    $res = '{"title": "you are answered", "description": "", "cnt": 0, "answers": [{}] }';
                }
                else{
$res='';


                    $sql="SELECT count(*) FROM `questions` WHERE test_id = ".$test_id."; ";
                    $result = $pdo->query($sql);
                    $row4 = $result->fetch($pdo::FETCH_NUM);



                    //$result0 = mysql_query("SELECT * FROM `tests` WHERE id = ".$test_id.";  ");
                    $sql = "SELECT * FROM `tests` WHERE id = ".$test_id."; ";
                    //$cnt = $pdo->query($sql)->fetchColumn() ;
                    foreach($pdo->query($sql) as $row0) {

                        $res = '{"title": "'.$row0["title"].'", "description": "'.$row0["description"].'", "cnt": "'.$row4[0].'", "questions":[';

                    }
                    $i = 0;

                    $sql = "SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer` FROM `questions` WHERE test_id = ".$test_id."; ";

                    $cnt=$pdo->query($sql)->fetchColumn();
                    //$res .="eeeeeeeeeeeeeeeeeeeeeeeee=".$cnt;
                    //$result = mysql_query("SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer` FROM `questions` WHERE test_id = ".$test_id."; ");
                    $sql = "SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer` FROM `questions` WHERE test_id = ".$test_id."; ";
                    foreach($pdo->query($sql) as $row) {
                        $i++;
                        $res .= '{"text": "'.$row["text"].'", "opened": "'.$row["opened"].'", "answers": "'.$row["answers"].'", "right_answer": '.$row["right_answer"].'}';
                        if($i < $row4[0] ) {$res .= ",";}
                    }
                    $res .= "]}";
                    /*if ($row0 && $row) {
                        $row0 = mysql_fetch_array($result0);
                        while($row = mysql_fetch_array($result)){
                            $i++;
                            $res .= '{"text": "'.$row["text"].'", "opened": "'.$row["opened"].'", "answers": "'.$row["answers"].'", "right_answer": '.$row["right_answer"].'}';
                            if($i < mysql_num_rows($result)) echo ",";
                        }
                        $res .= "]}";
                    }
                    else{
                        $res = '{"title": "", "description": "", "cnt": 0, "answers":[{}]}';
                    }*/
                }

            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }


            /*$result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("SELECT id FROM `results` WHERE login = '".$login."' AND test_id = ".$test_id."; ");
            if (!$result) {echo "ERROR!";}
            if(mysql_num_rows($result) > 0 ){
                $res = '{"title": "you are answered", "description": "", "cnt": 0, "answers": [{}] }';
            }
            else{

            }*/
            return $res;
        }
    }


} 