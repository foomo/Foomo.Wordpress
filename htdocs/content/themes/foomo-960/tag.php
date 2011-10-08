<? get_header(); ?>

	<? get_template_part('before-wrapper', 'tag'); ?>

	<div id="wrapper">

		<? get_template_part('before-header', 'tag'); ?>

		<? get_template_part('content-header', 'tag'); ?>

		<? get_template_part('after-header', 'tag'); ?>

		<? get_sidebar('before-container') ?>

		<div id="container"<?= foomo_get_container_classes(); ?>>

			<? get_sidebar('before-content') ?>

			<div id="content">

				<? get_template_part('before-loop', 'tag'); ?>

				<? if (have_posts()): ?>

					<? get_template_part('content-loop', 'tag'); ?>

				<? else: ?>

					<? get_template_part('content-404', 'tag'); ?>

				<? endif; ?>

				<? get_template_part('after-loop', 'tag'); ?>

			</div>

			<? get_sidebar('after-content') ?>

		</div>

		<? get_sidebar('after-container') ?>

		<? get_template_part('before-footer', 'tag'); ?>

		<? get_template_part('content-footer', 'tag'); ?>

		<? get_template_part('after-footer', 'tag'); ?>

	</div>

	<? get_template_part('after-wrapper', 'tag'); ?>

<? get_footer(); ?>
