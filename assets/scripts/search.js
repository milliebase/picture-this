const searchInput = document.querySelector("#search");
const searchForm = document.querySelector(".search__form");
const foundUsers = document.querySelector(".found__users");

const appendUsers = function(user, isAvatar) {
    let username = user.username;
    let name = user.name;

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

const appendPosts = post => {
    const div = document.createElement("div");

    template = `
        <div class="user">
            <a>
                <img src="uploads/${post.image}" alt="${post.description}">
                <div class="user__name">
                    <p>${post.description}</p>
                    <p>${post.date}</p>
                </div>
            </a>
        </div>
    `;

    div.innerHTML = template;

    foundUsers.appendChild(div);
};

if (typeof searchInput != "undefined" && searchInput != null) {
    searchInput.addEventListener("keyup", e => {
        if (e.keyCode !== 13) {
            foundUsers.innerHTML = "";

            if (e.target.value.length >= 3) {
                const formData = new FormData(searchForm);

                fetch("app/search/search.php", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        foundUsers.innerHTML = "";
                        console.log(data[0].users);
                        console.log(data[0].posts);
                        const users = data[0].users;
                        const posts = data[0].posts;

                        if (users) {
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

                        if (posts) {
                            posts.forEach(post => {
                                appendPosts(post);
                            });
                        }
                    });
            }
        }
    });
}

const searchButton = document.querySelector(".search__form button");

if (typeof searchButton != "undefined" && searchButton != null) {
    searchButton.addEventListener("click", event => {
        event.preventDefault();

        const formData = new FormData(searchForm);

        fetch("app/search/search.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data[0].users);
                console.log(data[0].posts);

                foundUsers.innerHTML = "";

                const users = data[0].users;
                const posts = data[0].posts;

                if (users) {
                    users.forEach(user => {
                        console.log(user);

                        if (user.avatar === null) {
                            let isAvatar = false;
                            appendUsers(user, isAvatar);
                        } else {
                            let isAvatar = true;
                            appendUsers(user, isAvatar);
                        }
                    });
                }

                if (posts) {
                    posts.forEach(post => {
                        appendPosts(post);
                    });
                }

                if (users.length === 0 && posts.length === 0) {
                    const div = document.createElement("div");

                    template = `
                        <img src="/assets/images/users.svg" alt="Icon of users">
                        <p>No users or posts found</p>
                    `;

                    div.innerHTML = template;

                    div.classList.add("no__users");

                    foundUsers.appendChild(div);
                }
            });
    });
}
