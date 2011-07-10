<? get_header(); ?>

	<? get_template_part('before-wrapper', '404'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', '404'); ?>

		<? get_template_part('content-header', '404'); ?>

		<? get_template_part('after-header', '404'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', '404'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', '404'); ?>

				<? else: ?>

					<? get_template_part('content-404', '404'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', '404'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', '404'); ?>

		<? get_template_part('content-footer', '404'); ?>

		<? get_template_part('after-footer', '404'); ?>

	</div>

	<? get_template_part('after-wrapper', '404'); ?>

<? get_footer(); ?>
