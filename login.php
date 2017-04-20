<?php include('includes/head.php');?>
<?php include('includes/login-header.php');?>
<?php include('includes/php/scripts/login.php');?>
<?php include('includes/php/scripts/signup.php'); ?>

<body>
  <div class="container my-5">
    <div class="row my-5">
      <div class="col-md-6 offset-md-6">
        <div class="login-boundry my-5">
          <h2 class="my-3">Sign up!</h2>
          <form class="form" onsubmit="return checkHoneypot()" action="login.php" method="post">
            <div class="form-group">
              <div id="fNameDiv" class="form-inline">
                <input id="signUpFirstName" maxlength="34" class="form-control my-2" type="text" name="signUpFirstName" value="" placeholder="First Name" onblur="validateFirstName()" required/>
              </div>
              <div id="lNameDiv" class="form-inline">
                <input id="signUpLastName" name="signUpLastName" maxlength="34" class="form-control my-2" type="text" value="" placeholder="Last Name" onblur="validateLastName()" required/>
              </div>
              <div id="emailSignUpGroup">
                <input id="signUpEmail" name="signUpEmail" maxlength="254" class="form-control my-2" type="email" onblur="validateEmail()" placeholder="Email (must be a UL email)" required/>
              </div>
              <input id="signUpID" maxlength="8" name="signUpID" type="text" autocomplete="off" class="form-control my-2" placeholder="Student ID" required/>
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
                <input id="signUpPassword" name="signUpPassword" maxlength="20" type="password" class="form-control my-2" placeholder="Password" onblur="validatePassword()" required/>
              </div>
              <div id="passwordConfirmGroup">
                <input id="signUpPasswordConfirm" name="signUpPasswordConfirm" maxlength="20" type="password" class="form-control my-2" placeholder="Confirm Password" onblur="confirmPassword()" required/>
              </div>
              <input type="submit" class="btn btn-default mb-5" value="Sign Up" name="signUpButton" role="button"/>
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
