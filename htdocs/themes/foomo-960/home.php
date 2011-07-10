<? get_header(); ?>

	<? get_template_part('before-wrapper', 'home'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'home'); ?>

		<? get_template_part('content-header', 'home'); ?>

		<? get_template_part('after-header', 'home'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'home'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'home'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'home'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'home'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'home'); ?>

		<? get_template_part('content-footer', 'home'); ?>

		<? get_template_part('after-footer', 'home'); ?>

	</div>

	<? get_template_part('after-wrapper', 'home'); ?>

<? get_footer(); ?>
