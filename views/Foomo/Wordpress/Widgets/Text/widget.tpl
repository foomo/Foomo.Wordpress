<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title_link)) echo '<a href="' . $model->title_link . '">' ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title_link)) echo '</a>' ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<div class="textwidget">
	<?= ($model->instance['filter']) ? wpautop($model->text) : $model->text; ?>
</div>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>
