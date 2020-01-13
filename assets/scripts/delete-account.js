const deleteAccountButton = document.querySelector(".delete-account__button");

if (typeof deleteAccountButton != "undefined" && deleteAccountButton != null) {
    const deleteAccountModal = document.querySelector(".delete-account__modal");

    deleteAccountButton.addEventListener("click", () => {
        deleteAccountModal.classList.toggle("hidden");
        deleteAccountButton.classList.toggle("hidden");
    });

    const deleteAccountCancel = document.querySelector(".delete__cancel");

    deleteAccountCancel.addEventListener("click", () => {
        deleteAccountModal.classList.toggle("hidden");
        deleteAccountButton.classList.toggle("hidden");
    });
}
