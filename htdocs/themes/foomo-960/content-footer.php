		<? if (\Foomo\Wordpress\Themes\Foomo960::$debug) echo '<!-- content-footer -->' ?>
		<div id="footer">
			<? get_sidebar('footer') ?>

			<div id="copyright">
				<p><? printf(__('Copyright &copy; %1$s by %2$s'), date('Y'), get_bloginfo('name', 'display') . ' - ' . get_bloginfo('description', 'display')) ?></p>
			</div>

			<? wp_nav_menu(array('container' => '', 'theme_location' => 'meta')); ?>
		</div>