<?php
namespace LiteSpeed;
defined( 'WPINC' ) || exit;
$log_list = array(
	'debug'	=> __( 'Debug Log', 'litespeed-cache' ),
	'crawler'	=> __( 'Crawler Log', 'litespeed-cache' ),
	'purge'	=> __( 'Purge Log', 'litespeed-cache' ),
);

if ( isset( $_GET[ 'log_type' ] ) ) {
	$log_type = $_GET[ 'log_type' ];
	setcookie( 'litespeed_log_view' , $log_type );
} else if ( isset( $_COOKIE[ 'litespeed_log_view' ] ) ) {
	$log_type = $_COOKIE[ 'litespeed_log_view' ];
} else {
	$log_type = 'debug';
}
?>

<h3 class="litespeed-title">
	<?php echo __($log_list[$log_type], 'litespeed-cache'); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/toolbox/#log-view-tab' ); ?>
	<a href="<?php echo Utility::build_url( Router::ACTION_DEBUG2, Debug2::TYPE_CLEAR_LOG ); ?>" class="button button-primary" litespeed-accesskey='D'>
		<?php echo __( 'Clear Log', 'litespeed-cache' ); ?>
	</a>
</h3>
<div class='nav-bar'>
	<?php
		foreach ( $log_list as $tab => $val ) {
			$str = admin_url( 'admin.php?page=litespeed-toolbox&log_type='.$tab.'#log_viewer');
			echo "<a href=\"" . $str . "\" class='tablinks' data-litespeed_log_tab='$tab'>$val</a>";
		}
	?>
	<div id='js-pointer' class='pointer'></div>
</div>
<script>
	const pointer = document.querySelector( '.pointer' );
	var links = document.getElementsByClassName( 'tablinks' );
	var tab_widths = [];
	for( var i = 0; i < links.length; i++ ){
		var current = links[i];
		tab_widths[i] = current.offsetWidth + 37;
		// var ele_width = current.offsetWidth;
		current.dataset.order = i * 110 + "%";
		current.addEventListener( "mouseover" , movePointer );
		pointer.style.width = tab_widths[i] + 'px';
	}

	function movePointer( e ) {
		var order = e.currentTarget.dataset.order;
		pointer.style.transform = "translate3d(" + order + ",0,0)";
	}

	jQuery( document ).ready( function () {
		$( "[data-litespeed-layout='log_viewer']" ).css( 'position', 'relative' );
		<?php
			echo "$( \"[ data-litespeed_log_tab = '" . $log_type . "' ]\" ).css('color', '#1B9292');";
			if ( $log_type === 'purge' ) {
				$index = 2;
				echo "pointer.style.transform = \"translate3d(\" + links[2].dataset.order + \",0,0)\";";
				$file = LSCWP_CONTENT_DIR . '/debug.purge.log';
			} else if ( $log_type === 'crawler' ) {
				$index = 1;
				echo "pointer.style.transform = \"translate3d(\" + links[1].dataset.order + \",0,0)\";";
				$file = LSCWP_CONTENT_DIR . '/crawler.log';
			} else {
				$index = 0;
				$file = LSCWP_CONTENT_DIR . '/debug.log';
			}
		?>
		$( '.nav-bar' ).mouseout( function( ) {
			pointer.style.transform = "translate3d(" + links[<?php echo $index; ?>].dataset.order + ",0,0)";
		});
	} ); // end jquery wraper
</script>
<?php
	$lines = File::count_lines( $file );
	$start = $lines > 1000 ? $lines - 1000 : 0;
	$logs = File::read( $file, $start );
	$logs = $logs ? implode( "\n", $logs ) : '';

	echo nl2br( htmlspecialchars( $logs ) );
?>
<a href="<?php echo Utility::build_url( Router::ACTION_DEBUG2, Debug2::TYPE_CLEAR_LOG ); ?>" class="button button-primary">
	<?php echo __( 'Clear Log', 'litespeed-cache' ); ?>
</a>
<!-- <link rel="stylesheet/less" href="~/Downloads/Ferrous/wp-content/plugins/litespeed-cache/tpl/toolbox/navbar.scss" /> -->
<style type= "text/css" >
.position {
	position: relative;
}

.my_container {
	display: flex;
	justify-content: space-between;
	flex-wrap: nowrap;
	align-items: flex-end;
}

.nav-bar {
/*	text-align: right;
	float: right;*/
	font-size:  1.3em;
	font-family:  -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
	color: #528ac6;
	font-weight: 600;
	/*margin: 3em 12em 1em 3em;*/
	line-height: inherit;
	padding-right:  5em;
	padding-left: 20px;
	/*padding-top: 5px;*/
	white-space: nowrap;
	position: absolute;
	right: 0;
	top: 0;
}

.tablinks {
	overflow: hidden;
	text-align: center;
	background-color: inherit;
	outline: none;
	cursor: pointer;
	transition: 0.3s;
	padding: 10px;
	margin-left: -1px;
	position: relative;
	left: 1px;
}

.tablinks:hover {
	/*color: #36b0b0;*/
	/*text-decoration: underline;*/
	text-shadow: #135e96;
}

.tablinks:active {
	color: 1px 1px #36b0b0;
}

a {
	/*color: #528ac6;*/
	text-decoration: none;
}

.pointer {
	z-index: 1;
	margin-top: 0.3em;
	margin-left: 0.2em;
	top: 0.6em;
	left: 1em;
	background-color: #36b0b0;
	height: 0.25em;
	transition: transform 0.25s ease-in-out;
	border-radius: 0.3em;
	will-change: transform;
	backface-visibility: hidden;

}
</style>