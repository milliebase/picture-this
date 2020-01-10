const postInformations = document.querySelectorAll(".post__information");

//Loop through all posts
postInformations.forEach(postInformation => {
    const postDetails = postInformation.children[0];

    //Variables for when editform is unactive
    const description = postInformation.children[1];

    if (postInformation.children.length > 2) {
        const editPostButton = postInformation.children[1].lastElementChild;

        //Variables for when editform is active
        const editMode = postInformation.children[2];
        const editForm = postInformation.children[2].firstElementChild;

        //Toggle between hiding and showing editform
        editPostButton.addEventListener("click", () => {
            postDetails.classList.toggle("hidden");
            description.classList.toggle("hidden");
            editMode.classList.toggle("hidden");
        });

        //Handle update of description
        editForm.addEventListener("submit", event => {
            event.preventDefault();

            const formData = new FormData(editForm);

            fetch("app/posts/update.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(post => {
                    description.children[1].textContent = post.description;
                });

            postDetails.classList.toggle("hidden");
            description.classList.toggle("hidden");
            editMode.classList.toggle("hidden");
        });
    }
});
