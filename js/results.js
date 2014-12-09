function Results() {
    var self = {};
    self.remove_result_id = 0;

    /**
     * Return list of Results
     * @param elm_id
     * @returns {*}
     */
    self.get_results = function(elm_id){
        req = $.ajax({
            url: "ajax.php?get_results",
            method: "post",
            data: {test_id: $("#test_id option:selected" ).val(), operator_id: $("#operator_id option:selected" ).val()}
        })
            .success(function(response){
                $("#results_blk").html(response);

                setTimeout(function(){
                    $('.selectpicker').on('change', function(){
                        self.get_results();
                    });
                    $('#myTab a').click(function (e) {
                        e.preventDefault()
                        $(this).tab('show');
                    })
                }, 500);
            })
            .fail(function(response){
                $("#results_blk").html("Error!");
            });
        return req;
    }
    self.remove_result = function(){
        req = $.ajax({
            url: "ajax.php?remove_result",
            method: "post",
            data: {result_id: self.remove_result_id}
        })
            .success(function(response){

            })
            .fail(function(response){

            });
        return req;
    }
    self.export_results = function(){
        req = $.ajax({
            url: "ajax.php?export_results",
            method: "post",
            data: {}
        })
            .success(function(response){

            })
            .fail(function(response){

            });
        return req;
    }
    self.show_diagram = function(){
        $("#diagram").show();
        $("#tdata").hide();

        req = $.ajax({
            url: "ajax.php?get_diagram",
            method: "post",
            data: {test_id: $("#test_id option:selected" ).val(), operator_id: $("#operator_id option:selected" ).val()}
        })
            .success(function(response){
                //console.log(response);
                var json = JSON.parse(response);
                //console.log()
                var data = [];
                for(i=0; i<json.data.length; i++){
                    data.push([json.data[i].fio, json.data[i].value]);
                }
                /*var data = [
                    ["Васся", 3244],["Retail", 9], ["Light Industry", 14],
                    ["Out of home", 16],["Commuting", 7], ["Orientation", 9]
                ];*/
                var plot1 = jQuery.jqplot ("chart1", [data],
                    {
                        seriesDefaults: {
                            renderer: jQuery.jqplot.PieRenderer,
                            rendererOptions: {
                                showDataLabels: true
                            }
                        },
                        legend: { show:true, location: "e" }
                    }
                );
            })
            .fail(function(response){

            });
        return req;


    }
    self.show_tdata = function(){
        $("#diagram").hide();
        $("#tdata").show()
    }
    return self;
}

var resultsVM = new Results;