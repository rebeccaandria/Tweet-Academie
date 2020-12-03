$(document).ready(function(){
  
$('#comment_form').submit(function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
    url:"add_comment.php",
    method:"POST",
    data: form_data,
    dataType:"JSON",
    success: function(data) {
      if(data.error != '')
      {
        $('#comment_form')[0].reset();
        $('#comment_message').html(data.error);
        load_comment();
      }
    }
  })
})
})
load_comment();
function load_comment() {
  setTimeout(function (){
  $.ajax ({
    url:"fetch_comment.php",
    method:"post",
    success:function(data)
    {
      $('#display_comment').html(data);
    }
  })
  
},1000)
}
load_comment();