function Tests() {
    var self = {};
    self.get_tests = function(elm_id, user_role){
        if(elm_id && user_role){
            $.ajax({
                url: "ajax.php?get_tests",
                method: "post",
                data: {
                    user_role: user_role,
                    login: userVM.login
                }
            })
                .success(function(response){
                    $("#"+elm_id).html(response);

                    $("#btnNewtask").click(function(){
                        spa.show_dialog("modal-new-test");
                    });

                })
                .fail(function(response){
                    $("#"+elm_id).html("Error!");
            });
        }
        else{
            //console.warn();
            logVM.w("get_tests: Отсутствует обязательный параметр!");
        }
    }
    self.new_test = function(title, description, role){
        $.ajax({
            url: "ajax.php?new_test",
            method: "post",
            data: {
                newTaskTitle: title,
                newTaskDescription: description,
                user_role: role,
                login: userVM.login
            }
        })
            .success(function(response){
                //$("#test_messages").html('<div class="alert alert-success" role="alert">Новый тест создан!</div>');
                var m = response.search("требуемый");
                console.log(m)
                if( m < 0){
                    logVM.informer("Новый тест успешно создан!")
                }
                $("#tests").html(response);
                setTimeout(function(){
                    $("#test_messages").text("");
                }, 4000)
            })
            .error(function(response){
                $("#test_messages").html('<div class="alert alert-error" role="alert"Ошибка!</div>');
            })
            .complete(function(){
                $(".new_test_err").css({"display": "none"});
                //hideNewTaskDlg();
                self.hide_dialog("modal-new-test");

                //history.pushState('', '', "/clh/#tests");

            });
    };
    return self;
}

var testVM = new Tests;