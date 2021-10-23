const addFormToCollection = (e) => {
    console.log(e.currentTarget.dataset);
    const collectionHolder = document.getElementById(e.currentTarget.dataset.collectionHolderId);


    const item = document.createElement('div');


    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
    // add a delete link to the new form
    addTagFormDeleteLink(item);
};

const addTagFormDeleteLink = (tagFormDiv) => {
    const removeFormButton = document.createElement('button')
    removeFormButton.classList += "btn btn-danger my-2";
    removeFormButton.innerText = 'Supprimer cette vidéo'

    tagFormDiv.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault()
        tagFormDiv.remove();
    });
}

const videos = document.querySelectorAll('div.videos > div')
videos.forEach((video) => {
    addTagFormDeleteLink(video)
})
document.querySelectorAll('.add_item_link').forEach(btn => btn.addEventListener("click", addFormToCollection));
