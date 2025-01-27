function calculateBMI(formId, resultId) {
    document.getElementById(formId).addEventListener('submit', function(e) {
        e.preventDefault();

        const weight = parseFloat(document.querySelector(`#${formId} #weight`).value);
        const height = parseFloat(document.querySelector(`#${formId} #height`).value) / 100;

        if (!weight || !height) {
            document.getElementById(resultId).innerText = "Proszę wprowadzić prawidłowe dane.";
            return;
        }

        const bmi = (weight / (height * height)).toFixed(2);

        let interpretation = '';
        if (bmi < 18.5) {
            interpretation = 'Niedowaga';
        } else if (bmi >= 18.5 && bmi <= 24.9) {
            interpretation = 'Waga prawidłowa';
        } else if (bmi >= 25 && bmi <= 29.9) {
            interpretation = 'Nadwaga';
        } else {
            interpretation = 'Otyłość';
        }

        document.getElementById(resultId).innerHTML = `
            Twoje BMI: <strong>${bmi}</strong> <br>
            Wynik: <strong>${interpretation}</strong>
        `;
    });
}


function calculateCalories(formId, resultId) {
    document.getElementById(formId).addEventListener('submit', function (e) {
        e.preventDefault();

        const weight = parseFloat(document.getElementById('weight').value);
        const height = parseFloat(document.getElementById('height').value);
        const age = parseInt(document.getElementById('age').value);
        const activity = parseFloat(document.getElementById('activity').value);
        const gender = document.querySelector('input[name="gender"]:checked').value;

        if (!weight || !height || !age || !activity || !gender) {
            document.getElementById(resultId).innerText = "Proszę wprowadzić wszystkie dane.";
            return;
        }

        let BMR;
        if (gender === "male") {
            BMR = 10 * weight + 6.25 * height - 5 * age + 5;  // Mifflin-St Jeor dla mężczyzn
        } else if (gender === "female") {
            BMR = 10 * weight + 6.25 * height - 5 * age - 161; // Dla kobiet
        }

        const dailyCalories = BMR * activity;
        const caloriesMaintaining = Math.round(dailyCalories);
        const caloriesLosing = Math.round(dailyCalories - 500);
        const caloriesGaining = Math.round(dailyCalories + 500);

        document.getElementById(resultId).innerText = `
            Zapotrzebowanie kaloryczne na utrzymanie wagi: ${caloriesMaintaining} kcal
            \nNa schudnięcie: ${caloriesLosing} kcal
            \nNa przytycie: ${caloriesGaining} kcal
        `;
    });
}

function calculateOneRepMax(formId, resultId) {
    document.getElementById(formId).addEventListener('submit', function (e) {
        e.preventDefault();

        const weight = parseFloat(document.getElementById('weight').value);
        const reps = parseInt(document.getElementById('reps').value);
        const exercise = document.getElementById('exercise').value;

        if (!weight || !reps || !exercise) {
            document.getElementById(resultId).innerText = "Proszę wprowadzić wszystkie dane.";
            return;
        }

        let oneRepMax = 0;
        if (exercise === "squat") {
            oneRepMax = weight * (1 + 0.0333 * reps);
        } else if (exercise === "benchPress") {
            oneRepMax = weight * (1 + 0.025 * reps);
        } else if (exercise === "deadlift") {
            oneRepMax = weight * (1 + 0.0277 * reps);
        } else if (exercise === "rows") {
            oneRepMax = weight * (1 + 0.0333 * reps);
        }

        oneRepMax = oneRepMax.toFixed(2);

        document.getElementById(resultId).innerText = `Twoje 1RM dla tego ćwiczenia to: ${oneRepMax} kg`;
    });
}


