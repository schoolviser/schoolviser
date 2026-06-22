require('./bootstrap');


$(document).ready(function() {
 $('#togglePassword').on('click', function() {
   const passwordInput = $('#password');
   const isPasswordVisible = passwordInput.attr('type') === 'text';

   // Toggle password input type
   passwordInput.attr('type', isPasswordVisible ? 'password' : 'text');

   // Toggle visibility icons
   $('#passwordIconOn').toggle(!isPasswordVisible);
   $('#passwordIconOff').toggle(isPasswordVisible);
 });
});