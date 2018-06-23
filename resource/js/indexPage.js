$(function () {
    if ($('#group_table').length > 0) {
        try {
            $('#group_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": true,
                "info": true,
                "searching": false,
                "autoWidth": false,
                "pageLength": 15
            });
        } catch (error) {

        }

    }
});