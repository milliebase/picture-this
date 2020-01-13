const posts = document.querySelectorAll(".post");

//Loop through all posts and handle edit form.
posts.forEach(post => {
    const userSettingsButton = post.querySelector(".post__user--settings");
    const settingsOverlay = post.querySelector(".settings__overlay");
    const editPostButton = post.querySelector(".settings__overlay button");

    const informationHolder = post.querySelector(".post__information--holder");
    const description = post.querySelector(".post__details--description p");

    const postEdit = post.querySelector(".post__edit");

    const editForm = post.querySelector(".edit__form");

    const editCancelButton = post.querySelector(".edit__form--buttons p");

    if (
        typeof userSettingsButton != "undefined" &&
        userSettingsButton != null
    ) {
        userSettingsButton.addEventListener("click", () => {
            settingsOverlay.classList.toggle("hidden");
        });
    }

    editPostButton.addEventListener("click", () => {
        userSettingsButton.classList.toggle("hidden");
        settingsOverlay.classList.toggle("hidden");
        informationHolder.classList.toggle("hidden");

        postEdit.classList.toggle("hidden");

        editForm.addEventListener("submit", event => {
            event.preventDefault();
            const formData = new FormData(editForm);
            fetch("app/posts/update.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(post => {
                    description.textContent = post.description;
                });

            informationHolder.classList.toggle("hidden");
            postEdit.classList.toggle("hidden");
            userSettingsButton.classList.toggle("hidden");
        });
    });

    if (typeof editCancelButton != "undefined" && editCancelButton != null) {
        editCancelButton.addEventListener("click", () => {
            informationHolder.classList.toggle("hidden");
            postEdit.classList.toggle("hidden");
            userSettingsButton.classList.toggle("hidden");
        });
    }

    const deletePostButton = post.querySelector(".delete__button");
    const deletePostOverlay = post.querySelector(".delete-post__overlay");

    deletePostButton.addEventListener("click", () => {
        deletePostOverlay.classList.toggle("hidden");
        settingsOverlay.classList.toggle("hidden");
    });

    const deletePostCancel = post.querySelector(
        ".delete-post__overlay .delete__cancel"
    );

    deletePostCancel.addEventListener("click", () => {
        deletePostOverlay.classList.toggle("hidden");
    });
});
