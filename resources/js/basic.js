require('./bootstrap');

(function($) {
  "use strict";


  $('.dev').click(function(e) {
    e.preventDefault();
    alert('The functionality you are trying to access is still under development ....!')
});

  $('.form-control').on('input', function() {
    if ($(this).val().trim() !== '') {
      $(this).addClass('focused');
    } else {
      $(this).removeClass('focused');
    }
  });



  let ugx = new Intl.NumberFormat('en-US');

  $("input[data-bs-type='currency']").on({
    keyup: function() {
      let val = $(this).val();
      let formated = ugx.format(val.replace(/,/g, ''));
      $(this).val(formated);
      //console.log(formated);

    },
    blur: function() {
      let val = $(this).val();
      let formated = ugx.format(val.replace(/,/g, ''));
      //console.log(formated);
      $(this).val(formated);

    }
  });


  // When a parent item with children is clicked
  $('a[data-bs-toggle="collapse"]').on('click', function (e) {
    var target = $(this).attr('href'); // Get the target collapse ID
    var isExpanded = $(target).hasClass('show'); // Check if the target is already expanded

      // Collapse all other parent items
    $('.collapse').not(target).collapse('hide');

      // If the clicked parent item is already expanded, prevent further action
    if (isExpanded) {
        e.preventDefault(); // Prevent the default action of collapsing/expanding
        return;
    }

    // Otherwise, allow it to expand
    $(target).collapse('show');
  });

    // When a single parent without children is clicked, collapse other parents
    $('a:not([data-bs-toggle="collapse"])').on('click', function () {
        // Collapse all parent items with children
        $('.collapse').collapse('hide');
    });

    $('.offcanvas').on('show.bs.offcanvas', function () {
        $('body').addClass('modal-open');
    });

  $('.offcanvas').on('hide.bs.offcanvas', function () {
      $('body').removeClass('modal-open');
  });


  //Notifications
  const baseUrl = $('meta[name="base-url"]').attr('content');

  if($('#notificationsCounterHolder').length){

    // Function to fetch unread notifications count
    function fetchNotificationsCount() {
        $.ajax({
            url: `${baseUrl}/account/notifications/unread`, // Use the correct endpoint
            method: 'GET',
            success: function(response) {
                // Count unread notifications
                const unreadCount = response.length;

                // Update the counter if there are unread notifications
                if (unreadCount > 0) {
                    $('#notificationsCounterHolder').text(unreadCount);
                } else {
                    $('#notificationsCounterHolder').text('0');
                }
            },
            error: function(xhr) {
                console.log("Failed to fetch notifications:", xhr);
            }
        });
    }

    // Fetch notifications count on page load
    //fetchNotificationsCount();

    // Optional: Refresh notifications count every minute
    //setInterval(fetchNotificationsCount, 60000);
  }


   $("#createCourseGroupForm").on("submit", function (e) {
       e.preventDefault(); // Prevent default form submission

       // Clear previous errors
       $(".error").text("");

       // Serialize the form data
       const formData = $(this).serialize();

       // Perform the AJAX request
       $.ajax({
           url: $(this).attr("action"), // Form action URL
           method: "POST", // HTTP method
           data: formData, // Form data
           success: function (response) {
               // Show success message
               alert(response.message);

               // Append the new course group to the table
               $("#courseGroupTable tbody").append(`
                    <tr>
                        <td>${response.data.id}</td>
                        <td>${response.data.name}</td>
                        <td>${
                            response.data.course
                                ? response.data.course.name
                                : "N/A"
                        }</td>
                    </tr>
                `);

               // Reset the form
               $("#createCourseGroupForm")[0].reset();
           },
           error: function (xhr) {
               // Handle validation errors
               if (xhr.status === 422) {
                   const errors = xhr.responseJSON.errors;
                   for (const [field, messages] of Object.entries(errors)) {
                       // Show error messages next to the relevant inputs
                       var errorField = ".error-" + field.replace("_", "-");
                       // Check if the error field exists in the DOM
                       if ($(errorField).length) {
                           $(errorField).text(messages[0]); // Show the error message
                       } else {
                           // If the error field is not found, log it (optional)
                           alert(`Error field not found for: ${field}`);
                       }
                   }
               } else {
                   // Handle other errors (e.g., server errors)
                   alert("Something went wrong. Please try again later.");
               }
           },
       });
   });

})(jQuery);
