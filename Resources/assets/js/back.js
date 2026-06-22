 //Get the number of items being trashed
 $('[data-trash-count-url]').each(function(){
  let holder = $(this).data('trash-count-holder');
  let url = $(this).data('trash-count-url');
  setInterval($.ajax(url, {
    success : function(data){
     $(holder).text(data.count)
     console.log(data);
    }
   }), 5000);
 });