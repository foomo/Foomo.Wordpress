<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<ul>
	<?
	foreach ($model->rss->get_items(0, $model->items) as $item ) {
		$link = $item->get_link();
		while (stristr($link, 'http') != $link) $link = substr($link, 1);
		$link = esc_url(strip_tags($link));
		$title = esc_attr(strip_tags($item->get_title()));
		if (empty($title)) $title = __('Untitled');
		$desc = str_replace( array("\n", "\r"), ' ', esc_attr(strip_tags(@html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset')))));
		$desc = wp_html_excerpt( $desc, 360 );

		// Append ellipsis. Change existing [...] to [&hellip;].
		if ('[...]' == substr( $desc, -5 )) {
			$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
		} elseif ('[&hellip;]' != substr( $desc, -10 )) {
			$desc .= ' [&hellip;]';
		}

		$desc = esc_html( $desc );

		$summary = ($model->show_summary) ? "<div class='rssSummary'>$desc</div>" : '';

		$date = '';
		if ($model->show_date) {
			$date = $item->get_date( 'U' );
			if ($date) $date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
		}

		$author = '';
		if ($model->show_author) {
			$author = $item->get_author();
			if (is_object($author)) {
				$author = $author->get_name();
				$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
			}
		}

		if ($link == '') {
			echo "<li>$title{$date}{$summary}{$author}</li>";
		} else {
			echo "<li><a class='rsswidget' href='$link' title='$desc'>$title</a>{$date}{$summary}{$author}</li>";
		}
	}
	?>
</ul>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>