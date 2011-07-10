<? get_header(); ?>

	<? get_template_part('before-wrapper', 'index'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'index'); ?>

		<? get_template_part('content-header', 'index'); ?>

		<? get_template_part('after-header', 'index'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'index'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'index'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'index'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'index'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'index'); ?>

		<? get_template_part('content-footer', 'index'); ?>

		<? get_template_part('after-footer', 'index'); ?>

	</div>

	<? get_template_part('after-wrapper', 'index'); ?>

<? get_footer(); ?>
