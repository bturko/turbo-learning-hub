function Tests() {
    var self = {};
    self.getTestsList = function(elm_id, user_role){
        if(elm_id && user_role){
            $.ajax({
                url: "ajax.php?getTestsList",
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
    self.createTest = function(title, description, role){
        $.ajax({
            url: "ajax.php?createTest",
            method: "post",
            data: {
                newTaskTitle: title,
                newTaskDescription: description,
                user_role: role,
                login: userVM.login
            }
        })
            .success(function(response){
                var m = response.search("требуемый");
                if( m < 0){
                    logVM.informer("Новый тест успешно создан!");
                }
                $("#tests").html(response);
                setTimeout(function(){
                    $("#test_messages").text("");
                }, 4000);
                self.getTestsList("tests_blk", userVM.role);
            })
            .error(function(response){
                $("#test_messages").html('<div class="alert alert-error" role="alert"Ошибка!</div>');
            })
            .complete(function(){
                $(".new_test_err").css({"display": "none"});
                spa.hide_dialog("modal-new-test");
            });
    };
    self.get_test_details = function(test_id){
        $.ajax({
            url: "ajax.php?get_test_details",
            method: "get",
            data: {
                testId: test_id,
                user_role: userVM.role
            }
        })
            .success(function(response){
                var json = JSON.parse(response);
                $("#editTaskTitle").val(json.title)
                $("#editTaskDescription").val(json.description);

            })
            .error(function(response){
                logVM.informer("Ошибка!");
            })
            .complete(function(){
            });
    }
    self.updateTest = function(){
        $.ajax({
            url: "ajax.php?updateTest",
            method: "post",
            data: {
                editTestId: spa.cur_edit_test_id,
                editTestTitle: $("#editTaskTitle").val(),
                editTestDescription: $("#editTaskDescription").val(),
                user_role: userVM.role,
                login: userVM.login
            }
        })
            .success(function(response){
                logVM.informer("Тест изменен!");
                $("#tests").html(response);
                self.getTestsList("tests_blk", userVM.role);
            })
            .error(function(response){
                $("#test_messages").html('<div class="alert alert-error" role="alert"Ошибка!</div>');
            })
            .complete(function(){
                spa.change_uri("tests")
                spa.hide_dialog("modal-edit-test");
            });
    }
    self.removeTest = function(test_id){
        $.ajax({
            url: "ajax.php?remove_test",
            method: "post",
            data: {
                removeTestId: test_id,
                user_role: userVM.role
            }
        })
            .success(function(response){
                logVM.informer("Тест удален!")

                setTimeout(function(){
                    self.getTestsList("tests", userVM.role)
                }, 400);
            })
            .error(function(response){
                $("#test_messages").html('<div class="alert alert-error" role="alert"Ошибка!</div>');
            })
            .complete(function(){
                spa.hide_dialog("modal-remove-test");
                //hideRemoveTestDlg();
                self.getTestsList("tests_blk", userVM.role)
                spa.change_uri("tests")
            });
    }
    return self;
}

var testVM = new Tests;