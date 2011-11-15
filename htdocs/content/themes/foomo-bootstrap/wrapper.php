	<header id="branding">
		<hgroup>
			<h1 id="site-title"><a href="<?= esc_url(home_url('/')); ?>" title="<?= esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><? bloginfo('name'); ?></a></h1>
			<h2 id="site-description"><? bloginfo( 'description' ); ?></h2>
		</hgroup>

		<nav id="access" role="navigation">
			<? wp_nav_menu(); ?>
		</nav>
	</header>

	<div id="primary">
		<div class="row">
			<div id="content" role="main" class="span8">

				<? get_template_part('loop', \Foomo\Wordpress\Themes\FoomoBootstrap::$baseTemplateName); ?>

			</div>
			<div class="span4">
				<? get_sidebar(); ?>
			</div>
		</div>
	</div>

	<footer>
	</footer>