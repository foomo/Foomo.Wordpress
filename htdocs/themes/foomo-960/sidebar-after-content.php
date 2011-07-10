	<? if (!is_active_sidebar('after-content-aside')) return; ?>

	<div id="after-content-aside" class="aside">
		<div id="after-content-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('after-content-aside') ?>">
			<ul>
				<? dynamic_sidebar('after-content-aside'); ?>
			</ul>
		</div>
	</div>
