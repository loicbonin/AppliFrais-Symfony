$(document).ready(function(){
    $('.modal').modal();
    $('.collapsible').collapsible();


    $('.datepicker').datepicker({
        nextMonth: 'Mois suivant',
        previousMonth: 'Mois précédent',
        labelMonthSelect: 'Selectionner le mois',
        labelYearSelect: 'Selectionner une année',
        months: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
        monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
        weekdays: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
        weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
        weekdaysAbbrev: [ 'D', 'S', 'T', 'Q', 'Q', 'S', 'S' ],
        today: 'Aujourd\'hui',
        clear: 'Réinitialiser',
        done: 'Valider',
        cancel: 'fermer',
        format: 'dd/mm/yyyy',
        firstDay: 1
    });
});

(function($) {
    window.materializeForm.initDate = function() {
        $('input.date').datepicker({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 2, // Creates a dropdown of 15 years to control year
            labelMonthNext: 'Mois suivant',
            labelMonthPrev: 'Mois précédent',
            labelMonthSelect: 'Selectionner le mois',
            labelYearSelect: 'Selectionner une année',
            monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
            weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            weekdaysLetter: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
            today: 'Aujourd\'hui',
            clear: 'Réinitialiser',
            close: 'Fermer',
            format: 'dd/mm/yyyy'
        });
    }
})(jQuery);

$('.datepicker').datepicker({
    nextMonth: 'Mois suivant',
    previousMonth: 'Mois précédent',
    labelMonthSelect: 'Selectionner le mois',
    labelYearSelect: 'Selectionner une année',
    months: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
    monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
    weekdays: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
    weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
    weekdaysAbbrev: [ 'D', 'S', 'T', 'Q', 'Q', 'S', 'S' ],
    today: 'Aujourd\'hui',
    clear: 'Réinitialiser',
    done: 'Valider',
    cancel: 'fermer',
    format: 'dd/mm/yyyy',
    firstDay: 1
});

/*
var instance = M.FeatureDiscovery.getInstance(elem);

$(document).ready(function(){
$('.tap-target').featureDiscovery();
});
*/