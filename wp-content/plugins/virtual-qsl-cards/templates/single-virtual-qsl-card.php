<?php

$args = [
	'post_type' => 'virtual-qso-card',
	'posts_per_page' => 10,
];
$loop = new WP_Query($args);
while ($loop->have_posts()) {
	$loop->the_post();

	$post_meta = get_post_meta( get_the_ID() );
	$your_call_sign = $post_meta['_vqslc_your_call_sign'][0];
	$your_name_and_address = $post_meta['_vqslc_your_name_and_address'][0];
	$contacted_station_call_sign = $post_meta['_vqslc_contacted_station_call_sign'][0];
	$qsl_date = $post_meta['_vqslc_qsl_date'][0];
	$qsl_time = $post_meta['_vqslc_qsl_time'][0];
	$qsl_frequency_or_band = $post_meta['_vqslc_qsl_frequency_or_band'][0];
	$qsl_mode = $post_meta['_vqslc_qsl_mode'][0];
	$qsl_rst = $post_meta['_vqslc_qsl_rst'][0];
	$qsl_message = $post_meta['_vqslc_qsl_message'][0];
	?>
	<div>
		<?php echo $your_call_sign; ?> - <?php echo $contacted_station_call_sign; ?><br />
		<?php echo $qsl_date; ?> - <?php echo $qsl_time; ?> via <?php echo $qsl_frequency_or_band; ?> <?php echo $qsl_mode; ?><br />
		RST: <?php echo $qsl_rst; ?><br />
		<?php echo $qsl_message; ?>
	</div>
	<?php
}
