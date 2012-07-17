$(document).ready(function(){
    //initial page load; disable linked lists
    $("#EquipmentBrand").attr("disabled","disabled");
    $("#EquipmentProduct").attr("disabled","disabled");
    
    //equipment type change
    $("#EquipmentType").change(function(){
        var type = $('#EquipmentType').val();
        if(type.length){
            $("#EquipmentBrand").attr("disabled","disabled");
            $("#EquipmentBrand").html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_equipment_brand", { 'type' : type },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Brand</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#EquipmentBrand").html(options);
                    $("#EquipmentBrand").removeAttr("disabled");
                } 
            }, "json");
        }
    });

    
    //equipment brand change (Planter type implicit)
    $("#EquipmentBrand").change(function(){
        var brand = $('#EquipmentBrand').val();
        var type = $('#EquipmentType').val();
        if(brand.length){
            $("#EquipmentProduct").attr("disabled","disabled");
            $("#EquipmentProduct").html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_equipment_product", { 'type' : type, 'brand' : brand },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Product</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    $("#EquipmentProduct").html(options);
                    $("#EquipmentProduct").removeAttr("disabled");
                } 
            }, "json");
        }
    });
    


    
    //bind show event to link
    $('#show_other_one').click(function() {
        $('#other_one').show();
    });
    

});