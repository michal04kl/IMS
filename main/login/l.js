$(document).ready(function(){
    $('#log_show').on('mousedown', function(){
        $("#log_passwd").attr('type', 'text');
    });
    $('#log_show').on('mouseup mouseleave', function(){
        $("#log_passwd").attr('type', 'password');
    });
    $('#log_show').on('click', function(e){
        e.preventDefault();
    });
    $("#log_form").submit(function(e){
        e.preventDefault();
        $("#log_error").text("");
        var data = $(this).serializeArray();
        var error = 0;
        $.each(data, function(i,f){
            if(f.name === "passwd" && f.value != ""){
                f.value = $.md5(f.value);
            }
            if(f.value === ""){
                error = 1;
            }
        });
        if(error == 0){
        $.ajax({
            url:"/main/in/cookie/cookie.php",
            type:"POST",
            data:$.param(data),
            cache: false,
            success: function(resp){
                if(resp=="in"){
                    location.reload();
                }else{
                    $("#log_error").text(resp);
                }
            },
            error: function(){
                $("#log_error").text("forms error");
            }
        })}else{
            $("#log_error").text("invalid login or password");
        }});
})