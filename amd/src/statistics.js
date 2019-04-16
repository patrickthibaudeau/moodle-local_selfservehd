define(['jquery', 'jqueryui', 'local_selfservehd/daterangepicker'], function ($, jqui, daterangepicker) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function init() {
        datePicker();
    }

    /**
     * Update alertsContainer every 2 seconds
     * @returns {undefined}
     */
    function datePicker() {
        var wwwroot = M.cfg.wwwroot;
        
        $('#dateRange').daterangepicker({
            opens: 'left'
        });

        $('#dateRange').change(function () {
            var dateRange = $(this).val();
            window.location = wwwroot + '/local/selfservehd/reports/statistics.php?daterange=' + dateRange;
//            $.ajax({
//                url: wwwroot + '/local/selfservehd/ajax/statistics.php?action=changeDate',
//                data: '&daterange=' + dateRange,
//                dataType: 'html',
//                success: function (results) {
//                    console.log(results);
//                },
//                error: function (e) {
//                    console.log(e);
//                }
//            });
        });
    }
    
    return {
        init: function () {
            init();
        }
    };
});