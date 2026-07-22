
const form = document.getElementById("form-of-checkin");
const input = document.getElementById('checkin_form_checkin')
const CODE_TO_DIGIT = {
    'Digit0': '0', 'Digit1': '1', 'Digit2': '2', 'Digit3': '3', 'Digit4': '4',
    'Digit5': '5', 'Digit6': '6', 'Digit7': '7', 'Digit8': '8', 'Digit9': '9',
    'Numpad0': '0', 'Numpad1': '1', 'Numpad2': '2', 'Numpad3': '3', 'Numpad4': '4',    // To cover the case where the reader using number pad
    'Numpad5': '5', 'Numpad6': '6', 'Numpad7': '7', 'Numpad8': '8', 'Numpad9': '9',
};
let buffer = '';
let enterKeypressedCounter = 0;


form.addEventListener("submit", (event) => {
    event.preventDefault();
});

input.addEventListener('keydown', async (e) => {
    if (CODE_TO_DIGIT[e.code]) {
        e.preventDefault();
        buffer += CODE_TO_DIGIT[e.code];
        input.value = buffer;
    }
    if (e.key === 'Enter') enterKeypressedCounter++;
    if (enterKeypressedCounter === 2) {
        /**@type Object*/
        handleScan(buffer);
        buffer = '';
        input.value = buffer;
        enterKeypressedCounter = 0;
    }
});

const handleResult = (runner) => {
    const nameElement = document.getElementById('name');
    if (!runner) {
        nameElement.innerText = "Aucun compétiteur n'a été trouvé !"
    }
    else {
        /* Here, we specify the value assigned according to the data provided and the page which calls the function */
        if (!runner.firstname) {
          runner = runner[0];
        }
        nameElement.innerText = runner.firstname + " " + runner.lastname;
    }
}

const handleScan = async (buffer) => {
    let runner = await fetch(form.action, {
        headers: {"Cache-Type": "application/json"},
        method: 'POST',
        body: new FormData(form),
    })
        .then((response) => {
            return response.json()
        })
        .then(json => {
            return json;
        })
        .catch((error) => {
            return new Error("Une erreur est survenue.")
        });

    handleResult(runner);
};