<?php


class Projects {
    public function createProject($_REQUESTs){
        $title = htmlspecialchars($_REQUESTs["title"]);
        $description = $_REQUESTs["description"];

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("INSERT INTO `projects`(`title`, `description`, `date_create`) VALUES ('$title','$description', NOW())");
        if ($result) {

        }
        else{
            echo "Ошибка при создании!";
        }
    }

    public function getProjectsList($user_role){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT * FROM `projects`; ");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        echo '<table class="table table-striped" style="border: 1px #989898 solid;">
           <tr>
               <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Название</th>';
        if( $user_role > 0 ){echo '<th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Действия</th>';}
        echo '</tr>
           ';
        while ($row = mysql_fetch_array($result)) {
            echo  '<tr>
               ';
            if( $user_role > 0 ){
                echo'
               <td>
                   <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().next().slideToggle(500);" class="project" style="font-weight: bold;"> '.strtoupper($row["title"]).'<span class="glyphicon glyphicon-chevron-down" ></span></a> <span style="color:grey">'.$row["description"].'</span>
                   <div style="display: none; padding: 8px; margin: 5px 1px 5px 16px; background: #cdcdcd;  border: #898989 1px solid">';
                $result2 = mysql_query("SELECT * FROM `kbase` WHERE project_id=".$row["id"]."; ");
                if (!$result2) {
                    echo 'Ошибка запроса: ' . mysql_error();
                    exit;
                }
                while ($row2 = mysql_fetch_array($result2)) {
                    $n_id = 1000 + $row2['id'];
                    echo '<a href="#questions/'.$n_id.'" class="btn btn-xs btn-info" style="margin: 2px"><span class="glyphicon glyphicon-paperclip"></span>  </a> <a href="#questions/'.$n_id.'" style="color: #252525;" >'.$row2['title'].'</a><br>';
                }
                echo '</div>
               </td>
               <td width="350px">
                 <a onclick="create_note('.$row["id"].');" href="#" class="btn btn-xs btn-success" title="Добавить"><span class="glyphicon glyphicon-plus"></span> добавить заметку</a>
                 <a onclick="edit_project('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                 <a onclick="remove_project('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                </td>';
            }
            else{
                echo '
               <td>
                 <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().slideToggle(500);">'.strtoupper($row["title"]).'</a>
                   <div  style="display: none; padding: 8px; margin: 5px 1px 5px 16px; background: #cdcdcd; border: #898989 1px solid">';
                    $result2 = mysql_query("SELECT * FROM `kbase` WHERE project_id=".$row["id"]."; ");
                    if (!$result2) {
                        echo 'Ошибка запроса: ' . mysql_error();
                        exit;
                    }
                    while ($row2 = mysql_fetch_array($result2)) {
                        $n_id = 1000 + $row2['id'];
                        echo '<a href="#questions/'.$n_id.'" class="btn btn-xs btn-info" style="margin: 2px"><span class="glyphicon glyphicon-paperclip"></span>  </a> <a style="color: #252525;" href="#questions/'.$n_id.'">'.$row2['title'].'</a><br>';
                    }
                    echo '</div>
               </td>
               ';
            }

            echo '</tr>';
        }
        echo '</table>';
    }

    public function updateProject($_REQUESTs){
        $project_id = htmlspecialchars($_REQUESTs["project_id"]);
        $title = htmlspecialchars($_REQUESTs["title"]);
        $description = $_REQUESTs["description"];
        //$user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($project_id=="" || $title==""){
            echo '<div class="alert alert-danger"><strong>Ошибка!</strong> Сохранение изменений не выполнено</div>';
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query('UPDATE `projects` SET `title`="'.$title.'", `description`="'.$description.'", `edit_date`=NOW() WHERE id= '.$project_id.' ;');
            if ($result) {
                echo '{"status": "Ok"}';
            }
            else{
                echo '{"status": "Ошибка сохранения в БД!"}';
            }
        }
        //$this->getProjectsList($user_role);
    }

    public function removeProject($_REQUESTs){
        $project_id = htmlspecialchars($_REQUESTs["project_id"]);
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($project_id=="" || $user_role==""){
            echo '{"status": "Не передан требуемый параметр!"}';
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("DELETE FROM `projects` WHERE id = $project_id;");
            if ($result) {
                echo '{"status": "removed"}';
            }
            else{
                echo '{"status": "Ошибка сохранения в БД!"}';
            }
        }
    }

    public function getProjectDetails($project_id){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT * FROM `projects` WHERE id = $project_id;");
        if ($result) {
            $row = mysql_fetch_array(  $result   );
            $resultStr = '{"status": "Ok", "title": "'.$row['title'].'", "description": "'.$row['description'].'"}';
        }
        else{
            $resultStr = '{"status": "Error"}';
        }
        return $resultStr;
    }
} 