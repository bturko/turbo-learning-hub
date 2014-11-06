<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>Авторизация - Contactis Learning Hub</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0" />
    <link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/bootstrap.icon-large.min.css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/component.css" />

    <script type='text/javascript' src='js/log.js'></script>
    <script type='text/javascript' src='vendors/jquery17.js'></script>
    <script type='text/javascript' src='vendors/fileuploader.js'></script>
    <script type='text/javascript' src='js/user.js'></script>
    <script type='text/javascript' src='js/class/spa.js'></script>
    <script type='text/javascript' src='js/main.js'></script>
</head>
<body>
<div id="informer"></div>
<div class="container">
    <div class="row vertical-center-row">
        <div class="col-lg-12">
            <div class="row ">
                <h1><div class="circular">&nbsp;Contactis&nbsp;Learning&nbsp;Hub</div></h1>

                <section id="set-8">
                    <div class="hi-icon-wrap hi-icon-effect-8">
                        <table align="center">
                            <tr>
                                <td>
                                    <a href="#" title="Вход" class="hi-icon hi-icon-user" onclick="showLoginDlg();"> </a> <!-- spa.show_popup('login') -->
                                </td>
                                <td>
                                    <a href="#" title="Регистрация" class="hi-icon hi-icon-contract" onclick="showRegisterDlg();"> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Вход</td>
                                <td>Регистрация</td>
                            </tr>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
<div class="footer">&copy 2014 - <?php echo date("Y");?>, turBO, v <span id="app_version"></span></div>





<div class="md-modal" id="modal-log-in">
    <div class="md-content">
        <h3>Вход<br></h3><div class="log_in_err">Введите логин и пароль!</div>
        <div>
            <form class="form-horizontal"  >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
                    <div class="col-sm-10">
                        <input size="15" type="text" class="form-control" id="my_login" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="my_password" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 row">
                        <div class="col-xs-4">
                            <button id="btnLogin" type="submit" class="btn btn-primary" >Войти</button>
                        </div>
                        <div class="col-xs-4">
                            <button id="btnLoginCancel" type="submit" class="btn btn-default" >Отмена</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="md-modal" id="modal-reg-user">
    <div class="md-content">
        <h3>Вход<br></h3><div class="register_err">Заполните все поля!</div>
        <div>
            <form class="form-horizontal" role="form" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_login" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="u_password" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">ФИО</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_fio" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 row">
                        <div class="col-xs-4">
                            <button id="btnRegister" type="submit" class="btn btn-primary" >Регистрация</button>
                        </div>
                        <div class="col-xs-4">
                            <button id="btnRegisterCancel" type="submit" class="btn btn-default" >Отмена</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--

-->




<div id="fade" class="black_overlay"></div>

<script>
    //var all_crenditles =[];
    $(document).ready(function(){
        req = spa.check_existing_db();
        req.success(function( response ){
           if(response != "Ok"){
                logVM.informer("Не удается подключиться к базе данных 'clh'! Возможно она не сущетвует", true)
            }
        });

         if(spa.getCookie("userName")!=undefined){
                setTimeout(function(){
                     window.location.replace('main.php#home');
                 }, 500);
         }

          $.ajax({
                url: "ajax.php?check_user",
                data: {login: $("#my_login").val()+Math.random(), password: $("#my_password").val()+Math.random()},
                method: "post"
            })
            .success(function(response){
                   // console.log(response);
                });

    })


    function login(){
        if($("#my_login").val()=="" || $("#my_password").val()==""){
            $(".log_in_err").show();
        }
        else{
            //console.log(userVM.crenditles.length, userVM.crenditles)
            var not_equal = true;
            for(var i = 0; i < userVM.crenditles.length; i++){
                if(userVM.crenditles[i].login==$("#my_login").val()){
                    not_equal =false;
                    if( userVM.crenditles[i].password == sha1( $("#my_password").val()) ){
                        var date = new Date( new Date().getTime() + 120*60*1000 );//120 min
                        document.cookie ='userName' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        document.cookie="userName="+$("#my_login").val()+", fio="+userVM.fio+", role="+userVM.role+"; path=/; expires="+date.toUTCString();

                        setTimeout(function(){
                            window.location.replace('main.php#home');
                        }, 10);
                    }
                    else{
                        alert("Неверный пароль!" );
                    }


                }
            }
            if(not_equal == true){
                setTimeout(function(){
                    alert("Неверные учетные данные!" );
                }, 190);
            }

           // alert( sha1($("#my_login").val()) );
         /* $.ajaxSetup({ cache: false });
            $.ajax({
                url: "ajax.php?check_user",
                data: {login: $("#my_login").val(), password: $("#my_password").val(), ran: +Math.random()},
                method: "post"
            })
            .success(function(response){

                var json = JSON.parse(response);
                 if(json.status=="true"){
                    var date = new Date( new Date().getTime() + 120*60*1000 );//120 min
                    document.cookie ='userName' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    document.cookie="userName="+json.login+", fio="+json.fio+", role="+json.role+"; path=/; expires="+date.toUTCString();


                    setTimeout(function(){
                         window.location.replace('main.php#home');
                     }, 100);
                       
                }
                else{
                   alert("Ошибка входа! Попробуйте снова!" );
                }
            })
            .fail(function(xhr,status,err){

            });*/

        }

    }
    function register(){
        if($("#u_login").val()=="" || $("#u_password").val()=="" || $("#u_fio").val()==""){
            $(".register_err").show();
        }
        else{
            req = userVM.create_user($("#u_login").val(), $("#u_password").val(), $("#u_fio").val());
            req.success(function( response ){
                var json = JSON.parse(response)
                if(json.status=="Ok"){
                    hideRegisterDlg();
                    logVM.informer("Вы успешно зарегистрировались! Теперь можете авторизоваться.")
                }
                else{
                    //hideRegisterDlg();
                    logVM.informer("Ошибка: "+json.message)
                }
            });
        }
    }
    function showLoginDlg(){
        $("#modal-log-in").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "visible",
            "opacity": "1"
        });
        $("#fade").fadeIn().animate({"opacity": "0.7"});
       userVM.get_crenditles();
    }
    function hideLoginDlg(){
        $("#modal-log-in").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "hidden",
            "opacity": "0"
        });
        //$(".black_overlay").css({"opacity": "0", "display": "none"})
        $("#fade").fadeOut().animate({"opacity": "0"}, 700);
        $("#log_in_err").show();
    }

    $(document).ready(function(){
        $("#btnLogin").click(function(){
            login();
        });
        $("#btnLoginCancel").click(function(){
            hideLoginDlg();
            $(".log_in_err").hide();
        });
        $("#btnRegister").click(function(){
            register();
        });
        $("#btnRegisterCancel").click(function(){
            hideRegisterDlg();
            $(".register_err").hide();
            //$(".new_test_err").css({"display": "none"});
        });
    });



    function showRegisterDlg(){
        $("#modal-reg-user").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "visible",
            "opacity": "1"
        });
        $("#fade").fadeIn().animate({"opacity": "0.7"});
    }
    function hideRegisterDlg(){
        $("#modal-reg-user").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "hidden",
            "opacity": "0"
        });
        $("#fade").fadeOut().animate({"opacity": "0"}, 700);
        //$("#log_in_err").show();
        $(".register_err").hide();
    }
</script>
</body>
</html>
