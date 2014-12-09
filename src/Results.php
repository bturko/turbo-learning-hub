<?php


//namespace src;
//


class Results {

    private $tests = array();
    private $tests_ids = array();

    /**
     * @return array
     */
    public function getOperatorsFioList(){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT DISTINCT fio
            FROM  `results`
            ORDER BY fio
            LIMIT 0 , 99 ;");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        $users = array();
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $users[$i]=$row['fio'];
            $i++;
        }
        return $users;
    }

    public function getTestsList(){
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT id, title FROM
            (SELECT DISTINCT test_id
                FROM  `results`
                ORDER BY fio) AS t1
                LEFT JOIN
            (SELECT id, title
            FROM  `tests`
            ORDER BY title) AS t2
            ON t1.test_id = t2.id");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        $tests = array();
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $this->tests[$i] = $row['title'];
            $this->tests_ids[$i] = $row['id'];
            $i++;
        }
        //var_dump($this->tests_ids[]);
        //return $tests;
    }

    /**
     * @param $REQUESTs
     */
    public function getResults($REQUESTs){

        $users = $this->getOperatorsFioList();
        //$tests =
        $this->getTestsList();

        $tests4 = "";
        $operators = "";
        if($REQUESTs['test_id'] != "" /*&& $REQUESTs['test_id'] != "Все"*/){
            $tests4 = "WHERE test_id =  ".$REQUESTs['test_id']."";
        }
        if($REQUESTs['operator_id'] != "" /*&& $REQUESTs['operator_id'] != "Все"*/){
            if($tests4 == ""){
                $operators = " WHERE fio like '".$REQUESTs['operator_id']."'";
            }
            else{
                $operators = " AND fio like '".$REQUESTs['operator_id']."'";
            }
        }

        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT * FROM(".
            "SELECT `id` AS `rid`, `login`, `test_id`, `fio`, `answered`, `answers_count`, `date_insert` ".
            "FROM `results` ".
            $tests4 .
            $operators .
            ") AS t1 ".
            "LEFT JOIN ".
            "(SELECT `id`, `title` from `tests` ) AS t2 ".
            "ON `t2`.`id` = `t1`.`test_id`");
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        echo '<nav class="navbar navbar-default" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->

                 <form class="navbar-form navbar-left" method=post action="export3.php" >
                     Тесты: <select class="selectpicker show-tick" id="test_id" name="test_id" >
                         <option value="">Все</option>';
                         $i=0;
                        /*foreach($tests as &$value) {
                            if ($value!="") echo '<option value="'.$this->value_ids[$i].'">'.$value.'</option>';
                            $i++;
                        }*/
                        for($i=0; $i < count($this->tests); $i++){
                            if ($this->tests[$i]!="") echo '<option value="'.$this->tests_ids[$i].'" ';
                            if ($this->tests_ids[$i]==$REQUESTs['test_id']) echo "selected";
                            echo '>'.$this->tests[$i].'</option>';
                        }
                        echo '</select>
                          Операторы: <select class="selectpicker show-tick" id="operator_id" name="operator_id" >
                              <option value="">Все</option>  ';
                        foreach($users as &$value) {
                            if ($value!="")  echo '<option value="'.$value.'"';
                            if ($value==$REQUESTs['operator_id']) echo "selected";
                            echo '>'.$value.'</option>';
                        }
                        echo '
                       </select>
<!--onclick="this.form.target=_blank;return true;" -->
                     <!--<button type="submit" class="btn btn-default"  ></button>-->
                     <div class="btn-group">
                          <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" >
                            Экспорт <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li id="export_to_excel_btn55555"><button type="submit" class="btn btn-default">В Excel (*.xls)</button></li>
                          </ul>
                        </div>
                  </form>

              </div>


                 </nav>

   <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a role="tab" onclick="resultsVM.show_tdata();" data-toggle="tab">Данные</a></li>
  <li role="presentation"><a role="tab" data-toggle="tab" onclick="resultsVM.show_diagram();">Статистика</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="tdata">
    <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>ФИО</th>
                <th>Оценка (правильно / из)</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        ';
        $i=0;
        while ($row = mysql_fetch_array($result)) {
            $i++;
            echo  '<tr>
                        <td>'.$i.'</td>
                        <td>'.$row["title"].'</td>
                        <td>'.iconv(mb_detect_encoding($row["fio"], mb_detect_order(), true), "UTF-8", $row["fio"]).'</td>
                        <td>'.$row["answered"].' / '.$row["answers_count"].'</td>
                        <td>'.substr($row["date_insert"],2,14).'</td>
                        <td width="4%; text-align: right;">
                            <a onclick="remove_result('.$row["rid"].'); " href="#" class="btn btn-xs btn-danger" title="Удалить"><span class="glyphicon glyphicon-remove"></span> удалить</a>
                         </td>
                    </tr>';
        }
        echo '</table>
  </div>
  <div role="tabpanel" class="tab-pane" id="diagram">
   <div id="chart1" style="height:300px;width:600px; ">Диаграмма не работает(</div>


  </div>
</div>';



    }

    public function getDiagramData($REQUESTs)
    {
        $tests4 = "";
        $operators = "";

        if($REQUESTs['test_id'] != ""){
            $tests4 = "WHERE test_id =  ".$REQUESTs['test_id']."";
        }
        if($REQUESTs['operator_id'] != ""){
            if($tests4 == ""){
                $operators = " WHERE fio like '".$REQUESTs['operator_id']."'";
            }
            else{
                $operators = " AND fio like '".$REQUESTs['operator_id']."'";
            }
        }
        $result = mysql_query("SET NAMES 'utf8'; ");
        $result = mysql_query("SELECT * FROM(".
            "SELECT `id` AS `rid`, `login`, `test_id`, `fio`, `answered`, `answers_count`, `date_insert` ".
            "FROM `results` ".
            $tests4 .
            $operators .
            ") AS t1 ".
            "LEFT JOIN ".
            "(SELECT `id`, `title` from `tests` ) AS t2 ".
            "ON `t2`.`id` = `t1`.`test_id`");
        //var_dump($REQUESTs);
        if (!$result) {
            echo 'Ошибка запроса: ' . mysql_error();
            exit;
        }
        $st = '{"data": [';
        while ($row = mysql_fetch_array($result)) {
            $st .= '{"fio": "'.$row['fio'].'", "value": "'.$row['answered'].'"},';
        }
        $st = substr($st, 0, strlen($st)-1);
        $st .= ']}';
        return $st;
    }

    public function setTestResult($_REQUESTs){
        $test_id = htmlspecialchars($_REQUESTs["test_id"]);
        $login = htmlspecialchars($_REQUESTs["login"]);
        $answers_cnt = htmlspecialchars($_REQUESTs["answers_cnt"]);
        $right_cnt = htmlspecialchars($_REQUESTs["right_cnt"]);
        $fio = htmlspecialchars($_REQUESTs["fio"]);

        if($login=="" || $right_cnt=="" ){
            echo "Ошибка!";
        }
        else{
            $result = mysql_query("SET NAMES 'utf8'; ");
            $result = mysql_query("INSERT INTO  `results` SET `login`='".$login."', `test_id`='".$test_id."', `answered`='".$right_cnt."', `answers_count`= '".$answers_cnt."', `fio`= '".$fio."', `date_insert`=NOW() ;");
            if ($result) {
            }
            else{
                echo "Ошибка!";
            }
        }
    }

    public function removeResult($result_id)
    {
        //$result_id = htmlspecialchars($result_i);

        $result = mysql_query("SET NAMES 'utf8'; ");

        $result0 = mysql_query("SELECT * FROM `results` WHERE `id`= ".$result_id." ;");
        if(mysql_num_rows($result0) > 0){
            $result = mysql_query("DELETE FROM `results` WHERE `id`= ".$result_id." ;");
            if ($result) {
                echo '{"status": "success"}';
            }
            else{
                echo '{"status": "error"}';
            }
        }
        else{
            echo '{"status": "error"}';
        }
    }



} 