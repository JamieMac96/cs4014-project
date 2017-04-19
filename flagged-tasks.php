<?php include_once('includes/head.php');?>
<?php include_once('includes/header.php');
if($reputation < 40){
  header('location: index.php');
}
?>

<div class="page-content my-5">
  <div class="container">
      <h2>Browse Flagged Tasks</h2>
    <div id="display-tasks">
    <?php include_once('includes/php/scripts/display-tasks-flag.php'); ?>
  </div>
   <div id="remove_row">
        <td><button type="button" name="btn_more_flagged"  id="btn_more_flagged" class="btn-success btn form-control" role="button">more</button></td>
   </div>
  </div>
</div>
<?php include('includes/footer.php') ?>
