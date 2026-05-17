(function () {
  if (!$("#orderLine").length) return;

  $.ajax({
    url: "/HungryPaws/backend/branch-orders-by-month.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (
        response.status === "success" &&
        response.data &&
        Object.keys(response.data).length > 0
      ) {
        buildOrderLineChart(response.data);
      } else {
        showEmptyOrderLinePlaceholder();
      }
    },
    error: function () {
      showEmptyOrderLinePlaceholder();
    },
  });

  function showEmptyOrderLinePlaceholder() {
    $("#orderLine").html(`
      <div class="text-center text-muted py-5" id="orderLinePlaceholder">
          <i class="fas fa-chart-line" style="font-size:40px;opacity:0.4;"></i>
          <h5 class="mt-3">No Orders Found</h5>
          <p class="mb-0">Orders will appear here once available.</p>
      </div>
    `);

    $("#orderLegend").empty();
  }

  function buildOrderLineChart(orderData) {
    let hasValues = false;
    Object.values(orderData).forEach((yearObj) => {
      if (Object.values(yearObj).some((v) => v > 0)) {
        hasValues = true;
      }
    });

    if (!hasValues) {
      showEmptyOrderLinePlaceholder();
      return;
    }

    const colors = ["#FF80AB", "#2979FF", "#F50057", "#82B1FF", "#B388FF"];
    const months = [
      [1, "Jan"],
      [2, "Feb"],
      [3, "Mar"],
      [4, "Apr"],
      [5, "May"],
      [6, "Jun"],
      [7, "Jul"],
      [8, "Aug"],
      [9, "Sep"],
      [10, "Oct"],
      [11, "Nov"],
      [12, "Dec"],
    ];

    const years = Object.keys(orderData).sort();

    const series = years.map((year, index) => {
      const yearData = Object.assign(
        Array.from({ length: 12 }, (_, i) => 0).reduce((acc, _, i) => {
          acc[i + 1] = 0;
          return acc;
        }, {}),
        orderData[year],
      );

      return {
        label: year,
        color: colors[index % colors.length],
        data: Object.keys(yearData).map((month) => [
          parseInt(month),
          yearData[month],
        ]),
      };
    });

    $.plot("#orderLine", series, {
      legend: { show: false },
      series: {
        lines: {
          show: true,
          fill: true,
          lineWidth: 1,
          fillColor: { colors: [{ opacity: 0.3 }, { opacity: 0.3 }] },
        },
        points: { show: true },
        shadowSize: 0,
      },
      grid: {
        hoverable: true,
        borderColor: "rgba(0,0,0,0.15)",
        borderWidth: 1,
        minBorderMargin: 0,
      },
      xaxis: {
        ticks: months,
        min: 0.7,
        max: 12.3,
        tickLength: 0,
        color: "rgba(0,0,0,0.1)",
      },
      yaxis: {
        min: 0,
        tickColor: "rgba(0,0,0,0.1)",
      },
      tooltip: true,
      tooltipOpts: {
        content: function (label, x, y) {
          return `
            <div style="
              background:#222;padding:6px 10px;
              color:#fff;border-radius:4px;
              font-size:13px;">
              <strong>${label}</strong><br>
              ${months[x - 1][1]}: <strong>${y}</strong>
            </div>`;
        },
        defaultTheme: false,
        shifts: { x: 10, y: -20 },
      },
    });

    const legendHTML = series
      .map(
        (s) => `
        <span style="margin-right:15px;">
          <span style="
            display:inline-block;width:12px;height:12px;
            background:${s.color};margin-right:5px;border-radius:3px;">
          </span>
          ${s.label}
        </span>
      `,
      )
      .join("");

    $("#orderLegend").html(legendHTML);
  }
})();

let cropper;
const dropzone = document.getElementById("dropzone");
const fileInput = document.getElementById("profileInput");
const cropImage = document.getElementById("cropImage");
const profilePreview = document.getElementById("profilePreview");
const cropModalEl = document.getElementById("cropModal");
const cropModal = new bootstrap.Modal(cropModalEl);

let pendingImage = null;

dropzone.addEventListener("click", () => fileInput.click());

dropzone.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropzone.classList.add("dragover");
});

dropzone.addEventListener("dragleave", () => {
  dropzone.classList.remove("dragover");
});

dropzone.addEventListener("drop", (e) => {
  e.preventDefault();
  dropzone.classList.remove("dragover");
  handleFile(e.dataTransfer.files[0]);
});

fileInput.addEventListener("change", () => {
  handleFile(fileInput.files[0]);
});

function handleFile(file) {
  if (!file) return;

  const reader = new FileReader();
  reader.onload = () => {
    pendingImage = reader.result;
    cropImage.src = reader.result;
    cropModal.show();
  };
  reader.readAsDataURL(file);
}

cropModalEl.addEventListener("shown.bs.modal", function () {
  if (!pendingImage) return;

  if (cropper) {
    cropper.destroy();
  }

  cropper = new Cropper(cropImage, {
    aspectRatio: 1,
    viewMode: 1,
    dragMode: "move",
    responsive: true,
    autoCropArea: 1,
    restore: false,
    background: false,
    zoomOnWheel: true,
  });
});

document.getElementById("cropBtn").addEventListener("click", function () {
  const canvas = cropper.getCroppedCanvas({
    width: 400,
    height: 400,
    imageSmoothingQuality: "high",
  });

  canvas.toBlob(
    (blob) => {
      const formData = new FormData();
      formData.append("profilePhoto", blob, "profile.jpg");

      fetch("/HungryPaws/backend/update-profile-photo.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((result) => {
          if (result.status === "warning") {
            showWarning(result.title, result.message);
          } else if (result.status === "error") {
            showError(result.title, result.message);
          } else if (result.status === "info") {
            showInfo(result.title, result.message);
          } else {
            profilePreview.src = result.data.url;
            document.getElementById("profile-header").src =
              result.data.url + "?v=" + Date.now();
            document.getElementById("profile-icon").src =
              result.data.url + "?v=" + Date.now();
            cropModal.hide();
            showSuccess(result.title, result.message);
          }
        });
    },
    "image/jpeg",
    0.9,
  );
});

document
  .getElementById("cropModal")
  .addEventListener("hidden.bs.modal", function () {
    document.getElementById("dropzone").focus();
  });

document
  .getElementById("updatePasswordForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "updatePassword");

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
        } else if (data.status === "info") {
          showInfo(data.title, data.message);
        } else {
          showSuccess(data.title, data.message);
          form.reset();
        }
      })
      .catch((error) => {
        showError("System Error", error.message || "Unexpected error.");
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

function showInfo(title, message) {
  document.getElementById("infoTitle").textContent = title;
  document.getElementById("infoMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalInfo" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}
