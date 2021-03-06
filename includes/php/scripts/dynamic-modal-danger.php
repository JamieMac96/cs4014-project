<a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="<?php echo '#' . $target; ?>" class="modal-trigger">
  <?php echo $modalTitle; ?>
</a>
<div class="modal" id="<?php echo $target; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle; ?> </h4>
    </div>
    <div class="modal-body">
      <?php include($includeURL);?>
    </div>
  </div>
</div>
</div>
