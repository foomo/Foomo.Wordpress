<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<? if ($model->count): ?>
	<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
		<option value=""><?= esc_attr(__('Select Month')); ?></option>
		<? wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $model->count))); ?>
	</select>
<? else: ?>
	<ul>
		<? wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $model->count))); ?>
	</ul>
<? endif; ?>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>