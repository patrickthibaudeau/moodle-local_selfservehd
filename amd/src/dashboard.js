define(['jquery', 'jqueryui', 'local_selfservehd/select2'], function ($, jqui, select2) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initDashboard() {
        initPreviewModal();
        initDeleteModal();
    }

    /**
     * Holds all functionality for the user select box
     * @returns {undefined}
     */
    function initPreviewModal() {
        var wwwroot = M.cfg.wwwroot;

        $(".preview").click(function () {
            var id = $(this).data('id');
            $('#preview-subject').html(id);
            $.ajax({
                url: wwwroot + '/local/selfservehd/ajax/messages.php?action=preview&templateid=' + id,
                dataType: 'json',
                success: function (preview) {
                    console.log(preview.subject);
                    $('#preview-name').html(preview.name);
                    $('#preview-subject').html(preview.subject);
                    $('#preview-content').html(preview.content);
                },
                error: function (e) {
                    console.log(e);
                }
            });

            $("#previewModal").modal({
                show: true,
                focus: true
            });
        });

    }

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.delete-message').click(function () {
            var id = $(this).data('id');
            var content = M.util.get_string('delete_message_confirmation', 'local_selfservehd');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    url: wwwroot + '/local/selfservehd/ajax/messages?action=deleteMessage&templateid=' + id,
                    dataType: 'text',
                    success: function (deleted) {
                        location.reload();
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });
    }

    return {
        init: function () {
            initDashboard();
        }
    };
});