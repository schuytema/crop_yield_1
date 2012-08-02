$(document).ready(function(){
    //initial page load; disable linked lists    
    $(".crop_entry").find('select[name^="CropBrand"]').attr("disabled","disabled");
    $(".crop_entry").find('select[name^="CropProduct"]').attr("disabled","disabled");
    $(".crop_entry").find('input[name^="OtherCropBrand"]').hide();
    $(".crop_entry").find('input[name^="OtherCropProduct"]').hide();
    $(".crop_entry").find('.custom_crop_entry_toggle').closest('span').hide();
    
    //crop type change  
    $("body").on("change", 'select[name^="CropType"]', function(){
        var type = $(this).val();
        if(type.length){
            var brand = $(this).closest('fieldset.crop_entry').find('select[name^="CropBrand"]');
            var product = $(this).closest('fieldset.crop_entry').find('select[name^="CropProduct"]');
            var custom_checkbox = $(this).closest('fieldset.crop_entry').find('.custom_crop_entry_toggle').closest('span');
         
            brand.attr("disabled","disabled");
            product.attr("disabled","disabled");
            brand.html("<option>wait...</option>");
            product.html("<option value=\"\">wait...</option>");
            $.post(CI.base_url + "member/get_crop_brand", { 'type' : type },
            function(data){
                if(data.response == true){
                    var options = '<option value="">Select Brand</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    brand.html(options);
                    brand.removeAttr("disabled");
                    product.html("<option>select brand...</option>");
                    custom_checkbox.show();
                } 
            }, "json");
        }
    });
    
    //crop brand change
    $("body").on("change", 'select[name^="CropBrand"]', function(){
        var type = $(this).closest('fieldset.crop_entry').find('select[name^="CropType"]').val();
        var brand = $(this).val();
        if(brand.length){
            var product = $(this).closest('fieldset.crop_entry').find('select[name^="CropProduct"]');
            
            product.attr("disabled","disabled");
            product.html("<option>wait...</option>");
            $.post(CI.base_url + "member/get_crop_product", {'type' : type, 'brand' : brand },
            function(data){
                if(data.response == true){
                    var options = '';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    product.html(options);
                    product.removeAttr("disabled");
                } 
            }, "json");
        }
    });
    
    $("body").on("click", '.custom_crop_entry_toggle', function() {
        $(this).closest('fieldset.crop_entry').find('input[name^="OtherCropBrand"]').toggle(this.checked).val('');
        $(this).closest('fieldset.crop_entry').find('input[name^="OtherCropProduct"]').toggle(this.checked).val('');
        if (this.checked) {
            $(this).closest('fieldset.crop_entry').find('select[name^="CropBrand"]').attr("disabled","disabled").html('<option>select type...</option>').val('').hide();
            $(this).closest('fieldset.crop_entry').find('select[name^="CropProduct"]').attr("disabled","disabled").html('<option>select brand...</option>').val('').hide();
        } else {
            $(this).closest('fieldset.crop_entry').find('select[name^="CropBrand"]').show();
            $(this).closest('fieldset.crop_entry').find('select[name^="CropProduct"]').show(); 
            $(this).closest('fieldset.crop_entry').find('select[name^="CropType"]').change();
        }
    });
    
    $("#add_new_crop_entry").click(function() {
        var index = $('fieldset.crop_entry').length;
        var new_index = index+1;
        var new_form = $('fieldset.crop_entry').last().clone();
        
        new_form.find('legend').html('Crop/Variety '+new_index);
        new_form.find('blockquote').remove();
        new_form.find('select[name^="CropType'+index+'"]').attr('id','CropType'+new_index).attr('name','CropType'+new_index);
        new_form.find('select[name^="CropBrand'+index+'"]').attr('id','CropBrand'+new_index).attr('name','CropBrand'+new_index);
        new_form.find('input[name^="OtherCropBrand'+index+'"]').attr('id','OtherCropBrand'+new_index).attr('name','OtherCropBrand'+new_index);
        new_form.find('select[name^="CropProduct'+index+'"]').attr('id','CropProduct'+new_index).attr('name','CropProduct'+new_index);
        new_form.find('input[name^="OtherCropProduct'+index+'"]').attr('id','OtherCropProduct'+new_index).attr('name','OtherCropProduct'+new_index);
        new_form.find('input[name^="AcresPlanted'+index+'"]').attr('id','AcresPlanted'+new_index).attr('name','AcresPlanted'+new_index).val('');
        
        $('fieldset.crop_entry').last().after(new_form);
    });
});