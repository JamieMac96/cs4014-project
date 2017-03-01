<?php include('includes/head.php');?>
<?php include('includes/login-header.php');?>
<?php include('includes/php/scripts/login.php');?>
<?php include('includes/php/scripts/signup.php') ?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-6">
        <div class="login-boundry my-5">
          <h2 class="my-3">Sign up!</h2>
          <form class="form" onsubmit="return checkHoneypot()" action="login.php" method="post">
            <div class="form-group">
              <div id="fNameDiv" class="form-inline">
                <input id="signUpFirstName" class="form-control my-2" type="text" name="signUpFirstName" value="" placeholder="First Name" onblur="validateFirstName()" required/>
              </div>
              <div id="lNameDiv" class="form-inline">
                <input id="signUpLastName" name="signUpLastName" class="form-control my-2" type="text" value="" placeholder="Last Name" onblur="validateLastName()" required/>
              </div>
              <div id="emailSignUpGroup">
                <input id="signUpEmail" name="signUpEmail" class="form-control my-2" type="email" onblur="validateEmail()" placeholder="Email" required/>
              </div>
              <input id="signUpID" name="signUpID" type="text" class="form-control my-2" placeholder="Student ID" required/>
              <select class="form-control my-2" name="signUpSubject">
                <option selected hidden>Subject / Discipline</option>
                <?php
                include('includes/php/utils/DropdownOptionGenerator.class.php');
                $gen = new DropdownOptionGenerator();
                $query = "SELECT * FROM Subject;";
                $gen -> generateOptions($query, 'SubjectName');
                ?>
              </select>
              <div id="passwordGroup">
                <input id="signUpPassword" name="signUpPassword" type="password" class="form-control my-2" placeholder="Password" onblur="validatePassword()"/>
              </div>
              <div id="passwordConfirmGroup">
                <input id="signUpPasswordConfirm" name="signUpPasswordConfirm" type="password" class="form-control my-2" placeholder="Confirm Password" onblur="confirmPassword()"/>
              </div>
              <input type="submit" class="btn btn-default" value="Sign Up" name="signUpButton" role="button"/>
              <div class="input-field">
                <input id="gotcha" type="text" name="contact" value="" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

<?php include('includes/footer.php');?>
