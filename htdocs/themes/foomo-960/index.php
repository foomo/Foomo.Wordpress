	<? get_header(); ?>

	<? get_template_part('index', 'before-container'); ?>

	<div id="container">

		<? get_sidebar('before-content') ?>

		<div id="content">
			<? get_template_part('loop', 'index'); ?>
		</div>

		<? get_sidebar('after-content') ?>
	</div>

	<? get_template_part('index', 'before-container'); ?>

	<? get_footer(); ?>
