<? if ($model->url): ?>
<p>
	<label for="rss-url-<?= $model->number; ?>"><?php _e('Enter the RSS feed URL here:'); ?></label>
	<input class="widefat" id="rss-url-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][url]" type="text" value="<?= $model->url; ?>" />
</p>
<? endif; ?>

<? if ($model->title): ?>
<p>
	<label for="rss-title-<?= $model->number; ?>"><?php _e('Give the feed a title (optional):'); ?></label>
	<input class="widefat" id="rss-title-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][title]" type="text" value="<?= $model->title; ?>" />
</p>
<? endif; ?>

<? if ($model->items) : ?>
<p>
	<label for="rss-items-<?= $model->number; ?>"><?php _e('How many items would you like to display?'); ?></label>
	<select id="rss-items-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][items]">
		<? for ( $i = 1; $i <= 20; ++$i ): ?>
			<?= "<option value='$i' " . ( $model->items == $i ? "selected='selected'" : '' ) . ">$i</option>"; ?>
		<? endfor; ?>
	</select>
</p>
<? endif; ?>

<? if ($model->show_summary) : ?>
<p>
	<input id="rss-show-summary-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][show_summary]" type="checkbox" value="1" <?php if ( $model->show_summary ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-summary-<?= $model->number; ?>"><?php _e('Display item content?'); ?></label>
</p>
<? endif; ?>

<? if($model->show_author): ?>
<p>
	<input id="rss-show-author-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][show_author]" type="checkbox" value="1" <?php if ( $model->show_author ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-author-<?= $model->number; ?>"><?php _e('Display item author if available?'); ?></label>
</p>
<? endif; ?>

<? if ($model->show_date) : ?>
<p>
	<input id="rss-show-date-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][show_date]" type="checkbox" value="1" <?php if ( $model->show_date ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-date-<?= $model->number; ?>"><?php _e('Display item date?'); ?></label>
</p>
<? endif; ?>

<? foreach (array_keys($model->default_inputs) as $input): ?>
	<? if ('hidden' === $model->instance[$input]): ?>
		<? $id = str_replace( '_', '-', $input ); ?>
		<input type="hidden" id="rss-<?= $id; ?>-<?= $model->number; ?>" name="widget-rss[<?= $model->number; ?>][<?= $input; ?>]" value="<?= $$input; ?>" />
	<? endif; ?>
<? endforeach; ?>
