$(document).ready(function () {

    //Card table
    $('.card-table').DataTable({
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false
    });

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
