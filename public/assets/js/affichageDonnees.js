window.onload = () => {
    let city = document.querySelector("#activity_cities");
    let placeSelect = document.querySelector("#activity_places");
    let rueInput = document.querySelector("#activity_placeStreet");
    let zipCodeInput = document.querySelector("#activity_zipCode");
    let latitudeInput = document.querySelector("#activity_latitude");
    let longitudeInput = document.querySelector("#activity_longitude");

    //Gestion des champs villes/lieu/rue/coordonnées
    city.addEventListener("change", function () {
        let form = document.querySelector("#activity_form");
        let data = this.name + "=" + this.value;
        let cityId = city.value;

        fetch(form.action, {
            method: form.getAttribute("method"),
            body: data,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset:UTF-8"
            }
        })
            .then(response => response.text())
            .then(html => {
                let content = document.createElement('html');
                content.innerHTML = html;
                let newPlaceSelect = content.querySelector("#activity_places");
                placeSelect.replaceWith(newPlaceSelect);
                placeSelect = newPlaceSelect;

                fetch('get-zipcode/' + cityId)
                    .then(response => response.text())
                    .then(zipCode => {
                        zipCodeInput.value = zipCode; // Set the value of rueInput
                    });
                // Add change event listener to the new select element
                placeSelect.addEventListener("change", function () {
                    let selectedOption = this.options[this.selectedIndex];
                    let placeId = selectedOption.value;
                    console.log(placeId);
                    let placeIdInput = document.createElement("input");
                    placeIdInput.type = "hidden";
                    placeIdInput.id = "placeIdInput";
                    placeIdInput.name = "activity[placeId]";
                    placeIdInput.value = placeId;
                    form.appendChild(placeIdInput);
                    console.log(placeIdInput);
                    // Make a request to retrieve the placeStreet based on the selected placeId
                    fetch('get-place-street/' + placeId)
                        .then(response => response.text())
                        .then(placeStreet => {
                            rueInput.value = placeStreet; // Set the value of rueInput

                            let address = placeStreet;
                            let encodedAddress = address.replace(/ /g, '+');
                            console.log(encodedAddress);
                            let postcode = zipCodeInput.value;
                            // Utilise une requête HTTP appropriée pour appeler l'API de géocodage avec l'adresse
                            fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodedAddress}&postcode=${postcode}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.features && data.features.length > 0) {
                                        const feature = data.features[0];
                                        if (feature.geometry && feature.geometry.coordinates) {
                                            const coordinates = feature.geometry.coordinates;
                                            const latitude = coordinates[1];
                                            const longitude = coordinates[0];
                                            console.log(latitude);
                                            console.log(longitude);
                                            latitudeInput.value = latitude;
                                            longitudeInput.value = longitude;
                                        }
                                    }
                                })
                                .catch(error => {
                                    console.log("Une erreur s'est produite lors de l'appel à l'API de géocodage :", error);
                                });
                        });
                });
            });
    });
};
