const addExerciseButton = document.getElementById('addExerciseButton');
const exerciseContainer = document.getElementById('exerciseContainer');
const removedExercisesContainer = document.getElementById('removedExercisesContainer');

addExerciseButton.addEventListener('click', () => {
    const firstExerciseBox = document.querySelector('.exerciseBox .particularExerciseBox');
    const exerciseDiv = firstExerciseBox.cloneNode(true);

    const exerciseInput = exerciseDiv.querySelector('select[name="exercises[exercise_id][]"]');
    if (exerciseInput) {
        exerciseInput.value = '';
    }

    const setsInput = exerciseDiv.querySelector('input[name="exercises[sets][]"]');
    if (setsInput) {
        setsInput.value = '';
        setsInput.placeholder = 'sets';
    }

    const repsInput = exerciseDiv.querySelector('input[name="exercises[reps][]"]');
    if (repsInput) {
        repsInput.value = '';
        repsInput.placeholder = 'reps';
    }

    const weightInput = exerciseDiv.querySelector('input[name="exercises[weight][]"]');
    if (weightInput) {
        weightInput.value = '';
        weightInput.placeholder = 'weight (kg)';
    }

    const notesInput = exerciseDiv.querySelector('input[name="exercises[notes][]"]');
    if (notesInput) {
        notesInput.value = '';
        notesInput.placeholder = 'notes';
    }

    exerciseContainer.querySelector('.exerciseBox').appendChild(exerciseDiv);

    const removeButton = exerciseDiv.querySelector('.removeExerciseButton');
    removeButton.addEventListener('click', () => {
        if (exerciseContainer.querySelectorAll('.particularExerciseBox').length > 1) {
            exerciseDiv.remove();
        } else {
            alert('Nie możesz usunąć wszystkich ćwiczeń! Co najmniej jedno ćwiczenie musi pozostać. 1');
        }
    });
});

document.querySelectorAll('.removeExerciseButton').forEach(removeButton => {
    removeButton.addEventListener('click', (event) => {
        const exerciseDiv = event.target.closest('.particularExerciseBox');

        const hiddenInput = exerciseDiv.querySelector('input[name="existing_exercises[]"]');
        if (hiddenInput) {
            const removedInput = document.createElement('input');
            removedInput.type = 'hidden';
            removedInput.name = 'removed_exercises[]';
            removedInput.value = hiddenInput.value;
            removedExercisesContainer.appendChild(removedInput);
        }

        if (exerciseContainer.querySelectorAll('.particularExerciseBox').length > 1) {
            exerciseDiv.remove();
        } else {
            alert('Nie możesz usunąć wszystkich ćwiczeń! Co najmniej jedno ćwiczenie musi pozostać.');
        }
    });
});