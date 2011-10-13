
	<div id="navbar" class="navbar navbar-fixed" data-scrollspy="scrollspy">
		<div class="navbar-inner">
			<nav id="access" role="navigation" class="container">
				<a href="<?php echo home_url('/'); ?>" rel="home" class="brand"><?php _e( 'Main menu', 'twentyeleven' ); ?></a>
				<div class="assistive-text"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="assistive-text"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
				<? wp_nav_menu(array('theme_location' => 'main', 'menu_class' => 'nav', 'container' => false, 'walker' => new Foomo\Wordpress\Walkers\NavBar(), 'depth' => 2)); ?>
				<? foomo_bootstrap_get_search_form('navbar'); ?>
			</nav>
		</div>
	</div>

	<header id="branding" role="banner" class="container">

		<div class="hero-unit">
			<h1 id="site-title"><a href="<?= esc_url(home_url('/')); ?>" title="<?= esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><? bloginfo('name'); ?></a></h1>
			<p><?php bloginfo('description'); ?></p>
		</div>

	</header>

	<div id="primary" class="row">
		<div id="content" role="main" class="span11 columns">

			<? get_template_part('loop', \Foomo\Wordpress\Themes\FoomoBootstrap::$baseTemplateName); ?>

		</div>
		<div class="span5 columns">
			<? get_sidebar(); ?>
		</div>
	</div>

	<footer class="container">
		<?php
		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with four columns of widgets.
		 */
		?>

		<?php
		global $sa_options;
		$sa_settings = get_option('sa_options', $sa_options);
		?>

		<?php
		if ($sa_settings['iubenda_id'] != '') :
			?>
			<a href="http://www.iubenda.com/privacy-policy/<?php echo $sa_settings['iubenda_id']; ?>" class="iubenda-green-xs" id="iubenda-embed" title="Privacy Policy">Privacy Policy (by iubenda)</a>
			<script type="text/javascript" src="http://cdn.iubenda.com/iubenda.js"></script>
		<?php endif; ?>

		<?php
		if ($sa_settings['credits'] == 'true') :
			?>

			<div style="float: right">
				<a href="http://wpbootstrap.iubenda.com/">Bootstrap for Wordpress</a> is a theme based on the <a href="http://twitter.github.com/bootstrap/">Twitter Bootstrap toolkit</a>
				-
				<a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">Proudly powered by WordPress </a>
			</div>

		<?php endif; ?>

		<?php
		/* Always have wp_footer() just before the closing </body>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to reference JavaScript files.
		 */

		wp_footer();
		?>
	</footer>
</div> <!-- /container -->
