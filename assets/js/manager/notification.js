(function ($) {
  let activeNotices = {};

  // 🔄 Optional auto-reset logic:
  // Uncomment the next line to always clear dismissed notices on page load.
  //localStorage.removeItem("dismissedNotices");

  // ✅ OR automatically reset once per day
  const todayKey = new Date().toISOString().split("T")[0];
  const lastReset = localStorage.getItem("lastResetDate");

  if (lastReset !== todayKey) {
    localStorage.removeItem("dismissedNotices");
    localStorage.setItem("lastResetDate", todayKey);
  }

  let dismissedNotices = JSON.parse(
    localStorage.getItem("dismissedNotices") || "[]"
  );

  function saveDismissed(productName) {
    if (!dismissedNotices.includes(productName)) {
      dismissedNotices.push(productName);
      localStorage.setItem(
        "dismissedNotices",
        JSON.stringify(dismissedNotices)
      );
    }
  }

  function checkStockRequest() {
    fetch("/HungryPaws/backend/manager/get-stock-request.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success" && data.data.length > 0) {
          const stockRequestItems = data.data.filter(
            (item) => !dismissedNotices.includes(item.product_name)
          );

          Object.keys(activeNotices).forEach((key) => {
            if (!stockRequestItems.find((item) => item.product_name === key)) {
              activeNotices[key].remove();
              delete activeNotices[key];
            }
          });

          if (stockRequestItems.length > 3) {
            if (!activeNotices["_summary_"]) {
              const summaryNotice = new PNotify({
                title: "Multiple Stock Transfer Requests",
                text: `There are ${stockRequestItems.length} stock transfer request from other branches. <a href="transfers" style="color:#fff; text-decoration:underline;">View all</a>`,
                addclass: "notification-primary click-2-close icon-nb",
                icon: "fas fa-circle-info",
                hide: false,
                buttons: { closer: false, sticker: false },
              });

              summaryNotice.get().click(() => {
                summaryNotice.remove();
                saveDismissed("_summary_");
                delete activeNotices["_summary_"];
              });

              activeNotices["_summary_"] = summaryNotice;
            }
          } else {
            stockRequestItems.forEach((item) => {
              if (!activeNotices[item.product_name]) {
                const notice = new PNotify({
                  title: "Stock Tranfer Request",
                  text: `${item.branch_name} requests a ${item.quantity} quantity of ${item.product_name}. The branch has ${item.stock_level} stocks left.`,
                  type: "primary",
                  addclass: "notification-primary click-2-close icon-nb",
                  icon: "fas fa-circle-info",
                  hide: false,
                  buttons: { closer: false, sticker: false },
                });

                notice.get().click(() => {
                  notice.remove();
                  saveDismissed(item.product_name);
                  delete activeNotices[item.product_name];
                });

                activeNotices[item.product_name] = notice;
              }
            });

            if (activeNotices["_summary_"]) {
              activeNotices["_summary_"].remove();
              delete activeNotices["_summary_"];
            }
          }
        } else {
          Object.values(activeNotices).forEach((notice) => notice.remove());
          activeNotices = {};
        }
      })
      .catch((error) => console.error("Error fetching low stock:", error));
  }

  setInterval(checkStockRequest, 60000);
  checkStockRequest();
})(jQuery);
