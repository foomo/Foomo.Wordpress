	<? if (!is_active_sidebar('before-content-aside')) return; ?>

	<div id="before-content-aside" class="aside">
		<div id="before-content-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('before-content-aside') ?>">
			<ul>
				<? dynamic_sidebar('before-content-aside'); ?>
			</ul>
		</div>
	</div>
