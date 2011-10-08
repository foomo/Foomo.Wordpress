<? get_header(); ?>

	<? get_template_part('before-wrapper', 'author'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'author'); ?>

		<? get_template_part('content-header', 'author'); ?>

		<? get_template_part('after-header', 'author'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'author'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'author'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'author'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'author'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'author'); ?>

		<? get_template_part('content-footer', 'author'); ?>

		<? get_template_part('after-footer', 'author'); ?>

	</div>

	<? get_template_part('after-wrapper', 'author'); ?>

<? get_footer(); ?>
