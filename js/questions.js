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
    self.get_questions = function(test_id){
        if(test_id){
            var req = $.ajax({
                url: "ajax.php?get_questions",
                data: {"testId": test_id, "login": userVM.login},
                method: "post"
            })
                .success(function(response){
                   // logVM.i("get_questions: "+response);
                    //alert(response)
                    var json = JSON.parse(response)
                    if(json.title=="no_params") logVM.informer("Не передан параметр!") //$("q_blk_content").html("<table><tr><td style=''>Вопросов еще нет</td></tr></table>")
                })
                .fail(function(response){
                    //return req;
                });
            return req;
        }
        else{
            logVM.i("get_questions: Отсутствует обязательный параметр!");
            return "";
        }
    }
    self.next = function(){
        if( $('input[name=gn'+self.cur_question+']:checked').val() != undefined || $("#my_answer").val()!=""){
            spa.change_uri("tests1")
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
                });

            }
        }
        else{
            alert("Введите ответ!")
        }
    }
    self.new_que = function(test_id, text, var0, var1, var2, var3, var4, rig_var){
        var req = $.ajax({
            url: "ajax.php?new_question",
            data: {"test_id": test_id, "text": text, "var0": var0, "var1": var1, "var2": var2, "var3": var3, var4: var4, rig_var: rig_var},
            method: "post"
        })
            .success(function(response){

            })
            .fail(function(response){
                //return req;
            });
        return req;

    }
    self.remove_que = function(que_id){
        var req = $.ajax({
            url: "ajax.php?remove_question",
            data: {"que_id": que_id},
            method: "post"
        })
            .success(function(response){

            })
            .fail(function(response){
                //return req;
            });
        return req;
    }
    self.get_que_details = function(que_id){
        var req = $.ajax({
            url: "ajax.php?get_que_details",
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
    self.edit_que = function(q_id, test_id, text, var0, var1, var2, var3, var4, rig_var, test_id){
        var req = $.ajax({
            url: "ajax.php?question_update",
            data: {"q_id": q_id, "test_id": test_id, "text": text, "opened": var0, "var1": var1, "var2": var2, "var3": var3, var4: var4, rig_var: rig_var, test_id: test_id},
            method: "post"
        })
            .success(function(response){

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
