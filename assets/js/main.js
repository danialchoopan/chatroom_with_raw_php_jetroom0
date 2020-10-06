$(document).ready(function () {
    //send messages
    $('#msg_text').on("keypress", function (e) {
        if (e.keyCode === 13) {
            if (e.target.value !== "") {
                let msg_text = e.target.value;
                $('#msg_text').attr("disabled", "true");
                e.target.value = "پیام شما در حال ارسال میباشد";
                $.ajax({
                    type: 'POST',
                    url: 'assets/php/messages.php?msg_do=send',
                    data: {msg_text: msg_text},
                    success: function (data) {
                        e.target.value = "";
                        if (data.status === "error") {
                            $("#show_error").innerText("پیام شما ارسال نشد!")
                            $("#show_error").addClass("error-box");
                            $("#show_error").addClass("form-box-p");
                            setTimeout(() => {
                                $("#show_error").innerText("")
                                $("#show_error").removeClass("error-box");
                                $("#show_error").removeClass("form-box-p");
                            }, 2000)
                        }
                        $('#msg_text').removeAttr("disabled");
                    }
                });
            }
        }
    });

    //get messages
    setInterval(() => {
        $.ajax({
            type: 'POST',
            url: 'assets/php/messages.php?msg_do=get_all',
            success: function (data) {
                let div_msg = ``;
                data.forEach(obj_data => {
                    div_msg += `<div>${obj_data.nickname} : ${obj_data.message}</div>`;
                });

                console.log(div_msg);
                $("#msg_show_box").html(div_msg);
            }
        });
    }, 500);
    //login
    $("#logout_btn").click(function () {
        $.ajax({
            type: 'POST',
            url: 'assets/php/auth.php?do_to=logout',
            success: function () {
                window.location = "login/login.php"
            }
        });
    });

});
