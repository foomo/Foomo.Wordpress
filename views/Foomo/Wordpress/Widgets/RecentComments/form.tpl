<p>
	<label for="<?= $model->widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?= $model->widget->get_field_id('title'); ?>" name="<?= $model->widget->get_field_name('title'); ?>" type="text" value="<?= $model->title; ?>" />
</p>

<p>
	<label for="<?= $model->widget->get_field_id('title_link'); ?>"><?php _e('Title Link:'); ?></label>
	<input class="widefat" id="<?= $model->widget->get_field_id('title_link'); ?>" name="<?= $model->widget->get_field_name('title_link'); ?>" type="text" value="<?= esc_attr($model->title_link); ?>" />
</p>

<p>
	<label for="<?= $model->widget->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
	<input id="<?= $model->widget->get_field_id('number'); ?>" name="<?= $model->widget->get_field_name('number'); ?>" type="text" value="<?= $model->number; ?>" size="3" />
</p>
