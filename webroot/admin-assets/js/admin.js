$(function(){
    "use strict";
    $('.icheck-style').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%' // optional
    });
    
	$('.input-date-picker').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
    });

    $('.timepicker-24').timepicker({
    	defaultTime: 'value',
	    autoclose: true,
	    minuteStep: 1,
	    showSeconds: false,
	    showMeridian: false
	});

    //colorpicker start

    $('.colorpicker-default').colorpicker({
        format: 'hex'
    });

    //colorpicker end

    $(document).on('click', '.event-close', function () {
        $(this).closest("li").remove();
        return false;
    });

    $('#is-weekend').change(function(){
        if(this.checked)
            $('#weekend').fadeIn('fast');
        else
            $('#weekend').fadeOut('fast');
    });

    $("#printPreview").click(function () {
       printDiv();
    });

    
});

function printDiv() {
    var divToPrint = document.getElementById('printPage');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
}
/*
    $(document).ready(function()
    {
        $('form[name="isdefault"]').change(function()
        {
            var formid = $(this).attr('id');
            //alert(formid);
            $(this).submit();
        });
    });
*/
    //$(":checkbox").change(function()
    //{
        /*$('#check').change(function() 
        {
          if(this.checked == true)
          {
            $('#myForm').submit();
          }
        });*/
        //var id = $(this).attr('id');
        //alert(id);
        //$('#myForm').submit();
    //});