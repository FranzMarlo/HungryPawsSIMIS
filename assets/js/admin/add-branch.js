document.addEventListener("DOMContentLoaded", function () {
  const regionSelect = document.getElementById("region");
  const provinceSelect = document.getElementById("province");
  const citySelect = document.getElementById("city");
  const barangaySelect = document.getElementById("barangay");

  const NCR_CODE = "130000000"; // Region NCR

  loadRegions();

  function loadRegions() {
    fetch("https://psgc.gitlab.io/api/regions")
      .then((res) => res.json())
      .then((data) => {
        data.sort((a, b) => a.name.localeCompare(b.name));

        regionSelect.innerHTML =
          '<option value="" selected disabled>Select Region</option>';

        data.forEach((region) => {
          regionSelect.innerHTML += `
                        <option value="${region.code}" data-name="${region.name}">${region.name}</option>
                    `;
        });
      });
  }

  regionSelect.addEventListener("change", function () {
    const regionCode = this.value;

    provinceSelect.disabled = true;
    citySelect.disabled = true;
    barangaySelect.disabled = true;

    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    citySelect.innerHTML =
      '<option value="" selected disabled>Select City / Municipality</option>';
    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

    if (!regionCode) return;

    if (regionCode === NCR_CODE) {
      provinceSelect.disabled = true;
      loadCitiesByRegion(regionCode);
      return;
    }

    fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces`)
      .then((res) => res.json())
      .then((data) => {
        data.sort((a, b) => a.name.localeCompare(b.name));

        provinceSelect.disabled = false;

        data.forEach((prov) => {
          provinceSelect.innerHTML += `
                        <option value="${prov.code}" data-name="${prov.name}">${prov.name}</option>
                    `;
        });
      });
  });

  function loadCitiesByRegion(regionCode) {
    citySelect.disabled = false;

    fetch(
      `https://psgc.gitlab.io/api/regions/${regionCode}/cities-municipalities`
    )
      .then((res) => res.json())
      .then((data) => {
        citySelect.innerHTML =
          '<option value="" selected disabled>Select City / Municipality</option>';

        data.sort((a, b) => a.name.localeCompare(b.name));

        data.forEach((city) => {
          citySelect.innerHTML += `
                        <option value="${city.code}" data-cityclass="${city.cityClass}" data-name="${city.name}">
                            ${city.name}
                        </option>
                    `;
        });
      });
  }

  provinceSelect.addEventListener("change", function () {
    const provinceCode = this.value;

    citySelect.disabled = true;
    barangaySelect.disabled = true;

    citySelect.innerHTML =
      '<option value="" selected disabled>Select City / Municipality</option>';
    barangaySelect.innerHTML =
      '<option value="" selected disabled>Select Barangay</option>';

    if (!provinceCode) return;

    fetch(
      `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities`
    )
      .then((res) => res.json())
      .then((data) => {
        citySelect.disabled = false;

        data.sort((a, b) => a.name.localeCompare(b.name));

        data.forEach((city) => {
          citySelect.innerHTML += `
                        <option value="${city.code}" data-cityclass="${city.cityClass}" data-name="${city.name}">
                            ${city.name}
                        </option>
                    `;
        });
      });
  });

  citySelect.addEventListener("change", function () {
    const cityCode = this.value;

    barangaySelect.disabled = true;
    barangaySelect.innerHTML = "<option>Loading...</option>";

    if (!cityCode) return;

    fetch(
      `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`
    )
      .then((res) => res.json())
      .then((data) => {
        barangaySelect.disabled = false;
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        data.sort((a, b) => a.name.localeCompare(b.name));

        data.forEach((brgy) => {
          barangaySelect.innerHTML += `
                        <option value="${brgy.code}" data-name="${brgy.name}">${brgy.name}</option>
                    `;
        });
      });
  });

  $("#region").on("change", function () {
    $("#region_name").val($("#region option:selected").data("name"));
  });

  $("#province").on("change", function () {
    $("#province_name").val($("#province option:selected").data("name"));
  });

  $("#city").on("change", function () {
    $("#city_name").val($("#city option:selected").data("name"));
  });

  $("#barangay").on("change", function () {
    $("#barangay_name").val($("#barangay option:selected").data("name"));
  });
});

document
  .getElementById("addBranchForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "addBranch");

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
          form.reset();
          form.querySelectorAll("select").forEach((select) => {
            select.selectedIndex = 0;

            if ($(select).data("select2")) {
              $(select)
                .val($(select).find("option:first").val())
                .trigger("change");
            }
          });
        }
      })
      .catch((error) => {
        showError(data.title, error);
      });
  });

document
  .getElementById("contactNumber")
  .addEventListener("input", function (e) {
    let value = this.value.replace(/\D/g, "");

    if (value.length > 4 && value.length <= 7) {
      value = value.replace(/(\d{4})(\d+)/, "$1-$2");
    } else if (value.length > 7) {
      value = value.replace(/(\d{4})(\d{3})(\d+)/, "$1-$2-$3");
    }

    this.value = value;
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
