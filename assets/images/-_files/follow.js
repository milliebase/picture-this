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
            .then(follows => {
                const followButton = document.querySelector(".follow__button");

                const followersNumber = document.querySelector(
                    ".followers__number"
                );

                if (follows > Number(followersNumber.textContent)) {
                    followButton.textContent = "Unfollow";
                    followersNumber.textContent = follows;
                } else if (follows < Number(followersNumber.textContent)) {
                    followButton.textContent = "Follow";
                    followersNumber.textContent = follows;
                }
            });
    });
}
