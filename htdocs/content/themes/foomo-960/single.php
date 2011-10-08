<? get_header(); ?>

	<? get_template_part('before-wrapper', 'single'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'single'); ?>

		<? get_template_part('content-header', 'single'); ?>

		<? get_template_part('after-header', 'single'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'single'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'single'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'single'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'single'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'single'); ?>

		<? get_template_part('content-footer', 'single'); ?>

		<? get_template_part('after-footer', 'single'); ?>

	</div>

	<? get_template_part('after-wrapper', 'single'); ?>

<? get_footer(); ?>
