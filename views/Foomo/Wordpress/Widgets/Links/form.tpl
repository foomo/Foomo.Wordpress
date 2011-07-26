<p>
	<label for="<?= $model->widget->get_field_id('category'); ?>" class="screen-reader-text"><?php _e('Select Link Category'); ?></label>
	<select class="widefat" id="<?= $model->widget->get_field_id('category'); ?>" name="<?= $model->widget->get_field_name('category'); ?>">
		<option value=""><?php _e('All Links'); ?></option>
		<?php
		foreach ($model->link_cats as $link_cat) {
			echo '<option value="' . intval($link_cat->term_id) . '"'
			. ( $link_cat->term_id == $model->instance['category'] ? ' selected="selected"' : '' )
			. '>' . $link_cat->name . "</option>\n";
		}
		?>
	</select></p>
<p>
	<input class="checkbox" type="checkbox" <?php checked($model->instance['images'], true) ?> id="<?= $model->widget->get_field_id('images'); ?>" name="<?= $model->widget->get_field_name('images'); ?>" />
	<label for="<?= $model->widget->get_field_id('images'); ?>"><?php _e('Show Link Image'); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($model->instance['name'], true) ?> id="<?= $model->widget->get_field_id('name'); ?>" name="<?= $model->widget->get_field_name('name'); ?>" />
	<label for="<?= $model->widget->get_field_id('name'); ?>"><?php _e('Show Link Name'); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($model->instance['description'], true) ?> id="<?= $model->widget->get_field_id('description'); ?>" name="<?= $model->widget->get_field_name('description'); ?>" />
	<label for="<?= $model->widget->get_field_id('description'); ?>"><?php _e('Show Link Description'); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($model->instance['rating'], true) ?> id="<?= $model->widget->get_field_id('rating'); ?>" name="<?= $model->widget->get_field_name('rating'); ?>" />
	<label for="<?= $model->widget->get_field_id('rating'); ?>"><?php _e('Show Link Rating'); ?></label>
</p>
