<?php

    //namespace src;

class Tests
{
    /**
     * return empty or string error
     *
     * @param $title
     * @param $description
     * @param $user_role
     *
     * @todo return result object
     */
    public function createTest($_REQUESTs, $pdo){
        $title = htmlspecialchars($_REQUESTs["newTaskTitle"]);
        $description = htmlspecialchars($_REQUESTs["newTaskDescription"]);
        //$user_role = htmlspecialchars($_REQUESTs["user_role"]);
        //$login = htmlspecialchars($_REQUESTs["login"]);

        if($title=="" || $description==""){
            echo "Не передан требуемый параметр!";
        }
        else{
           try {
               $pdo->exec("SET NAMES 'utf8';");      // Sets encoding UTF-8
               $sql = "INSERT INTO `tests`(`title`, `description`, `date_create`) VALUES ('$title','$description', NOW());";
               $pdo->exec($sql);
           }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @param $_REQUESTs
     */
    public function getTestsList($_REQUESTs, $pdo){
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);
        $login = htmlspecialchars($_REQUESTs["login"]);

        $sql = "select `id`, `title`, `description`, IF(`cnt`>0, `cnt`, '0') as `cnt`, `cnt2` from(
            SELECT `id`, `title`, `description` FROM `tests`
            ) as t1
            LEFT JOIN
           (SELECT `test_id`, COUNT(`id`) AS `cnt` FROM `questions`
            GROUP BY `test_id`
            ) as t2
             ON t1.`id` = t2.`test_id`
             LEFT JOIN
           (SELECT `test_id`, COUNT(`id`) AS `cnt2`, `login` FROM `results`
            GROUP BY `test_id`,`login`
            ) as t3
             ON t1.`id` = t3.`test_id` AND t3.`login` = '".$login."'
             ORDER BY `title`;
           ";

        try {
            $pdo->exec("SET NAMES 'utf8';");      // Sets encoding UTF-8
            //$conn->exec($sql);
            echo '<table class="table table-striped" style="border: 1px solid white">
			<tr>
			    <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">№</th>
			    <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Название<div style="display: inline-block; color: grey; text-align:left; float: right;">Описание</div></th>
			    <th ';  echo' style="color: grey; font-size: 14pt; text-align: right;">Действия</th>
			   ';

            echo '
			</tr>';
            $i = 0;
            foreach($pdo->query($sql) as $row){
                $i++; //<a onclick="watch_questions('.$row["id"].');" style="font-weight: bold">  </a>

                if($row["cnt2"] < 1){
                    $tx1 = 'btn-success"><span class="glyphicon glyphicon-check"></span> пройти тест';
                }
                else{
                    $tx1 = 'btn-default"><span class="glyphicon glyphicon-exclamation-sign"></span> пройден! ';
                }

                echo  '<tr>
			    	<td width="5%">'.$i.'</td>
			    	<td><b>'.strtoupper(substr(mb_strtoupper($row["title"]),0, 45)).'</b>
			    	<div style="display: inline-block; color: grey; text-align:left; float: right;">'.substr($row["description"],0,70).' ('.$row["cnt"].')</div></td>
			    	<td style="text-align: right;"><a onclick="watch_test('.$row["id"].');" href="#" class="btn btn-xs '.$tx1.'</a>';
                if($user_role > 0){
                    echo '
                    <a href="#questions/'.$row["id"].'" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-edit"></span> управление вопросами</a>
                    <a onclick="edit_test('.$row["id"].');" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                    <a onclick="remove_test('.$row["id"].');" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                    ';
                }
                echo '</td>
                </tr>';
            }
            //echo 'PPDDOO='.$pdo->query($sql)->fetchColumn();
            if($pdo->query($sql)->fetchColumn() < 1) {echo '<tr><td style="text-align: center">Нет тестов.</td></tr>';}
            echo '</table>';
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }



        /*$result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query();
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }

        while ($row = mysql_fetch_array($result)) {

        }
        */
    }


    /**
     * @param $test_id
     */
    public function removeTest($test_id){
        if($test_id==""){
            echo "Не передан параметр!";
        }
        else{
            $result = mysql_query("DELETE FROM `tests` WHERE id = ".$test_id."; ");
            if ($result) {
            }
            else{
                echo "Ошибка при удалении!";
            }
        }
    }

    public function updateTest($_REQUESTs){
        $test_id = htmlspecialchars($_REQUESTs["editTestId"]);
        $test_title = htmlspecialchars($_REQUESTs["editTestTitle"]);
        $test_description = htmlspecialchars($_REQUESTs["editTestDescription"]);
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);
        $login = htmlspecialchars($_REQUESTs["login"]);

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("UPDATE `tests` SET title = '".$test_title."',description = '".$test_description."' WHERE id = ".$test_id."; ");
        if ($result) {
           // $test = new Tests();
            $this->getTestsList( $user_role, $login );
        }
        else{
            echo "Ошибка при изменении!";
        }
    }

    /**
     * @param $test_id
     * @throws InvalidArgumentException
     */
    public function getTestDetails($test_id){

        if($test_id < 1){
            throw new InvalidArgumentException('Попытка получить несуществующий тест!');
          }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("SELECT * FROM `tests` WHERE id = ".$test_id."; ");
            if ($result) {
                $row = mysql_fetch_array($result);
                echo '{"title": "'.$row["title"].'", "description": "'.$row["description"].'"}';
            }
            else{
                echo '{"title": "[Ошибка!!!]", "description": ""}';
            }
        }

    }
} 