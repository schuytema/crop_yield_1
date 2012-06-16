$(document).ready(function(){
    $('#Date').datepicker({
        defaultDate: null,
        dateFormat: 'yy/mm/dd',
        showOn: 'button',
	buttonImage: CI.base_url + 'css/images/calendar.png',
        buttonImageOnly: false,
        changeMonth: true,
        changeYear: true,
        yearRange: '2000:2050'
    });
});
