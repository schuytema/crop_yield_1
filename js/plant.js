$(document).ready(function(){
    //initial page load; disable linked lists
    $("#EquipmentProduct").attr("disabled","disabled");
    $("#CropBrand").attr("disabled","disabled");
    $("#CropProduct").attr("disabled","disabled");
    
    //equipment brand change (Planter type implicit)
    $("#EquipmentBrand").change(function(){
        var brand = $('#EquipmentBrand').val();
        if(brand.length){
            $("#Product").attr("disabled","disabled");
            $("#Product").html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_equipment_product", { 'type' : 'Planter', 'brand' : brand },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Product</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#Product").html(options);
                    $("#Product").removeAttr("disabled");
                } 
            }, "json");
        }
    });
    
    //crop type change
    $("#CropType").change(function(){
        var type = $('#CropType').val();
        if(type.length){
            $("#CropBrand").attr("disabled","disabled");
            $("#CropProduct").attr("disabled","disabled");
            $("#CropBrand").html("<option>wait...</option>");
            $("#CropProduct").html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_crop_brand", { 'type' : type },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Brand</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#CropBrand").html(options);
                    $("#CropBrand").removeAttr("disabled");
                    $("#CropProduct").html("<option>select brand...</option>");
                } 
            }, "json");
        }
    });
    
    //crop brand change
    $("#CropBrand").change(function(){
        var type = $('#CropType').val();
        var brand = $('#CropBrand').val();
        if(brand.length){
            $("#CropProduct").attr("disabled","disabled");
            $("#CropProduct").html("<option>wait...</option>");
            $.post(CI.base_url + "member/get_crop_product", {'type' : type, 'brand' : brand },
            function(data){
                if(data.response == true){
                    var options = '';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#CropProduct").html(options);
                    $("#CropProduct").removeAttr("disabled");
                } 
            }, "json");
        }
    });
});