<p><label for="<?= $model->widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?= $model->widget->get_field_id('title'); ?>" name="<?= $model->widget->get_field_name('title'); ?>" type="text" value="<?= esc_attr($model->title); ?>" /></p>

<textarea class="widefat" rows="16" cols="20" id="<?= $model->widget->get_field_id('text'); ?>" name="<?= $model->widget->get_field_name('text'); ?>"><?= $model->text; ?></textarea>

<p><input id="<?= $model->widget->get_field_id('filter'); ?>" name="<?= $model->widget->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($model->instance['filter']) ? $model->instance['filter'] : 0); ?> />&nbsp;<label for="<?= $model->widget->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
