// code here will run after page loaded (or called dom.ready)
jQuery(document).ready(function($) {
// $(function(){
//	console.log("ready!");
//});
	// this is JS comment
	// $('#easy_gdpr_btn2').click( abc );
	$('#easy_gdpr_btn2').click( abc );
	function abc(){
		// 1st step
		$('.easy_gdpr_banner').fadeOut();
		// 2nd step: save cookie
		easy_gdpr_setcookie( 'gdpr_yummy_cookie', 'accepted! cheers!', 14 );
	}
	function easy_gdpr_setcookie(cname, cvalue, exdays) {
		console.log( 'gdpr_setcookie is called' );
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	// my_func_in_blahblah_file(); // <--- this is just to show why we need to jq.ready wrapper (@Alice)
	$('#easy_gdpr_btn3').click( closeIt );
	function closeIt(){
		// 1st step
		$('.easy_gdpr_banner').fadeOut();
		// 2nd step: save cookie
		easy_gdpr_setcookie( 'gdpr_yummy_cookie', 'GDPR rejected', 14 );
	}
	function easy_gdpr_setcookie(cname, cvalue, exdays) {
		console.log( 'gdpr_setcookie is called' );
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

});