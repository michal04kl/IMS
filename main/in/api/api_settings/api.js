$(document).ready(function(){

adjust();

$("#out").on('click', function(){
    $.ajax({
        url: '/main/in/cookie/kill.php',
        type: 'POST',
        success: function(){
            location.reload();
        }
    })
});

$(window).resize(adjust);

function adjust(){
    $("#panel").width($("#name").innerWidth()+"px");
}

var intern_boxes = [];
$(document).on('change', '.intern_box', function(){
    let chc = 0;
    $('.intern_box').each(function(){
        if($(this).is(':checked')){
            chc = 1;
        }});
    if(chc == 0 && $("#edit_intern").length > 0){
        $('#edit_intern').remove();
        $('#del_intern').remove();
    }
    intern_boxes = [];
    $('.intern_box').each(function(){
      if($(this).is(':checked')){
        intern_boxes.push($(this).attr('id'));
        if($("#edit_intern").length == 0){
          $("#intern_buttons").append("<button id='edit_intern'><i class='fas fa-edit'></i></button>");
          $("#intern_buttons").append("<button id='del_intern'><i class='fa-solid fa-trash'></i></button>");
        }
      }
    });
  });

$("#interns").on('click', function(){
    $("#inform").html('Interns');
    $.ajax({
        url: '/main/in/api/actions/load_intern.php',
        type: 'POST',
        success: function(table){
            $("#screen").html(table);
            $("#screen").append("<div id='intern_buttons'><button id = 'add_intern'><i class='fa-solid fa-plus'></i><button></div>");
            $("#inform").append("<br><input type='text' id='search' placeholder='search (write + enter)'>");
        }
    })
});

$(document).on('click', '#add_intern', function(){
    $("#inform").html('Add intern');
    $("#screen").html("<form id = 'ia_form'><label for='email'>Email:</label><input type='email' id='ia_email' name='email' required pattern='^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$'>&nbsp;<label for='name'>Name:</label><input type='text' id='ia_name' name='name' required pattern='^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+$' title='The first letter is uppercase, the rest are lowercase'>&nbsp;<label for='surname'>Surname:</label><input type='text' id='ia_surname' name='surname' required pattern='^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+(?:[-\\s][A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+)*$' title='Name in capital letters, may contain a hyphen or space'>&nbsp;<label for='deadline'>Deadline (optional):</label><input type='text' id='ia_deadline' name='deadline' pattern='^(NULL|\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|)$' title='Format: YYYY-MM-DD HH:MM:SS, e.g. 2025-04-10 15:30:00' value='NULL'>&nbsp;<button type='submit'>ADD</button></form>");
});

$(document).on('submit', '#ia_form', function(e){
    e.preventDefault();
    $.ajax({
        url:"/main/in/api/actions/add_intern.php",
        type:"POST",
        data:$("#ia_form").serialize(),
        cache: false,
        success: function(resp){
            alert(resp);
            location.reload();
        }
    })
});

$(document).on('click', '#del_intern', function(){
    let msg = "";
    intern_boxes.forEach(intern => {
        msg += $("#"+intern).val()+"\n";
    });
    if(confirm("Are you sure you want to remove from the intern list:\n"+msg)==true){
        intern_boxes.forEach(intern => {
        $.ajax({
            url:"/main/in/api/actions/del_intern.php",
            type:"POST",
            data:{ID: intern},
            cache: false,
            success: function(){
            }
        })});
        location.reload(); 
    };
});

$(document).on('click', '#edit_intern', function(){
    $.ajax({
        url:"/main/in/api/actions/edit_select_intern.php",
        type:"POST",
        data:{'ids[]': intern_boxes},
        traditional: true,
        success: function(resp){
            $("#screen").html(resp);
        }
    })
})

$(document).on('submit', '.edit_i', function(e){
    e.preventDefault();
    $('.edit_i').each(function(){
        $.ajax({
            url:"/main/in/api/actions/edit_intern.php",
            type:"POST",
            data:$(this).serialize(),
            traditional: true,
            success: function(resp){
                alert(resp);
                location.reload();  
            }
        }) 
    })
});

$(document).on('change', '.sort_in', function(){
    $.ajax({
        url:"/main/in/api/actions/load_intern.php",
        type:"POST",
        data:$(this).serialize(),
        traditional: true,
        success: function(resp){
            $("#screen").html(resp);
            $("#screen").append("<div id='intern_buttons'><button id = 'add_intern'><i class='fa-solid fa-plus'></i><button></div>");
        }
    })
});

$(document).on('input', '#search', function(){
    $("span.highlight").each(function(){
        $(this).replaceWith($(this).text());
        });
})

$(document).on('change', '#search', function(){
    let term = $(this).val();
    $("span.highlight").each(function(){
    $(this).replaceWith($(this).text());
    });
    if(term.length > 0){
        if(term == ""){return;}
        let esc = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        let re = new RegExp('('+esc+')', 'gi');
        $("#screen").find("*").not("script, style, noscript").each(function(){
          $(this).contents().filter(function(){
            return this.nodeType === 3;
          }).each(function(){
            let original = this.nodeValue;
            let new_t = original.replace(re, '<span class="highlight">$1</span>');
            if(new_t !== original){
                $(this).replaceWith(new_t);
            }
          });  
        });
    }
});

$(document).on('click', '#down_pagin', function(){
    let offset= Number($("#intern_pagin").data('offset'));
    let val = Number($("#down_pagin").val());
    if(offset!=0){
        $.ajax({
            url:"/main/in/api/actions/load_intern.php",
            type:"POST",
            data:{'offset_in': offset-val},
            traditional: true,
            success: function(resp){
                $("#screen").html(resp);
                $("#screen").append("<div id='intern_buttons'><button id = 'add_intern'><i class='fa-solid fa-plus'></i><button></div>");
            }
        })
    }
});

$(document).on('click', '#up_pagin', function(){
    let max = Number($("#intern_pagin").data('off_max'));
    let offset= Number($("#intern_pagin").data('offset'));
    let val = Number($("#up_pagin").val());
    if(max-offset>0 && max > 5){
        $.ajax({
            url:"/main/in/api/actions/load_intern.php",
            type:"POST",
            data:{'offset_in': offset+val},
            traditional: true,
            success: function(resp){
                $("#screen").html(resp);
                $("#screen").append("<div id='intern_buttons'><button id = 'add_intern'><i class='fa-solid fa-plus'></i><button></div>");
            }
        })
    }
});

$("#admins").on('click', function(){
    $("#inform").html('Recruters');
    $.ajax({
        url: '/main/in/api/actions/rac_load.php',
        type: 'POST',
        data: {mail: $("#user_").data('mail')},
        traditional: true,
        success: function(table){
            $("#screen").html(table);
            $("#screen").append("<div id='admin_buttons'><button id = 'add_admin'><i class='fa-solid fa-plus'></i><button></div>");
        }
    })
});

var admin_boxes = [];
$(document).on('change', '.admin_box', function(){
    let chc = 0;
    $('.admin_box').each(function(){
        if($(this).is(':checked')){
            chc = 1;
        }});
    if(chc == 0 && $("#del_admin").length > 0){
        $('#del_admin').remove();
    }
    admin_boxes = [];
    $('.admin_box').each(function(){
      if($(this).is(':checked')){
        admin_boxes.push($(this).attr('id'));
        if($("#del_admin").length == 0){
          $("#admin_buttons").append("<button id='del_admin'><i class='fa-solid fa-trash'></i></button>");
        }
      }
    });
  });

  $(document).on('click', '#add_admin', function(){
    $("#inform").html('Add recruter');
    $.ajax({
        url: '/main/in/api/actions/admin_form.php',
        type: 'POST',
        success: function(form){
            $("#screen").html(form);
        }
    })
});

$(document).on('submit', '#admin_form', function(e){
    e.preventDefault();
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
        url:"/main/in/api/actions/add_admin.php",
        type:"POST",
        data:$.param(data),
        cache: false,
        success: function(resp){
            alert(resp);
            location.reload();
        }})
}});

$(document).on('click', '#del_admin', function(){
    admin_boxes.forEach(admin => {
        $.ajax({
            url:"/main/in/api/actions/del_admin.php",
            type:"POST",
            data:{ID: admin},
            traditional: true,
            cache: false
        })});
        location.reload(); 
    });

    $("#anwser").on('click', function(){
        $("#inform").html('send us your anwser');
        let user = $("#user_").data('mail');
        $("#screen").html('<form action="#" id="git_form" method="post"><input type="text" name = "mail" style="display:none;" value="'+user+'"><label for="github-url"><i class="fab fa-github"></i></label><input type="text" id="github-url" name="github-url" title="Enter a valid GitHub repository link (e.g. https://github.com/user/repository)" placeholder="https://github.com/user/repository" required><button type="submit">SEND</button></form>'); 
    });    

    $(document).on('submit', '#git_form', function(e){
        e.preventDefault();
        $.ajax({
            url:"/main/in/api/actions/work.php",
            type:"POST",
            data:$("#git_form").serialize(),
            cache: false,
            success: function(){
                alert("thank you for your time, now your account from this site will be deleted ");
                location.reload();
            }})
    });
    if($("#user_").data('mail')=='test@test.test'){
        $("#screen").html('<h1>Hello! This is a set-up account. To start create a Recruter account:</h1>');
        $.ajax({
            url: '/main/in/api/actions/admin_form.php',
            type: 'POST',
            success: function(form){
                $("#screen").append(form);
                $("#admin_form").append('<br><label><input type="checkbox" name = "tester" value="test">I am an Api tester, (import testing data)</label>');
                $("#admin_form").attr("id", "start_form");
            }
        })
    }

    $(document).on('submit', '#start_form', function(e){
        e.preventDefault();
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
            url:"/main/in/api/actions/set-up.php",
            type:"POST",
            data:$.param(data),
            cache: false,
            success: function(resp){
                alert(resp);
                location.reload();
            }})
    }
    });

});