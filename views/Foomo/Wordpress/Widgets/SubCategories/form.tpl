<p>
	<label for="<?php echo $model->widget->get_field_id('title'); ?>"><?php _e('Title:', 'sub_categories'); ?></label>
	<input class="widefat" id="<?php echo $model->widget->get_field_id('title'); ?>" name="<?php echo $model->widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($model->instance['title']) ?>" />
</p>
<p>
	<label for="<?= $model->widget->get_field_id('title_link'); ?>"><?php _e('Title Link:'); ?></label>
	<input class="widefat" id="<?= $model->widget->get_field_id('title_link'); ?>" name="<?= $model->widget->get_field_name('title_link'); ?>" type="text" value="<?= esc_attr($model->instance['title_link']); ?>" />
</p>
<p>
	<label for="<?php echo $model->widget->get_field_id('category_id'); ?>"><?php _e('Parent Category:', 'sub_categories'); ?></label>
	<select id="<?php echo $model->widget->get_field_id('category_id'); ?>" name="<?php echo $model->widget->get_field_name('category_id'); ?>">
		<?php
			$categories = get_categories(array('hide_empty' => 0));
			foreach ($categories as $cat) {
				if ($cat->cat_ID == $model->instance['category_id']) {
					$option = '<option selected="selected" value="'.$cat->cat_ID.'">';
				} else {
					$option = '<option value="'.$cat->cat_ID.'">';
				}
				$option .= $cat->cat_name.'</option>';
				echo $option;
			}
		?>
	</select>
</p>
<p>
	<input id="<?php echo $model->widget->get_field_id('show_post_count'); ?>" name="<?php echo $model->widget->get_field_name('show_post_count'); ?>" type="checkbox" value="1" <?php if ($model->instance['show_post_count']) echo 'checked="checked"'; ?>/>
	<label for="<?php echo $model->widget->get_field_id('show_post_count'); ?>"><?php _e('Show Post Count?', 'sub_categories'); ?></label>
</p>
<p>
	<input id="<?php echo $model->widget->get_field_id('hide_empty_cats'); ?>" name="<?php echo $model->widget->get_field_name('hide_empty_cats'); ?>" type="checkbox" value="1" <?php if ($model->instance['hide_empty_cats']) echo 'checked="checked"'; ?>/>
	<label for="<?php echo $model->widget->get_field_id('hide_empty_cats'); ?>"><?php _e('Hide Empty Sub-Categories?', 'sub_categories'); ?></label>
</p>
