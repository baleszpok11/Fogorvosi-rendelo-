function validateForm() {
    var emailInput = document.getElementById("email");
    var emailHelpBlock = document.getElementById("emailHelpBlock");
    var passwordInput = document.getElementById("password");
    var passwordConfirmInput = document.getElementById("passwordConfirm");
    var passwordHelpBlock = document.getElementById("passwordHelpBlock");
    var passwordConfirmHelpBlock = document.getElementById("passwordConfirmHelpBlock");
    var registerBtn = document.getElementById("registerBtn");

    var email = emailInput.value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var password = passwordInput.value;
    var numberRegex = /\d/;
    var uppercaseRegex = /[A-Z]/;
    var specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var passwordConfirm = passwordConfirmInput.value;

    var validEmail = emailRegex.test(email);
    var validPassword = numberRegex.test(password) && uppercaseRegex.test(password) && specialCharRegex.test(password);
    var passwordMatch = password === passwordConfirm;

    if (!validEmail) {
        emailHelpBlock.style.display = "block";
    } else {
        emailHelpBlock.style.display = "none";
    }

    if (!validPassword) {
        passwordHelpBlock.style.display = "block";
    } else {
        passwordHelpBlock.style.display = "none";
    }

    if (!passwordMatch) {
        passwordConfirmHelpBlock.style.display = "block";
    } else {
        passwordConfirmHelpBlock.style.display = "none";
    }

    if (validEmail && validPassword && passwordMatch) {
        registerBtn.disabled = false;
        return true;
    } else {
        registerBtn.disabled = true;
        return false;
    }
}

window.addEventListener("load", function () {
    var emailInput = document.getElementById("email");
    var passwordInput = document.getElementById("password");
    var passwordConfirmInput = document.getElementById("passwordConfirm");

    emailInput.addEventListener("input", validateForm);
    passwordInput.addEventListener("input", validateForm);
    passwordConfirmInput.addEventListener("input", validateForm);

    validateForm();
});
