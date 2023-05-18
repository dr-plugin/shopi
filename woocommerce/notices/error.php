<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $notices ) {
	return;
}
?>
<ul class="ahidden-notice woocommerce-error" style="background-color:#ffc269;">
	<div class="aflashrow"></div>
	<div>
		<?php foreach ( $notices as $notice ) : ?>
		<li>
			<?php echo wc_kses_notice( $notice['notice'] ); ?>
		</li>
		<?php endforeach; ?>
	</div>
</ul>