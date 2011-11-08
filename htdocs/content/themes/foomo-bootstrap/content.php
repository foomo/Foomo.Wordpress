	<article id="post-<? the_ID(); ?>" <? post_class(); ?>>
		<header class="entry-header">
			<? if (is_sticky()) : ?>
				<hgroup>
					<h2 class="entry-title"><a href="<? the_permalink(); ?>" title="<? printf(esc_attr__('Permalink to %s', 'twentyeleven'), the_title_attribute('echo=0')); ?>" rel="bookmark"><? the_title(); ?></a></h2>
					<h3 class="entry-format"><? _e('Featured', 'twentyeleven'); ?></h3>
				</hgroup>
			<? else : ?>
				<h1 class="entry-title"><a href="<? the_permalink(); ?>" title="<? printf(esc_attr__('Permalink to %s', 'twentyeleven'), the_title_attribute('echo=0')); ?>" rel="bookmark"><? the_title(); ?></a></h1>
			<? endif; ?>

			<? if ('post' == get_post_type()) : ?>
			<div class="entry-meta">
				<?
					printf(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven'),
						esc_url(get_permalink()),
						esc_attr(get_the_time()),
						esc_attr(get_the_date('c')),
						esc_html(get_the_date()),
						esc_url(get_author_posts_url(get_the_author_meta('ID'))),
						sprintf(esc_attr__('View all posts by %s', 'twentyeleven'), get_the_author()),
						esc_html(get_the_author())
					);
				?>
			</div><!-- .entry-meta -->
			<? endif; ?>

			<? if (comments_open() && ! post_password_required()) : ?>
			<div class="comments-link">
				<? comments_popup_link('<span class="leave-reply">' . __('Reply', 'twentyeleven') . '</span>', _x('1', 'comments number', 'twentyeleven'), _x('%', 'comments number', 'twentyeleven')); ?>
			</div>
			<? endif; ?>
		</header><!-- .entry-header -->

		<? if (is_search()) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<? the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<? else : ?>
		<div class="entry-content">
			<? the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven')); ?>
			<? wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'twentyeleven') . '</span>', 'after' => '</div>')); ?>
		</div><!-- .entry-content -->
		<? endif; ?>

		<footer class="entry-meta">
			<? $show_sep = false; ?>
			<? if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
			<?
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list(__(', ', 'twentyeleven'));
				if ($categories_list):
			?>
			<span class="cat-links">
				<? printf(__('<span class="%1$s">Posted in</span> %2$s', 'twentyeleven'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list);
				$show_sep = true; ?>
			</span>
			<? endif; // End if categories ?>
			<?
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list('', __(', ', 'twentyeleven'));
				if ($tags_list):
				if ($show_sep) : ?>
			<span class="sep"> | </span>
				<? endif; // End if $show_sep ?>
			<span class="tag-links">
				<? printf(__('<span class="%1$s">Tagged</span> %2$s', 'twentyeleven'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
				$show_sep = true; ?>
			</span>
			<? endif; // End if $tags_list ?>
			<? endif; // End if 'post' == get_post_type() ?>

			<? if (comments_open()) : ?>
			<? if ($show_sep) : ?>
			<span class="sep"> | </span>
			<? endif; // End if $show_sep ?>
			<span class="comments-link"><? comments_popup_link('<span class="leave-reply">' . __('Leave a reply', 'twentyeleven') . '</span>', __('<b>1</b> Reply', 'twentyeleven'), __('<b>%</b> Replies', 'twentyeleven')); ?></span>
			<? endif; // End if comments_open() ?>

			<? edit_post_link(__('Edit', 'twentyeleven'), '<span class="edit-link">', '</span>'); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post-<? the_ID(); ?> -->