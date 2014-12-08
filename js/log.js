function Logs() {
    var self = {};
    self.logging = false;
    self.w = function(messagee){
        if(self.logging == true) console.warn(messagee);
    }
    self.l = function(messagee){
        if(self.logging == true) console.log(messagee);
    }
    self.i = function(messagee){
        if(self.logging == true) console.info(messagee);
    }
    self.informer = function(message, error1){
        error1 == true ? $("#informer").css({"background-color": "red"}) : $("#informer").css({"background-color": "green"});
        $("#informer").html(message);
        $("#informer").fadeIn(500);
        setTimeout(function(){
            $("#informer").fadeOut(500);
        }, 4500)
    }
    return self;
}

var logVM = new Logs;