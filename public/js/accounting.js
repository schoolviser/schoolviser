/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Resources/assets/js/app.js":
/*!************************************!*\
  !*** ./Resources/assets/js/app.js ***!
  \************************************/
/***/ (() => {

$(function () {
  'use strict';

  // Universal ChartJs Options for Student Module
  var accountingChartOptions = {
    tooltips: {
      callbacks: {
        label: function label(tooltipItem, data) {
          var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return value.toLocaleString('en-US', {
            style: 'currency',
            currency: 'UGX'
          });
        }
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          callback: function callback(value, index, values) {
            return value.toLocaleString();
          }
        }
      }]
    },
    legend: {
      display: false,
      position: 'bottom',
      onClick: function onClick() {
        alert('hello');
      }
    },
    elements: {
      point: {
        radius: 4,
        hitRadius: 7,
        pointStyle: 'circle'
      }
    }
  };

  // Cash Flow Chart
  if ($("#cashFlowChart").length) {
    // Check if element exists
    var cashFlowChartCtx = $("#cashFlowChart").get(0).getContext("2d");
    var cashFlowChart = new Chart(cashFlowChartCtx, {
      type: 'bar',
      data: {
        labels: cashFlowChartLabels,
        datasets: [{
          label: 'Cash Inflows',
          data: [100, 200],
          borderColor: 'rgb(136,211,202)',
          backgroundColor: 'rgb(136,211,202)',
          fill: false,
          tension: 0.1
        }, {
          label: 'Cash Outflows',
          data: cashFlowExpenseChartData,
          borderColor: 'rgb(226,161,153)',
          backgroundColor: 'rgb(226,161,153)',
          fill: false,
          tension: 0.1
        }]
      },
      options: accountingChartOptions
    });
  }

  // Cash Balance Chart
  if ($("#cashBalanceChart").length) {
    // Check if element exists
    var cashBalanceChartCtx = $("#cashBalanceChart").get(0).getContext("2d");
    var cashBalanceChart = new Chart(cashBalanceChartCtx, {
      type: 'bar',
      data: {
        labels: cashBalanceChartLabels,
        // Example labels
        datasets: [{
          label: 'Cash Balance',
          // Add a label for the dataset
          data: cashBalanceChartData,
          backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(231, 233, 237, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(153, 102, 255, 0.2)'],
          borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(231, 233, 237, 1)', 'rgba(255, 159, 64, 1)', 'rgba(153, 102, 255, 1)'],
          borderWidth: 1
        }]
      },
      options: accountingChartOptions
    });
  }

  // Cash Balance Chart
  if ($("#expenseByCategoryChart").length) {
    var expenseByCategoryChartCtx = $("#expenseByCategoryChart").get(0).getContext("2d");
    var expenseByCategoryChart = new Chart(expenseByCategoryChartCtx, {
      type: 'bar',
      data: {
        labels: expenseByCategoryChartLabels,
        // Example labels
        datasets: [{
          label: 'Cash Balance',
          // Add a label for the dataset
          data: expenseByCategoryChartData,
          backgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(231, 233, 237, 1)', 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
          borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(231, 233, 237, 1)', 'rgba(255, 159, 64, 1)', 'rgba(153, 102, 255, 1)'],
          borderWidth: 1
        }]
      },
      options: accountingChartOptions
    });
  }

  // Load products for the initial row
  if ($("#itemsTable").length) {
    loadProducts('#itemList-0');
  }

  // Event listener for when the user selects a product
  $('#itemsTable').on('input', '.item-input', function () {
    var selectedProductName = $(this).val(); // Get the product name from the input
    var row = $(this).closest('.item-row'); // Get the current row

    // Find the selected product's data from the AJAX response cache
    var product = findProductByName(selectedProductName);

    // If the product exists, populate the quantity and price
    if (product) {
      row.find('input[name$="[quantity]"]').val(product.quantity);
      row.find('input[name$="[unit_price]"]').val(product.price);
    }
  });

  // Function to find a product by its name from the cached products
  function findProductByName(productName) {
    return cachedProducts.find(function (product) {
      return product.name === productName;
    });
  }
  var rowIndex = 1; // Initialize the rowIndex

  $('#addItem').on('click', function () {
    var newRow = "\n        <tr class=\"item-row\">\n            <td>\n                <input list=\"itemList-".concat(rowIndex, "\" name=\"items[").concat(rowIndex, "][name]\" placeholder=\"Type or Select Item\" class=\"form-control item-input\">\n                <datalist id=\"itemList-").concat(rowIndex, "\">\n                    <!-- Options will be populated dynamically here -->\n                </datalist>\n            </td>\n             <td>\n                <textarea name=\"items[").concat(rowIndex, "][description]\" placeholder=\"description\" class=\"form-control\"></textarea>\n            </td>\n            <td>\n                <input type=\"text\" name=\"items[").concat(rowIndex, "][quantity]\" placeholder=\"Quantity\" class=\"form-control\">\n            </td>\n            <td>\n                <input type=\"text\" name=\"items[").concat(rowIndex, "][unit_price]\" data-bs-type=\"currency\" placeholder=\"Unit Price\" class=\"form-control\">\n            </td>\n            <td>\n                <button type=\"button\" class=\"btn btn-danger remove-item\">Remove</button>\n            </td>\n        </tr>");
    $('#itemsTable').append(newRow);

    // Load products for the datalist of the new row
    loadProducts("#itemList-".concat(rowIndex));
    rowIndex++;
  });

  // Cache the products from the AJAX response
  var cachedProducts = [];

  // Function to load products into the datalist
  function loadProducts(datalistElement) {
    var baseUrl = $('meta[name="base-url"]').attr('content');
    $.ajax({
      url: baseUrl + '/accounting/products',
      // Use base URL + '/accounting/products'
      method: 'GET',
      success: function success(response) {
        // Cache the products for later use
        cachedProducts = response;
        // Populate the datalist with product options
        $(datalistElement).empty(); // Clear existing options
        $.each(response, function (key, product) {
          $(datalistElement).append('<option value="' + product.name + '">');
        });
      },
      error: function error() {
        alert('Failed to load products.');
      }
    });
  }

  // Remove row when 'Remove' button is clicked
  $(document).on('click', '.remove-item', function () {
    $(this).closest('tr').remove();
  });
  $('#invoiceForm').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
      url: $(this).attr('action'),
      // The route in your form's action attribute
      type: 'POST',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Send CSRF token
      },
      success: function success(response) {
        // Handle successful response
        if (response.success) {
          alert('Invoice created successfully!');
          window.location.href = '/accounting/invoices'; // Redirect to invoice list or success page
        } else {
          alert('Something went wrong: ' + response.message);
        }
      },
      error: function error(xhr) {
        // Handle validation errors or server errors
        var errors = xhr.responseJSON.errors;
        for (var key in errors) {
          alert(errors[key]); // Display each error message
        }
      }
    });
  });
});

/***/ }),

/***/ "./Resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./Resources/assets/sass/app.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/accounting": 0,
/******/ 			"css/accounting": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/accounting"], () => (__webpack_require__("./Resources/assets/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/accounting"], () => (__webpack_require__("./Resources/assets/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;