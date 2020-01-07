const followForm = document.querySelector(".follow__form");

followForm.addEventListener("submit", event => {
    event.preventDefault();

    const formData = new FormData(followForm);

    fetch("app/users/follow.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(isFollowing => {
            console.log(isFollowing);

            const followButton = document.querySelector(".follow__button");

            if (isFollowing === "follow") {
                followButton.textContent = "Unfollow";
            } else if (isFollowing === "unfollow") {
                followButton.textContent = "Follow";
            }
        });
});
