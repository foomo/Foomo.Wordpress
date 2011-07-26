<<?= $model->tag ?> <? comment_class(empty($model->args['has_children']) ? '' : 'parent') ?> id="comment-<? comment_ID() ?>">
	<? if ('div' != $model->args['style']) : ?>
		<div id="div-comment-<? comment_ID() ?>" class="comment-body">
	<? endif; ?>

	<div class="comment-author vcard">
		<? if ($model->args['avatar_size'] != 0) echo get_avatar($model->comment, $model->args['avatar_size']); ?>
		<? printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>

	<? if ($model->comment->comment_approved == '0'): ?>
		<em class="comment-awaiting-moderation"><? _e('Your comment is awaiting moderation.') ?></em>
		<br />
	<? endif; ?>

	<div class="comment-meta commentmetadata">
		<a href="<?= htmlspecialchars(get_comment_link($model->comment->comment_ID)) ?>">
			<? /* translators: 1: date, 2: time */ ?>
			<? printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time())?>
		</a>
		<? edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', ''); ?>
	</div>

	<? comment_text() ?>

	<div class="reply">
		<? comment_reply_link(array_merge($model->args, array('add_below' => $model->add_below, 'depth' => $model->depth, 'max_depth' => $model->args['max_depth']))) ?>
	</div>

	<? if ('div' != $model->args['style']) : ?>
		</div>
	<? endif; ?>
