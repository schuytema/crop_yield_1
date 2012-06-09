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
            $("#Product").html("<option>wait...</option>");
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
    
});



