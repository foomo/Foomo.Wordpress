<? if (isset($model->before_widget)) echo $model->before_widget; ?>
<? if (!empty($model->title) && isset($model->before_title)) echo $model->before_title; ?>
<? if (!empty($model->title)) echo $model->title; ?>
<? if (!empty($model->title) && isset($model->after_title)) echo $model->after_title; ?>
<ul>
	<? while ($model->r->have_posts()) : $model->r->the_post(); ?>
		<li>
			<a href="<? the_permalink() ?>" title="<?= esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><? (get_the_title()) ? the_title() : the_ID(); ?></a>
		</li>
	<? endwhile; ?>
</ul>
<? if (isset($model->after_widget)) echo $model->after_widget; ?>