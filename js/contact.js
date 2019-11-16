function contact() 
{
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var name = $("#name").val();
    var email = $("#email").val();
    var subject = $("#subject").val();
    var comment = $("#comment").val();
    
    if(name == "")
    {
        $("#status").html('<div class="red-text" >Please enter your name in the required field to proceed.</div>');
        $("#name").focus();
    }
    else if(email == "")
    {
        $("#status").html('<div class="red-text" >Please enter your email address to proceed.</div>');
        $("#email").focus();
    }
    else if(reg.test(email) == false)
    {
        $("#status").html('<div class="red-text" >Please enter a valid email address to proceed.</div>');
        $("#email").focus();
    }
    else
    {
        var dataString = 'name='+ name + '&email=' + email + '&subject=' + subject + '&comment=' + comment + '&page=contact';
        $.ajax({
            type: "POST",
            url: "./form/contact.php",
            data: dataString,
            cache: false,
            beforeSend: function() 
            {
                $("#status").html('<br clear="all"><br clear="all"><div align="left"><font style="font-family:Verdana, Geneva, sans-serif; font-size:15px; color:black;">Please wait</font> <img src="./img/Others/loadin.gif" alt="Loading...." align="absmiddle" title="Loading...."/></div><br clear="all">');
            },
            success: function(response)
            {
                var response_brought = response.indexOf('sent_successful=yes');
                if (response_brought != -1) 
                {
                    $("#status").html('<div class="green-text">Message sent, we will get back to you through '+email+' shortly. Thank you</div>');
                    window.location.replace(response);
                    $(".md-form").find('input').val('');
                }
                else
                {
                    $("#status").fadeIn(1000).html(response);
                }
            }
        });
    }
}