document
  .getElementById("addInventoryForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "addInventory");

    fetch("/HungryPaws/backend/handle-post.php", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        const data = await response.json();

        if (!response.ok) {
          showWarning(data.message || "Something went wrong.");
          throw new Error(data.message);
        }

        if (data.status === "warning") {
          showWarning(data.title, data.message);
        } else if (data.status === "error") {
          showError(data.title, data.message);
        } else {
          showSuccess(data.title, data.message);
        }
      })
      .catch((error) => {
        showError(data.title, error);
      });
  });

$(document).on("click", "#closeSuccessBtn", function (e) {
  e.preventDefault();

  const form = document.getElementById("addInventoryForm");
  if (form) {
    console.log(document.getElementById("addInventoryForm"));
    form.reset();

    form.querySelectorAll("select").forEach((select) => {
      select.selectedIndex = 0;

      if ($(select).data("select2")) {
        $(select).val($(select).find("option:first").val()).trigger("change");
      }
    });
  }
  $.magnificPopup.close();
});

$("#productSelect").on("change", function () {
  let isPerish = $(this).find(":selected").data("perish");

  // Set hidden input value
  $("#isPerish").val(isPerish);

  // Disable expiry date if non-perishable
  if (isPerish == 0) {
    $("#expiryDate").prop("disabled", true);
    $("#expiryDate").val("");
  } else {
    $("#expiryDate").prop("disabled", false);
  }
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
