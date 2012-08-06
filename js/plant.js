$(document).ready(function(){
    //initial page load; disable linked lists    
    $(".crop_entry").find('select[id^="CropBrand"]').attr("disabled","disabled");
    $(".crop_entry").find('select[id^="CropProduct"]').attr("disabled","disabled");
    $(".crop_entry").find('input[id^="OtherCropBrand"]').hide();
    $(".crop_entry").find('input[id^="OtherCropProduct"]').hide();
    //$(".crop_entry").find('.custom_crop_entry_toggle').closest('span').hide();
    
    //crop type change  
    $("body").on("change", 'select[id^="CropType"]', function(){
        var type = $(this).val();
        if(type.length){
            var brand = $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]');
            var product = $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]');
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
    $("body").on("change", 'select[id^="CropBrand"]', function(){
        var type = $(this).closest('fieldset.crop_entry').find('select[id^="CropType"]').val();
        var brand = $(this).val();
        if(brand.length){
            var product = $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]');
            
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
        $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropBrand"]').toggle(this.checked).val('');
        $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropProduct"]').toggle(this.checked).val('');
        if (this.checked) {
            $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').attr("disabled","disabled").html('<option>select type...</option>').val('').hide();
            $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').attr("disabled","disabled").html('<option>select brand...</option>').val('').hide();
        } else {
            $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').show();
            $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').show(); 
            $(this).closest('fieldset.crop_entry').find('select[id^="CropType"]').change();
        }
    });
    
    $("#add_new_crop_entry").click(function() {
        //get original button text
        var orig_button_html = $('#add_new_crop_entry').html();
        //disable button and change to loading text
        $('#add_new_crop_entry').attr("disabled","disabled").html('Loading...');
        //get name/id index of last CropType select (parse string as int)
        var form_num = 0;
        if ($('select[id^="CropType"]').last().attr('id')) {
            form_num = parseInt($('select[id^="CropType"]').last().attr('id').replace(/[^\d]/g, ""),10);
        }
        //increment for new crop box
        form_num++;
        
        //grab new crop box via AJAX
        $.post(CI.base_url + "member/add_crop_instance", { 'event_type' : 'Plant', 'form_num' : form_num },
        function(data){
            response = $(data.result);
            
            //set the new crop box to hide fields initially
            response.find('select[id^="CropBrand"]').attr("disabled","disabled");
            response.find('select[id^="CropProduct"]').attr("disabled","disabled");
            response.find('input[id^="OtherCropBrand"]').hide();
            response.find('input[id^="OtherCropProduct"]').hide();
            
            //add result after last crop box
            $('#add_new_crop_entry').closest('table').before(response);
            
            //return button to original form
            $('#add_new_crop_entry').removeAttr('disabled').html(orig_button_html);
        }, "json");
    });
    
    $("body").on("click", '.delete_crop', function(e) {
        e.preventDefault();
        if (confirm('Deleting this crop/variety will delete any harvest data associated with it.')) {
            $(this).closest('fieldset.crop_entry').remove();
        }
    });
    
});