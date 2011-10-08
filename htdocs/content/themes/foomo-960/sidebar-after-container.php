	<? if (0 == $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-after-container-aside')) return; ?>

	<div id="after-container-aside" class="aside widget-containers-<?= $count ?>">
		<? if (is_active_sidebar('first-after-container-aside')): ?>
		<div id="first-after-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('first-after-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('first-after-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-after-container-aside')): ?>
			<div id="second-after-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-after-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('second-after-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-after-container-aside')): ?>
			<div id="third-after-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-after-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('third-after-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>