var callInterval;

function callHelp() {

    $('.helpBtn').click(function () {
        $('.helpBtn').unbind();
        var wwwroot = $(this).data('wwwroot');
        var token = $(this).data('token');
        var ip = $(this).data('ip');
        $.ajax({
            url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
            data: '&wsfunction=sshd_get_help_call&ip=' + ip + '&moodlewsrestformat=json',
            dataType: 'json',
            success: function (results) {
                $('#helpModal').modal({
                    backdrop: 'static',
                    show: true
                });
                //Only show the close button once an agent has answered.
                $('#updateStatus').hide();
                $('#agentResponded').hide();
                checkStatus(wwwroot, token, ip);

            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#updateStatus').click(function () {
        var wwwroot = $(this).data('wwwroot');
        var token = $(this).data('token');
        var ip = $(this).data('ip');
        $.ajax({
            url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
            data: '&wsfunction=sshd_update_status&ip=' + ip + '&moodlewsrestformat=json',
            dataType: 'json',
            success: function (results) {
                document.location = 'index.php';
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

}

function checkStatus(wwwroot, token, ip) {
        $.ajax({
        url: wwwroot + '/webservice/rest/server.php?wstoken=' + token,
        data: '&wsfunction=sshd_check_status&ip=' + ip + '&moodlewsrestformat=json',
        dataType: 'json',
        success: function (results) {
            console.log(results);
            if (results[0].agent == "false") {
                clearInterval(callInterval);
                callInterval = setInterval(function () {
                    checkStatus(wwwroot, token, ip);
                }, 2000);
            } else {
                var data = results[0];
                $('#agentName').html(data.agent);
                $('#updateStatus').show();
                $('#agentResponded').show();
                clearInterval(callInterval);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}