<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title_link)) echo '<a href="' . $model->title_link . '">' ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title_link)) echo '</a>' ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<ul>
<? foreach ($model->categories as $category): ?>
	<li>
		<a href="<?= get_category_link($category->cat_ID) ?>"><?= $category->name ?></a>
		<? if ($model->show_post_count) echo '<span class="categoryCounts">' . $category->count . '</span>' ?>
	</li>
<? endforeach; ?>
</ul>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>