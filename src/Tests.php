<?php

    //namespace src;

class Tests
{
    /**
     * @param $title
     * @param $description
     * @param $user_role
     */
    public function createTest($title, $description, $user_role, $login){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("INSERT INTO `tests`(`title`, `description`, `date_create`) VALUES ('$title','$description', NOW())");
        if ($result) {
            //get_tests_list($user_role);
            $this->getTestsList($user_role, $login);
        }
        else{
            echo "Ошибка при создании!";
        }
    }

    public function getTestsList($user_role, $login){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("select `id`, `title`, `description`, IF(`cnt`>0, `cnt`, '0') as `cnt`, `cnt2` from(
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
             ON t1.`id` = t3.`test_id` AND t3.`login` = '".$login."';
           ");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        echo '<table class="table table-striped" style="border: 1px solid white">
			<tr>
			    <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">№</th>
			    <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Название<div style="display: inline-block; color: grey; text-align:left; float: right;">Описание</div></th>
			    <th '; /*if($user_role > 0) echo 'colspan="4"';*/ echo' style="color: grey; font-size: 14pt; text-align: right;">Действия</th>
			   ';

        echo '
			</tr>';
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
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
                    <a onclick="edit_test('.$row["id"].'); href="#" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                    <a onclick="remove_test('.$row["id"].');" href="#" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                    ';
            }
            echo '</td>
                </tr>';
        }
        if(mysql_num_rows($result) < 1) {echo '<tr><td style="text-align: center">Нет тестов.</td></tr>';}
        echo '</table>';
    }
} 