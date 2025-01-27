function deleteExercise(exerciseId) {

    if (exerciseId) {
        $.ajax({
            url: '/deleteExercise',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ exercise_id: exerciseId }),
            success: function (response) {
                if (response.success) {

                } else {
                    $('[data-id="'+exerciseId+'"]').remove()
                    alert('Ćwiczenie zostało pomyślnie usunięte!');
                }
            },
            error: function (error) {
                console.error('Błąd podczas usuwania:', error);
            }
        });
    } else {
        console.error('Brak ID ćwiczenia!');
    }
}
window.deleteExercise = deleteExercise;

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
        fetchExercises(searchQuery);
    });

});
