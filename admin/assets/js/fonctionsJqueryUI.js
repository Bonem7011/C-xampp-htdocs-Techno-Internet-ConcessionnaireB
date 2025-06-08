$(document).ready(function () {
    $('.voir-details').click(function () {
        let id = $(this).data('id');

        $.ajax({
            url: 'admin/src/php/ajax/get_voiture_details.php',
            type: 'POST',
            data: { id_voiture: id },
            success: function (data) {
                $('#modal-content').html(data);
                $('#detailsModal').modal('show');
            }
        });
    });
});
