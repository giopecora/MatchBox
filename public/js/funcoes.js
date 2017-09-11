$( document ).ready(function() {
    insertChat("me", "Olá! Como posso ajudar?");
});


var me = {};
me.avatar = "https://lh4.ggpht.com/EJNRVilnQU4-mIp2yMmd2MYj5N-R58psCWc9che116OUGlqlswbyF0D_-WL5aZQbmSs=w300";

var you = {};
you.avatar = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY0FSOMFzs4rjfX46HqkkfdNeGjc1pYhKIFnrFIhFaE7jHQPr3";

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}            

//-- No use time. It is a javaScript effect.
function insertChat(who, text, time = 0){
    text = text.replace("\"", "");
    text = text.replace("\"", "");
    var control = "";
    var date = formatAMPM(new Date());
    
    if (who == "me"){
        
        control = '<li style="width:100%">' +
                        '<div class="msj macro">' +
                        '<div class="avatar"><img class="img-circle" style="width:100%;" src="'+ me.avatar +'" /></div>' +
                            '<div class="text text-l">' +
                                '<p>'+ text +'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '</div>' +
                    '</li>';                    
    }else{
        control = '<li style="width:100%;">' +
                        '<div class="msj-rta macro">' +
                            '<div class="text text-r">' +
                                '<p>'+text+'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="'+you.avatar+'" /></div>' +                                
                  '</li>';
    }
    setTimeout(
        function(){                        
            $("ul").append(control);

        }, time);
    
}

function resetChat(){
    $("ul").empty();
}

$(".mytext").on("keyup", function(e){
    if (e.which == 13){
        var text = $(this).val();
        if (text !== ""){
            insertChat("you", text);              
            $(this).val('');
            $.ajax({
                url: "ChatBox/enviarPergunta",
                method: "POST",
                data: {'pergunta': text},
                context: document.body
            }).done(function(data) {
                insertChat("me",data,0);
            }).fail(function(){
                alert("teste 2");   
            });
        }
    }
});

//-- Clear Chat
resetChat();
