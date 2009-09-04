<div class="block block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">
  <div class="balloon_top">
    <?php print $block->content; ?>
  </div>
  
  <div class="balloon_bottom">
  </div>

  <?php if ($block->subject!=""): ?>
    <h3><?php print $block->subject; ?></h3>
  <?php endif; ?>

</div>
