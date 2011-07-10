<? get_header(); ?>

	<? get_template_part('before-wrapper', 'archive'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'archive'); ?>

		<? get_template_part('content-header', 'archive'); ?>

		<? get_template_part('after-header', 'archive'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'archive'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'archive'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'archive'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'archive'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'archive'); ?>

		<? get_template_part('content-footer', 'archive'); ?>

		<? get_template_part('after-footer', 'archive'); ?>

	</div>

	<? get_template_part('after-wrapper', 'archive'); ?>

<? get_footer(); ?>
