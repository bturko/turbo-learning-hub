function User() {
    var self = {};
    self.login = "";
    self.role = 0;
    self.user_fio = "";
    self.user_id = 0;
    self.crenditles = [];
    self.removing_user_id = 0;

    self.get_crenditles = function(){
        var req = $.ajax({
            url: "ajax.php?get_crenditles",
            method: "post"
        })
            .success(function(response){
                var json = JSON.parse(response);
                //console.log(json);
                self.crenditles = json.crenditles;
            })
            .fail(function(response){
                //echo "Error";
            });
        return req;
    }
    self.create_user = function(login, password, fio){
        var req = $.ajax({
            url: "ajax.php?create_user",
            data: {login: login, password: password, fio: fio},
            method: "post"
        })
            .success(function(response){
                return response;
            })
            .fail(function(response){
                return '{"status": "Error", "message": "Ошибка соединения!"}';
            });
        return req;
    }
    self.get_user_by_login = function(login, password){
        $.ajax({
            url: "ajax.php?get_user_by_login",
            data: {login: login},
            method: "post"
        })
            .success(function(response){
                var json = JSON.parse(response);

                if(json.status == "success"){
                    self.login = json.login;
                    self.role = json.role;
                    self.user_fio = json.user_fio;
                    self.user_id = json.user_id;
                }
                else{
                    logVM.informer("Возникла ошибка!");
                }
            })
            .fail(function(response){
                //echo "Error";
            });
        //return req;
    }
    self.exit_user = function(){
        var date = new Date(0);
        document.cookie="userName=; path=/; expires="+date.toUTCString();
        self.login = "";
        logVM.i("user clear");
        setTimeout(function(){
            window.location.replace('index.php');
        }, 100);
    }
    self.get_users = function(){
        var req = $.ajax({
            url: "ajax.php?get_users",
            method: "post"
        })
            .success(function(response){
                //var json = JSON.parse(response);   
            })
            .fail(function(response){
                //echo "Error";
            });
        return req;
    }
    self.get_user = function(user_id){
        self.user_id = user_id;
        $.ajax({
            url: "ajax.php?get_user",
            method: "post",
            data: {user_id: user_id}
        })
            .success(function(response){
                var json = JSON.parse(response);

                if(json.status == "success"){
                    $("#editUserLogin").val(json.login)
                    $("#editUserPassword").val(json.password)
                    $("#editUserFIO").val(json.fio)                              
                    spa.show_dialog("modal-edit-user");
                }
                else{
                    logVM.informer("Возникла ошибка!");
                }    
            })
            .fail(function(response){
                logVM.informer("Возникла ошибка!");
            });
        //return req;
    }
    self.update_user = function(login, password, fio){
        var req = $.ajax({
            url: "ajax.php?update_user",
            method: "post",
            data: {user_id: self.user_id, login: login, password: password, fio: fio}
        })
            .success(function(response){
                return response;
            })
            .fail(function(response){
                
            });
        return req;
    }       
    self.remove_user = function(user_id){
        $.ajax({
            url: "ajax.php?remove_user",
            method: "post",
            data: {user_id: user_id}
        })
            .success(function(response){
                var json = JSON.parse(response);
                //console.log(json);
                //alert(json.status)
                if(json.status == "removed") {
                    logVM.informer("Пользователь удален!")
                    req = self.get_users();
                        req.success(function(result1){
                            $('#users2').html(result1);
                        });
                }
                else{
                    logVM.informer("Возникла ошибка во время удаления!")
                }
            })
            .fail(function(response){
                
            });
        //return req;
    }    

    return self;
}

var userVM = new User;