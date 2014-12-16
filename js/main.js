

    $(document).ready(function(){

        spa.set_app_version( spa.app_version );


         if(spa.getCookie("userName")!=undefined){
            
           var m = spa.getCookie("userName").split(",");
            userVM.login = m[0]; //spa.getCookie("userName");

             //console.log(userVM)
             if(userVM.user_fio=="") userVM.get_user_by_login(  userVM.login );


            userVM.user_fio = m[1].substr(5, m[1].length-4); //spa.getCookie("fio");
            userVM.role = m[2].slice(-1); //spa.getCookie("role");
            //console.info("Cookies found! Authorization checking!", userVM.user_fio)

            setInterval(function(){
                $("#user_login").text(userVM.login);
                $("#user_fio").text(userVM.user_fio);
                if( userVM.role < 1){
                    $("#user_role").text("Оператор");
                }
                else{
                    $("#user_role").text("Администратор");
                }
            }, 3200)


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
          

        }
        else{ 
           //alert("spa.getCookie('userName')!=undefined");
            var path = window.location.pathname;
            var page = path.split("/").pop();
            //console.log( page );
            if(page=="main.php"){
                //console.warn("Cookies undefined! Need log-in!")
                location.replace("index.php")
            }
       }

       // console.log($(".nav-pills>li").css("display"))

       setTimeout(function(){

        }, 200)
        setTimeout(function(){
            if(userVM.role < 1){
                $(".role1").hide();
            }
        }, 1200);




       // $("ul>li:last-child").hide();


        setTimeout(function(){
            $("#btnNewtask").click(function(){
               spa.show_dialog("modal-new-test");
            });
            $("#sh_newquestion").click(function(){
                //alert(23423423)
                $("#newQueText").val("");
                $("#var0").attr('checked', false);
                $("#new_cb_toggle_blk").show();
                $("#var1").val("");
                $("#var2").val("");
                $("#var3").val("");
                $("#var4").val("");
                $("#rig_var :nth-child(1)").attr("selected", "selected");
                spa.show_dialog("modal-new-que");
            });
            $("#new_note").click(function(){
                $("#noteTitle").val("");
                newNC.set_text("");
                spa.show_dialog("modal-new-note");
            });
       }, 1500);

       /* setInterval(function(){
            $("#btnNewtask").click(function(){
               spa.show_dialog("modal-new-test");
            });
           $("#new_note").click(function(){
                spa.show_dialog("modal-new-note");
            });
        }, 2000);*/



       $("#test_create").click(function(){
            $("#test_create_blk").show(500);
        });
        $("#test_create_btn").click(function(){
            if($("#newTaskTitle").val()==""){
                $(".new_test_err").css({"display": "block"});
            }
            else{
                testVM.createTest($("#newTaskTitle").val(), $("#newTaskDescription").val(), userVM.role)
                spa.hide_dialog("modal-new-test");
                spa.change_uri("tests")
            }
            
        });



        $("#test_create_cancel").click(function(){
            spa.hide_dialog("modal-new-test");
          $(".new_test_err").css({"display": "none"});
            spa.change_uri("tests")
        });



        $("#test_remove_btn").click(function(){
            testVM.removeTest(spa.cur_remove_test_id);
             spa.change_uri("tests");
        });


        $("#test_remove_cancel").click(function(){
            spa.change_uri("tests")
            hideRemoveTestDlg();
        });


        $("#test_edit_btn").click(function(){
            testVM.updateTest();
        });


        $("#test_edit_cancel").click(function(){
            spa.hide_dialog("modal-edit-test");
            spa.change_uri("tests")
        });

        $("#watch_que_btn").click(function(){
             $("#question0").show(500);
            $("#next").show();
            $("#watch_que_btn").hide();
            spa.change_uri("tests");
            $("#que_counter").text("1/"+questionVM.question_cnt);
            questionVM.cur_question = 0;
            questionVM.results = "";
        });

        $("#watch_que_cancel").click(function(){
            spa.hide_popup("watch_test_popup");
            $("#next").hide();
            $("#watch_que_btn").show();
            //hideEditTestDlg();
            spa.change_uri("tests")
        });

        $("#watch_que_close").click(function(){
            spa.hide_popup("watch_test_popup");
            spa.change_uri("tests");

           //req.success(function(){
                questionVM.cur_question = 0;
                questionVM.right_answers_count = 0;
                questionVM.right_answers = [];


                setTimeout(function(){
                    $("#quiz_results").hide()
                    $("#watch_que_btn").show()
                    $("#watch_que_cancel").show()   
                }, 1000); 
            //})                    
        });



        $("#que_new_cancel").click(function(){
            //hideNewQueDlg();
            spa.hide_dialog("modal-new-que");
            spa.change_uri("questions/" + questionVM.cur_edit_que)
        });

        $("#que_new_btn").click(function(){
            if( $("#newQueText").val()!="" && $("#var1").val()!="" ){
                var req = questionVM.addQuestion(questionVM.cur_edit_que ,$("#newQueText").val(), $("#var0").is(":checked"), $("#var1").val(), $("#var2").val(),$("#var3").val(),$("#var4").val(),$("#rig_var").val())
                req.success(function(){
                    logVM.informer("Вопрос успешно создан!");
                })
                spa.hide_dialog("modal-new-que");
                spa.change_uri("questions/"+questionVM.cur_edit_que)
            }
            else{
                $(".new_que_err").show();
                spa.change_uri("questions/"+questionVM.cur_edit_que)
            }

        });

        $("#que_remove_btn").click(function(){
            var req = questionVM.removeQuestion(questionVM.remove_que_id);
            req.success(function(){
                logVM.informer("Вопрос успешно удален!")
            })
            spa.change_uri("questions/"+questionVM.cur_edit_que)
            spa.hide_dialog("modal-remove-que")
            //hideRemoveQueDlg();
        });

        $("#que_remove_cancel").click(function(){
            spa.hide_dialog("modal-remove-que")
            spa.change_uri("questions/"+questionVM.cur_edit_que)
            //hideRemoveQueDlg();
        });




        $("#new_note_btn").click(function(){
            if( $("#noteTitle").val()==""/* || $("#noteContent").val()==""*/ ){
                $(".new_note_err").show();
            }
            else{
                var req = kbaseVM.createNote($("#noteTitle").val(), $("#noteContent").val(), "kbase_blk");
                /*setTimeout(function(){
                    projectsVM.getProjectsList("projects_blk");
                }, 700);*/
                spa.hide_dialog("modal-new-note");
                $("#noteTitle").val("");
                newNC.set_text("");
                spa.change_uri("kbase")
            }

        });

        $("#new_note_cancel").click(function(){
            //hideNewNoteDlg();
            spa.hide_dialog("modal-new-note");
            $("#noteTitle").val("");
            newNC.set_text("");
            spa.change_uri("kbase")
        });

        $("#edit_note_btn").click(function(){
            kbaseVM.updateNote( $("#editNoteTitle").val(), $("#editNoteContent").val(), "kbase_blk" )
            spa.hide_dialog("modal-edit-note");
            var a = 1000 + kbaseVM.cur_viewed_note;
            spa.change_uri("questions/"+a);
        });


        $("#edit_note_cancel").click(function(){
            //hideNewNoteDlg();
            spa.hide_dialog("modal-edit-note");
            var a = 1000 + kbaseVM.cur_viewed_note;
            spa.change_uri("questions/"+a);
        });



        $("#que_edit_btn").click(function(){
            test_id = questionVM.cur_edit_que;
            var req = questionVM.updateQuestion(questionVM.edit_que_id, questionVM.test_id, $("#editQueText").val(), $("#editvar0").is(":checked"), $("#editvar1").val(), $("#editvar2").val(), $("#editvar3").val(), $("#editvar4").val(), $("#editrig_var option:selected").val())
            //console.log(req)
            req.success(function(){
               logVM.informer("Вопрос успешно изменен!")
            })
            spa.hide_dialog("modal-edit-que");
            spa.change_uri("questions/"+questionVM.cur_edit_que);
        });

        $("#que_edit_cancel").click(function(){
            spa.hide_dialog("modal-edit-que");
            spa.change_uri("questions/"+questionVM.cur_edit_que);
        });


        $("#edit_user_btn").click(function(){
            var req = userVM.update_user($("#editUserLogin").val(), $("#editUserPassword").val(), $("#editUserFIO").val())
            //console.log(req)
            req.success(function(response){
               logVM.informer("Пользователь успешно отредактирован!")
                spa.hide_dialog("modal-edit-user");               
                $("#users2").html(response);
                //alert(response)
            })
             spa.change_uri("users");
           
        });



        $("#edit_user_cancel").click(function(){
            spa.hide_dialog("modal-edit-user");
            spa.change_uri("users");
        });


        $("#results_remove_btn").click(function(){
            var req = resultsVM.remove_result();
            req.success(function(response){
                var json = JSON.parse(response);
                if(json.status == "success"){
                    logVM.informer("Результат был удален!")
                    spa.hide_dialog("modal-remove-result");                                   
                    setTimeout(function(){                        
                        var req0 = resultsVM.get_results();
                        req0.success(function(response0){
                            $("#results_blk").html(response0); 
                        });    
                    }, 200);
                }
                else{
                    logVM.informer("Возникла ошибка!")
                }
                              
            })
            spa.change_uri("results");           
        });

        $("#results_remove_cancel").click(function(){
            spa.hide_dialog("modal-remove-result");
            spa.change_uri("results");
        });


        $("#note_remove_btn").click(function(){
            var req = kbaseVM.removeNote();
            req.success(function(response){
                var json = JSON.parse(response);
                if(json.status == "Ok"){
                    logVM.informer("Запись была удалена!")
                    spa.hide_dialog("modal-remove-note");
                    setTimeout(function(){
                         kbaseVM.get_kbase("kbase_blk");
                    }, 200);
                }
                else{
                    logVM.informer("Возникла ошибка!", true)
                }
            });
            spa.hide_dialog("modal-remove-note");

            //location.reload("#kbase");
        });

        $("#note_remove_cancel").click(function(){
            spa.hide_dialog("modal-remove-note");
            var a = 1000 + kbaseVM.cur_viewed_note;
            spa.change_uri("questions/"+a);
        });

        $("#user_remove_btn").click(function(){
            var req = userVM.remove_user(userVM.removing_user_id);
            req.success(function(response){
                var json = JSON.parse(response);
                if(json.status == "removed"){
                    logVM.informer("Пользователь был удален!")
                    spa.hide_dialog("modal-remove-user");

                }
                else{
                    logVM.informer("Возникла ошибка!", true)
                }
            });
            //spa.hide_dialog("modal-remove-note");
            spa.change_uri("users");
        });

        $("#user_remove_cancel").click(function(){
            spa.hide_dialog("modal-remove-user");
            spa.change_uri("users");
        });



        $("#new_project_btn").click(function(){
            if( $("#projectTitle").val()=="" ){
                $(".new_project_err").show();
            }
            else{
                var req = projectsVM.createProject($("#projectTitle").val(), $("#projectDescription").val(), "projects_blk");

                spa.hide_dialog("modal-new-project");
                $("#projectTitle").val("");
                $("#projectDescription").val("");
                //newNC.set_text("");
                spa.change_uri("kbase")
            }

        });

        $("#new_project_cancel").click(function(){
            spa.hide_dialog("modal-new-project");
            $("#projectTitle").val("");
            $("#projectDescription").val("");
            //newNC.set_text("");
            spa.change_uri("kbase")
        });


        $("#project_remove_btn").click(function(){
            var req = projectsVM.removeProject(projectsVM.remove_project_id);
            req.success(function(response){
                var json = JSON.parse(response);
                if(json.status == "removed"){
                    logVM.informer("Проект был удален!")
                    spa.hide_dialog("modal-remove-project");
                }
                else{
                    logVM.informer("Возникла ошибка!", true)
                }
            });
            spa.change_uri("kbase");
        });

        $("#project_remove_cancel").click(function(){
            spa.hide_dialog("modal-remove-project");
            spa.change_uri("kbase");
        });

        $("#edit_project_btn").click(function(){
            projectsVM.updateProject( $("#editProjectTitle").val(), $("#editProjectDescription").val(), "projects_blk" )
            spa.hide_dialog("modal-edit-project");
            spa.change_uri("kbase")
        });


        $("#edit_project_cancel").click(function(){
            spa.hide_dialog("modal-edit-project");
            spa.change_uri("kbase")
        });


        if(userVM.login!="admin"){
            $(".svetik").css("display", "none");
        }
    });


    function remove_test(test_id){
        spa.cur_remove_test_id = test_id;
        showRemoveTestDlg();
    }

    function remove_user(user_id){
        userVM.removing_user_id = user_id;
        spa.show_dialog("modal-remove-user");
    }

    function remove_project(project_id){
        projectsVM.remove_project_id = project_id;
        spa.show_dialog("modal-remove-project");
    }

    function edit_project(project_id){
        projectsVM.getProjectDetails(project_id);
        spa.show_dialog("modal-edit-project");

    }

    function create_note(project_id){
        kbaseVM.creating_note_proj_id = project_id;
        spa.show_dialog("modal-new-note");
    }

    function showRemoveTestDlg(){
        $("#modal-remove-test").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "visible",
            "opacity": "1"
           });
    }
    function hideRemoveTestDlg(){
        $("#modal-remove-test").css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "hidden",
            "opacity": "0"
           });
    }


    function watch_test(test_id){
//alert(123);
        questionVM.test_id = test_id;
        var req = questionVM.getTestQuestions(test_id);
        req.success(function( response ){
        $("#sh_newquestion").click(function(){
             $("#newQueText").val("");
             $("#var0").attr('checked', false);
             $("#new_cb_toggle_blk").show();
             $("#var1").val("");
             $("#var2").val("");
             $("#var3").val("");
             $("#var4").val("");
             $("#rig_var :nth-child(1)").attr("selected", "selected");
             spa.show_dialog("modal-new-que");
        });

        var json = JSON.parse(response);
        if(json.title=="you are answered"){
            logVM.informer("Вы уже отвечали на этот тест!")
        }
        else{
            var html = "<div class='question_title'><center>"+json.title+"<br><span style='color; #575757;'>Описание: "+json.description+"</span><br>Кол-во вопросов: <span id='que_counter'>"+json.cnt+"</span></center></div>";

            questionVM.question_cnt = json.cnt;
            questionVM.questions = json.questions;
            if(json.cnt < 1 ){$("#watch_que_btn").attr("disabled", "disabled");}else{$("#watch_que_btn").removeAttr("disabled");}
            $("#my_results").html("");

            for(i = 0; i < json.cnt; i++){
                j=i+1;
                html += '<div id="question'+i+'" class="question">'+j+'. '+json.questions[i].text + '<div class="answers">';
                mas = json.questions[i].answers.split("|");
                questionVM.right_answers.push(json.questions[i].right_answer);
                if(json.questions[i].opened=="0") json.questions[i].opened=false;
//alert(json.questions[i].opened)
                if(json.questions[i].opened==true || json.questions[i].opened==1 || json.questions[i].opened=="true"){
                    html += 'Ответ: <INPUT type="text" id="my_answer">';
                }
                else{
                    for(j = 0; j < mas.length; j++){
                        html += '<INPUT name="gn'+i+'" type="radio" value="'+j+'"/ >'+ mas[j]+'<br>';
                    }
                }
                html +='</div></div>';
            }
            $("#que_blk").html(html);
            spa.show_popup('watch_test_popup');
//alert(8787)
            }
            
        });

    }

function edit_test(test_id){
    //alert(343)
    spa.cur_edit_test_id = test_id;
    spa.show_dialog("modal-edit-test");
    testVM.get_test_details( test_id );
}

function get_questions_editing(test_id){
    questionVM.getQuestionsList(test_id);
}


/*function showEditTestDlg(){
    $("#modal-edit-test").css({
        "-webkit-perspective": "1300px",
        "-webkit-animation-duration": "1s",
        "animation-duration": "2s",
        "visibility": "visible",
        "opacity": "1"
    });
}
function hideEditTestDlg(){
    $("#modal-edit-test").css({
        "-webkit-perspective": "1300px",
        "-webkit-animation-duration": "1s",
        "animation-duration": "2s",
        "visibility": "hidden",
        "opacity": "0"
    });
}*/


function watch_questions(test_id){
    spa.show_popup("watch_questions_popup")
}



function remove_question(que_id){
    questionVM.remove_que_id = que_id;
    spa.show_dialog("modal-remove-que");
}

function edit_que(que_id){
    questionVM.edit_que_id = que_id;
    questionVM.test_id = questionVM.cur_edit_que;
    //questionVM.edit_que_id = que;
    //showRemoveQueDlg();
    var req = questionVM.getQuestionForEditing(que_id);
    //console.log(req)
    req.success(function(jsontext){
        //console.log(jsontext)
        var json = JSON.parse(jsontext)
        //alert(json.status)
        if(json.status=="Ok"){
            //alert(json.text)
            $("#editQueText").val(json.text);
            var answers = json.answers.split("|");
            if(json.opened=="0") json.opened=false;

            if(json.opened==true || json.opened==1 || json.opened=="true"){
                //alert(2)
                $("#edit_cb_toggle_blk").hide();
                $("#editvar0").attr("checked", true);
            }
            else{
                //alert(5)
                $("#edit_cb_toggle_blk").show();
                $("#editvar0").attr("checked", false);
            }
            $("#editvar1").val(answers[0]);
            $("#editvar2").val(answers[1]);
            $("#editvar3").val(answers[2]);
            $("#editvar4").val(answers[3]);
            $("#editrig_var option[value="+json.right_answer+"]").attr('selected','selected');
        }
        else{
            $("#editQueText").val("[Ошибка!]");
        }

    });
    spa.show_dialog("modal-edit-que")
}

    function remove_result(result_id){
        resultsVM.remove_result_id = result_id;
        spa.show_dialog("modal-remove-result")
    }
    function remove_note(note_id){
        kbaseVM.remove_id = note_id;
        spa.show_dialog("modal-remove-note")
    }


    /**
     *  Secure Hash Algorithm (SHA1)
     *  http://www.webtoolkit.info/
     **/
    function sha1(msg) {
        function rotate_left(n,s) {
            var t4 = ( n<<s ) | (n>>>(32-s));
            return t4;
        };
        function lsb_hex(val) {
            var str="";
            var i;
            var vh;
            var vl;
            for( i=0; i<=6; i+=2 ) {
                vh = (val>>>(i*4+4))&0x0f;
                vl = (val>>>(i*4))&0x0f;
                str += vh.toString(16) + vl.toString(16);
            }
            return str;
        };
        function cvt_hex(val) {
            var str="";
            var i;
            var v;
            for( i=7; i>=0; i-- ) {
                v = (val>>>(i*4))&0x0f;
                str += v.toString(16);
            }
            return str;
        };
        function Utf8Encode(string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";
            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        };
        var blockstart;
        var i, j;
        var W = new Array(80);
        var H0 = 0x67452301;
        var H1 = 0xEFCDAB89;
        var H2 = 0x98BADCFE;
        var H3 = 0x10325476;
        var H4 = 0xC3D2E1F0;
        var A, B, C, D, E;
        var temp;
        msg = Utf8Encode(msg);
        var msg_len = msg.length;
        var word_array = new Array();
        for( i=0; i<msg_len-3; i+=4 ) {
            j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
                msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
            word_array.push( j );
        }
        switch( msg_len % 4 ) {
            case 0:
                i = 0x080000000;
                break;
            case 1:
                i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
                break;
            case 2:
                i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
                break;
            case 3:
                i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8  | 0x80;
                break;
        }
        word_array.push( i );
        while( (word_array.length % 16) != 14 ) word_array.push( 0 );
        word_array.push( msg_len>>>29 );
        word_array.push( (msg_len<<3)&0x0ffffffff );
        for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
            for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
            for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
            A = H0;
            B = H1;
            C = H2;
            D = H3;
            E = H4;
            for( i= 0; i<=19; i++ ) {
                temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B,30);
                B = A;
                A = temp;
            }
            for( i=20; i<=39; i++ ) {
                temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B,30);
                B = A;
                A = temp;
            }
            for( i=40; i<=59; i++ ) {
                temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B,30);
                B = A;
                A = temp;
            }
            for( i=60; i<=79; i++ ) {
                temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B,30);
                B = A;
                A = temp;
            }
            H0 = (H0 + A) & 0x0ffffffff;
            H1 = (H1 + B) & 0x0ffffffff;
            H2 = (H2 + C) & 0x0ffffffff;
            H3 = (H3 + D) & 0x0ffffffff;
            H4 = (H4 + E) & 0x0ffffffff;
        }
        var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

        return temp.toLowerCase();
    }

    function new_cb_toggle(){
        if( $("#new_cb_toggle_blk").css("display")=="block" ){
            $("#new_cb_toggle_blk").slideUp(500);
            $("#var1_label").text("Ответ");
        }
        else{
            $("#new_cb_toggle_blk").slideDown(500);
            $("#var1_label").text("Вариант1");
        }
    }
    function edit_cb_toggle(){
         if( $("#edit_cb_toggle_blk").css("display")=="block" ){
            $("#edit_cb_toggle_blk").slideUp(500);
            $("#editvar1_label").text("Ответ");
        }
        else{
            $("#edit_cb_toggle_blk").slideDown(500);
            $("#editvar1_label").text("Вариант1");
        }
    }


function redir_url(){
    //window.location.replace("main.php#notes/1/15");
}

