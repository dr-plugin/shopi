<?php defined( 'ABSPATH' ) || exit;?>

<div class="namecontiner">
<a id="filter-btn" class="ashow-mobile-only"><i class="fas fa-align-right"></i> منو</a>
<span><?php echo $current_user->display_name ; ?></span>
<a href="https://tical.ir/my-account/exit/?_wpnonce=<?php echo wp_create_nonce( 'log-out' ); ?>">
<i class="fas fa-power-off"></i>
</a>
</div>

<?php do_action( 'woocommerce_account_navigation' ); ?>

<div class="woocommerce-MyAccount-content">
<?php do_action( 'woocommerce_account_content' ); ?>
</div>

<br><br>
</div>