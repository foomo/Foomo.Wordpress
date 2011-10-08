	<? if (0 == $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-before-container-aside')) return; ?>

	<div id="before-container-aside" class="aside widget-containers-<?= $count ?>">
		<? if (is_active_sidebar('first-before-container-aside')): ?>
		<div id="first-before-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('first-before-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('first-before-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-before-container-aside')): ?>
			<div id="second-before-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-before-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('second-before-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-before-container-aside')): ?>
			<div id="third-before-container-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-before-container-aside') ?>">
				<ul>
					<? dynamic_sidebar('third-before-container-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>