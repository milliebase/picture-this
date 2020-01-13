const followForm = document.querySelector(".follow__form");

if (typeof followForm != "undefined" && followForm != null) {
    followForm.addEventListener("submit", event => {
        event.preventDefault();

        const formData = new FormData(followForm);

        fetch("app/users/follow.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(followers => {
                const followButton = document.querySelector(".follow__button");

                const followersNumber = document.querySelector(
                    ".followers__number"
                );

                if (followers > Number(followersNumber.textContent)) {
                    followButton.textContent = "Unfollow";
                    followButton.classList.add("follow__button--unfollow");
                    followersNumber.textContent = followers;
                } else if (followers < Number(followersNumber.textContent)) {
                    followButton.textContent = "Follow";
                    followButton.classList.remove("follow__button--unfollow");
                    followersNumber.textContent = followers;
                }
            });
    });
}
