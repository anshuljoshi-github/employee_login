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
    $("#update-account-btn1").click(
      function()
      {
        console.log("enter validation block");
        var first_name = $("fname").val();
        var last_name = $("lname").val();
        var phone_number = $("pnum").val();
        var email = $("email").val();
        var dob = new Date($("dob").val());
        var day = dob.getDate();
        var month = dob.getMonth() + 1;
        var year = dob.getFullYear();
        var gender = $("gender").val();
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
        else if (pass != cnfm_pass)
        {
          alert("passwords didn't match");
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
          console.log("all good");
          alert("first_name: "+first_name+
                "\nlast_name: "+last_name+
                "\nphone number: "+phone_number+
                "\nemail: "+email+
                "\ndob: "+dob+
                "\ndate: "+day+"\tmonth: "+month+"\tyear: "+year+
                "\ngender: "+gender+
                "\naddress: "+address);

          // window.location.href="user_dashboard.php";
          // $(location).attr('href',"user_dashboard.php");
        }
      }
    );
  }
);
