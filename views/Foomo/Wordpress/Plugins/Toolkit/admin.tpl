<div class="wrap">
	<h2><?= \Foomo\Wordpress\Plugins\Toolkit::NAME; ?></h2>

	<? if (isset($model['message'])): ?>
		<div style="border:2px solid #cc0000; padding:8px; font-weight:bold; margin:10px;"><?= $model['message']; ?></div>
	<? endif; ?>

	<h3><? _e('Admin Settings', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></h3>

	<table class="widefat">
		<thead>
			<tr>
				<th><? _e('Disable Updates', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<form method="post" action="">
						<table class="form-table">
							<tr>
								<th scope="row"><? _e('Disable Core Updates', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
								<td><input type="checkbox" name="coreUpdatesDisabled"<?= ($model['options']['coreUpdatesDisabled']) ? ' checked="checked"' : ''; ?>/></td>
							</tr>
							<tr>
								<th scope="row"><? _e('Disable Plugin Updates', \Foomo\Wordpress\Plugins\Toolkit::ID); ?></th>
								<td><input type="checkbox" name="pluginUpdatesDisabled"<?= ($model['options']['pluginUpdatesDisabled']) ? ' checked="checked"' : ''; ?>/></td>
							</tr>
						</table>
						<br/>
						<p><input type="submit" name="disableUpdatesSubmit" class="button" value="<? _e('Save Changes') ?>"/></p>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>