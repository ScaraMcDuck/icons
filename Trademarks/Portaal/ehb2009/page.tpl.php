<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">
 <head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
 </head>
 <body class="<?php print $body_classes; ?>">

 <!-- begin background div -->
  <div id="background">

  <!-- begin container -->
   <div id="container">

   <!-- begin header -->
    <div id="header">
     <?php if ($logo) { ?>
      <div id="logo">
	   <a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a>
	  </div>
     <?php } ?>
     <div id="related_info">
      <?php if (isset($secondary_links)) : ?>
       <ul class="dropdown">
        <li>Directe links
         <?php print theme('links', $secondary_links, array('class' => 'secondary-links')) ?>
        </li>
       </ul>
      <?php endif; ?>
      <?php print $searchform; ?>
      <?php if (isset($primary_links)) : ?>
       <?php print theme('links', $primary_links, array('id' => 'primary_links')) ?>
      <?php endif; ?>
       <ul id="lang">
        <li><a href="#" title="English">English</a></li>
        <li><a href="#" title="Nederlands" class="active">Nederlands</a></li>
       </ul>
	 </div>
    </div>
    <!-- end header -->

    <!-- begin top -->
    <div id="top">
      <?php print $navigation; ?>
    </div>
    <!-- end top -->

    <!-- begin main -->
    <div id="main">

		<!-- begin content -->
		<div id="content">
		  <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
		  <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
		  <?php if ($title): print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>'; endif; ?>
		  <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
		  <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
		  <?php if ($show_messages && $messages): print $messages; endif; ?>
		  <?php print $help; ?>
		  <div id="content-body">
			 <?php print $content ?>
		  </div>
		  <?php print $feed_icons ?>
		</div>
		<!-- end content -->

		<!-- begin sidebar -->
		<?php if ($sidebar) { ?>
		  <div id="sidebar">
			<?php print $sidebar ?>
		  </div><br class="clear" />
		<?php }; ?>
		<!-- end sidebar -->

    </div>
    <!-- end main -->
  </div>
  <!-- end container -->

  <!-- begin footer -->
  <div id="footer">
    <div class="footer_content">
	<?php print $footer; ?>
      <?php if ($footer_message): ?>
	  <div id="footer-message">
      <?php print $footer_message; ?>
      </div>
	  <?php endif; ?>
	  

    </div>
  </div>
  <!-- end footer -->
  </div>
  <!-- end background div -->
  <?php print $closure; ?>
 </body>
</html>