<?php
namespace TLH\Notes;
class Notes {
    /**
     * @return string
     */
    public function getNoteDetails($note_id){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT `id`, `project_id`, `title`, `text` AS `content` FROM `kbase` WHERE id = $note_id;");
        if ($result) {
            $row = mysql_fetch_array(  $result   );
            $resultStr = $row['title'].'::::'.base64_decode($row['content']);
        }
        else{
            $resultStr = "Ошибка при получении даннных!";
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
    public function addNote($_REQUESTs){
        $title = htmlspecialchars($_REQUESTs["title"]);
        $content = $_REQUESTs["content"];
        $project_id = $_REQUESTs["project_id"];
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($title=="" || $content==""){
            echo "Не передан один или более параметров";
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("INSERT INTO `kbase` (`title`, `text`, `project_id`, `creation_date`) VALUES ('$title','". chunk_split(base64_encode($content)) ."', ".$project_id.", NOW());");
            if ($result) {

            }
            else{
                echo "Ошибка!";
            }
        }
        //$this->getNotesList($user_role);
    }

    /**
     * @param $_REQUESTs
     */
    public function updateNote($_REQUESTs){
        $note_id = htmlspecialchars($_REQUESTs["note_id"]);
        $title = htmlspecialchars($_REQUESTs["title"]);
        $content = $_REQUESTs["content"];
        $user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($note_id=="" || $title=="" || $content==""){
            echo "Не передан требуемый параметр!<br>";
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query('UPDATE `kbase` SET `title`="'.$title.'", `text`="'. chunk_split(base64_encode($content)) .'", `edit_date`=NOW() WHERE id= '.$note_id.' ;');
            if ($result) {

            }
            else{
                echo "Ошибка!";
            }
        }

    }

    /**
     *
     */
    public function removeNote($_REQUESTs){
        $note_id = htmlspecialchars($_REQUESTs["note_id"]);
        //$user_role = htmlspecialchars($_REQUESTs["user_role"]);

        if($note_id==""){
            echo '{"result": "error", "messsage": "Не передан требуемый параметр!"}';
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            echo "DELETE FROM `kbase` WHERE id = $note_id;";
            $result = mysql_query("DELETE FROM `kbase` WHERE id = $note_id;");
            if ($result) {
                echo '{"result": "success", "message": ""}';
            }
            else{
                echo '{"result": "error", "message": "Ошибка сохранения в БД!"}';
            }
        }
    }
} 