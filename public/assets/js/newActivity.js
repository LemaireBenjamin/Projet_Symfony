document.addEventListener('DOMContentLoaded', function() {
    var placeSelect = document.getElementById('place-select');
    placeSelect.addEventListener('change', function() {
        var selectedPlaceId = this.value;
        console.log('ID de la place sélectionnée : ' + selectedPlaceId);
        // Récupérer l'élément input
        var inputElement = document.getElementById('rue');
        // Changer la valeur de l'attribut value
        // inputElement.value = places[selectedPlaceId];
     var place = places[0];
     var id = place.id;
     console.log(id);

    });

});