<?php
namespace TLH\Notes;
class Notes {
    /**
     * @param $note_id
     * @param $pdo
     * @return mixed
     */
    public function getNoteDetails($note_id, $pdo){
        try {
            $pdo->exec("SET NAMES 'utf8';");
            //$sql = "SELECT `id`, `project_id`, `title`, `text` AS `content` FROM `kbase` WHERE id = $note_id;";
            //$pdo->exec($sql);

            $q = $pdo->prepare("SELECT `id`, `project_id`, `title`, `text` AS `content` FROM `kbase` WHERE id =:note_id; ");
            $q->bindValue(':note_id', $note_id);
            $q->execute();
            $row = $q->fetch($pdo::FETCH_ASSOC);

            if (!empty($row)){
                $resultStr = $row['title'].'::::'.base64_decode($row['content']);
            }
            else{
                $resultStr = "Ошибка при получении даннных!";
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $resultStr;
    }

    public function getNotesList($user_role){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `project_id`, `title`, `text` AS `content` FROM `kbase`; ");
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
                   <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().slideToggle(500);" class="project"> '.strtoupper($row["title"]).'<span class="glyphicon glyphicon-chevron-down" ></span></a>
                   <div style="display: none; padding: 8px; margin: 5px; background: #cdcdcd; color: #575757; border: #898989 1px solid">'.base64_decode($row['content']).'</div>
               </td>
               <td width="260px">
                 <a onclick="kbaseVM.get_note('.$row["id"].');" href="#" class="btn btn-xs btn-info" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span> редактировать</a>
                 <a onclick="remove_note('.$row["id"].');" href="#" class="btn btn-xs btn-danger" title="Удалить"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                </td>';
            }
            else{
                echo '
               <td>
                 <span class="glyphicon glyphicon-folder-close" style="color: yellow;"></span> <a onclick="$(this).next().slideToggle(500);">'.strtoupper($row["title"]).'</a>
                   <div style="display: none; padding: 8px; margin: 5px; background: #cdcdcd; color: #575757; border: #898989 1px solid">'.base64_decode($row['content']).'</div>
               </td>
               ';
            }

            echo '</tr>';
        }
        echo '</table>';
    }

    /**
     * @param $_REQUESTs
     */
    public function addNote($_REQUESTs, $pdo){
        $title = htmlspecialchars($_REQUESTs["title"]);
        $content = $_REQUESTs["content"];
        $project_id = $_REQUESTs["project_id"];
        //$user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($title=="" || $content==""){
            echo "Не передан один или более параметров";
        }
        else{
            $sql = "INSERT INTO `kbase` (`title`, `text`, `project_id`, `creation_date`)  VALUES (
            :title,
            '".chunk_split(base64_encode($content))."',
            :project_id,
            NOW() )";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':title', $title, $pdo::PARAM_STR);
            //$stmt->bindParam(':text', , $pdo::PARAM_STR);
            $stmt->bindParam(':project_id', $project_id, $pdo::PARAM_INT);

            $stmt->execute();
            /*$result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("INSERT INTO `kbase` (`title`, `text`, `project_id`, `creation_date`) VALUES ('$title','". chunk_split(base64_encode($content)) ."', ".$project_id.", NOW());");
            if ($result) {

            }
            else{
                echo "Ошибка!";
            }*/
        }
    }

    /**
     * @param $_REQUESTs
     * @param $pdo
     * @return string
     */
    public function updateNote($_REQUESTs, $pdo){
        $note_id = htmlspecialchars($_REQUESTs["note_id"]);
        $title = htmlspecialchars($_REQUESTs["title"]);
        $content = $_REQUESTs["content"];

        if($note_id=="" || $title=="" || $content==""){
            $res = "Не передан требуемый параметр!<br>";
        }
        else{
            $sql = 'UPDATE `kbase` SET `title`=:title, `text`="'. chunk_split(base64_encode($content)) .'", `edit_date`= NOW() WHERE id= :note_id ;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title, $pdo::PARAM_STR);
            $stmt->bindParam(':note_id', $note_id, $pdo::PARAM_INT);

            $stmt->execute();
            $res = '{"status": "Ok"}';
        }
        return $res;
    }

    /**
     * @param $_REQUESTs
     * @param $pdo
     * @return string
     */
    public function removeNote($_REQUESTs, $pdo){
        $note_id = htmlspecialchars($_REQUESTs["note_id"]);

        if($note_id < 1){
            $res = '{"status": "error", "messsage": "Не передан требуемый параметр!"}';
        }
        else{
            $sql = "DELETE FROM `kbase` WHERE id = :note_id; ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':note_id', $note_id, $pdo::PARAM_INT);
            $stmt->execute();
            $res = '{"status": "Ok"}';
        }
        return $res;
    }
} 