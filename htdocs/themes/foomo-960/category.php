<? get_header(); ?>

	<? get_template_part('before-wrapper', 'category'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'category'); ?>

		<? get_template_part('content-header', 'category'); ?>

		<? get_template_part('after-header', 'category'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'category'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'category'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'category'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'category'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'category'); ?>

		<? get_template_part('content-footer', 'category'); ?>

		<? get_template_part('after-footer', 'category'); ?>

	</div>

	<? get_template_part('after-wrapper', 'category'); ?>

<? get_footer(); ?>
