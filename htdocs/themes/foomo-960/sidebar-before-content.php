<? if (0 == $count = foomo_get_active_sidebar_count(array('first', 'second', 'third'), '-before-content-aside')) return; ?>

	<div id="before-content-aside" class="aside widgets-<?= $count ?>">
		<? if (is_active_sidebar('first-before-content-aside')): ?>
			<div id="first-before-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('first-before-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('second-before-content-aside')): ?>
			<div id="second-before-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('second-before-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<? if (is_active_sidebar('third-before-content-aside')): ?>
			<div id="third-before-content" class="widget-container">
				<ul>
					<? dynamic_sidebar('third-before-content-aside'); ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>