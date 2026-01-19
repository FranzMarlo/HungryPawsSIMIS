document
  .getElementById("forgotPasswordForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "forgotPassword");

    // Elements
    const resetBtn = document.getElementById("resetBtn");
    const btnText = resetBtn.querySelector(".btn-text");
    const spinner = document.getElementById("resetSpinner");

    // Show loading spinner + disable button
    resetBtn.disabled = true;
    btnText.textContent = "Sending...";
    spinner.classList.remove("d-none");

    fetch("/HungryPaws/backend/handle-post.php", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        const data = await response.json();

        if (!response.ok) {
          showWarning("Warning", data.message || "Something went wrong.");
          throw new Error(data.message);
        }

        if (data.status === "warning") {
          showWarning(data.title, data.message);
        } else if (data.status === "error") {
          showError(data.title, data.message);
        } else {
          showSuccess(data.title, data.message);
          form.reset();
        }

        // Restore button
        resetBtn.disabled = false;
        btnText.textContent = "Reset!";
        spinner.classList.add("d-none");
      })
      .catch((error) => {
        showError("Error", error.message || "Request failed");

        // Restore button
        resetBtn.disabled = false;
        btnText.textContent = "Reset!";
        spinner.classList.add("d-none");
      });
  });

function showSuccess(title, message) {
  document.getElementById("successTitle").textContent = title;
  document.getElementById("successMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalSuccess" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

function showWarning(title, message) {
  document.getElementById("warningTitle").textContent = title;
  document.getElementById("warningMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalWarning" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

function showError(title, message) {
  document.getElementById("errorTitle").textContent = title;
  document.getElementById("errorMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalError" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

$(document).on("click", ".modal-dismiss", function (e) {
  e.preventDefault();
  $.magnificPopup.close();
});
