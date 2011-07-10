<? wp_enqueue_style('dashboard'); ?>
<? wp_enqueue_script('dashboard'); ?>

		<div class="wrap">
            <? screen_icon("options-general"); ?>
            <h2><?= $model->title ?></h2>
            <form action="options.php" method="post">
				<div id="poststuff" class="metabox-holder">
					<div id="post-body">
						<div id="post-body-content">
							<? settings_fields($model->id); ?>
							<? wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
							<? wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
							<? do_meta_boxes($model->id, 'advanced', null); ?>
							<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<? esc_attr_e('Save Changes'); ?>" /></p>

				        </div>
					</div>
				</div>
            </form>
        </div>
