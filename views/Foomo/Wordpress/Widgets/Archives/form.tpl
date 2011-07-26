<p><label for="<?= $model->widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?= $model->widget->get_field_id('title'); ?>" name="<?= $model->widget->get_field_name('title'); ?>" type="text" value="<?= esc_attr($model->title); ?>" /></p>
<p>
	<input class="checkbox" type="checkbox" <?= $model->dropdown; ?> id="<?= $model->widget->get_field_id('dropdown'); ?>" name="<?= $model->widget->get_field_name('dropdown'); ?>" /> <label for="<?= $model->widget->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown'); ?></label>
	<br/>
	<input class="checkbox" type="checkbox" <?= $model->count; ?> id="<?= $model->widget->get_field_id('count'); ?>" name="<?= $model->widget->get_field_name('count'); ?>" /> <label for="<?= $model->widget->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
</p>
