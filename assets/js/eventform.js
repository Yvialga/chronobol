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
    removeFormButton.innerText = 'Supprimer le parcours'

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