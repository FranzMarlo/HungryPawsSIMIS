document.addEventListener("DOMContentLoaded", function () {
  const showPasswordCheckbox = document.getElementById("showPassword");
  const passwordFields = document.querySelectorAll(
    'input[type="password"], input[data-password="true"]'
  );

  showPasswordCheckbox.addEventListener("change", function () {
    passwordFields.forEach((input) => {
      input.type = this.checked ? "text" : "password";
    });
  });
});
