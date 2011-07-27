<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title_link)) echo '<a href="' . $model->title_link . '">' ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title_link)) echo '</a>' ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<ul>
	<? foreach ($model->comments as $comment): ?>
		<li><?= sprintf(_x('%1$s on %2$s', 'widgets'), get_comment_author_link($comment->comment_ID), '<a href="' . esc_url(get_comment_link($comment->comment_ID)) . '">' . get_the_title($comment->comment_post_ID) . '</a>'); ?></li>
	<? endforeach; ?>
</ul>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>
