function Spa1() {
   var self = {};
    self.cur_remove_test_id = 0;
     self.cur_edit_test_id = 0;
    self.app_version = "0.4";
    self.change_uri = function(uri){
        
        setTimeout(function(){
            window.location.host=="localhost" ? pref = "/clh" : pref = "";
            history.pushState('', '', pref+'/main.php#'+uri);
        }, 70);
    }
    self.show_popup = function(popup_name){
        $("#" + popup_name).fadeIn(700).animate({"opacity": "1"}, 700);
        $("#fade").fadeIn().animate({"opacity": "0.7"});
    }
    self.hide_popup = function(popup_name){
        $("#" + popup_name).fadeOut(700);
        $("#fade").fadeOut().animate({"opacity": "0"}, 700);
    }
    self.getCookie = function(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    self.show_dialog = function(id){
        $("#"+id).css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "visible",
            "opacity": "1"
        });
    }
    self.hide_dialog = function(id){
        $("#"+id).css({
            "-webkit-perspective": "1300px",
            "-webkit-animation-duration": "1s",
            "animation-duration": "2s",
            "visibility": "hidden",
            "opacity": "0"
        });
    }
    self.check_existing_db = function(){
        var req = $.ajax({
            url: "ajax.php?check_existing_db",
            method: "get"
        })
            .success(function(response){

            })
            .fail(function(response){

            });
        return req;
    }
   self.set_app_version = function(ver){
        self.app_version = ver;
        $("#app_version").text(ver);
    }
    return self;
}
var spa = new Spa1;