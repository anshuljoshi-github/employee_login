$(document).ready(
  function()
  {
    $("#profile-div").hide();
    $("#changepassword-div").hide();
    $("#home-btn").click(
      function()
      {
        $("#home-div").show();
        $("#profile-div").hide();
        $("#changepassword-div").hide();
        console.log("home button clicked");
      }
    );
    $("#profile-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").show();
        $("#changepassword-div").hide();
        console.log("profile button clicked");
      }
    );
    $("#changepassword-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").hide();
        $("#changepassword-div").show();
        console.log("changepassword button clicked");
      }
    );
    
  }
);
