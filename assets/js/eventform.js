const addFormToCollection = event => {
    const collectionHolder = document.querySelector('.' + event.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    addTrailFormDeleteLink(item);

    collectionHolder.dataset.index++;
};

const addTrailFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-red-600 lucide lucide-trash2-icon lucide-trash-2">
        <path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
    </svg>`;
    removeFormButton.innerHTML = svg;
    const svgElement = removeFormButton.querySelector('svg');
    removeFormButton.classList.add('cursor-pointer', 'tooltip');
    removeFormButton.setAttribute('data-tip', 'Supprimer le parcours');

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        item.remove();
    })
}

document
    .querySelectorAll('.add_item_link')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });
document
    .querySelectorAll('ul.fk_trail_id li')
    .forEach((trail => {
        addTrailFormDeleteLink(trail);
    }))