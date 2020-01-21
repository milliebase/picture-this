window.$_GET = new URLSearchParams(location.search);
const id = $_GET.get("id");

const getComments = async () => {
    const formData = new FormData();
    formData.append("id", id);
    const response = await fetch(
        "http://localhost:1111/app/posts/comments.php",
        {
            method: "POST",
            body: formData,
            credentials: "include"
        }
    );
    const data = await response.json();
    console.log(data);
};

getComments();
