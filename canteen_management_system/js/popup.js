$(document).ready(function(){

    //show after 1s
    setTimeout(showModal,1000);

    function showModal(){
        var is_already_show = 
        sessionStorage.getItem('alreadyShow');
        if(is_already_show != 'alreadyShow')
        {
            sessionStorage.setItem('alreadyShow','alreadyShow');
            $("#popup").show();     
        }
        else
        {
            console.log(is_already_show);
        }
    }

    $("#close").click(function(){
        $("#popup").hide();
    })

});