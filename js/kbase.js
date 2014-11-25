function KBase() {
    var self = {};
    self.edit_nid = 0;
    self.remove_id = 0;
    self.get_kbase = function(elm_id){
        $.ajax({
            url: "ajax.php?get_kbase",
            method: "post",
            data: {user_role: userVM.role}
        })
            .success(function(response){
                $("#"+elm_id).html(response);

                $("#new_note").click(function(){
                     spa.show_dialog("modal-new-note");
                });
            })
            .fail(function(response){
                $("#"+elm_id).html("Error!");
            });
    }
    self.add_note = function(title, content, elm_id){
        //alert($("#noteContent").val())
        $.post('ajax.php?add_note', {title: title, user_role: userVM.role, content: $("#noteContent").val()}, function(result){
            $("#"+elm_id).html(result);
            var n = result.search("Ошибка");
            console.log(n)
            if(n < 0){
                logVM.informer("Запись успешно добавлена!")
            }
            self.get_kbase(userVM.role);
        });
        /*$.ajax({
            url: "ajax.php?add_note",
            method: "post",
            data: {title: title, user_role: userVM.role, content: $("#noteContent").val()}
        })
            .success(function(response){
                $("#"+elm_id).html(response);
            })
            .fail(function(response){
                $("#"+elm_id).html("Error!");
            });*/
    }
    self.get_note = function(note_id){
        self.edit_nid = note_id;
        $.ajax({
            url: "ajax.php?get_note",
            method: "post",
            data: {note_id: note_id, user_role: userVM.role}
        })
            .success(function(resp1){
                //var json = JSON.parse(resp1);
                var n = resp1.search("::::");
                part1 = resp1.substring(0, n);
                part2 = resp1.substring(n+4);

                //console.log( unescapeHTML(part2)  );

                $("#editNoteTitle").val(part1);
                //$("#editNoteContent").val(json.content);
                editNC.set_text(part2);
            })
            .fail(function(response){
                $("#editNoteTitle").val("Ошибка!");
            });
        spa.show_dialog("modal-edit-note");
    }
    self.edit_note = function(title, content, elm_id){
        var txt = $("#editNoteContent").val();
        //alert(txt)
        if(txt=="") txt = editNC.get_html();
        console.log(txt)
        //alert(editNC.get_text())
        //alert(editNC.get_html())
        $.post('ajax.php?update_note', {note_id: self.edit_nid, title: title, user_role: userVM.role, content: txt}, function(result){
            $("#"+elm_id).html(result);
            var n = result.search("требуемый");
            //console.log(n)
            var m = result.search("Ошибка!");
            //.log(m)
            if(n < 0 && m < 0){
                logVM.informer("Запись успешно изменена!")
                setTimeout(function(){
                    location.reload();
                }, 500)
            }
            self.get_kbase(userVM.role);
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
    self.remove_note = function(){
        note_id = self.remove_id;
        if(note_id > 0){
            var req = $.ajax({
                url: "ajax.php?remove_note",
                method: "post",
                data: {note_id: note_id, user_role: userVM.role}
                })
                .success(function(response){
                    logVM.informer("Заметка удалена!")
                    //$("#kbase_blk").html(response);
                })
                .fail(function(response){
                    //$("#"+elm_id).html("Error!");
                });
            return req;
        }
    }
    return self;
}

var kbaseVM = new KBase;

/*
function unescapeHTML(p_string)
{
    if ((typeof p_string === "string") && (new RegExp(/&amp;|&lt;|&gt;|&quot;|&#39;/).test(p_string)))
    {
        return p_string.replace(/&amp;/g, "&").replace(/&lt/g, "<").replace(/&gt;/g, ">").replace(/&quot;/g, "\"").replace(/&#39;/g, "'");
    }

    return p_string;
}*/