<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<h4>پیشخوان</h4>
<p>
تیکالی عزیز به صفحه حساب کاربری خود خوش آمدید ،
برای رفتن به هر بخش روی منو کلیک کنید
</p>
در قسمت لینک بازاریابی می‌توانید با دریافت لینک مخصوص به خود و ارسال آن برای دیگران 
از خرید انها پورسانت دریافت نمایید

<?php
	do_action( 'woocommerce_account_dashboard' );
	do_action( 'woocommerce_before_my_account' );
	do_action( 'woocommerce_after_my_account' );