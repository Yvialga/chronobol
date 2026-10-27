
const form = document.getElementById('form-of-checkin');
const manualForm = document.getElementById('manual-form');
const automaticInput = document.getElementById('checkin_form_checkin'); // provided that it does change its name
const submitManualFormBtn = document.getElementById('manual-submit'); // same issue here
const typoLinkContainer = document.getElementById('typo-link-container');
const loadingSpinner = document.createElement('div');
const CODE_TO_DIGIT = {
    'Digit0': '0', 'Digit1': '1', 'Digit2': '2', 'Digit3': '3', 'Digit4': '4',
    'Digit5': '5', 'Digit6': '6', 'Digit7': '7', 'Digit8': '8', 'Digit9': '9',
    'Numpad0': '0', 'Numpad1': '1', 'Numpad2': '2', 'Numpad3': '3', 'Numpad4': '4',    // To cover the case where the reader using number pad
    'Numpad5': '5', 'Numpad6': '6', 'Numpad7': '7', 'Numpad8': '8', 'Numpad9': '9',
};
let buffer = '';
let enterKeypressedCounter = 0;
const onVerifPage = (window.location.pathname).includes('verif');


//!\\ LISTENERS //!\\

form.addEventListener("submit", (event) => {
    event.preventDefault();
});

automaticInput.addEventListener('keydown', (e) => {
    if (CODE_TO_DIGIT[e.code]) {
        e.preventDefault();
        buffer += CODE_TO_DIGIT[e.code];
        automaticInput.value = buffer;
    }
    if (e.key === 'Enter') enterKeypressedCounter++;
    if (enterKeypressedCounter === 2) {
        resetCollectionFormErrorMessage();
        
        handleCheckIn(form)
            .then(response => {

                if (response.ok) {
                    return response.json();
                }
                else if (response.status >= 400) {
                    const errorMessage = handleError(response, form);
                    throw new Error(errorMessage);
                }
            })
            .then(json => {
                handleResult(json, form);
            })
            .catch((error) => {
                // gérer les cas d'erreurs (host not found, no connection, server not responding, etc...)
                console.log('error ?' + error)
            });
        loading();

        if (typoLinkContainer) typoLinkContainer.innerHTML = '';
        buffer = '';
        automaticInput.value = buffer;
        enterKeypressedCounter = 0;
    }
});

submitManualFormBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    resetCollectionFormErrorMessage();

    handleCheckIn(manualForm)
        .then(response => {

            if (response.ok) {
                return response.json();
            } else {
                const errorMessage = handleError(response, manualForm);
                throw new Error(errorMessage);
            }

        })
        .then((json) => {
            handleResult(json, manualForm);

            automaticInput.focus();

            const bibInput = document.querySelector("#manual-bib-input input");
            const captainInputList = document.querySelectorAll("#manual-captain-input input");
            bibInput.value = '';
            for (const captainInput of captainInputList) {
                captainInput.checked = false;
            }
        })
        .catch((error) => {
        // gérer les cas d'erreurs (host not found, no connection, server not responding, etc...)
        console.log('error ?' + error)
    });
    loading(true);
});



//!\\ FUNCTIONS //!\\

/**Display the information get from the JSON response
 * @param {Object} runner JSON response from fetch request.
 * @param {HTMLFormElement} originForm
 */
const handleResult = (runner, originForm) => {
    loadingSpinner.remove();

    const firstnameOutput = document.getElementById('name');
    const lastnameOutput = document.getElementById('lastname');
    const bibElement = document.getElementById('bib-line');
    const bibOutput = document.getElementById('bib-print');
    const trailElement = document.getElementById('trail-line');
    const trailOutput = document.getElementById('trail-print');

    if (!runner && onVerifPage) {
            firstnameOutput.innerText = "Aucun compétiteur n'a été trouvé !"
            lastnameOutput.innerText = '';
            bibOutput.innerText = '';
            trailOutput.innerText = '';
            bibElement.classList.add('invisible');
            trailElement.classList.add('invisible');
    }
    else {

        if (onVerifPage) {
            firstnameOutput.innerText = runner.firstname;
            lastnameOutput.innerText = runner.lastname;
            bibOutput.innerText = runner.bib_number;
            trailOutput.innerText = runner.trail;
            bibElement.classList.remove('invisible');
            trailElement.classList.remove('invisible');

            /** @type {HTMLAnchorElement} Anchor element allows to correct a typo */
            const typoCorrection = document.createElement("a");
            const slugOwnerBlock = document.querySelector('.js-event-slug');
            const slug = slugOwnerBlock.getAttribute('data-slug');

            typoCorrection.href = Routing.generate("app_team_edit", { id: runner.team_id, slug: slug });
            typoCorrection.innerText = 'Corrigez une faute de frappe';
            typoCorrection.classList.add('underline', 'hover:no-underline');
            typoLinkContainer.appendChild(typoCorrection);
        }
        else { // on checkin page
            const feedbackTag = document.createElement('li');
            feedbackTag.classList.add('flex','gap-x-1')
            const markerTag = document.createElement('span');
            markerTag.classList.add('pr-2');
            markerTag.innerText = '•';

            const trailSpan = document.createElement('span');
            trailSpan.innerText = runner.trail + " : ";

            const bibSpan = document.createElement('span');
            bibSpan.innerText = 'n°' + runner.bib_number;

            const firstnameSpan = document.createElement('span');
            if (runner.final_time) {
                firstnameSpan.innerText = "l'équipe de " + runner.firstname;
            } else {
                firstnameSpan.innerText = runner.firstname;
            }
            const lastnameSpan = document.createElement('span');
            lastnameSpan.classList.add('uppercase');
            lastnameSpan.innerText = runner.lastname;

            const timeSpan = document.createElement('span');
            let timeDisplayed;
            let textIfTeamFinished;
            if (runner.final_time) {
                textIfTeamFinished = 'vient de terminer ';
                timeDisplayed = new Date(runner.final_time);
            }
            else {
                textIfTeamFinished = 'a fini en ';
                timeDisplayed = new Date(runner.personal_time);
            }
            timeSpan.innerText = textIfTeamFinished + ("0" + timeDisplayed.getHours()).slice(-2) + ":" + ("0" + timeDisplayed.getMinutes()).slice(-2) + ":" + ("0" + timeDisplayed.getSeconds()).slice(-2);

            feedbackTag.append(trailSpan, bibSpan, firstnameSpan, lastnameSpan, timeSpan);
            feedbackTag.insertBefore(markerTag, feedbackTag.firstChild);

            const resultBlock = document.getElementById('result-block');
            resultBlock.insertBefore(feedbackTag, resultBlock.firstChild);
        }

    }
}

/**
 * @param {Response} response
 * @param {HTMLFormElement} originForm
 * @return {String}
 */
const handleError = (response, originForm) => {
    loadingSpinner.remove();

    let errorMessage;
    if (response.status === 404) {
        errorMessage = 'Compétiteur inconnu';
    }
    else if (response.status === 409) {
        errorMessage = "Déjà pointé";
    }
    else if (response.status === 422) {
        errorMessage = "Veuillez saisir correctement toutes les informations requises";
    }
    else {
        errorMessage = "Erreur rencontrée : " + response.status;
    }
    const errorTag = document.createElement("p");
    errorTag.innerText = errorMessage;
    errorTag.classList.add('text-red-400')

    document.querySelector(`#${originForm.id} .error-helper`).append(errorTag);
    return errorMessage;
}

/**
 * @param {HTMLFormElement} providedForm Form to fill out to determine the URL to which the POST request should be sent.
 * @returns {Promise<Response>}
 */
const handleCheckIn = async (providedForm) => {
    return await fetch(providedForm.action, {
        headers: {"Cache-Type": "application/json"},
        method: 'POST',
        body: new FormData(providedForm),
    })
        .then((response) => {
            return response;
        })
        .catch((response) => {
            console.log(response.ok, response.statusText);
            response.json().then((json) => {
                console.log(json)
            })
        });
};

/**Add a loading spinner just beside input during the process.
 * @param {boolean} manual True means that the manual form is requesting feedback. Otherwise, it refers to the "automatic" checkin or verif page.
 */
const loading = (manual = false) => {
    loadingSpinner.innerHTML = `<svg class="mr-3 -ml-1 size-5 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

    /**@type HTMLElement*/
    let fieldset;
    if (!manual) fieldset = document.getElementById('chip-input');
    else fieldset = document.querySelector('.loader');

    fieldset.appendChild(loadingSpinner);
};

const resetCollectionFormErrorMessage = () => {
    const formCollection = document.querySelectorAll(`form .error-helper`);

    for (const form of formCollection) {
        if (form.hasChildNodes()) {
            form.replaceChildren();
        }
    }
};