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


})(jQuery);
