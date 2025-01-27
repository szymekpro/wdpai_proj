document.addEventListener('DOMContentLoaded', function () {
    const workoutDeleteFields = document.querySelectorAll('.workoutDeleteField');

    workoutDeleteFields.forEach(button => {
        button.addEventListener('click', function () {

            const workoutId = button.getAttribute('data-workout-id');

            if (workoutId) {
                console.log('Workout ID:', workoutId);
                const requestID = JSON.stringify({ workout_id: workoutId });
                console.log('Request workout ID:', requestID);

                const request = {
                    method: 'POST',
                    body: requestID,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                };

                fetch('/delete', request)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Trening został pomyślnie usunięty!');
                            location.reload();  // Odświeżenie strony po sukcesie
                        } else {
                            alert('Błąd: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Błąd podczas żądania:', error);
                    });
            } else {
                console.error('Brak ID treningu!');
            }
        });
    });
});