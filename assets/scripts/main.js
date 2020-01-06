"use strict";

const readImgURL = function(reader, chosenImage, preview) {
    reader.onload = e => {
        preview.src = e.target.result;
    };

    chosenImage.addEventListener("change", e => {
        const image = e.target.files[0];
        reader.readAsDataURL(image);
    });
};

const reader = new FileReader();

//Preview choosen image to post.
if (window.location.pathname === "/create-post.php") {
    //Preview chosen image for new post
    const chooseImage = document.querySelector("#post-image");
    const previewImage = document.querySelector("#preview");

    readImgURL(reader, chooseImage, preview);
}

//Preview chosen image for avatar
if (window.location.pathname === "/settings.php") {
    const chooseAvatar = document.querySelector("#avatar");
    const previewAvatar = document.querySelector("#avatar-image");

    readImgURL(reader, chooseAvatar, previewAvatar);
}

//Script for edit post
const postInformations = document.querySelectorAll(".post__information");

postInformations.forEach(postInformation => {
    const information = postInformation.children[1];
    const editPostButton = postInformation.children[1].lastElementChild;
    const editForm = postInformation.children[2].lastElementChild;

    editPostButton.addEventListener("click", () => {
        information.classList.toggle("hidden");
        editForm.classList.toggle("hidden");
    });

    editForm.addEventListener("submit", event => {
        event.preventDefault();

        const formData = new FormData(editForm);

        fetch("app/posts/update.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(post => {
                console.log(post);
            });

        information.classList.toggle("hidden");
        editForm.classList.toggle("hidden");
    });
});
