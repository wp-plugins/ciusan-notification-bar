<?php 
/*
Plugin Name: Ciusan Notification Bar
Plugin URI: http://plugin.ciusan.com/
Description: Showing information or notes on top bar.
Author: Dannie Herdyawan
Version: 1.0
Author URI: http://www.ciusan.com/
*/

/*
   _____                                                 ___  ___
  /\  __'\                           __                 /\  \/\  \
  \ \ \/\ \     __      ___     ___ /\_\     __         \ \  \_\  \
   \ \ \ \ \  /'__`\  /' _ `\ /` _ `\/\ \  /'__'\        \ \   __  \
    \ \ \_\ \/\ \L\.\_/\ \/\ \/\ \/\ \ \ \/\  __/    ___  \ \  \ \  \
     \ \____/\ \__/.\_\ \_\ \_\ \_\ \_\ \_\ \____\  /\__\  \ \__\/\__\
      \/___/  \/__/\/_/\/_/\/_/\/_/\/_/\/_/\/____/  \/__/   \/__/\/__/

*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function CNB_enqueue() {
	wp_enqueue_style( 'ciusan-notification-bar', plugin_dir_url( __FILE__ ).'assets/css/ciusan-notification-bar.css', false ); 
	wp_enqueue_script( 'ciusan-notification-bar', plugin_dir_url( __FILE__ ).'assets/js/ciusan-notification-bar.js', false );
}
add_action( 'wp_enqueue_scripts', 'CNB_enqueue' );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('ciusan_admin__head')){
	function ciusan_admin__head(){
	wp_register_style('ciusan', plugin_dir_url( __FILE__ ).'assets/css/ciusan.css');
		wp_enqueue_style('ciusan');
	wp_register_script('ciusan', plugin_dir_url( __FILE__ ).'assets/js/ciusan.js');
		wp_enqueue_script('ciusan');
	}
}
function cnb_admin__menu(){
	global $menu;
	$main_menu_exists = false;
	foreach ($menu as $key => $value) {
		if($value[2] == 'ciusan-plugin'){
			$main_menu_exists = true;
		}
	}
	if(!$main_menu_exists){
		$ciusan_menu_icon = plugin_dir_url( __FILE__ ).'assets/img/ciusan.png';
		add_object_page(null, 'Ciusan Plugin', null, 'ciusan-plugin', 'ciusan-plugin', $ciusan_menu_icon);
		add_submenu_page('ciusan-plugin', 'Submit a Donation', 'Submit a Donation', 0, 'submit_donation', 'ciusan_submit_donation');
	}
	add_submenu_page('ciusan-plugin', 'Notification Bar', 'Notification Bar', 1, 'notification_bar','ciusan_notification_Bar');
}
function cnb_admin_init(){
	// Create admin menu and page.
	add_action( 'admin_menu' , 'cnb_admin__menu');
	// Enable admin scripts and styles
	if(function_exists(ciusan_admin__head)){
		add_action( 'admin_enqueue_scripts' , 'ciusan_admin__head');
	}
} add_action('init', 'cnb_admin_init');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require ('admin_menu.php');
function ciusan_notification_bar(){ 
	echo '<div class="wrap"><h2>Ciusan Notification Bar</h2>';
	if (isset($_POST['save'])) {
		$options['CNB_Showing']	= trim($_POST['CNB_Showing'],'{}');
		$options['CNB_FixedBar']= trim($_POST['CNB_FixedBar'],'{}');

		$pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
//		$options['CNB_Content']	= preg_replace($pattern, esc_url('$1'), $_POST['CNB_Content']);

		$options['CNB_Content']	= $_POST['CNB_Content'];
		$options['CNB_BName']	= trim($_POST['CNB_BName'],'{}');
		$options['CNB_BLink']	= esc_url($_POST['CNB_BLink']);

		update_option('ciusan_notification_bar', $options);
		// Show a message to say we've done something
		echo '<div class="updated ciusan-success-messages"><p><strong>'. __("Settings saved.", "Ciusan").'</strong></p></div>';
	} else {
		$options = get_option('ciusan_notification_bar');
	}
	echo CiusanNotificationBar_Settings();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function CiusanNotificationBar(){ global $options; $options = get_option('ciusan_notification_bar');
	if($options['CNB_Showing']=='yes'){ ?>
	<!-- Ciusan Notification Bar -->
	<div class="ciusan-notification-bar" style=" <?php if($options[CNB_FixedBar]=='yes'){echo 'position: fixed;';}elseif($options[CNB_FixedBar] == 'no'){echo 'position: absolute;'; } ?>!important;">
		<input id="hide" type="radio" name="bar" value="hide">
		<input id="show" type="radio" name="bar" value="show" checked="checked">
		
		<label for="hide">hide</label>
		<label for="show">show</label>
		
		<div class="ciusan-notification-text">
			<?php echo $options['CNB_Content']; ?>
			<?php if(isset($options[CNB_BName]) && isset($options[CNB_BLink])){ ?>
				<a class="button black-stripe" href="<?php echo $options[CNB_BLink]; ?>">
					<?php echo $options[CNB_BName]; ?>
				</a>
			<?php } ?>
		</div>
	</div>
	<!-- Ciusan Notification Bar -->
<?php }}add_action( 'wp_head', 'CiusanNotificationBar' ); ?>