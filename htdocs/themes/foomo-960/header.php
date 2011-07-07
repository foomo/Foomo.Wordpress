<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="de" dir="ltr" class="no-js ie ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="de" dir="ltr" class="no-js ie ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="de" dir="ltr" class="no-js ie ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="de" dir="ltr" class="no-js ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <? language_attributes(); ?> dir="ltr" class="no-js"> <!--<![endif]-->
<head>
<title dir="ltr"><? foomo_get_title() ?></title>
<meta name="title" content="<? foomo_get_title() ?>"></title>
<meta charset="<? bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="all" href="<? bloginfo('stylesheet_url'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<? bloginfo('pingback_url'); ?>" />
<? wp_head(); ?>
</head>
<body <? body_class(); ?>>
<div id="wrapper">

	<? get_template_part('header', 'above'); ?>

	<div id="header">
		<? get_template_part('header', 'content'); ?>
	</div>

	<? get_template_part('header', 'below'); ?>

	<div id="main">

