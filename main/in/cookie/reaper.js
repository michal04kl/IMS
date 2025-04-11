$(document).ready(function(){
    setInterval(function(){
        $.ajax({
            url:"/main/in/cookie/42.php",
            type: "POST",
            success: function(meaning){
                if(meaning != 42){
                    location.reload();
                }
            }
        });
    }, 3000)
});