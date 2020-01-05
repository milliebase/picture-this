//Preview choosen image to post.
const reader = new FileReader();
const chooseImage = document.querySelector("#post-image");
const previewImage = document.querySelector("#preview");

reader.onload = e => {
    previewImage.src = e.target.result;
};

chooseImage.addEventListener("change", e => {
    const image = e.target.files[0];
    reader.readAsDataURL(image);
});
