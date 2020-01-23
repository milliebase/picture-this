const commentsContainer = document.querySelector(".comments");
// const commentForm = document.querySelector(".comment__form");
const commentTextarea = document.querySelector("#comment-textarea");

const commentButton = document.querySelector(".comment-button");

window.$_GET = new URLSearchParams(location.search);
const id = $_GET.get("id");

const appendComments = comment => {
    const div = document.createElement("div");

    template = `
        <div class="user">
            <div class="user__name">
                <p>${comment.comment}</p>
            </div>
        </div>
    `;

    div.innerHTML = template;

    commentsContainer.appendChild(div);
};

const getComments = async () => {
    const formData = new FormData();
    formData.append("id", id);

    const response = await fetch("../../app/comments/comments.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    });

    const comments = await response.json();
    if (comments.length > 0) {
        comments.forEach(comment => {
            appendComments(comment);
            console.log(comment);
        });
    }
};

getComments();

commentButton.addEventListener("click", event => {
    event.preventDefault();
    if (commentTextarea.value) {
        const createComment = async () => {
            const formData = new FormData();
            formData.append("id", id);
            formData.append("comment", commentTextarea.value);

            const response = await fetch("../../app/comments/create.php", {
                method: "POST",
                body: formData,
                credentials: "include"
            });
        };
        createComment();
        commentsContainer.innerHTML = "";
        commentTextarea.value = "";
        getComments();
    }
});
