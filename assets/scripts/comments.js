window.$_GET = new URLSearchParams(location.search);
const id = $_GET.get("id");

const commentsContainer = document.querySelector(".comments");
const commentTextarea = document.querySelector("#comment-textarea");
const commentButton = document.querySelector(".comment-button");

const appendComments = comment => {
    const div = document.createElement("div");
    // <div class="post__user--settings">
    //     <img src="/assets/images/kebab.svg" alt="Kebab menu icon">
    // </div>
    template = `
        <div class="comment">
            <div class="comment__name">
                <p>${comment.comment}</p>
                <span class="edit"><img src="/assets/images/kebab.svg" alt="Kebab menu icon"></span>
            </div>
            <form class="comment-form">
                <label for="update-comment">Update Comment</label>
                <textarea data-number="${comment.id}" name="update-comment" class="update-comment-textarea" cols="50" rows="10" placeholder="Update comment"></textarea>
                <button class="update-comment-button">Save</button>
                <button class="delete-comment-button">Delete</button>
            </form>
        </div>
    `;

    //     template2 = `
    //     <div class="comment">
    //         <div class="comment__name">
    //             <p>${comment.comment}</p>
    //         </div>
    //     </div>
    // `;

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
            // console.log(comment);
        });

        const commentsFetched = document.querySelectorAll(".comment");
        commentsFetched.forEach(comment => {
            const updateCommentTextarea = comment.querySelector(
                ".update-comment-textarea"
            );

            const updateCommentButton = comment.querySelector(
                ".update-comment-button"
            );

            const deleteCommentButton = comment.querySelector(
                ".delete-comment-button"
            );

            const commentForm = comment.querySelector(".comment-form");

            const editButton = comment.querySelector(".edit");

            editButton.addEventListener("click", event => {
                event.preventDefault();
                commentForm.classList.toggle("show");
            });

            deleteCommentButton.addEventListener("click", event => {
                event.preventDefault();
                const deleteComment = async () => {
                    const formData = new FormData();
                    formData.append("id", updateCommentTextarea.dataset.number);

                    const response = await fetch(
                        "../../app/comments/delete.php",
                        {
                            method: "POST",
                            body: formData,
                            credentials: "include"
                        }
                    );
                };
                deleteComment();
                commentsContainer.innerHTML = "";
                getComments();
            });

            updateCommentButton.addEventListener("click", event => {
                event.preventDefault();
                if (updateCommentTextarea.value) {
                    const updateComment = async () => {
                        const formData = new FormData();
                        formData.append(
                            "id",
                            updateCommentTextarea.dataset.number
                        );
                        formData.append("comment", updateCommentTextarea.value);

                        const response = await fetch(
                            "../../app/comments/update.php",
                            {
                                method: "POST",
                                body: formData,
                                credentials: "include"
                            }
                        );
                    };
                    updateComment();
                    commentsContainer.innerHTML = "";
                    updateCommentTextarea.value = "";
                    getComments();
                    console.log(updateCommentTextarea.value);
                    console.log(updateCommentTextarea.dataset.number);
                }
            });

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
