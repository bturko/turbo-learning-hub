<?php

   // namespace src;

class Questions
{
    /**
     * @var getQuestionList
     */
    public function getQuestionList($test_id){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `test_id`, `text`, `answers`, `right_answer` FROM `questions` WHERE test_id=".$test_id."; ");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        echo '<table class="table table-striped" style="border: 1px white solid;">
            <tr>
                <th style="border-right: 1px solid grey;">Вопрос</th>
                <th >Действие</th>
            </tr>
        ';
        while ($row = mysql_fetch_array($result)) {
            echo  '<tr>
                      <td style="border-right: 1px grey solid;">'.$row["text"].'</td>
                      <td width="230px">
                        <a onclick="edit_que('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать вопрос"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                        <a onclick="remove_que('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить вопрос"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                        </td>
                    </tr>';
        }
        if(mysql_num_rows($result) <1) {echo '<tr><td colspan=2">Пока вопросов нет</td></tr>';}
        echo '</table>';
    }

    /**
     * @param $test_id
     * @param $test_id
     * @param $text
     * @param $opened
     * @param $var1
     * @param $var2
     * @param $var3
     * @param $var4
     * @param $rig_var
     * @internal param \src\addQuestion $
     */
    public function addQuestion($test_id, $test_id, $text, $opened, $var1, $var2, $var3, $var4, $rig_var){
        $array = array($var1, $var2);
        if( $var3 != "" ) {array_push($array, $var3);}
        if( $var4 != "" ) {array_push($array, $var4);}
        $separated = implode("|", $array);

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("INSERT INTO `questions`(`test_id`, `text`, `opened`, `answers`, `right_answer`, `date_create`) VALUES ('$test_id','$text', $opened, '$separated','$rig_var', NOW());");
        if ($result) {

        }
        else{
            echo "Ошибка при создании!";
        }
        //get_questions_list($test_id);
        $this->getQuestionList($test_id);
    }

     /**
      * @param $que_id
      */
    public function getQuestionDetails($que_id){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer`, `date_create` FROM `questions` WHERE id=".$que_id." ;");
        if ($result) {
            $row = mysql_fetch_row($result);
            echo '{"status": "Ok", "id":'.$row[0].', "test_id":'.$row[1].', "text": "'.$row[2].'", "opened": "'.$row[3].'","answers": "'.$row[4].'", "right_answer": '.$row[5].'}';
        }
        else{
            echo '{"status": "Error"}';
        }
    }

    /**
     * @param $_REQUEST
     */
    public function updateQuestion($_REQUESTs){
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

            $result = mysql_query("SET NAMES 'utf8'; ");
            echo "UPDATE `questions` SET `text`='$text', `opened`='$opened', `answers`='$separated', `right_answer`='$rig_var', `date_edit`=NOW() WHERE id = $q_id;";
            $result = mysql_query("UPDATE `questions` SET `text`='$text', `opened`='$opened', `answers`='$separated', `right_answer`='$rig_var', `date_edit`=NOW() WHERE id = $q_id;");
            if ($result) {

            }
            else{
                echo "Ошибка при создании!";
            }
            //get_questions_list($test_id);
            $this->getQuestionList($test_id);
        }
    }

    public function getTestQuestions($_REQUESTs){
        $test_id = htmlspecialchars($_REQUESTs["testId"]);
        $login = htmlspecialchars($_REQUESTs["login"]);

        if($login=="" || $test_id < 1){
            echo '{"title": "no_params", "description": "", "cnt": 0, "answers": [{}] }';
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("SELECT id FROM `results` WHERE login = '".$login."' AND test_id = ".$test_id."; ");
            if (!$result) {echo "ERROR!";}
            if(mysql_num_rows($result) > 0 ){
                echo '{"title": "you are answered", "description": "", "cnt": 0, "answers": [{}] }';
            }
            else{
                $result0 = mysql_query("SELECT * FROM `tests` WHERE id = ".$test_id.";  ");

                $result = mysql_query("SELECT `id`, `test_id`, `text`, `opened`, `answers`, `right_answer` FROM `questions` WHERE test_id = ".$test_id."; ");

                if ($result0 && $result) {
                    $row0 = mysql_fetch_array($result0);
                    $i = 0;
                    echo '{"title": "'.$row0["title"].'", "description": "'.$row0["description"].'", "cnt": "'.mysql_num_rows($result).'", "questions":[';
                    while($row = mysql_fetch_array($result)){
                        $i++;
                        echo '{"text": "'.$row["text"].'", "opened": "'.$row["opened"].'", "answers": "'.$row["answers"].'", "right_answer": '.$row["right_answer"].'}';
                        if($i < mysql_num_rows($result)) echo ",";
                    }
                    echo "]}";
                }
                else{
                    echo '{"title": "", "description": "", "cnt": 0, "answers":[{}]}';
                }
            }
        }
    }


} 