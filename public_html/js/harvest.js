$(document).ready(function(){
    //initial page load

    //check for crop entry boxes
    if($('fieldset.crop_entry').length) {
        //plant event exists
        $('#harvest_error_msg').hide();
    } else {
        //plant event doesn't extist
        $('#equipment_container').hide();
        $('#crop_container').hide();
        $('#submit_container').hide();
    }
    
    //field change
    $("body").on("change", 'select[name="fields"]', function(){
        var field = $(this).val();
        $.post(CI.base_url + "member/get_harvest_crops", {'field' : field },
            function(data){
                if(data.result.length){
                    //valid response
                    //replace contents of crop container
                    $('#crop_container').html(data.result);
                    //hide error message
                    $('#harvest_error_msg').hide();
                    $('#equipment_container').show();
                    $('#crop_container').show();
                    $('#submit_container').show();
                }
                else {
                    //invalid response
                    //hide error message
                    $('#harvest_error_msg').show();
                    $('#equipment_container').hide();
                    $('#crop_container').hide();
                    $('#submit_container').hide();
                }
            }, "json");
    });
});