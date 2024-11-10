require('./bootstrap');


(function($) {
 'use strict';


 var body = $('body');
 var contentWrapper = $('.content-wrapper');
 var scroller = $('.container-scroller');
 var footer = $('.footer');
 var sidebar = $('.sidebar');

 $('[data-bs-toggle="minimize"]').on("click", function() {
  body.toggleClass('sidebar-icon-only');
 });

 //COunt items in the trash
 function countItemsInTheTrash(){
  let trashCountUrl = body.find('[data-trash-count-url]');
  trashCountUrl.each(function(){
    let holder = $(this).data('trash-count-holder');
    let url = $(this).data('trash-count-url');
    $.ajax(url, {
      success : function(data){
        $(holder).text(data.count);
        console.log(data.count);
      }
    });
  });
 }

 countItemsInTheTrash()
 setInterval(countItemsInTheTrash(), 60000);




 //Show image on select
 $.fn.renderImageOnInputFileChange = function(options){
  let plugin = this;
  let defaults = {};

  plugin.settings = {}

  plugin.init = function(){
    plugin.settings = $.extend(plugin.settings, defaults, options);
    plugin.each(function(){
      plugin.on('change', function(){
        let holder = plugin.data('imgholder');
        if(typeof (FileReader) != undefined){
          $(holder).attr('src', '');
          let reader = new FileReader();

          reader.onload = function(e) {
            let image = e.target.result;
            $(holder).attr('src', image);
          }
          reader.readAsDataURL($(this)[0].files[0]);
        }
      })
    });
  }

  this.init();
  return this;
}

$('.render-image-on-input-file-change').renderImageOnInputFileChange();

//Open submenu on hover in compact sidebar mode and horizontal menu mode
$(document).on('mouseenter mouseleave', '.sidebar .nav-item', function(ev) {
  var body = $('body');
  var sidebarIconOnly = body.hasClass("sidebar-icon-only");
  var sidebarFixed = body.hasClass("sidebar-fixed");
  if (!('ontouchstart' in document.documentElement)) {
    if (sidebarIconOnly) {
      if (sidebarFixed) {
        if (ev.type === 'mouseenter') {
          body.removeClass('sidebar-icon-only');
        }
      } else {
        var $menuItem = $(this);
        if (ev.type === 'mouseenter') {
          $menuItem.addClass('hover-open')
        } else {
          $menuItem.removeClass('hover-open')
        }
      }
    }
  }
});

$('.aside-toggler').click(function(){
  $('.chat-list-wrapper').toggleClass('slide');
});


$('[data-bs-toggle="offcanvas"]').on("click", function() {
  $('.sidebar-offcanvas').toggleClass('active')
});

$("#checkAll").click(function(){
  $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
});


$('#addFeeDiscountModal #discountMode').on('change', function(){
  let mode = this.value;
  if (mode == 'percentage') {
    $('#fixedAmountInputHolder').addClass('d-none');
    $('#percentageInputHolder').removeClass('d-none');
  } else {
    $('#fixedAmountInputHolder').removeClass('d-none');
    $('#percentageInputHolder').addClass('d-none');
  }
});

$('.dev').on('click', function(e){
  e.preventDefault();
  alert('This functionality is still under development.... Sorry about that');
});


//Hostels Js
$('.allocate-hostel-select').each(function(e){
  this.on('change', function(){
    alert('hello');
  });
});


// Format the currency
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


// Login Page JS
$('#togglePassword').click(function(){
  var passwordField = $('#password');
  var icon = $(this).find('i');

  // Toggle password visibility
  if(passwordField.attr('type') === 'password') {
    passwordField.attr('type', 'text');
    icon.removeClass('mdi-eye-off').addClass('mdi-eye');
  } else {
      passwordField.attr('type', 'password');
      icon.removeClass('mdi-eye').addClass('mdi-eye-off');
  }
  
});





})(jQuery);

