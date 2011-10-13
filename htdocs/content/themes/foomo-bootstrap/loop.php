<? if (have_posts()): ?>

	<? if ($wp_query->max_num_pages > 1): ?>
		<nav id="post-nav-above">
			<h3 class="assistive-text"><? _e('Post navigation', 'twentyeleven'); ?></h3>
			<div class="nav-previous"><? next_posts_link( __('<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven')); ?></div>
			<div class="nav-next"><? previous_posts_link( __('Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven')); ?></div>
		</nav><!-- #nav-above -->
	<? endif; ?>

	<? while (have_posts()) : the_post(); ?>

<? get_template_part('content', get_post_format()); ?>

	<? endwhile; ?>

	<? if ($wp_query->max_num_pages > 1): ?>
		<nav id="post-nav-below">
			<h3 class="assistive-text"><? _e('Post navigation', 'twentyeleven'); ?></h3>
			<div class="nav-previous"><? next_posts_link( __('<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven')); ?></div>
			<div class="nav-next"><? previous_posts_link( __('Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven')); ?></div>
		</nav><!-- #post-nav-below -->
	<? endif; ?>

<? else: ?>

<? get_template_part('content', '404'); ?>

<? endif; ?>