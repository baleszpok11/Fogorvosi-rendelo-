var emailInput = document.getElementById("email");
var emailHelpBlock = document.getElementById("emailHelpBlock");
var passwordInput = document.getElementById("password");
var passwordConfirmInput = document.getElementById("passwordConfirm");
var passwordHelpBlock = document.getElementById("passwordHelpBlock");
var passwordConfirmHelpBlock = document.getElementById("passwordConfirmHelpBlock");

// Email validation
emailInput.addEventListener("input", function () {
    var email = emailInput.value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        emailHelpBlock.style.display = "block";
    } else {
        emailHelpBlock.style.display = "none";
    }
});

// Password validation
passwordInput.addEventListener("input", function () {
    var password = passwordInput.value;
    var numberRegex = /\d/;
    var uppercaseRegex = /[A-Z]/;
    var specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    if (!numberRegex.test(password) || !uppercaseRegex.test(password) || !specialCharRegex.test(password)) {
        passwordHelpBlock.style.display = "block";
    } else {
        passwordHelpBlock.style.display = "none";
    }
});

// Password confirmation validation
passwordConfirmInput.addEventListener("input", function () {
    var password = passwordInput.value;
    var passwordConfirm = passwordConfirmInput.value;

    if (password !== passwordConfirm) {
        passwordConfirmHelpBlock.style.display = "block";
    } else {
        passwordConfirmHelpBlock.style.display = "none";
    }
});

function validateForm() {
    var email = emailInput.value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        emailHelpBlock.style.display = "block";
        return false;
    } else {
        emailHelpBlock.style.display = "none";
    }

    var password = passwordInput.value;
    var numberRegex = /\d/;
    var uppercaseRegex = /[A-Z]/;
    var specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    if (!numberRegex.test(password) || !uppercaseRegex.test(password) || !specialCharRegex.test(password)) {
        passwordHelpBlock.style.display = "block";
        return false;
    } else {
        passwordHelpBlock.style.display = "none";
    }

    var passwordConfirm = passwordConfirmInput.value;

    if (password !== passwordConfirm) {
        passwordConfirmHelpBlock.style.display = "block";
        return false;
    } else {
        passwordConfirmHelpBlock.style.display = "none";
    }

    return true;
}
