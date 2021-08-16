$(function () {

    // download pdf
    var start = moment().subtract(29, 'days');
    var end = moment();
    var start_date = start.format('YYYY-MM-DD');
    var end_date = end.format('YYYY-MM-DD');

    function cb(start, end) {
        $('#rangemodalPDF span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#rangemodalPDF').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function (start, end, label) {
        $('#rangemodalPDF span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        start_date = start.format('YYYY-MM-DD');
        end_date = end.format('YYYY-MM-DD');
    });

    cb(start, end);

    $('#formPDF').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        window.open(url + '?start_date=' + start_date + " 00:00:00&end_date=" + end_date + " 23:59:59", '_blank');
    });

    // download excel
    var start_excel = moment().subtract(29, 'days');
    var end_excel = moment();
    var start_date_excel = start_excel.format('YYYY-MM-DD');
    var end_date_excel = end_excel.format('YYYY-MM-DD');

    function cbExcel(start_excel, end_excel) {
        $('#rangemodalExcel span').html(start_excel.format('MMMM D, YYYY') + ' - ' + end_excel.format('MMMM D, YYYY'));
    }

    $('#rangemodalExcel').daterangepicker({
        startDate: start_excel,
        endDate: end_excel,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function (start, end, label) {
        $('#rangemodalExcel span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        start_date_excel = start.format('YYYY-MM-DD');
        end_date_excel = end.format('YYYY-MM-DD');
    });

    cbExcel(start_excel, end_excel);

    $('#formExcel').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        window.open(url + '?start_date=' + start_date_excel + " 00:00:00&end_date=" + end_date_excel + " 23:59:59", '_blank');
    });

});