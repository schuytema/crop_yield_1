$(document).ready(function(){
    //initial page load; disable linked lists
    $("#Brand").attr("disabled","disabled");
    $("#Product").attr("disabled","disabled");
    
    //type change
    $("#ChemicalType").change(function(){
        var type = $('#ChemicalType').val();
        if(type != ''){
            $("#Brand").attr("disabled","disabled");
            $("#Product").attr("disabled","disabled");
            $("#Brand").html("<option>wait...</option>");
            $("#Product").html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_chemical_brand", { 'type' : type },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Brand</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#Brand").html(options);
                    $("#Brand").removeAttr("disabled");
                    $("#Product").html("<option>select brand...</option>");
                } 
            }, "json");
        }
    });
    
    //brand change
    $("#Brand").change(function(){
        var type = $('#ChemicalType').val();
        var brand = $('#Brand').val();
        if(brand != ''){
            $("#Product").attr("disabled","disabled");
            $("#Product").html("<option>wait...</option>");
            $.post(CI.base_url + "member/get_chemical_product", {'type' : type, 'brand' : brand },
            function(data){
                if(data.response == true){
                    var options = '';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#Product").html(options);
                    $("#Product").removeAttr("disabled");
                } 
            }, "json");
        }
    });
    
    $("#keyword").autocomplete({
        source: function(req, add){
            $.ajax({
                url: CI.base_url + "member/chemical_suggest",
                dataType: 'json',
                type: 'POST',
                data: req,
                success: function(data){
                    if(data.message != null){
                        add(data.message);
                    }
                }
            });
        },
        minLength: 2
    });
    
    $("#keyword_submit").click(function (e) {
        e.preventDefault();
        $('#keyword_submit').attr('disabled', 'disabled');
        $("#results").html('loading...');
        $.post(CI.base_url + "member/chemical_fetch", { 'term' : $("#keyword").val() },
        function(data){
            $('#keyword_submit').removeAttr('disabled');
            //$("#results").show().html(data.result);
            $("#FK_ChemicalId").val(data.result);
        }, "json");
    });
    
});