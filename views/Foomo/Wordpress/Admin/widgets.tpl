<div class="wrap">
	<? screen_icon("options-general"); ?>
	<h2><?= $model->title ?></h2>
	<form action="options.php" method="post">
	<?php settings_fields('foomo-widgets'); ?>
	<?php do_settings_sections('foomo-widgets') ?>
	<p class="submit">
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</p>
	</form>
</div>