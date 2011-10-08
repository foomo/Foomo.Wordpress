<? get_header(); ?>

	<? get_template_part('before-wrapper', 'attachment'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'attachment'); ?>

		<? get_template_part('content-header', 'attachment'); ?>

		<? get_template_part('after-header', 'attachment'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'attachment'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'attachment'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'attachment'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'attachment'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'attachment'); ?>

		<? get_template_part('content-footer', 'attachment'); ?>

		<? get_template_part('after-footer', 'attachment'); ?>

	</div>

	<? get_template_part('after-wrapper', 'attachment'); ?>

<? get_footer(); ?>
