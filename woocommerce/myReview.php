<?php
defined( 'ABSPATH' ) || exit;
global $product;
//$comment_form['comment_field'] 
?>

<ul class="feedback">
    <li class="angry" value="1">
        <div>
            <svg class="eye left">
                <use xlink:href="#eye">
            </svg>
            <svg class="eye right">
                <use xlink:href="#eye">
            </svg>
            <svg class="mouth">
                <use xlink:href="#mouth">
            </svg>
        </div>
    </li>
    <li class="sad" value="2">
        <div>
            <svg class="eye left">
                <use xlink:href="#eye">
            </svg>
            <svg class="eye right">
                <use xlink:href="#eye">
            </svg>
            <svg class="mouth">
                <use xlink:href="#mouth">
            </svg>
        </div>
    </li>
    <li class="ok" value="3">
        <div></div>
    </li>
    <li class="good" value="4">
        <div>
            <svg class="eye left">
                <use xlink:href="#eye">
            </svg>
            <svg class="eye right">
                <use xlink:href="#eye">
            </svg>
            <svg class="mouth">
                <use xlink:href="#mouth">
            </svg>
        </div>
    </li>
    <li class="happy" value="5">
        <div>
            <svg class="eye left">
                <use xlink:href="#eye">
            </svg>
            <svg class="eye right">
                <use xlink:href="#eye">
            </svg>
        </div>
    </li>
</ul>
        
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
    </symbol>
</svg>


<script>
jQuery(document).ready(function ($) {
	$('.feedback').on("click" , "li" ,function(e){
		e.preventDefault();// این دستور کلیه فرمان پیش فرض دکمه را غیر فعال میکند
		if(!$(this).hasClass('active')) {
       		$('.feedback li.active').removeClass('active');
      	  	$(this).addClass('active');
  		}
		var myval = $(this).attr("value");

		// $('.stars').addClass('selected');

		// if($('.stars a').hasClass('active'))
		// 	$('.stars a').removeClass('active');

		// if( myval == 1)
		// 	$('.star-1').addClass('active');

		// if(myval == 2)
		// 	$('.star-2').addClass('active');

		// if(myval == 3)
		// 	$('.star-3').addClass('active');

		// if(myval == 4)
		// 	$('.star-4').addClass('active');

		// if(myval == 5)
		// 	$('.star-5').addClass('active');

		$("#rating").val(myval);

	});

});
</script>