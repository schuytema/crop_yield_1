$(document).ready(function(){
    $('a[name=crop_manage]').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $( "#m_" + id ).dialog({
            modal: true,
            height: 400,
            width: 700,
            title: "Manage Crop Entry",
            closeOnEscape: false,
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
        });
        //create content container
        $("#m_" + id).append('<div id="content_' + id + '"></div>');
        $('#content_' + id).empty().html('<p><img src="' + CI.base_url + 'css/images/loader.gif" /></p>');
        $.post(CI.base_url + "admin/crop_validation_data/", {'id' : id},
            function(data){
                //ensure session exists
                if(data.expired_session){
                    logout();
                }
            
                $('#content_' + id).empty().html(data.result);
                $("#m_" + id).dialog( "option", "buttons", [
                    {text: "Resolve", click: function() {formSubmit(id)}},
                    {text: "Cancel", click: function() {dialogClose(this)}}
                ] );
                //disable crop product dropdown
                $("#m_" + id).children('div').find('select[id^="CropProduct"]').attr("disabled","disabled");
            }, "json");
        return false;
    });
    
    $('a[name=equip_manage]').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $( "#m_" + id ).dialog({
            modal: true,
            height: 400,
            width: 700,
            title: "Manage Equipment Entry",
            closeOnEscape: false,
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
        });
        //create content container
        $("#m_" + id).append('<div id="content_' + id + '"></div>');
        $('#content_' + id).empty().html('<p><img src="' + CI.base_url + 'css/images/loader.gif" /></p>');
        $.post(CI.base_url + "admin/equip_validation_data/", {'id' : id},
            function(data){
                //ensure session exists
                if(data.expired_session){
                    logout();
                }
            
                $('#content_' + id).empty().html(data.result);
                $("#m_" + id).dialog( "option", "buttons", [
                    {text: "Resolve", click: function() {formSubmit2(id)}},
                    {text: "Cancel", click: function() {dialogClose(this)}}
                ] );
                //disable crop product dropdown
                $("#m_" + id).children('div').find('select[id^="EquipProduct"]').attr("disabled","disabled");
            }, "json");
        return false;
    });
        
    $("input[name=val_type]").live("change", function(){
        if($(this).attr('value') == 'user'){
            $('.div_user').show('slow');
            $('.div_db').hide('slow');
        } else {
            $('.div_db').show('slow');
            $('.div_user').hide('slow');
        }
    });
    
    $("body").on("change", 'select[id^="CropBrand"]', function(){
        var type = $(this).siblings('span').text();
        var brand = $(this).val();
        if(brand.length){
            var product = $(this).closest('div').find('select[id^="CropProduct"]');
            product.attr("disabled","disabled");
            product.html("<option>wait...</option>");
            $.post(CI.base_url + "admin/get_crop_product", {'type' : type, 'brand' : brand },
            function(data){
                //ensure session exists
                if(data.expired_session){
                    logout();
                }
                
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
    
    $("body").on("change", 'select[id^="EquipBrand"]', function(){
        var type = $(this).siblings('span').text();
        var brand = $(this).val();
        if(brand.length){
            var product = $(this).closest('div').find('select[id^="EquipProduct"]');
            product.attr("disabled","disabled");
            product.html("<option>wait...</option>");
            $.post(CI.base_url + "admin/get_equip_product", {'type' : type, 'brand' : brand },
            function(data){
                //ensure session exists
                if(data.expired_session){
                    logout();
                }
                
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
    
    function dialogClose(id){
        $('.error_msg').remove();
        $(id).dialog("close");
    }
   
    function formSubmit(modal_id){
        $('.error_msg').remove();
        $('.crop_verification').hide();
        $(".ui-dialog-buttonpane button:contains('Resolve')").button("disable");
        $(".ui-dialog-buttonpane button:contains('Cancel')").button("disable");
        $("#m_" + modal_id).append('<div class="loader"><img src="' + CI.base_url + 'css/images/loader.gif" /></div>');
        $.post(CI.base_url + "admin/process_crop_validation/", {'id' : modal_id, 'form' : $('.crop_verification').serialize() },
        function(data){
            //ensure session exists
            if(data.expired_session){
                logout();
            }
            //remove loader
            $('.loader').remove();
            if(data.error){
                //create error container
                $('#content_' + modal_id).before('<div class="error_msg">' + data.error + '</div>');
                $(".ui-dialog-buttonpane button:contains('Resolve')").button("enable");
                $(".ui-dialog-buttonpane button:contains('Cancel')").button("enable");
                $('.crop_verification').show();
            } else {
                //refresh page
                location.reload();
            }
        }, "json");
    }
    
    function formSubmit2(modal_id){
        $('.error_msg').remove();
        $('.equip_verification').hide();
        $(".ui-dialog-buttonpane button:contains('Resolve')").button("disable");
        $(".ui-dialog-buttonpane button:contains('Cancel')").button("disable");
        $("#m_" + modal_id).append('<div class="loader"><img src="' + CI.base_url + 'css/images/loader.gif" /></div>');
        $.post(CI.base_url + "admin/process_equip_validation/", {'id' : modal_id, 'form' : $('.equip_verification').serialize() },
        function(data){
            //ensure session exists
            if(data.expired_session){
                logout();
            }
            //remove loader
            $('.loader').remove();
            if(data.error){
                //create error container
                $('#content_' + modal_id).before('<div class="error_msg">' + data.error + '</div>');
                $(".ui-dialog-buttonpane button:contains('Resolve')").button("enable");
                $(".ui-dialog-buttonpane button:contains('Cancel')").button("enable");
                $('.equip_verification').show();
            } else {
                //refresh page
                location.reload();
            }
        }, "json");
    }
    
    function logout(){
        window.location.href = CI.base_url + 'admin/expired';
    }
});