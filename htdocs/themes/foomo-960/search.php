<? get_header(); ?>

	<? get_template_part('before-wrapper', 'search'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'search'); ?>

		<? get_template_part('content-header', 'search'); ?>

		<? get_template_part('after-header', 'search'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'search'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'search'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'search'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'search'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'search'); ?>

		<? get_template_part('content-footer', 'search'); ?>

		<? get_template_part('after-footer', 'search'); ?>

	</div>

	<? get_template_part('after-wrapper', 'search'); ?>

<? get_footer(); ?>
