(function ($) {
  "use strict";

  var ecommerceListDataTableInit = function () {
    var $ecommerceListTable = $("#datatable-report");

    $ecommerceListTable.dataTable({
      paging: false,
      info: false,
      searching: false,
      lengthChange: false,
      ordering: false,

      dom: '<"table-responsive"t>',

      columnDefs: [
        {
          targets: 0,
          orderable: false,
        },
      ],

      drawCallback: function () {
      },
    });
  };

  ecommerceListDataTableInit();
})(jQuery);
