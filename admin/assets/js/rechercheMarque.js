$(document).ready(function () {
    $('#recherche-marque').on('keyup', function () {
        let terme = $(this).val();
        $.ajax({
            url: 'admin/src/php/ajax/recherche_marque.php',
            method: 'POST',
            data: { recherche: terme },
            success: function (data) {
                $('#resultats-marques').html(data);
            }
        });
    });
});
