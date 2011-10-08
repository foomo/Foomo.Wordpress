			<div id="comments">
<? if (post_password_required() ) : ?>
				<p class="nopassword"><? _e( 'This post is password protected. Enter the password to view any comments.', 'foomo960'); ?></p>
			</div>
<? return; endif; ?>


<? if (have_comments()): ?>
			<h3 id="comments-title"><?
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'foomo960' ),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h3>

<? if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
			<div class="navigation">
				<div class="nav-previous"><? previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'foomo960' ) ); ?></div>
				<div class="nav-next"><? next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'foomo960' ) ); ?></div>
			</div>
<? endif; ?>
			<ol class="commentlist">
				<? wp_list_comments(array('walker' => new \Foomo\Wordpress\Walkers\Comment())); ?>
			</ol>

<? if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
			<div class="navigation">
				<div class="nav-previous"><? previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'foomo960' ) ); ?></div>
				<div class="nav-next"><? next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'foomo960' ) ); ?></div>
			</div>
<? endif; ?>

<? else: ?>

	<? if (!comments_open()): ?>
		<? #<p class="nocomments"><? _e( 'Comments are closed.', 'foomo960' ); ? ></p> ?>
	<? endif; ?>

<? endif; ?>

<? comment_form(); ?>

</div>
