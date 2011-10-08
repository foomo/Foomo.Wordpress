	<? if (0 == $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-footer-aside')) return; ?>

	<div id="footer-aside" class="aside widget-containers-<?= $count ?>">
		<? if (is_active_sidebar('first-footer-aside')): ?>
		<div id="first-footer-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('first-footer-aside') ?>">
				<ul>
					<? dynamic_sidebar('first-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-footer-aside')): ?>
			<div id="second-footer-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-footer-aside') ?>">
				<ul>
					<? dynamic_sidebar('second-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-footer-aside')): ?>
			<div id="third-footer-widget-container" class="widget-container widgets-<?= foomo_get_widget_count('second-footer-aside') ?>">
				<ul>
					<? dynamic_sidebar('third-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>