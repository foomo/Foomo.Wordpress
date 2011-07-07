<div class="wrap">
	<h2><?= \Foomo\Wordpress\Plugins\Toolkit::NAME; ?></h2>

	<? if (isset($model['message'])): ?>
		<div style="border:2px solid #cc0000; padding:8px; font-weight:bold; margin:10px;"><?= $model['message']; ?></div>
	<? endif; ?>

	<table class="widefat">
		<thead>
			<tr>
				<th><? _e('Admin Settings', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<form method="post" action="">
						<table class="form-table">
							<tr>
								<th scope="row"><? _e('Disable Core Updates', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
								<td><input type="checkbox" name="disableCoreUpdates"<?= ($model['options']['disableCoreUpdates']) ? ' checked="checked"' : ''; ?>/></td>
							</tr>
							<tr>
								<th scope="row"><? _e('Disable Plugin Updates', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
								<td><input type="checkbox" name="disablePluginUpdates"<?= ($model['options']['disablePluginUpdates']) ? ' checked="checked"' : ''; ?>/></td>
							</tr>
						</table>
						<br/>
						<p><input type="submit" name="adminSettingsSubmit" class="button" value="<? _e('Save Changes') ?>"/></p>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	<br/>
	<table class="widefat">
		<thead>
			<tr>
				<th><? _e('Theming Settings', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<form method="post" action="">
						<table class="form-table">
							<tr>
								<th scope="row"><? _e('Enable Shortcodes', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
								<td><input type="checkbox" name="enableShortcodes"<?= ($model['options']['enableShortcodes']) ? ' checked="checked"' : ''; ?>/></td>
							</tr>
						</table>
						<br/>
						<p><input type="submit" name="themingSettingsSubmit" class="button" value="<? _e('Save Changes') ?>"/></p>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>