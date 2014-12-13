function Quetions() {
    var self = {};
    self.cur_question = 0;
    self.question_cnt = 0;
    self.cur_edit_que = 0;
    self.remove_que_id = 0;
    self.edit_que_id = 0;
    self.test_id = 0;
    self.right_answers = [];
    self.selected_values = [];
    self.questions = {};
    self.results = ""; // Error answers string
    self.right_answers_count = 0;
    self.cc = 0;

    self.addQuestion = function(test_id, text, var0, var1, var2, var3, var4, rig_var){
        var req = $.ajax({
            url: "ajax.php?addQuestion",
            data: {"test_id": test_id, "text": text, "var0": var0, "var1": var1, "var2": var2, "var3": var3, var4: var4, rig_var: rig_var},
            method: "post"
        })
            .success(function(response){
                self.getQuestionsList(test_id);
            })
            .fail(function(response){
            });
        return req;
    }
    self.getQuestionsList = function(test_id){
        if(test_id >0){
            var req = $.ajax({
                url: "ajax.php?getQuestionsList",
                data: {"test_id": test_id, "login": userVM.login},
                method: "post"
            })
                .success(function(response){
                     $("#q_blk_content").html(response);
                    $("#sh_newquestion").click(function(){
                       // alert(345);
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
                })
                .fail(function(response){
                });
            return req;
        }
        else{
            logVM.i("getQuestionsList: Отсутствует обязательный параметр!");
            return "";
        }
    }
    self.getQuestionForEditing = function(){
        $.ajax({
            url: "ajax.php?getQuestionForEditing",
            method: "post",
            data: {
                test_id: test_id
            }
        })
            .success(function(response){
                $("#q_blk_content").html(response)

            })
            .error(function(response){
                $("#test_messages").html('<div class="alert alert-error" role="alert"Ошибка!</div>');
            })
            .complete(function(){

            });
    }
    self.next = function(){
        if( $('input[name=gn'+self.cur_question+']:checked').val() != undefined || $("#my_answer").val()!=""){
            spa.change_uri("tests")
            $("#question"+self.cur_question).hide(500);


            var answers = self.questions[self.cur_question].answers.split("|");
            var right_answer = self.questions[self.cur_question].right_answer;
            var next_q = self.cur_question+1;

            //--> CHECK IF ANSWER IS RIGHT
            if(self.questions[self.cur_question].opened==1){ //--> OPENED
                //my_answer_val = $('#my_answer').val();
                if(answers[0]==$('#my_answer').val() ) {
                    self.right_answers_count++;
                }
                else{ //--> wrong answer
                    self.results += "<br> "+next_q+". Ошибка! Ваш ответ: "+$('#my_answer').val()+" Правильный: "+answers[0];
                }
            }
            else{ //--> NOT OPENED
                my_answer_val = $('input[name=gn'+self.cur_question+']:checked').val();
                if(my_answer_val == right_answer-1) {
                    self.right_answers_count++;
                }
                else{ //--> wrong answer
                    self.results += "<br> "+next_q+". Ошибка! Ваш ответ: "+answers[my_answer_val]+" Правильный: "+answers[right_answer-1];
                }
            }


            $("#my_answer").val("");


            self.cur_question++;
            $("#question"+self.cur_question).show(500);

            self.cc = self.cur_question;
            if( self.cur_question < self.question_cnt) self.cc = self.cc +1;
            $("#que_counter").text(self.cc+"/"+self.question_cnt);



            //--> Saving results
            if( self.cur_question >= self.question_cnt) {
                var req = questionVM.set_result();
                req.success(function(){
                    logVM.informer("Результат теста зафиксирован!");
                    $("#quiz_results").show(500);
                    $("#watch_que_cancel").hide();
                    $("#next").hide();
                    $("#my_results").html(self.right_answers_count+"/"+self.question_cnt+"<br><br>"+self.results+"<Br><br>");
                    testsVM.getTestsList("tests_blk", userVM.role)
                });

            }
        }
        else{
            alert("Введите ответ!")
        }
    }
    self.removeQuestion = function(que_id){
        var req = $.ajax({
            url: "ajax.php?removeQuestion",
            data: {"que_id": que_id},
            method: "post"
        })
            .success(function(response){
                //alert(self.test_id);
                self.getQuestionsList(self.cur_edit_que);
            })
            .fail(function(response){
                //return req;
            });
        return req;
    }
    self.getQuestionForEditing = function(que_id){
        var req = $.ajax({
            url: "ajax.php?getQuestionForEditing",
            data: {"que_id": que_id},
            method: "get"
        })
            .success(function(response){

            })
            .fail(function(response){
                //return req;
            });
        return req;
    }
    self.updateQuestion = function(q_id, test_id, text, var0, var1, var2, var3, var4, rig_var, test_id){
        var req = $.ajax({
            url: "ajax.php?updateQuestion",
            data: {"q_id": q_id, "test_id": test_id, "text": text, "opened": var0, "var1": var1, "var2": var2, "var3": var3, var4: var4, rig_var: rig_var, test_id: test_id},
            method: "post"
        })
            .success(function(response){
                self.getQuestionsList(self.cur_edit_que);
            })
            .fail(function(response){
                //return req;
            });
        return req;
    }
    self.set_result = function(){
        var req = $.ajax({
            url: "ajax.php?set_testresult",
            data: {"test_id": self.test_id, "login": userVM.login, "answers_cnt": self.question_cnt, "right_cnt": self.right_answers_count, "fio": userVM.user_fio},
            method: "post"
        })
            .success(function(response){

            })
            .fail(function(response){
                //return req;
            });
        return req;
    }
    
    return self;
}

var questionVM = new Quetions;
