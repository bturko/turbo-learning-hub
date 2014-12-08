function Project() {
    var self = {};
    self.edit_project_id = 0;
    self.remove_project_id = 0;
    self.getProjectsList = function(elm_id){
        $.ajax({
            url: "ajax.php?getProjectsList",
            method: "post",
            data: {user_role: userVM.role}
        })
            .success(function(response){
                $("#"+elm_id).html(response);

                $("#new_project").click(function(){
                    spa.show_dialog("modal-new-project");
                });
                /*$("#new_note").click(function(){
                    spa.show_dialog("modal-new-note");
                });*/

            })
            .fail(function(response){
                $("#"+elm_id).html("Error!");
            });
    }
    self.createProject = function(title, description, elm_id){
         $.post('ajax.php?createProject', {title: title, user_role: userVM.role, description: description}, function(result){
            $("#"+elm_id).html(result);
            var n = result.search("Ошибка");
            if(n < 0){
                logVM.informer("Проект успешно добавлен!")
            }
            self.getProjectsList("projects_blk");
        });

    }
    self.getProjectDetails = function(project_id){
        self.edit_project_id = project_id;
        $.ajax({
            url: "ajax.php?getProjectDetails",
            method: "post",
            data: {project_id: project_id, user_role: userVM.role}
        })
            .success(function(response){
                var json = JSON.parse(response);
                if(json.status=="Ok"){
                    $("#editProjectTitle").val(json.title);
                    $("#editProjectDescription").val(json.description);
                }
                else{
                    $("#editProjectTitle").val("Ошибка!");
                }
            })
            .fail(function(response){
                $("#editProjectTitle").val("Ошибка!");
            });
        //spa.show_dialog("modal-edit-note");
    }
    self.editProject = function(title, description, elm_id){
        //var txt = $("#editNoteContent").val();
       // if(txt=="") txt = editNC.get_html();

        $.ajax({
            url: "ajax.php?updateProject",
            method: "post",
            data: {
                project_id: self.edit_project_id,
                title: title,
                description: description,
                user_role: userVM.role
            }
        })
            .success(function(response){
                var json = JSON.parse(response);
                if(json.status=="Ok"){
                    //$("#"+elm_id).html(result);
                    //console.log("updateProject suc")

                    self.getProjectsList("projects_blk");
                }
                else{
                    logVM.informer("<strong>Ошибка!</strong> Сохранение изменений не выполнено", true);
                }
            })
            .fail(function(response){
               // $("#editProjectTitle").val("Ошибка!");
            });
    }
    self.removeProject = function(){
        var project_id = self.remove_project_id;
        if(project_id > 0){
            var req = $.ajax({
                url: "ajax.php?removeProject",
                method: "post",
                data: {project_id: project_id, user_role: userVM.role}
                })
                .success(function(response){
                    logVM.informer("Проект удален!");
                    self.getProjectsList("projects_blk");
                })
                .fail(function(response){

                });
            return req;
        }
    }
    return self;
}

var projectsVM = new Project;
