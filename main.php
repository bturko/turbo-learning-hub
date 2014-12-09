<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Рабочий кабинет - Contactis Learning Hub</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0" />
    <link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.icon-large.min.css" >
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />

    <script type='text/javascript' src='vendors/jquery17.js'></script>
    <script type='text/javascript' src='vendors/sammy.js'></script>
    <script type='text/javascript' src='vendors/knockout.js'></script>
    <!--<script type='text/javascript' src='vendors/fileuploader.js'></script>-->

    <script type='text/javascript' src='js/log.js'></script>
    <script type='text/javascript' src='js/user.js'></script>
    <script type='text/javascript' src='js/results.js'></script>
    <script type='text/javascript' src='js/projects.js'></script>
    <script type='text/javascript' src='js/kbase.js'></script>
    <script type='text/javascript' src='js/tests.js'></script>
    <script type='text/javascript' src='js/questions.js'></script>
    <script type='text/javascript' src='js/class/spa.js'></script>
    <script type='text/javascript' src='js/main.js'></script>
    <script type='text/javascript' src='js/bootstrap-select.js'></script>
    <script type="text/javascript" src="vendors/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="vendors/jqplot.pieRenderer.js"></script>
    <script type="text/javascript" src="vendors/jqplot.donutRenderer.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<body>
    <div id="informer"></div>
        <div class="container">
            <div class="row vertical-row" style="margin-top: 7px;">
                <div class="col-lg-12">
                    <div class="row" >
                        <ul class="nav nav-pills" data-bind="foreach:views">
                            <li data-bind="css: {active: $root.currentView() == name}" style="display:block">
                                <a data-bind="text: title, attr:{href:'#' + name}"></a>
                            </li>
                        </ul>
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div data-bind="template: {name: currentView()}"></div>
                                </div>
                            </div>
                        </div>


                        <!-- HOME -->
                         <script type="text/html" id="home">
                            <div>
                            <h2></h2>    
                            <div class="hi-icon-wrap hi-icon-effect-8" id="btns">
                                    <table>
                                        <tr>
                                            <td>
                                                <a href="#tests1" title="Тесты" class="hi-icon hi-icon-1" > </a>
                                            </td>
                                            <td>
                                                <a href="#kbase" title="База знаний" class="hi-icon hi-icon-2" > </a>
                                            </td>

                                             <td class="role1 role1-1" style="display:none;">
                                                <a href="#users" title="Пользователи" class="hi-icon hi-icon-3" > </a>
                                            </td>
                                            <td class="role1 role1-2" style="display:none;">
                                                <a href="#results" title="Результаты" class="hi-icon hi-icon-4" > </a>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><!--<a href="#set-8">-->Тесты</td>
                                            <td><!--<a href="#set-8">-->База знаний</td>
                                            <td style="display:none;" class="role1 role1-1"><!--<a href="#set-8">-->Пользователи</td>
                                            <td style="display:none;" class="role1 role1-2"><!--<a href="#set-8">-->Результаты</td>
                                        </tr>        
                                    </table>   
                                    <!--<input type="button" value="Click" onclick='$.ajax({url: "ajax.php?sha",data: {},method: "post"}).success(function(response){alert(response);});'>-->
                                </div>
                            </div>
                        </script>
                        <!-- /HOME -->    


                        <!-- TESTS -->
                        <script type="text/html" id="tests1">
                            <div>
                            <section id="set-8">
                                <div title="Тесты" class="hi-icon hi-icon-1"> </div><span style="font-size: 32pt; color: white">Тесты</span>
                            </section>
                             <div id='test_messages'></div>
                            

                                <a href="#home" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
                                <a id="btnNewtask" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-file role1"></span> Новый тест</a>

                                <!--<button type="button" class="btn btn-primary btn-xs"><a href="#home">&laquo; Назад</a></button>-->
                            <div id='tests'></div>
                            </div>
                        </script>
                        <!-- /TESTS -->

                         <!-- TEST_VIEW -->
                        <script type="text/html" id="test_view">
                            <div>
                            <section id="set-8">
                                <div title="Тесты" class="hi-icon hi-icon-1"> </div><span style="font-size: 32pt; color: white">test_view</span>
                            </section>
                             <div id='test_messages'></div>
                            
                            <button class="md-trigger" data-modal="modal-9">Новый тест</button>
                            <!--<h3>Example heading <span class="label label-default">New</span></h3>-->

                            <div id='tests'></div>
                            </div>
                        </script>
                        <!-- /TEST_VIEW -->
                      
                        <!-- KBASE PROJECTS -->
                        <script type="text/html" id="kbase">
                            <div>
                            <section id="set-8">
                                <div title="База знаний" class="hi-icon hi-icon-2"> </div><span style="font-size: 32pt; color: white">База знаний</span>
                            </section>
                             <div id='test_messages'></div>

                                <a href="#home" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
                                <a id="new_project" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-paperclip role1"></span> Добавить проект</a>

                            <div id="projects_blk"></div>

                            </div>
                        </script>
                        <!-- /KBASE PROJECTS -->

                        <!-- KBASE NOTES
                        <script type="text/html" id="notes">
                            <div>
                                <section id="set-8">
                                    <div title="База знаний" class="hi-icon hi-icon-2"> </div><span style="font-size: 32pt; color: white">Заметка</span>
                                </section>
                                <div id='test_messages'></div>

                                <a href="main.php#kbase" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
                                <a id="edit_note" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-pencil role1"></span> Редактировать заметку</a>
                                <a id="edit_note" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-remove role1"></span> Удалить заметку</a>

                                <div id="kbase_blk"></div>
                            </div>
                        </script>
                        /KBASE NOTES -->

                        <!-- USERS -->
                        <script type="text/html" id="users">
                            <div>
                                <section id="set-8">
                                    <div title="Пользователи" class="hi-icon hi-icon-2"> </div><span style="font-size: 32pt; color: white">Пользователи</span>
                                </section>
                            </div>
                            <div id="users2"></div>
                        </script>
                        <!-- /USERS -->


                        <!-- RESULTS -->    
                        <script type="text/html" id="results">
                            <div>
                            <section id="set-8">
                                <div title="Результаты" class="hi-icon hi-icon-2"> </div><span style="font-size: 32pt; color: white">Результаты</span>
                            </section>
                             <div id='test_messages'></div>
                            
                          
                            <div id="results_blk"></div>
                            
                            </div>
                        </script>
                        <!-- /RESULTS -->
                        
                     
                        <!-- PROFILE --> 
                        <script type="text/html" id="profile">
                            <div>

                                <section id="set-8">
                                    <div title="Профиль" class="hi-icon hi-icon-2"> </div><span style="font-size: 32pt; color: white">Профиль</span>
                                </section>
                                <div style="float:left">
                                 <IMG src="images/user.jpg">
                                 </div>
                                 <div class="user_details">
                                    Логин: <span id="user_login" data-bind="" ></span><Br>
                                    ФИО: <span id="user_fio" data-bind="" ></span><Br>
                                    Роль: <span id="user_role" data-bind="" ></span><Br>
                                    </div>
                            </div>
                        </script>
                        <!-- /PROFILE --> 

                        <script type="text/html" id="exit">
                            <div>
                            <h2>Выход</h2>
                            </div>
                        </script>

                        <script type="text/html" id="pages">
                            <div>
                                <h2>Заметка</h2>
                            </div>

                            <a href="main.php#kbase" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
                            <a onclick='spa.show_dialog("modal-edit-note"); kbaseVM.getNoteDetails(kbaseVM.cur_viewed_note, false);' class="btn btn-danger"><span class="glyphicon glyphicon-pencil role1"></span> Редактировать заметку</a>
                            <a id="edit_note" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-remove role1"></span> Удалить заметку</a>

                            <div id="kbase_blk"></div>
                        </script>


                        <script type="text/html" id="questions">
                            <div>
                                <h2>Вопросы</h2>

                                <a href="#tests1" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
                                <a href="#" class="btn btn-primary" onclick="questionVM.get_questions(questionVM.cur_edit_que);"><span class="glyphicon glyphicon-refresh"></span> Обновить</a>
                                <a id="sh_newquestion" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-question-sign role1"></span> Добавить вопрос</a>

                                <!--<button id="sh_newquestion" style="margin: 3px;">Новый вопрос</button>
                                <button type="button" class="btn btn-primary btn-xs"><a href="#tests1">&laquo; Назад</a></button><br>-->
                                <div id="q_blk_content">

                                </div>
                            </div>
                        </script>





                        <div id="mainbody" >
                            <!--<div id="upload" ><span id="sel_file">:)<span></div><span id="status" ></span>
                            <ul id="files" ></ul>-->
                        </div>

                           <!-- <section id="set-8">
                                
                            </section> -->

                        <!--</div>-->

                    </div>
                </div>
            </div>
        </div>

    <div class="footer">&copy 2014 - <?php echo date("Y");?>, v <span id="app_version"></span></div>







    <div id="watch_test_popup" class="white_content">
        <form class="form-horizontal" >
            <div id="que_blk" class="form-group">

            </div>
            <div id="quiz_results">
                Результат: <span id="my_results"></span>
                <a id="watch_que_close" href="#" class="btn btn-primary"><span class="glyphicon glyphicon-flag"></span> Закрыть</a>
            </div>
            <div class="form-group">
                <div  style="text-align: center;">
                    <a id="watch_que_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-play"></span> Начать</a>
                    <a id="next" href="#" class="btn btn-warning" onclick="questionVM.next();"><span class="glyphicon glyphicon-check"></span> Ответить</a>
                    <a id="watch_que_cancel" href="#" class="btn btn-danger" href = "javascript:void(0)" onclick = "spa.hide_popup('watch_test_popup');"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                </div>
            </div>
        </form>
    </div>





        <div class="md-modal md-effect-9" id="modal-new-test">
            <div class="md-content">
                <h3>Новый тест<br></h3><div class="new_test_err">Введите название!</div>
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-10">
                                <input size="15" type="text" class="form-control" id="newTaskTitle" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Описание</label>
                            <div class="col-sm-10">
                                <input type="test" class="form-control" id="newTaskDescription" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-6">
                                    <!--<button id="test_create_btn" type="submit" class="btn btn-primary" >Создать</button>-->
                                    <a id="test_create_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Создать</a>                                </div>
                                <div class="col-xs-6">
                                    <!--<button id="test_create_cancel" type="submit" class="btn btn-default" >Отмена</button>-->
                                    <a id="test_create_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="md-modal" id="modal-remove-test">
            <div class="md-content">
                <h3>Удаление теста<br></h3><!--<div class="new_test_err">Введите название!</div>-->
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: center;">Вы действительно хотите удалить тест?</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <!--<button id="test_remove_btn" type="submit" class="btn btn-primary" >Да</button>-->
                                    <a id="test_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Да</a>
                                </div>
                                <div class="col-xs-4">
                                    <!--<button id="test_remove_cancel" type="submit" class="btn btn-default" >Нет</button>-->
                                    <a id="test_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="md-modal" id="modal-edit-test">
            <div class="md-content">
                <h3>Редактирование теста<br></h3>
                <div>
                    <form class="form-horizontal" >
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-10">
                                <input size="15" type="text" class="form-control" id="editTaskTitle" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Описание</label>
                            <div class="col-sm-10">
                                <input type="test" class="form-control" id="editTaskDescription" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <button id="test_edit_btn" type="submit" class="btn btn-primary" >Сохранить</button>
                                </div>
                                <div class="col-xs-4">
                                    <button id="test_edit_cancel" type="submit" class="btn btn-default" >Отмена</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="md-modal" id="modal-new-que">
            <div class="md-content">
                <h3>Новый вопрос<br></h3><div class="new_que_err">Заполните поле вопрос и хотя бы 1й вариант ответа!</div>
                <div>
                    <form class="form-horizontal" >
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Вопрос</label>
                            <div class="col-sm-10">
                                <input size="15" type="text" class="form-control" id="newQueText" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Открытый</label>
                            <div class="col-sm-1">
                                <input type="checkbox" class="form-control" id="var0" onclick="new_cb_toggle();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="var1_label" for="var1" class="col-sm-2 control-label">Вариант1</label>
                            <div class="col-sm-10">
                                <input type="test" class="form-control" id="var1" >
                            </div>
                        </div>
                        <div id="new_cb_toggle_blk">
                            <div class="form-group">
                                <label for="var2" class="col-sm-2 control-label">Вариант2</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="var2" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="var2" class="col-sm-2 control-label">Вариант3</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="var3" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="var4" class="col-sm-2 control-label">Вариант4</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="var4" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rig_var" class="col-sm-2 control-label">Правильн.</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="rig_var" >
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <!--<button id="que_new_btn" type="submit" class="btn btn-primary" >Сохранить</button>-->
                                    <a id="que_new_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Сохранить</a>
                                </div>
                                <div class="col-xs-4">
                                    <!--<button id="que_new_cancel" type="submit" class="btn btn-default" >Отмена</button>-->
                                    <a id="que_new_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="md-modal" id="modal-edit-que">
            <div class="md-content">
                <h3>Редактирование вопроса<br></h3><div class="new_que_err">Заполните поле вопрос и хотя бы 2 варианта!</div>
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Вопрос</label>
                            <div class="col-sm-10">
                                <input size="15" type="text" class="form-control" id="editQueText" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Открытый</label>
                            <div class="col-sm-1">
                                <input type="checkbox" class="form-control" id="editvar0" onclick="edit_cb_toggle();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="editvar1_label" for="inputPassword3" class="col-sm-2 control-label">Вариант1</label>
                            <div class="col-sm-10">
                                <input type="test" class="form-control" id="editvar1" >
                            </div>
                        </div>
                        <div id="edit_cb_toggle_blk">
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Вариант2</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="editvar2" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Вариант3</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="editvar3" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Вариант4</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control" id="editvar4" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Правильн.</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="editrig_var" >
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <!--<button id="que_edit_btn" type="submit" class="btn btn-primary" >Изменить</button>-->
                                    <a id="que_edit_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Изменить</a>
                                </div>
                                <div class="col-xs-4">
                                    <!--<button id="que_edit_cancel" type="submit" class="btn btn-default" >Отмена</button>-->
                                    <a id="que_edit_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="md-modal" id="modal-remove-que">
            <div class="md-content">
                <h3>Удаление теста<br></h3>
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: center;">Вы действительно хотите удалить вопрос?</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <!--<button id="que_remove_btn" type="submit" class="btn btn-primary" >Да</button>-->
                                    <a id="que_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Да</a>
                                </div>
                                <div class="col-xs-4">
                                    <!--<button id="que_remove_cancel" type="submit" class="btn btn-default" >Нет</button>-->
                                    <a id="que_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <script language="Javascript" src="vendors/htmlbox.colors.js" type="text/javascript"></script>
    <script language="Javascript" src="vendors/htmlbox.styles.js" type="text/javascript"></script>
    <script language="Javascript" src="vendors/htmlbox.syntax.js" type="text/javascript"></script>
    <script language="Javascript" src="vendors/xhtml.js" type="text/javascript"></script>
    <script language="Javascript" src="vendors/htmlbox.full.js" type="text/javascript"></script>
    <script>
        /*$(function() {
            $( "#noteContent" ).resizable({
                handles: "se"
            });
        });*/
    </script>
   
        <div class="md-modal" id="modal-new-note">
            <div class="md-content" style="width: 795px;">
                <h3>Новая заметка<br></h3><div class="new_note_err">Введите заголовок и содержание!</div>
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-10">
                                <input size="15" type="text" class="form-control" id="noteTitle" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Содержание</label>
                            <div class="col-sm-10">
                                <TEXTAREA type="test" class="form-control" id="noteContent" rows="11"></TEXTAREA>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <a id="new_note_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Сохранить</a>
                                </div>
                                <div class="col-xs-4">
                                    <a id="new_note_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      
    <div class="md-modal" id="modal-edit-note">
        <div class="md-content" style="width: 795px;">
            <h3>Правка заметки<br></h3>
            <div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input size="15" type="text" class="form-control" id="editNoteTitle" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Содержание</label>
                        <div class="col-sm-10">
                            <TEXTAREA type="test" class="form-control" id="editNoteContent" rows="11"></TEXTAREA>
                        </div><span id="status"></span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                <!--<button id="edit_note_btn" type="submit" class="btn btn-primary" >Изменить</button>-->
                                <a id="edit_note_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Изменить</a>
                            </div>
                            <div class="col-xs-4">
                                <!--<button id="edit_note_cancel" type="submit" class="btn btn-default" >Отмена</button>-->
                                <a id="edit_note_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="md-modal" id="modal-remove-note">
        <div class="md-content">
            <h3>Удаление записи<br></h3>
            <div>
                <form class="form-horizontal"  >
                    <div class="form-group" >
                        <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: center;">Вы действительно хотите удалить запись в Базе Знаний?</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                <!--<button id="note_remove_btn" type="submit" class="btn btn-primary" >Да</button>-->
                                <a id="note_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-trash"></span> Да</a>
                            </div>
                            <div class="col-xs-4">
                                <!--<button id="note_remove_cancel" type="submit" class="btn btn-default" >Нет</button>-->
                                <a id="note_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="md-modal" id="modal-edit-user">
        <div class="md-content">
            <h3>Редактирование пользователя<br></h3>
            <div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
                        <div class="col-sm-10">
                            <input size="15" type="text" class="form-control" id="editUserLogin" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input size="15" type="password" class="form-control" id="editUserPassword" >                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">ФИО</label>
                        <div class="col-sm-10">
                            <input size="15" type="text" class="form-control" id="editUserFIO" >                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                <!--<button id="edit_user_btn" type="submit" class="btn btn-primary" >Изменить</button>-->
                                <a id="edit_user_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Изменить</a>
                            </div>
                            <div class="col-xs-4">
                                <!--<button id="edit_user_cancel" type="submit" class="btn btn-default" >Отмена</button>-->
                                <a id="edit_user_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="md-modal" id="modal-remove-user">
        <div class="md-content">
            <h3>Удаление пользователя<br></h3>
            <div>
                <form class="form-horizontal"  >
                    <div class="form-group" >
                        <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: center;">Вы уверены что хотите удалить пользователя?</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                <!--<button id="results_remove_btn" type="submit" class="btn btn-primary" >Да</button>-->
                                <a id="user_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-trash"></span> Да</a>
                            </div>
                            <div class="col-xs-4">
                                <!--<button id="results_remove_cancel" type="submit" class="btn btn-default" >Нет</button>-->
                                <a id="user_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="md-modal" id="modal-remove-result">
            <div class="md-content">
                <h3>Удаление результата теста<br></h3>
                <div>
                    <form class="form-horizontal"  >
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: center;">Вы действительно хотите удалить этот результат?</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 row">
                                <div class="col-xs-4">
                                    <!--<button id="results_remove_btn" type="submit" class="btn btn-primary" >Да</button>-->
                                    <a id="results_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-trash"></span> Да</a>
                                </div>
                                <div class="col-xs-4">
                                    <!--<button id="results_remove_cancel" type="submit" class="btn btn-default" >Нет</button>-->
                                    <a id="results_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    <div class="md-modal" id="modal-new-project">
        <div class="md-content" style="width: 795px;">
            <h3>Новый проект<br></h3><div class="new_project_err">Введите заголовок и описание!</div>
            <div>
                <form class="form-horizontal"  >
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input size="15" type="text" class="form-control" id="projectTitle" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <TEXTAREA type="test" class="form-control" id="projectDescription" rows="4"></TEXTAREA>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                 <a id="new_project_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Сохранить</a>
                            </div>
                            <div class="col-xs-4">
                                <a id="new_project_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="md-modal" id="modal-edit-project">
        <div class="md-content" style="width: 795px;">
            <h3>Редактирование проекта<br></h3>
            <div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input size="15" type="text" class="form-control" id="editProjectTitle" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <TEXTAREA type="test" class="form-control" id="editProjectDescription" rows="3"></TEXTAREA>
                        </div><span id="status"></span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                 <a id="edit_project_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Изменить</a>
                            </div>
                            <div class="col-xs-4">
                                <a id="edit_project_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="md-modal" id="modal-remove-project">
        <div class="md-content">
            <h3>Удаление проекта<br></h3>
            <div>
                <form class="form-horizontal"  >
                    <div class="alert alert-success"><span class="glyphicon glyphicon-question-sign"></span> Вы действительно хотите удалить Проект и все его заметки?</div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 row">
                            <div class="col-xs-4">
                                <a id="project_remove_btn" href="#" class="btn btn-success"><span class="glyphicon glyphicon-trash"></span> Да</a>
                            </div>
                            <div class="col-xs-4">
                                <a id="project_remove_cancel" href="#" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Нет</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



        <div id="fade" class="black_overlay"></div>




    <script type="text/javascript" >

        $(function(){


        });

        /* $(function(){
             var btnUpload=$('#upload');//
             var status=$('#status');
             new AjaxUpload(btnUpload, {
                 action: 'upload-file.php',
                 name: 'uploadfile',
                 onSubmit: function(file, ext){
                     if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                         // extension is not allowed
                         status.text('Поддерживаемые форматы JPG, PNG или GIF');
                         return false;
                     }
                     status.text('Загрузка...');
                 },
                 onComplete: function(file, response){
                     //On completion clear the status
                     status.text('');
                     //Add uploaded file to list
                     if(response==="success"){
                         $('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
                     } else{
                         $('<li></li>').appendTo('#files').text('Файл не загружен' + file).addClass('error');
                     }
                 }
             });

         });*/


    </script>

    <!--<div class="md-overlay"></div> the overlay element -->

      <script>
          $(document).ready(function(){

              var mass = [];
              function viewModel() {
                  var self = this;
                  self.currentView = ko.observable("home");
                  //self.myClass = ko.observable('test5');
                  self.views = ko.observableArray([]);
              }
              var vm = new viewModel();

              Sammy(function () {
                  this.get('#:view', function () {
                      vm.currentView(this.params.view);
                  });
                  /*this.get('#:notes/:id', function() {
                      alert(this.params['name'])
                      kbaseVM.cur_viewed_note = this.params['id'];
                      vm.currentView("notes");
                        //get_questions_editing(questionVM.cur_edit_que);
                      //req = kbaseVM.getNoteDetails(kbaseVM.cur_viewed_note, true);

                  });*/
                  this.get('#:questions/:id', function() {
                      //alert(89)

                      if(this.params['id']>1000){
                          vm.currentView("pages");
                          kbaseVM.cur_viewed_note = this.params['id'];

                          kbaseVM.cur_viewed_note = kbaseVM.cur_viewed_note - 1000;
                          req = kbaseVM.getNoteDetails(kbaseVM.cur_viewed_note);
                          req.success(function(result1){
                              $('#kbase_blk').html(result1);
                          });
                      }
                      else{
                          vm.currentView("questions");
                          questionVM.cur_edit_que = this.params['id'];
                          get_questions_editing(questionVM.cur_edit_que);
                      }

                  });

              }).run('#home')




                //console.log(userVM.crenditles)


               if(userVM.role > 0){
                   vm.views = [
                       {name: "home", title: "Главная"},
                       {name: "tests1", title: "Тесты"},
                       {name: "kbase", title: "База знаний"},
                       {name: "users", title: "Пользователи"},
                       {name: "results", title: "Результаты"},
                       {name: "profile", title: "Профиль"},
                       {name: "exit", title: "Выход"}
                   ];
               }
               else{
                   vm.views = [
                       {name: "home", title: "Главная"},
                       {name: "tests1", title: "Тесты"},
                       {name: "kbase", title: "База знаний"},
                       {name: "profile", title: "Профиль"},
                       {name: "exit", title: "Выход"}
                   ];
               }
               //console.log(userVM.role)




            vm.currentView.subscribe(function(newValue) {
                switch (newValue){
                    case "home":                        
                        /*$("#btnNewtask").click(function(){
                           spa.show_dialog("modal-new-test");
                        });
                        $("#sh_newquestion").click(function(){
                            spa.show_dialog("modal-new-que");
                        });
                        $("#new_note").click(function(){
                            spa.show_dialog("modal-new-note");
                        });*/

                        //userVM.get_user(userVM.u);
                        setTimeout(function(){             
                            if(userVM.role < 1){
                                $(".role1").hide();
                                $("#new_note").hide();
                                $("#btnNewtask").hide();                    
                            }              
                            else{
                                $(".role1-1").show();
                                $(".role1-2").show();                
                            }
                        }, 100);
                        break;
                     case "tests1":
                         testVM.get_tests("tests", userVM.role);
                         setTimeout(function(){
                             if(userVM.role < 1){
                                 $(".role1").hide();
                                 $("#new_note").hide();
                                 $("#btnNewtask").hide();
                                 //console.log(userVM.role,newValue)

                             }
                         }, 50);

                         break;
                     case "kbase":
                        // alert(4)
                        projectsVM.getProjectsList("projects_blk");
                         setTimeout(function(){
                             if(userVM.role < 1){
                                 $(".role1").hide();
                                 $("#new_note").hide();
                                 $("#btnNewtask").hide();
                                 //console.log(userVM.role,newValue)
                             }
                         },50)
                        break;
                    case "users":
                        req = userVM.get_users();
                        req.success(function(result1){
                            $('#users2').html(result1);
                        });
                        break;
                     case "results":
                         req = resultsVM.get_results();
                         req.success(function(result1){
                             $('#results_blk').html(result1);
                             $("#export_to_excel_btn").click(function(){
                                  resultsVM.export_results();
                                 })
                              });
                         break;
                     case "questions":
                         alert(baseVM.cur_viewed_note)
                        if(kbaseVM.cur_viewed_note > 0){
                            req = kbaseVM.getNoteDetails(kbaseVM.cur_viewed_note);
                            req.success(function(result1){
                                $('#kbase_blk').html(result1);
                            });
                        }
                         break;
                    case "pages":
                        /*
                         break;*/
                    case "profile":
                        $('#user_login').text(userVM.login);
                        $('#user_fio').text(userVM.user_fio);
                        break;
                    case "exit":
                        userVM.exit_user();
                        break;
                }
            });


            ko.applyBindings(vm);
               
               /* .error(message, original_error){
                    alert(message+" "+original_error)
            })*/;


          })

var editNC = $("#editNoteContent")/*.css("height","100%").css("width","100%")*/.htmlbox({
    toolbars:[
        [   
        "separator","cut","copy","paste",
        "separator","undo","redo",
        "separator","bold","italic","underline","strike","sup","sub",
        "separator","justify","left","center","right",    
        "separator","ol","ul","indent","outdent",     
        "separator","link","unlink","image"        
        ],
        [
        "separator","code",
         "separator","formats","fontsize","fontfamily",
        "separator","fontcolor","highlight",
        ],
        [
        "separator","removeformat","striptags","hr","paragraph",
        "separator","quote","styles","syntax"
        ]
    ],
    skin:"blue"
});
var newNC = $("#noteContent")/*.css("height","100%").css("width","100%")*/.htmlbox({
    toolbars:[
        [   
        "separator","cut","copy","paste",
        "separator","undo","redo",
        "separator","bold","italic","underline","strike","sup","sub",
        "separator","justify","left","center","right",    
        "separator","ol","ul","indent","outdent",     
        "separator","link","unlink","image"        
        ],
        [
        "separator","code",
         "separator","formats","fontsize","fontfamily",
        "separator","fontcolor","highlight",
        ],
        [
        "separator","removeformat","striptags","hr","paragraph",
        "separator","quote","styles","syntax"
        ]
    ],
    skin:"blue"
});
            </script>
    <script type='text/javascript' src='js/bootstrap.min.js'></script>

</body>
</html>
