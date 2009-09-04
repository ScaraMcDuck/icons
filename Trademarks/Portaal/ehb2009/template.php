<?php
function phptemplate_blocks($region) {
  // Set global to be read elsewhere.
  global $_current_region;
  $_current_region = $region;

  // invoke usual function.
  $output = theme_blocks($region);

  // Reset to null so we don't get a false reading.
  $_current_region = NULL;

  return $output;
}

function phptemplatesss_menu_item($mid, $children = '', $leaf = TRUE) {
  global $_current_region;
  // Make sure it's not NULL and we are in the right region.
  if (isset($_current_region) && $_current_region == 'footer') {
    // YOUR CODE
  }
  return '<li class="'. ($leaf ? 'leaf' : ($children ? 'expanded' : 'collapsed')) .'">'. menu_item_link($mid) . $children ."</li>\n";
}

function phptemplate_menu_tree($tree) {
  global $_current_region;
  if (isset($_current_region) && $_current_region == 'footer') {
  $tree = '<ul class="footmap-menu">'. $tree .'</ul>';
  }
  else {
		$tree = '<ul class="menu">'. $tree .'</ul>';
	}
	return $tree;
}

function phptemplate_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  global $_current_region;
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' '. $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
  if (isset($_current_region) && $_current_region == 'footer') {
  $link = '<li class="footmap-link ' . $class . '">'. $link . $menu ."</li>\n";
  }
  else {
  $link = '<li class="'. $class .'">'. $link . $menu ."</li>\n";
  }
  return $link;
}

