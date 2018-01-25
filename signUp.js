$(function() {
  $('#btnSignUp').click(function() {
    console.log("This is working so far");
    alert("This is working so far!");


    $.ajax({
      url: '/signup',
      data: $('form').serialize(),
      type: 'POST',
      success: function(response) {
        console.log(response),
        console.log("This might be working");
        alert("This might be working.");
      },
      error: function(error) {
        console.log(error),
        console.log("This is not working");
        alert("This is not working!");
      }
    });
  });
});
