const addExerciseButton = document.getElementById('addExerciseButton');
const exerciseContainer = document.getElementById('exerciseContainer');

addExerciseButton.addEventListener('click', () => {
    const exerciseDiv = document.querySelector('.exerciseBox').cloneNode(true);
    exerciseDiv.querySelectorAll('input').forEach(input => input.value = '');
    exerciseContainer.appendChild(exerciseDiv);

    const removeButton = exerciseDiv.querySelector('.removeExerciseButton');
    removeButton.addEventListener('click', () => {
        exerciseDiv.remove();
    });
});