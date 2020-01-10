const deleteAccountButton = document.querySelector(".delete-account__button");

if (typeof followForm != "undefined" && followForm != null) {
    deleteAccountButton.addEventListener("click", () => {
        const deleteAccountModal = document.querySelector(
            ".delete-account__modal"
        );

        deleteAccountModal.classList.toggle("hidden");
        deleteAccountButton.classList.toggle("hidden");

        const deleteAccountCancel = document.querySelector(
            ".delete-account__cancel"
        );

        deleteAccountCancel.addEventListener("click", () => {
            deleteAccountModal.classList.toggle("hidden");
            deleteAccountButton.classList.toggle("hidden");
        });
    });
}
