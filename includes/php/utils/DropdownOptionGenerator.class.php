<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/QueryHelper.class.php');

class DropdownOptionGenerator{
    function generateOptions($query, $displayColumn){
      $qh = new QueryHelper();

      $queryResult = $qh -> select($query);

      for ($i=0; $i < sizeof($queryResult); $i++) {
         ?><option><?php echo $queryResult[$i][$displayColumn]; ?>
           <?php  }
    }
}

?>
