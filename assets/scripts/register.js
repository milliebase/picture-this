// const firstName = document.querySelector("#register__first-name");
// const lastName = document.querySelector("#register__last-name");
// const email = document.querySelector("#register__email");
// const username = document.querySelector("#register__username");
// const password = document.querySelector("#register__password");
// const confirmPassword = document.querySelector("#register__confirm-password");

// const pFirstN = document.createElement("p");
// const pLastN = document.createElement("p");
// const pEmail = document.createElement("p");
// const pUsername = document.createElement("p");
// const pPassword = document.createElement("p");
// const pConfirm = document.createElement("p");

// const checkForm = function checkForm() {
//     const registerInputs = document.querySelectorAll(".register__form input");

//     let invalidInputs = [];

//     for (let i; i < registerInputs.length; i++) {
//         console.log(registerInputs[i].style.backgroundColor);

//         if (
//             registerInputs[i].style.backgroundColor ===
//                 "rgba(221, 90, 114, 0.32)" ||
//             registerInputs[i].value === ""
//         ) {
//             invalidInputs.push(registerInputs[i]);
//             console.log(invalidInputs);
//         }
//     }

//     // console.log(invalidInputs);

//     if (invalidInputs.length > 0) {
//         // console.log("va");

//         return false;
//     }

//     return true;
// };

// const invalidInput = function(input, p, message) {
//     input.style.backgroundColor = "rgba(221, 90, 114, 0.32)";
//     p.innerHTML = message;
//     input.parentElement.appendChild(p);
// };

// const validInput = function(input, p) {
//     input.style.backgroundColor = "#f5e5e852";
//     if (input.parentElement.children.length > 2) {
//         input.parentElement.removeChild(p);
//     }
// };

// firstName.addEventListener("keyup", () => {
//     if (!firstName.value.replace(/\s/g, "").length) {
//         invalidInput(firstName, pFirstN, "What's your name?");
//     } else {
//         validInput(firstName, pFirstN);
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });

// lastName.addEventListener("keyup", () => {
//     if (!lastName.value.replace(/\s/g, "").length) {
//         invalidInput(lastName, pLastN, "What's your last name?");
//     } else {
//         validInput(lastName, pLastN);
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });

// email.addEventListener("keyup", () => {
//     if (!email.checkValidity()) {
//         invalidInput(email, pEmail, "Please type in a valid e-mail.");
//     } else {
//         validInput(email, pEmail);
//         checkForm();
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });

// username.addEventListener("keyup", () => {
//     if (
//         !username.value.replace(/\s/g, "").length &&
//         username.value.length < 5
//     ) {
//         invalidInput(
//             username,
//             pUsername,
//             "Username should be at least 5 characters long."
//         );
//     } else {
//         validInput(username, pUsername);
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });

// password.addEventListener("keyup", () => {
//     if (password.value.length < 8) {
//         invalidInput(
//             password,
//             pPassword,
//             "Your password should be at least 8 characters long."
//         );
//     } else {
//         validInput(password, pPassword);
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });

// confirmPassword.addEventListener("keyup", () => {
//     if (
//         confirmPassword.value.length < 8 &&
//         confirmPassword.value.length !== password.value.length
//     ) {
//         invalidInput(confirmPassword, pConfirm, "Your password doesn't match.");
//     } else {
//         validInput(confirmPassword, pConfirm);
//         if (checkForm()) {
//             const submitButton = document.querySelector(
//                 ".register__form button"
//             );
//             submitButton.classList.remove("button--disabled");
//         }
//     }
// });
