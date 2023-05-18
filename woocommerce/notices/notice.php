<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
<div class="woocommerce-notices-wrapper ahidden-notice"<?php echo wc_get_notice_data_attr( $notice );?>style="background-color:#6a1b9a;color:white;">
		<div class="aflashrow"></div>
		<?php echo wc_kses_notice( $notice['notice'] ); ?>
	</div>
<?php endforeach; ?>