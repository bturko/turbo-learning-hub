function KBase() {
    var self = {};
    self.edit_nid = 0;
    self.remove_id = 0;
    self.creating_note_proj_id = 0;
    self.cur_viewed_note = 0;
    self.getNotesList = function(elm_id){
        $.ajax({
            url: "ajax.php?getNotesList",
            method: "post",
            data: {user_role: userVM.role}
        })
            .success(function(response){
                $("#"+elm_id).html(response);
            })
            .fail(function(response){
                $("#"+elm_id).html("Error!");
            });
    }
    self.createNote = function(title, content, elm_id){
        $.post('ajax.php?add_note', {
                title: title,
                user_role: userVM.role,
                content: $("#noteContent").val(),
                project_id: self.creating_note_proj_id
            }, function(result){

               projectsVM.getProjectsList("projects_blk");

                var n = result.search("Ошибка");
            if(n < 0){
                logVM.informer("Запись успешно добавлена!")
            }
            //self.get_kbase(userVM.role);

        });
    }
    self.getNoteDetails = function(note_id, if_not_edit){
        self.edit_nid = note_id;
        //alert(if_not_edit)
        $.ajax({
            url: "ajax.php?getNoteDetails",
            method: "post",
            data: {
                note_id: note_id,
                user_role: userVM.role
            }
        })
            .success(function(resp1){
                //alert(resp1)
                var n = resp1.search("::::");
                part1 = resp1.substring(0, n);
                part2 = resp1.substring(n+4);

                //alert(if_not_edit)
                if(if_not_edit==false){
                    $("#editNoteTitle").val(part1);
                    editNC.set_text(part2);
                    spa.show_dialog("modal-edit-note");
                    //alert(part1)
                }
                else{
                    $("#kbase_blk").html("<div style='background: #cdcdcd; padding: 15px;'><h2><span class='glyphicon glyphicon-paperclip' aria-hidden='true'></span> "+part1+"</h2><br>"+part2+"</div>");
                }
                $("td span").css("color", "black");
            })
            .fail(function(response){
                $("#editNoteTitle").val("Ошибка!");
            });

    }
    self.editNote = function(title, content, elm_id){
        var txt = $("#editNoteContent").val();
        if(txt=="") txt = editNC.get_html();
       // console.log(txt)
        $.post('ajax.php?updateNote', {note_id: self.edit_nid, title: title, user_role: userVM.role, content: txt}, function(result){
            $("#"+elm_id).html(result);
            var n = result.search("требуемый");
            var m = result.search("Ошибка!");
            //.log(m)
            if(n < 0 && m < 0){
                logVM.informer("Запись успешно изменена!");
                /*setTimeout(function(){
                    location.reload();
                }, 500)*/
            }
            //self.get_kbase(userVM.role);
            projectsVM.getProjectsList("projects_blk");
        });
        /*$.ajax({
            url: "ajax.php?update_note",
            method: "post",
            data: {title: title, content: content, note_id: self.edit_nid, user_role: userVM.role}
        })
            .success(function(response){
                logVM.informer("Заметка успешно изменена!")
                $("#kbase_blk").html(response);
                //$("#"+elm_id).html(response);
            })
            .fail(function(response){
               // $("#"+elm_id).html("Error!");
            });
        spa.hide_dialog("modal-edit-note");*/
    }
    self.removeNote = function(){
        note_id = self.cur_viewed_note;
        if(note_id > 0){
            var req = $.ajax({
                url: "ajax.php?removeNote",
                method: "post",
                data: {note_id: note_id, user_role: userVM.role}
                })
                .success(function(response){
                    logVM.informer("Заметка удалена!")
                })
                .fail(function(response){

                });
            return req;
        }
    }
    return self;
}

var kbaseVM = new KBase;

