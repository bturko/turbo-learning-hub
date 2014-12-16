<?php
namespace TLH\Projects;

class Projects {
    /**
     * @param $_REQUESTs
     * @param $pdo
     */
    public function createProject($_REQUESTs, $pdo){
        $title = htmlspecialchars($_REQUESTs["title"]);
        $description = $_REQUESTs["description"];

        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql = "INSERT INTO `projects`(`title`, `description`, `date_create`) VALUES ('$title','$description', NOW()); ";
            $pdo->exec($sql);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        /*$result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("INSERT INTO `projects`(`title`, `description`, `date_create`) VALUES ('$title','$description', NOW())");
        if ($result) {

        }
        else{
            echo "Ошибка при создании!";
        }*/
    }

    /**
     * @param $user_role
     */
    public function getProjectsList($user_role, $pdo){
        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql = "SELECT * FROM `projects`; ";

            $res = '<table class="table table-striped" style="border: 1px #989898 solid;">
               <tr>
                   <th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Название</th>';
            if( $user_role > 0 ){$res .= '<th style="border-right: 1px grey solid; color: grey; font-size: 14pt;">Действия</th>';}
            $res .= '</tr>';

            //$pdo->exec($sql);
            foreach($pdo->query($sql) as $row){
                $res .=  '<tr>
               ';
                if( $user_role > 0 ){
                    $res .='
               <td>
                   <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().next().slideToggle(500);" class="project" style="font-weight: bold;"> '.strtoupper($row["title"]).'<span class="glyphicon glyphicon-chevron-down" ></span></a> <span style="color:grey">'.$row["description"].'</span>
                   <div style="display: none; padding: 8px; margin: 5px 1px 5px 16px; background: #cdcdcd;  border: #898989 1px solid">';
                    /*$result2 = mysql_query("SELECT * FROM `kbase` WHERE project_id=".$row["id"]."; ");
                    if (!$result2) {
                        echo 'Ошибка запроса: ' . mysql_error();
                        exit;
                    }*/
                    $sql2 = "SELECT * FROM `kbase` WHERE project_id=".$row["id"]."; ";
                    foreach($pdo->query($sql2) as $row2){
                        $n_id = 1000 + $row2['id'];
                        $res .=  '<a href="#questions/'.$n_id.'" class="btn btn-xs btn-info" style="margin: 2px"><span class="glyphicon glyphicon-paperclip"></span>  </a> <a href="#questions/'.$n_id.'" style="color: #252525;" >'.$row2['title'].'</a><br>';
                    }
                    $res .=  '</div>
               </td>
               <td width="350px">
                 <a onclick="create_note('.$row["id"].');" href="#" class="btn btn-xs btn-success" title="Добавить"><span class="glyphicon glyphicon-plus"></span> добавить заметку</a>
                 <a onclick="edit_project('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                 <a onclick="remove_project('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                </td>';
                }
                else{
                    $res .=  '
               <td>
                 <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().slideToggle(500);">'.strtoupper($row["title"]).'</a>
                   <div  style="display: none; padding: 8px; margin: 5px 1px 5px 16px; background: #cdcdcd; border: #898989 1px solid">';
                    $sql2 = "SELECT * FROM `kbase` WHERE project_id=".$row["id"]."; ";
                    foreach($pdo->query($sql2) as $row2){
                    /*if (!$result2) {
                        echo 'Ошибка запроса: ' . mysql_error();
                        exit;
                    }
                    while ($row2 = mysql_fetch_array($result2)) {*/
                        $n_id = 1000 + $row2['id'];
                        $res .=  '<a href="#questions/'.$n_id.'" class="btn btn-xs btn-info" style="margin: 2px"><span class="glyphicon glyphicon-paperclip"></span>  </a> <a style="color: #252525;" href="#questions/'.$n_id.'">'.$row2['title'].'</a><br>';
                    }
                    $res .=  '</div>
               </td>
               ';
                }
                $res .=  '</tr>';
            }
            $res .=  '</table>';

        }
        catch(PDOException $e) {
            $res .=  $e->getMessage();
        }

        /*
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT * FROM `projects`; ");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }*/
        return $res;
    }

    /**
     * @param $_REQUESTs
     * @param $pdo
     * @return string
     */
    public function updateProject($_REQUESTs, $pdo){
        $project_id = htmlspecialchars($_REQUESTs["project_id"]);
        $title = htmlspecialchars($_REQUESTs["title"]);
        $description = $_REQUESTs["description"];
        //$res = "";

        if($project_id=="" || $title==""){
            //$res = '<div class="alert alert-danger"><strong>Ошибка!</strong> Сохранение изменений не выполнено</div>';
            $res = '{"status": "error"}';
        }
        else{
            $sql = "UPDATE `projects` SET `title`=:title, `description`=:description, `edit_date` = NOW() WHERE id= ".$project_id."; ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title, $pdo::PARAM_STR);
            $stmt->bindParam(':description', $description, $pdo::PARAM_STR);
            //$stmt->bindParam(':project_id', $project_id, $pdo::PARAM_INT);

            $stmt->execute();
            $res = '{"status": "Ok"}';
        }
        return $res;
    }

    /**
     * @param $_REQUESTs
     * @param $pdo
     */
    public function removeProject($_REQUESTs, $pdo){
        $project_id = htmlspecialchars($_REQUESTs["project_id"]);
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($project_id=="" || $user_role==""){
            echo '{"status": "Не передан требуемый параметр!"}';
        }
        else{
            try {
                $pdo->exec("SET NAMES 'utf8';");
                $sql = "DELETE FROM `projects` WHERE id = $project_id;";
                $pdo->exec($sql);
                echo '{"status": "removed"}';
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
            /*$result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("DELETE FROM `projects` WHERE id = $project_id;");
            if ($result) {
                echo '{"status": "removed"}';
            }
            else{
                echo '{"status": "Ошибка сохранения в БД!"}';
            }*/
        }
    }

    public function getProjectDetails($project_id, $pdo){
        try {
            $pdo->exec("SET NAMES 'utf8';");
            $sql = "SELECT * FROM `projects` WHERE id = :project_id; ";

            $statement = $pdo->prepare($sql);
            //$statement->execute(array(':project_id' => $project_id));
            $statement->bindParam(':project_id', $project_id);
            $statement->execute();
            $row = $statement->fetch();
            $resultStr = '{"status": "Ok", "title": "'.$row['title'].'", "description": "'.$row['description'].'"}';
        }
        catch(PDOException $e) {
            $resultStr = $e->getMessage();
        }
        return $resultStr;
    }
} 