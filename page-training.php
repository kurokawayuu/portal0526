<?php //トップページ用 ?><?php get_header(); ?>
<!DOCTYPE html>
<html>
<head>
<title></title>

</head>
	
<body>

<div class="report-inner">				
<div class="under-inner">
<?php echo do_shortcode('[contact-form-7 id="389f653" title="FC研修受講記録提出"]'); ?>
	</div>
</div>
<h1 class="h1-order"><?php echo esc_html($nickname); ?>のFC研修受講状況一覧</h1><br>
<?php echo do_shortcode('[flamingo_training_submissions] '); ?>
<br><br>
</body>	

<?php get_footer(); ?>

</html>
