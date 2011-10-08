<? get_header(); ?>

	<? get_template_part('before-wrapper', 'page'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'page'); ?>

		<? get_template_part('content-header', 'page'); ?>

		<? get_template_part('after-header', 'page'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'page'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'page'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'page'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'page'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'page'); ?>

		<? get_template_part('content-footer', 'page'); ?>

		<? get_template_part('after-footer', 'page'); ?>

	</div>

	<? get_template_part('after-wrapper', 'page'); ?>

<? get_footer(); ?>
