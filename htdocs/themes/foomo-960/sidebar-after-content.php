<? if (0 == $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-after-content-aside')) return; ?>

	<div id="after-content-aside" class="aside widgets-<?= $count ?>">
		<? if (is_active_sidebar('first-after-content-aside')): ?>
			<div id="first-after-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('first-after-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-after-content-aside')): ?>
			<div id="second-after-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('second-after-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-after-content-aside')): ?>
			<div id="third-after-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('third-after-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>