$(document).ready(
  function()
  {
    $("#home-btn").click(
      function()
      {
        $("#home-div").show();
        $("#profile-div").hide();
        $("#changepassword-div").hide();
        $("#delete-account-div").hide();
        $("#confirm-delete-div").hide();
        console.log("home button clicked");
      }
    );
    $("#profile-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").show();
        $("#changepassword-div").hide();
        $("#delete-account-div").hide();
        $("#confirm-delete-div").hide();
        console.log("profile button clicked");
      }
    );
    $("#changepassword-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").hide();
        $("#changepassword-div").show();
        $("#delete-account-div").hide();
        $("#confirm-delete-div").hide();
        console.log("changepassword button clicked");
      }
    );
    $("#changepassword-btn-id").click(
      function()
      {
        event.preventDefault();
        // $("#home-div").hide();
        // $("#profile-div").hide();
        // $("#changepassword-div").show();
        // $("#delete-account-div").hide();
        // $("#confirm-delete-div").hide();
        console.log("changepassword button from form clicked");
      }
    );
    $("#deleteaccount-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").hide();
        $("#changepassword-div").hide();
        $("#delete-account-div").show();
        $("#confirm-delete-div").hide();
        console.log("delete accoount button clicked");
      }
    );
    $("#delete-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").hide();
        $("#changepassword-div").hide();
        $("#delete-account-div").hide();
        $("#confirm-delete-div").show();
        console.log("delete button clicked form delete account div");
      }
    );
    $("#cancel-delete-btn").click(
      function()
      {
        $("#home-div").hide();
        $("#profile-div").hide();
        $("#changepassword-div").hide();
        $("#delete-account-div").show();
        $("#confirm-delete-div").hide();
        console.log("delete button clicked form delete account div");
      }
    );
    $("#update-account-btn1").click(
      function()
      {
        var first_name = $("fname").val();
        var last_name = $("lname").val();
        var phone_number = $("pnum").val();
        var email = $("email").val();
        var dob = new Date($("dob").val());
        var day = dob.getDate();
        var month = dob.getMonth() + 1;
        var year = dob.getFullYear();
        var gender = $("gender:checked").val();
        var address = $("address").val();

        if(first_name == "")
        {
          alert("please enter first name");
          return false;
        }
        else if (last_name == "")
        {
          alert("please enter last name");
          return false;
        }
        else if (phone_number == "")
        {
          alert("please enter phone number");
          return false;
        }
        else if (!(phone_number.match(/^\d{10}$/)))
        {
          alert("phone number should be an integer value and must be of 10 digits.");
          return false;
        }
        else if (email == "")
        {
          alert("please enter email");
          return false;
        }
        else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
        {
          alert("You have entered an invalid email address!");
          return false;
        }
        else if (dob == "Invalid Date")
        {
          alert("dob is necessary");
          return false;
        }
        else if (gender == undefined)
        {
          alert("gender not selected");
          return false;
        }
        else if (address == "")
        {
          alert("please enter address");
          return false;
        }
        else
        {
          alert("first_name: "+first_name+
                "\nlast_name: "+last_name+
                "\nphone number: "+phone_number+
                "\nemail: "+email+
                "\ndob: "+dob+
                "\ndate: "+day+"\tmonth: "+month+"\tyear: "+year+
                "\ngender: "+gender+
                "\naddress: "+address);
        }
      }
    );
    $("#changepassword-btn1").click(
      function()
      {
        var oldpass = $("oldpass").val();
        var newpass = $("newpass").val();
        var cnfmnewpass = $("cnfmnewpass").val();

        if (oldpass == "")
        {
          alert("please enter old password.");
          return false;
        }
        else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/.test(oldpass)))
        {
          alert("password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character");
          return false;
        }
        else if (newpass == "")
        {
          alert("please enter new password.");
          return false;
        }
        else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/.test(newpass)))
        {
          alert("password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character");
          return false;
        }
        else if (newpass != cnfmnewpass)
        {
          alert("passwords didn't match");
          return false;
        }
      }
    );
  }
);
