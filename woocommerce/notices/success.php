<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="ahidden-notice woocommerce-message "<?php echo wc_get_notice_data_attr( $notice ); ?> role="alert" style="background-color:#baf377;">
		<div class="aflashrow"></div>
		<?php echo wc_kses_notice( $notice['notice'] ); ?>
<?php endforeach; ?></div>