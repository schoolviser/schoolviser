/******/ (() => { // webpackBootstrap
/*!**********************************************!*\
  !*** ./Resources/assets/js/admissionForm.js ***!
  \**********************************************/
(function ($) {
  if ($('#admissionForm').length > 0) {
    $('#admissionForm').on('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Clear any previous error messages
      $('.text-danger').text('');
      var form = $(this);
      var url = form.attr('action'); // Form action URL
      var data = form.serialize(); // Serialize form inputs into a query string

      // Make an AJAX POST request
      $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function success(response) {
          // Show success message or redirect as needed
          alert('Admission added successfully!');
          // Optionally, reset the form
          form.trigger('reset');
        },
        error: function error(xhr) {
          if (xhr.status === 422) {
            // Laravel validation error status code
            var errors = xhr.responseJSON.errors;

            // Iterate over each validation error
            for (var field in errors) {
              // Append the error message next to the corresponding input field
              var errorContainer = $("[name=\"".concat(field, "\"]")).next('.text-danger');
              $("[name=\"".concat(field, "\"]")).addClass('is-invalid');
              if (errorContainer.length > 0) {
                errorContainer.text(errors[field][0]); // Display the first error message
              }
            }
          } else {
            // Handle other errors
            alert('An unexpected error occurred. Please try again.');
          }
        }
      });
    });
  }
})(jQuery);
/******/ })()
;