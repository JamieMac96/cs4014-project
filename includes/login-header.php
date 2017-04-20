<header class="banner navbar navbar-toggleable-md navbar-default navbar-inverse navbar-static-top">
  <div class="container nav-container">
    <div class="row">
      <div class="col-md-6 text-left hidden-sm-down">
         <h2 class="header-heading">Peer Review Centre</h2>
      </div>
      <div class="login-form col-md-4 offset-md-2">
        <div class="collapse navbar-collapse" id="log-in">
          <form class="form-inline" action="login.php" novalidate="novalidate" method="post" onsubmit="window.location.reload()">
            <div class="form-group">
              <div id="emailSignInGroup" class="form-group">
                <input id="signInEmail" maxlength="255" name="signInEmail" class="form-control" type="email" placeholder="email" />
              </div>
              <div id="passwordSignInGroup" class="form-group">
                <input id="signInPassword" maxlength="20" name="signInPassword" type="password" class="form-control" placeholder="password"/>
                <input type="submit" class="btn btn-default" value="login" name="loginSubmitButton" role="button"/>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-1 hidden-md-up">
        <div class="dropdown">
          <button class="btn btn-secondary" role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bars"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <form class="form-inline" action="login.php" novalidate="novalidate" method="post" onsubmit="">
              <div class="form-group">
                <div class="dropdown-item">
                  <div id="emailSignInGroup" class="form-group">
                    <input id="signInEmail" name="signInEmail" class="form-control" type="email" placeholder="email" />
                  </div>
                </div>
                <hr>
                <div class="dropdown-item">
                  <div id="passwordSignInGroup" class="form-group">
                    <input id="signInPassword" name="signInPassword" type="password" class="form-control" placeholder="password"/>
                    <input type="submit" class="btn btn-default" value="login" name="loginSubmitButton" role="button"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</header>
