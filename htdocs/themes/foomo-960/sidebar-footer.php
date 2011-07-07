<? if (0 < $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-footer-aside')) return; ?>

	<div id="footer-aside" class="aside widgets-<?= $count ?>">
		<? if (is_active_sidebar('first-footer-aside')): ?>
			<div id="first-footer" class="widget-container">
				<ul>
					<? dynamic_sidebar('first-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-footer-aside')): ?>
			<div id="second-footer" class="widget-container">
				<ul>
					<? dynamic_sidebar('second-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-footer-aside')): ?>
			<div id="third-footer" class="widget-container">
				<ul>
					<? dynamic_sidebar('third-footer-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>