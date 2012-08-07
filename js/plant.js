$(document).ready(function(){
    //initial page load

    //check custom crop entry checkbox status
    $('.custom_crop_entry_toggle').each(function() {
        
        if($(this).prop('checked')) { //checked

            //hide brand/product lists          
            $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').hide();
            $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').hide();
        } else { //unchecked
            
            //hide custom brand/product input fields
            $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropBrand"]').hide();
            $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropProduct"]').hide();
            
            if (!$(this).closest('fieldset.crop_entry').find('select[id^="CropType"]').val().length) { //crop type empty      
                //hide custom input toggle checkbox
                $(this).closest('span').hide();
            }
            
            if (!$(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').val().length) { //crop brand empty
                //disable brand list
                $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').attr("disabled","disabled");
            }
            
            if (!$(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').val().length) { //crop product empty
                //disable brand list
                $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').attr("disabled","disabled");
            }
        }
    });
    
    //crop type change  
    $("body").on("change", 'select[id^="CropType"]', function(){
        var type = $(this).val();
        var custom_checkbox = $(this).closest('fieldset.crop_entry').find('.custom_crop_entry_toggle').closest('span');
        var brand = $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]');
        var product = $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]');
        var custom_brand = $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropBrand"]');
        var custom_product = $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropProduct"]');
        if(type.length){
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
                    custom_brand.removeAttr("disabled");
                    custom_product.removeAttr("disabled");
                } 
            }, "json");
        } else {
            custom_checkbox.hide();
            brand.attr("disabled","disabled");
            product.attr("disabled","disabled");
            custom_brand.attr("disabled","disabled");
            custom_product.attr("disabled","disabled");
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
                    var options = '<option value="">Select Product</option>';
                    for (var i = 0; i < data.list.length; i++) {
                        options += '<option value="' + data.list[i].value + '">' + data.list[i].display + '</option>';
                    }
                    product.html(options);
                    product.removeAttr("disabled");
                } 
            }, "json");
        }
    });
    
    $("body").on("click", '.custom_crop_entry_toggle', function(){
        $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropBrand"]').toggle();
        $(this).closest('fieldset.crop_entry').find('input[id^="OtherCropProduct"]').toggle();
        $(this).closest('fieldset.crop_entry').find('select[id^="CropBrand"]').toggle();
        $(this).closest('fieldset.crop_entry').find('select[id^="CropProduct"]').toggle();
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
            response.find('.custom_crop_entry_toggle').closest('span').hide();
            
            
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