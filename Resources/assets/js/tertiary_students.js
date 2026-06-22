$(function () {
  ("use strict");


  let debounceTimer;

  // SEARCH Students
  $("#searchStudentInput").on("keyup", function () {
    // Clear any existing debounce timer
    clearTimeout(debounceTimer);

    // Start a new debounce timer
    debounceTimer = setTimeout(function () {
      // Get the search query from the input field
      var query = $("#searchStudentInput").val();

      // Get the search URL from the data-url attribute
      var url = $("#searchStudentInput").data("url");
      var profileUrl = $("#searchStudentInput").data("profile-url")

      // Validate that the query is not empty
      if (!query.trim()) {
        $(".offcanvas-body").html("<p>Please enter a search term.</p>");
        return;
      }

      // Append the query to the URL
      var searchUrl = url + "/" + query;

      console.log("Search URL:", searchUrl);

      // Make an AJAX request to search for students
      $.ajax({
        url: searchUrl, // Use the dynamic URL
        method: "GET",
        beforeSend: function () {
          // Show a loading spinner or message in the offcanvas body
          $(".offcanvas-body").html("<p>Loading...</p>");
        },
        success: function (response) {
          // Check if results are available
          if (response.success && response.data.data.length > 0) {
            // Build the HTML for cards
            var cards = "";

            // Iterate over the student results and create cards
            $.each(response.data.data, function (index, student) {
              cards += `
                <div class="card my-2" style="border-color: rgb(136,211,202);">
                  <div class="card-body d-flex p-1">
                    <div class="px-1 text-dark">${
                      student.student.access_number || "N/A"
                    }</div>
                    <div class="px-1 text-uppercase fw-bold text-dark"><a href="${
                      profileUrl.replace('replace', student.student.uuid)
                    }">${student.student.first_name} ${
                student.student.last_name
              }</a></div>
                    <div class="px-1 text-capitalize"> ${
                      student.student.course?.name || "N/A"
                    }</div>
                  </div>
                </div>
              `;
            });

            // Inject the cards into the offcanvas body
            $(".offcanvas-body").html(cards);
          } else {
            // If no results are found, show a message
            $(".offcanvas-body").html(
              "<p>No students found matching your search criteria.</p>"
            );
          }
        },
        error: function () {
          // Display an error message if the request fails
          $(".offcanvas-body").html(
            "<p>An error occurred while searching. Please try again later.</p>"
          );
        },
      });
    }, 500); // Delay of 500ms before making the request
  });


});
