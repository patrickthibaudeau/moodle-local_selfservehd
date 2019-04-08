function callHelp() {
    $('.helpBtn').click(function () {
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
                console.log(results);
                document.location = 'index.php';
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

}


