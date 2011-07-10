<?php while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'foomo960'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta">
				<p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('l, F j, Y'); ?></p>
			</div>

	<?php if (is_archive() || is_search()) : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
	<?php else: ?>
			<div class="entry-content">
				<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'foomo960')); ?>
				<?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'foomo960'), 'after' => '</div>')); ?>
			</div>
	<?php endif; ?>

			<div class="entry-utility">
				<?php if (count(get_the_category())) : ?>
					<span class="cat-links">
						<?php printf(__('<span class="%1$s">Posted in</span> %2$s', 'foomo960'), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list(', ')); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<? $tags_list = get_the_tag_list('', ', ');  ?>
				<? if ($tags_list): ?>
					<span class="tag-links">
						<?php printf(__('<span class="%1$s">Tagged</span> %2$s', 'foomo960'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<span class="comments-link"><?php comments_popup_link(__('Leave a comment', 'foomo960'), __('1 Comment', 'foomo960'), __('% Comments', 'foomo960')); ?></span>
				<?php edit_post_link(__('Edit', 'foomo960'), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?>
			</div>
		</div>

		<?php comments_template('', true); ?>


<?php endwhile; ?>