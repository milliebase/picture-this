const searchInput = document.querySelector("#search");
const searchForm = document.querySelector(".search__form");
const foundUsers = document.querySelector(".found__users");

const appendUsers = function(user) {
    let username = user.username;
    let name = user.first_name + " " + user.last_name;

    const div = document.createElement("div");

    template = `
        <div>
            <a href="profile.php?username=${username}">${username}</a>
            <p>${name}</p>
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
                        appendUsers(user);
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
                foundUsers.innerHTML = "";

                if (users !== "No users") {
                    users.forEach(user => {
                        appendUsers(user);
                    });
                }
            });
    });
}
