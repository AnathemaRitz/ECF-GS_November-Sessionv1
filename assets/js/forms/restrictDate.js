
// TODO : repasser sur ce script pour qu'il prenne bien en compte le formulaire

/*
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const maxDate = new Date();
    maxDate.setDate(today.getDate() + 7);

    const dateInput = document.querySelector('#order_pickupDate');

    dateInput.min = today.toISOString().split('T')[0];
    dateInput.max = maxDate.toISOString().split('T')[0];

    dateInput.addEventListener('change', function (e) {
        const selectedDate = new Date(e.target.value);
        const dayOfWeek = selectedDate.getDay();

        if (dayOfWeek === 0 || dayOfWeek === 1) {
            alert('La date ne peut pas être un lundi ou un dimanche.');
            e.target.value = '';
        }
    });
});*/