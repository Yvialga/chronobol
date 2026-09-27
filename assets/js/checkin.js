
const form = document.getElementById("form-of-checkin");
const manualForm = document.getElementById("manual-form");
const input = document.getElementById('checkin_form_checkin'); // provided that it does change its name
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

input.addEventListener('keydown', (e) => {
    if (CODE_TO_DIGIT[e.code]) {
        e.preventDefault();
        buffer += CODE_TO_DIGIT[e.code];
        input.value = buffer;
    }
    if (e.key === 'Enter') enterKeypressedCounter++;
    if (enterKeypressedCounter === 2) {
        handleCheckIn(form)
            .then(response => handleResult(response));
        loading();

        if (typoLinkContainer) typoLinkContainer.innerHTML = '';
        buffer = '';
        input.value = buffer;
        enterKeypressedCounter = 0;
    }
});

submitManualFormBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    handleCheckIn(manualForm)
        .then(response => handleResult(response));
    loading(true);
});



//!\\ FUNCTIONS //!\\

/**Display the information get from the JSON response
 * @param runner JSON response from fetch request.
 */
const handleResult = (runner) => {
    loadingSpinner.remove();

    const firstnameOutput = document.getElementById('name');
    const lastnameOutput = document.getElementById('lastname');
    const bibElement = document.getElementById('bib-line');
    const bibOutput = document.getElementById('bib-print');
    const trailElement = document.getElementById('trail-line');
    const trailOutput = document.getElementById('trail-print');

    if (!runner) {
        firstnameOutput.innerText = "Aucun compétiteur n'a été trouvé !"
        lastnameOutput.innerText = '';

        if (onVerifPage) {
            bibOutput.innerText = '';
            trailOutput.innerText = '';
            bibElement.classList.add('invisible');
            trailElement.classList.add('invisible');
        }
    }
    else {
        firstnameOutput.innerText = runner.firstname;
        lastnameOutput.innerText = runner.lastname;

        if (onVerifPage) {
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

    }
}

/**
 * @param providedForm Form to fill out to determine the URL to which the POST request should be sent.
 * @returns {Promise<void>}
 */
const handleCheckIn = async (providedForm) => {
    return await fetch(providedForm.action, {
        headers: {"Cache-Type": "application/json"},
        method: 'POST',
        body: new FormData(providedForm),
    })
        .then((response) => {
            return response.json()
        })
        .then(json => {
            return json;
        })
        .catch((error) => {
            console.log(error);
            return new Error("Une erreur est survenue.")
        });
};

/**Add a loading spinner just beside input during the process.
 * @param manual True means that the manual form is requesting feedback. Otherwise, it refers to the "automatic" checkin or verif page.
 */
const loading = (manual = false) => {
    loadingSpinner.innerHTML = `<svg class="mr-3 -ml-1 size-5 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

    /**@type HTMLElement*/
    let fieldset;
    if (!manual) fieldset = document.getElementById('chip-input');
    else fieldset = document.querySelector('.loader');

    fieldset.appendChild(loadingSpinner);
};