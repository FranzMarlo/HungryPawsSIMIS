document.addEventListener("DOMContentLoaded", function () {
  fetch("/HungryPaws/backend/handle-fetch.php", {
    method: "POST",
    body: new URLSearchParams({
      submitType: "getMonthlyRevenue",
      branchId: branchId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (!data || data.length === 0) {
        document.getElementById("revenueChart").style.display = "none";
        document.getElementById("revenuePlaceholder").style.display = "block";
        return;
      }

      document.getElementById("revenueChart").style.display = "block";
      document.getElementById("revenuePlaceholder").style.display = "none";

      new Morris.Bar({
        element: "revenueChart",
        data: data,
        xkey: "y",
        ykeys: ["a"],
        labels: ["Revenue"],
        barColors: ["#28a745"],
        hideHover: "auto",
        resize: true,
      });
    })
    .catch((error) => {
      console.error("Error loading chart:", error);

      document.getElementById("revenueChart").style.display = "none";
      document.getElementById("revenuePlaceholder").textContent =
        "Failed to load revenue data.";
      document.getElementById("revenuePlaceholder").style.display = "block";
    });
});
