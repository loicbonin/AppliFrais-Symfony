$(document).ready(function(){
    $('.modal').modal();
});

var instance = M.FeatureDiscovery.getInstance(elem);

$(document).ready(function(){
    $('.tap-target').featureDiscovery();
});

$('.timepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 5, // Creates a dropdown of 15 years to control year,
    today: 'Aujourd\'hui',
    clear: 'Vider',
    close: 'Ok',
    closeOnSelect: false, // Close upon selecting a date,// The title label to use for the month nav buttons
    labelMonthNext: 'Mois suivant',
    labelMonthPrev: 'Mois precedent',
    // The title label to use for the dropdown selectors
    labelMonthSelect: 'Selectionner un mois',
    labelYearSelect: 'Selectionner une année',
	// Months and weekdays
    monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre' ],
    monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
    weekdaysFull: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
    weekdaysShort: [ 'DIm', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
    // Materialize modified
    weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
    // The format to show on the `input` element
    format: 'yyyy-mm-dd',
});