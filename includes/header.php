
<?php
      include_once('includes/php/scripts/check-session.php');
      include_once('includes/php/scripts/current-user-info.php');
      include_once('includes/php/scripts/dynamic-search.php')
      ?>
<header class="banner hidden-sm-down">
  <div class="container">
    <div class="flex-row">
      <div class="col-xs-12 text-center">
         <h1 class="header-heading">Peer Review Centre</h1>
      </div>
    </div>
  </div>
</header>
<div id="sticky-nav-wrap">
  <header class="navbar navbar-toggleable-md navbar-default navbar-inverse navbar-static-top">
    <div class="container nav-container">
      <div class="col-md-6">
        <div class="collapse navbar-collapse">
          <div class="nav-menu">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
              <li class="active nav-item"><a href="index.php">Home</a></li>
              <li class="active nav-item"><a href="profile.php?userID=<?php echo $userID;?>">Profile</a></li>
              <li class="active nav-item"><a href="faq.php">FAQS</a></li>
              <?php

              if($reputation >= 40){
                ?>
                <li class="active nav-item"><a href="flagged-tasks.php">Flagged Tasks</a></li>
                <?php
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <form class="form-inline my-2 my-lg-0" action="search-results.php" method="get">
          <input id="dynamic-search" maxlength="20" name="search-query" class="form-control mr-sm-2" autocomplete="off" type="text" placeholder="Search">
          <ul class="dropdown-menu search-dropdown">
            <div id="dynamic-results"></div>
          </ul>
          <button name='submit-search' class="btn btn-outline-success my-2 my-sm-0" type="submit">
            <i class="fa fa-search">
              <a href="search-results.php"></a>
            </i>
          </button>
        </form>
      </div>
      <div class="col-md-1">
        <div class="dropdown">
          <button class="btn btn-secondary" role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bars"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Current user: <br><?php echo "$firstname $lastname";?></a>
            <hr>
            <a class="dropdown-item" href="profile.php?userID=<?php echo $userID;?>">View Profile</a>
            <hr>
            <a class="dropdown-item" href="login.php">Logout</a>
            <a class="dropdown-item" href="index.php">Home</a>
            <a class="dropdown-item" href="profile.php?userID=<?php echo $userID;?>">Profile</a>
            <a class="dropdown-item" href="faq.php">FAQS</a>
            <?php
            if($reputation >= 40) {
              ?>
              <a class="dropdown-item" href="flagged-tasks.php">Flagged Tasks</a>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </header>
</div>
