<?php
// $Id: block.tpl.php,v 1.3 2007/08/07 08:39:36 goba Exp $
?>
  <div class="block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">

<?php if ($block->subject!=""): ?>
<div class="header">
    <h2 class="title"><?php print $block->subject; ?></h2>
</div>
 <?php endif; ?>

    <div class="content"><?php print $block->content; ?></div>
 </div>
