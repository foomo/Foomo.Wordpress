		<? if (\Foomo\Wordpress\Themes\Foomo960::$debug) echo '<!-- after-loop -->' ?>
		<? if (!is_home() && !is_page() && $wp_query->max_num_pages > 1): ?>
			<div id="post-nav-below" class="navigation">
				<div class="post-nav-previous"><? next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts')); ?></div>
				<div class="post-nav-next"><? previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>')); ?></div>
			</div>
		<? endif; ?>
