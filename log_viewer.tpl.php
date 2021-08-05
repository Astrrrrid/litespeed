<?php
namespace LiteSpeed;
defined( 'WPINC' ) || exit;
$log_list = array(
	'debug'	=> __( 'Debug Log', 'litespeed-cache' ),
	'crawler'	=> __( 'Crawler Log', 'litespeed-cache' ),
	'purge'	=> __( 'Purge Log', 'litespeed-cache' ),
);



if ( isset( $_GET['log_type'] ) ) {
	$log_type = $_GET['log_type'];
	setcookie( 'litespeed_log_view' , $log_type );
} else if ( isset( $_COOKIE['litespeed_log_view'] ) ) {
	$log_type = $_COOKIE['litespeed_log_view'];
} else {
	$log_type = 'debug';
}

if ( $log_type === 'purge' ) {
	$file = LSCWP_CONTENT_DIR . '/debug.purge.log';
} else if ( $log_type === 'crawler' ) {
	$file = LSCWP_CONTENT_DIR . '/crawler.log';
} else {
	$file = LSCWP_CONTENT_DIR . '/debug.log';
}
?>


	<div class='nav-bar'>
		<?php
			foreach ( $log_list as $tab => $val ) {
				$str = admin_url( 'admin.php?page=litespeed-toolbox&log_type='.$tab.'#log_viewer');
				echo "<a href=\"" . $str . "\" class='tablinks' data-litespeed_log_tab='$tab'>$val</a>";
			}
		?>
	</div>



<h3 class="litespeed-title">
	<?php echo __($log_list[$log_type], 'litespeed-cache'); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/toolbox/#log-view-tab' ); ?>
	<a href="<?php echo Utility::build_url( Router::ACTION_DEBUG2, Debug2::TYPE_CLEAR_LOG ); ?>" class="button button-primary" litespeed-accesskey='D'>
		<?php echo __( 'Clear Log', 'litespeed-cache' ); ?>
	</a>
</h3>
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



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js "></script>
<script>


// function showLog(evt, type) {
//   var i, tabcontent, tablinks;
//   tabcontent = document.getElementsByClassName("tabcontent");
//   for (i = 0; i < tabcontent.length; i++) {
//     tabcontent[i].style.display = "none";
//   }
//   tablinks = document.getElementsByClassName("tablinks");
//   for (i = 0; i < tablinks.length; i++) {
//     tablinks[i].className = tablinks[i].className.replace(" active", "");
//   }
//   // document.querySelectorAll('[data-litespeed_log_tab="type"]').style.display = "block";
//   document.getElementById(type).style.display = "block";
//   evt.currentTarget.className += " active";
// }

// jQuery(document).ready( function () {
// 	var litespeed_log_view_current = document.cookie;
// 	let searchParam = new URLSearchParams(window.location.search);
// 	console.log( searchParam.has('log_type') );
// 	let param = searchParam.get('log_type');
// 	if( searchParam.has('log_type') ) {
// 		litespeed_log_view_current = param;
// 	}
// 	if( !litespeed_log_view_current || !$('[data-litespeed_log_tab="'+litespeed_log_view_current+'"]').length) {
// 		litespeed_log_view_current = $('[data-litespeed_log_tab]').first().data('litespeed-tab1') ;
// 	}
// 	$('[data-litespeed_log_tab]').on( 'click', function(event) {
// 		document.cookie = 'litespeed_log_view='+$(this).data('litespeed-tab1') ;
// 		$(this).blur() ;
// 	});
// } );

</script>
<style type="text/css">
	.nav-bar {
		font-size:  1.3em;
		/*color: #1d2327;*/
		font-family:  -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
		color: #3c434a;
		font-weight: 600;
		margin: 1.5em 0px 3.5em 0;
		line-height: inherit;

		padding-right:  50px;
		padding-left: 3px;
		padding-top: 5px;
	}
	/* Style the tab */
	.tablinks {
	  overflow: hidden;
	  /*border: 1px solid #ccc;*/
	  background-color: #f1f1f1;
	}

	/* Style the buttons that are used to open the tab content */
	.tablinks {
	  background-color: inherit;

	  outline: none;
	  cursor: pointer;
	  transition: 0.3s;
	}

	/* Change background color of buttons on hover */
	.tablinks:hover {
	  /*background-color: #ddd;*/
	}

	/* Create an active/current tablink class */
	.tablinks a.active {
	  background-color: #36b0b0;
	}

	/* Style the tab content */
	.tabcontent {
	  display: none;
	  padding: 6px 12px;
	  border: 1px solid #ccc;
	  border-top: none;
	}

	.litespeed-tab1 {
	  position: sticky;
	  left: 200px;
	  top: 150px;
	  margin: 25px 0;
	  display: flex;
      align-items: flex-start;
	}
	.tablinks {
	  float: left;
	}
	.tablinks {
	  /*background: #eee;*/
	  padding: 10px;
	  /*border: 1px solid #ccc;*/
	  margin-left: -1px;
	  position: relative;
	  left: 1px;
	}
	a {
		color: #3c434a;
		text-decoration: none;
	}

</style>