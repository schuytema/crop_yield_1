$(document).ready(function(){
    $('a[name=crop_manage]').click(function(e) {
        e.preventDefault();
        build_modal($(this).attr('id'));
        return false;
    });
    
    $('a[name=equip_manage]').click(function(e) {
        e.preventDefault();
        build_modal($(this).attr('id'));
        return false;
    });
    
    function build_modal(id){
        $( "#m_" + id ).dialog({
            modal: true,
            height: 400,
            width: 700,
            title: "Manage Entry",
            closeOnEscape: false,
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
        });
        //create content container
        $("#m_" + id).append('<div id="content_' + id + '"></div>');
        $('#content_' + id).empty().html('<p><img src="' + CI.base_url + 'css/images/loader.gif" /></p>');
        $.post(CI.base_url + "admin/verification_data/", {'form_type' : CI.form_type,'id' : id},
            function(data){
                //ensure session exists
                if(data.expired_session){
                    logout();
                }
            
                $('#content_' + id).empty().html(data.result);
                $("#m_" + id).dialog( "option", "buttons", [
                    {text: "Submit", click: function() {formSubmit(id)}},
                    {text: "Cancel", click: function() {dialogClose(this)}}
                ] );
                //disable product dropdown
                $("#m_" + id).children('div').find('select[id^="Product"]').attr("disabled","disabled");
            }, "json");
    }
    
    $("input[name=val_type]").live("change", function(){
        if($(this).attr('value') == 'user'){
            $('.div_user').show('slow');
            $('.div_db').hide('slow');
        } else {
            $('.div_db').show('slow');
            $('.div_user').hide('slow');
        }
    });
    
    $("body").on("change", 'select[id^="Brand"]', function(){
        var brand = $(this).val();
        if(brand.length){
            var product = $(this).closest('div').find('select[id^="Product"]');
            product.attr("disabled","disabled");
            product.html("<option>wait...</option>");
            $.post(CI.base_url + "admin/get_product", {'form_type' : CI.form_type,'type' : $(this).siblings('span').text(), 'brand' : brand },
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
        $('.verification').hide();
        $(".ui-dialog-buttonpane button:contains('Submit')").button("disable");
        $(".ui-dialog-buttonpane button:contains('Cancel')").button("disable");
        $("#m_" + modal_id).append('<div class="loader"><img src="' + CI.base_url + 'css/images/loader.gif" /></div>');
        $.post(CI.base_url + "admin/process_verification/", {'form_type' : CI.form_type,'id' : modal_id, 'form' : $('.verification').serialize() },
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
                $(".ui-dialog-buttonpane button:contains('Submit')").button("enable");
                $(".ui-dialog-buttonpane button:contains('Cancel')").button("enable");
                $('.verification').show();
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