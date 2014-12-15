<?php
    error_reporting(E_ALL);
    ini_set("display_errors","On");/*

     spl_autoload_register ('autoload');
     function autoload ($className) {
         $fileName = $className . '.php';
         include  $fileName;
     }
    function my_autoload($class){
        $file = __DIR__.'/class/' . $class . '.class.php';
        if(file_exists($file)) {
           include $file;
        }
    };*/


    //date_default_timezone_set('America/Los_Angeles');

    //$script_tz = date_default_timezone_get();
    /*var_dump($script_tz);
    if (strcmp($script_tz, ini_get('date.timezone'))){
        echo 'Временная зона скрипта отличается от заданной в INI-файле.';
    } else {
        echo 'Временные зоны скрипта и настройки INI-файла совпадают.';
    }*/

    /*require_once('/usr/local/www/clh.contactis.com.ua/www/src/MySqlConnecting.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Logs.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Questions.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Results.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Tests.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Users.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Projects.php');
    require_once('/usr/local/www/clh.contactis.com.ua/www/src/Notes.php');*/

    //if ( ! class_exists('Logs')) die('Class Logs not exists!');
   // if ( ! class_exists('Questions')) die('Class Questions not exists!');

    //echo 'Current PHP version: ' . phpversion();
    //echo getcwd() . "\n";
    include 'vendor/autoload.php';
     use \TLH\Config\Config;
     use \TLH\Logs\Logs;
     use \TLH\MySqlConnecting\MySqlConnecting;
     use \TLH\Tests\Tests;
     use \TLH\Questions\Questions;
     use \TLH\Results\Results;
     use \TLH\Users\Users;
     use \TLH\Projects\Projects;
     use \TLH\Notes\Notes;

    $conf = new Config();
    $log = new Logs();
    $conn = new MySqlConnecting();
    //$conn->setConnection($conf);
    try {
        $conn->createDbConnection($conf, null);
        $conn_pdo = $conn->getDBH();
    } catch (PDOException $e) {
        echo $log->showNotification( $e->getMessage(), "error" );
     }




    //$questions = new Questions();
    $test = new Tests();
    $results = new Results();
    $users = new Users();
    $projects = new Projects();
    $notes = new Notes();

    /**/

    //--> TESTS *************************************************************
    if(isset($_REQUEST["createTest"])){
       $test->createTest($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["getTestsList"])){
        $test->getTestsList( $_REQUEST, $conn_pdo );
    }
    elseif(isset($_REQUEST["remove_test"])){
        $test->removeTest( htmlspecialchars($_REQUEST["removeTestId"]) );
    }
    elseif(isset($_REQUEST["updateTest"])){
        $test->updateTest($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["get_test_details"])){
        try {
            $test->getTestDetails( htmlspecialchars($_GET["testId"]) );
        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
    }




    //--> QUESTIONS ********************************************************
    elseif(isset($_REQUEST["addQuestion"])){
        $questions = new Questions();
        $questions->addQuestion($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["getQuestionsList"])){
        $questions = new Questions();
        //$questions->getTestQuestions($_REQUEST);
        $questions->getQuestionsList($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["getQuestionsList2"])){
        $questions = new Questions();
        $questions->getQuestionsList($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["removeQuestion"])){
        $questions = new Questions();
        $questions->removeQuestion($_REQUEST, $conn_pdo);
    }
    elseif(isset($_REQUEST["getQuestionForEditing"])){
        $questions = new Questions();
        $questions->getQuestionForEditing( htmlspecialchars($_GET["que_id"]), $conn_pdo );
    }
    elseif(isset($_REQUEST["updateQuestion"])){
        $questions = new Questions();
        $questions->updateQuestion($_REQUEST, $conn_pdo);
    }


    //--> RESULTS *********************************************************
    elseif(isset($_REQUEST["get_results"])){
        $results->getResults($_REQUEST);
    }
    elseif(isset($_REQUEST["get_diagram"])){
        echo $results->getDiagramData($_REQUEST);
    }




    //--> USERS **********************************************************
    elseif(isset($_REQUEST["get_crenditles"])){
        echo $users->getCrenditles($conn_pdo);
    }
    elseif(isset($_REQUEST["create_user"])){
        $users->createUser($_REQUEST);
    }
    elseif(isset($_REQUEST["check_user"])){
        /*/===$login = htmlspecialchars($_POST["login"]);
           if($login=="") {$login = htmlspecialchars($_GET["login"]);}
        $password = htmlspecialchars($_POST["password"]);
           if($password=="") {$password = htmlspecialchars($_GET["password"]);}

        if($login=="" || $password==""){
           echo '{"status": "Error", "message": "Не переданы все данные!", "role": "0"}';
        }
        else{
           $result = mysql_query("SET NAMES 'utf8'; ");
           //echo "SELECT `login`, `password`,`admin`,`fio`  FROM `users` WHERE `login`='".$login."';";
           $result = mysql_query("SELECT `login`, `password`,`admin`,`fio`  FROM `users` WHERE `login`='".$login."';");
           if ($result) {
               $done = '{"status": "error", "role": "0", "message": "---"}';
               while ($row = mysql_fetch_array($result)) {
                   //echo $password." ".sha1($password)." ".$row["password"]."<br>";
                   if($row["login"]==$login && $row["password"]==sha1($password) )   {
                       $done = '{"status": "true", "login": "'.$row["login"].'", "fio": "'.$row["fio"].'", "role": '.$row["admin"].', "rnd": '.rand().'}';
                       $done = '{"status": "true", "login": "'.$row["login"].'", "fio": "'.$row["fio"].'", "role": '.$row["admin"].', "rnd": '.rand().'}';
                   }
               }
               echo $done;
           }
           else{
               echo '{"status": "error", "message": "Ошибка запроса!", "role": "0"}';
           }
        }===/*/
    }
    elseif(isset($_REQUEST["get_user_by_login"])){
        echo $users->getUserByLogin(htmlspecialchars($_REQUEST["login"]), $log, $conn_pdo);
    }
    elseif(isset($_REQUEST["get_users"])){
        $users->getUsersList();
    }
    elseif(isset($_REQUEST["get_user"])){
        $users->getUser( htmlspecialchars($_REQUEST["user_id"]) );
    }
    elseif(isset($_REQUEST["update_user"])){
        echo $users->updateUser($_REQUEST);
    }
    elseif(isset($_REQUEST["remove_user"])){
        echo $users->removeUser( htmlspecialchars($_REQUEST['result_id']) );
    }


    //--> PROJECTS *********************************************************************
    elseif(isset($_REQUEST["createProject"])){
        $projects->createProject($_REQUEST);
    }
    elseif(isset($_REQUEST["updateProject"])){
        $projects->updateProject($_REQUEST);
    }
    elseif(isset($_REQUEST["removeProject"])){
        $projects->removeProject($_REQUEST);
    }
    elseif(isset($_REQUEST["getProjectDetails"])){
        echo $projects->getProjectDetails( htmlspecialchars($_REQUEST["project_id"]) );
    }
    elseif(isset($_REQUEST["getProjectsList"])){
        $projects->getProjectsList( htmlspecialchars($_REQUEST["user_role"]) );
    }


    //--> NOTES *********************************************************************
    elseif(isset($_REQUEST["add_note"])){
        $notes->addNote($_REQUEST);
    }
    elseif(isset($_REQUEST["updateNote"])){
        $notes->updateNote($_REQUEST);
    }
    elseif(isset($_REQUEST["removeNote"])){
        $notes->removeNote($_REQUEST);
    }
    elseif(isset($_REQUEST["getNoteDetails"])){
        echo $notes->getNoteDetails( htmlspecialchars($_REQUEST["note_id"]) );
    }
    elseif(isset($_REQUEST["getNotesList"])){
        $notes->getNotesList( htmlspecialchars($_REQUEST["user_role"]) );
    }


    //--> CONFIG **********************************************************************
    elseif(isset($_REQUEST["check_existing_db"])){
        $conn->checkDBConnection('tlh', $conf);
    }



    //--> RESULTS *******************************************
    elseif(isset($_REQUEST["remove_result"])){
        $results->removeResult($_REQUEST["result_id"]);
    }
    elseif(isset($_REQUEST["export_results"])){
        $results->exportExcel();
    }
    elseif(isset($_REQUEST["sha"])){
        $password = "admin";
        echo sha1($password);
    }
    elseif(isset($_REQUEST["set_testresult"])){
        $results->setTestResult($_REQUEST);
    }



    $conn->connClose();

?>