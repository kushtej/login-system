console.log('hello world!')

function CheckUsername() {
    $.get('/signup/', { username: $('#username').val() },
        function (data) {
            var username = $.trim($('#username').val());
            if (username.length < 5) {
                $('#availabality').css({ "color": "red" })
                $('#availabality').html("Username too short!");
            } else {
                if (data == "True") {
                    $('#availabality').css({ "color": "green" })
                    $('#availabality').html("Username available");
                } else {
                    $('#availabality').css({ "color": "red" })
                    $('#availabality').html("Username not available");
                }
            }
        });
}
function onChange() {
    $("#username").change(function () { CheckUsername() });
}
$(document).ready(onChange);
