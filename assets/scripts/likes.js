//Handle likes
const likeForms = document.querySelectorAll(".like__form");

likeForms.forEach(likeForm => {
    likeForm.addEventListener("submit", event => {
        event.preventDefault();
        const likeButton = likeForm.childNodes[3];
        //Toggle between filled or unfilled icon on click
        if (likeButton.classList.contains("like__button--unliked")) {
            likeButton.classList.toggle("like__button--unliked");
            likeButton.classList.toggle("like__button--liked");
        } else if (likeButton.classList.contains("like__button--liked")) {
            likeButton.classList.toggle("like__button--unliked");
            likeButton.classList.toggle("like__button--liked");
        }
        const formData = new FormData(likeForm);
        fetch("app/posts/like.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(likes => {
                //Update likes
                let currentLikes = likeForm.lastElementChild;
                if (likes[0] > 0) {
                    currentLikes.textContent = `${likes[0]} people likes this`;
                } else {
                    currentLikes.textContent = "Nobody has liked this yet";
                }
            });
    });
});
