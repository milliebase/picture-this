const searchInput = document.querySelector("#search");
const searchForm = document.querySelector(".search__form");
const foundUsers = document.querySelector(".found__users");

const appendUsers = function(user, isAvatar) {
    let username = user.username;
    let name = user.first_name + " " + user.last_name;

    let avatar;

    if (isAvatar) {
        avatar = `uploads/avatars/${user.avatar}`;
    } else {
        avatar = "assets/images/avatar.png";
    }

    const div = document.createElement("div");

    template = `
        <div class="user">
            <a href="profile.php?username=${username}">
                <img src="${avatar}" alt="${username}'s profile picture">
                <div class="user__name">
                    <p>${username}</p>
                    <p>${name}</p>
                </div>
            </a>
        </div>
    `;

    div.innerHTML = template;

    foundUsers.appendChild(div);
};

if (typeof searchInput != "undefined" && searchInput != null) {
    searchInput.addEventListener("keyup", () => {
        const formData = new FormData(searchForm);

        fetch("app/users/search.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(users => {
                foundUsers.innerHTML = "";

                if (users !== "No users") {
                    users.forEach(user => {
                        if (user.avatar === null) {
                            let isAvatar = false;
                            appendUsers(user, isAvatar);
                        } else {
                            let isAvatar = true;
                            appendUsers(user, isAvatar);
                        }
                    });
                }
            });
    });
}

const searchButton = document.querySelector(".search__form button");

if (typeof searchButton != "undefined" && searchButton != null) {
    searchButton.addEventListener("click", event => {
        event.preventDefault();

        const formData = new FormData(searchForm);

        fetch("app/users/search.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(users => {
                console.log(users);

                foundUsers.innerHTML = "";

                if (users !== "No users") {
                    users.forEach(user => {
                        if (user.avatar === null) {
                            let isAvatar = false;
                            appendUsers(user, isAvatar);
                        } else {
                            let isAvatar = true;
                            appendUsers(user, isAvatar);
                        }
                    });
                } else {
                    const div = document.createElement("div");

                    template = `
                        <img src="/assets/images/users.svg" alt="Icon of users">
                        <p>No users found</p>
                    `;

                    div.innerHTML = template;

                    div.classList.add("no__users");

                    foundUsers.appendChild(div);
                }
            });
    });
}
