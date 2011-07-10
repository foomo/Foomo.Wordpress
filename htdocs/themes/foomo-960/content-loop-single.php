<? while (have_posts()) : the_post(); ?>

			<div id="post-<? the_ID(); ?>" <? post_class(); ?>>
				<? if (is_front_page()):  ?>
					<h2 class="entry-title"><? the_title(); ?></h2>
				<? else: ?>
					<h1 class="entry-title"><? the_title(); ?></h1>
				<? endif; ?>
				<div class="entry-content">
					<? the_content(); ?>
					<? wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
				</div>
			</div>

<? endwhile; ?>