document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = this;
  const formData = new FormData(form);
  const role = form.dataset.role;

  if (role === "Inventory Staff"){
    var roleLink = "staff";
  }
  else {
    var roleLink = role;
  }
  
  formData.append("role", role);

  fetch("/HungryPaws/backend/handle-login.php", {
    method: "POST",
    body: formData,
  })
    .then(async (response) => {
      const data = await response.json();

      if (!response.ok) {
        showWarning(data.message || "Something went wrong.");
        throw new Error(data.message);
      }

      if (data.status === "success") {
        window.location.href = `/HungryPaws/${roleLink.toLowerCase()}/dashboard`;
      } else if (data.status === "error") {
        showError(data.message);
      } else {
        showWarning(data.message || "Unexpected error occurred.");
      }
    })
    .catch((error) => {
      showError(error.message || "Server error occurred.");
    });
});

function showWarning(message) {
  document.getElementById("warningMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalWarning" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

function showError(message) {
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
