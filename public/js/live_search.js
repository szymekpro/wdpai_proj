$(document).ready(function () {
    function fetchExercises(searchQuery = '') {
        $.ajax({
            url: 'public/scripts/live_search.php',
            method: 'POST',
            data: { search: searchQuery },
            success: function (response) {
                $('#results').html(response);
            }
        });
    }
    fetchExercises();
    $('#searchInput').on('keyup', function () {
        let searchQuery = $(this).val();
        fetchExercises(searchQuery); //
    });
});