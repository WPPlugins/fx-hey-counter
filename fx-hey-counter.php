<?php
/**
 * @package FX Hey counter
 * @author Aivaras Sondeckis
 * @version 1
 */
/*
Plugin Name: FX HEY counter
Plugin URI: http://www.3Dgrafika.lt
Description: Adds www.hey.lt counter widget. All you need is get your HEY ID on www.hey.lt site and set your ID in widget.
Author: Aivaras Sondeckis
Version: 1.0.3
Author URI: http://www.3Dgrafika.lt/
*/

$heycounter_defaultoptions = array(
	'heycounter-id'		=> 'testid',
	//'enablescript'		=> true
);

// Hey counter code
function heycounter_code() {
	$heycounterOptions = get_heycounter_options();

	$hey_code = '<script language="javascript1.2" type="text/javascript">
<!--
_hey_lt_w = screen.width; _hey_lt_h = screen.height; _hey_lt_c = navigator.appName.indexOf("Microsoft") >= 0 ? screen.colorDepth : screen.pixelDepth;
//-->
</script>
<script language="javascript" type="text/javascript">
<!--
document.write("<a target=\'_blank\' href=\'http://www.hey.lt/details.php?id='.$heycounterOptions['heycounter-id'].'\'><img width=88 height=31 border=0 src=\'//www.hey.lt/count.php?id='.$heycounterOptions['heycounter-id'].'&width=" + _hey_lt_w + "&height=" + _hey_lt_h + "&color=" + _hey_lt_c + "&referer=" + escape(document.referrer) + "\' alt=\'Hey.lt - Nemokamas lankytoju skaitliukas\'><\/a>");
//-->
</script>
<noscript>
<a target="_blank" href="http://www.hey.lt/details.php?id='.$heycounterOptions['heycounter-id'].'"><img width=88 height=31 border=0 src="//www.hey.lt/count.php?id='.$heycounterOptions['heycounter-id'].'" alt="Hey.lt - Nemokamas lankytoju skaitliukas"></a>
</noscript>';

//.$heycounterOptions['heycounter-id'].
	return $hey_code;
}

// get options
function get_heycounter_options()
{
	global $heycounter_defaultoptions;

	$options = get_option('heycounter');
	$options['heycounter-id'] = $options['heycounter-id'] === NULL ? $heycounter_defaultoptions['heycounter-id'] : $options['heycounter-id'];
	//$options['enablescript'] = $options['enablescript'] === NULL ? $heycounter_defaultoptions['enablescript'] : $options['enablescript'];

	return $options;
}



function heycounter_control()
{
	$heycounterOptions = get_heycounter_options();
	
	if (isset($_POST['heycounter-id']))
	{
		$heycounterOptions['heycounter-id'] = strip_tags(stripslashes($_POST['heycounter-id']));
		update_option('heycounter', $heycounterOptions);
	}
	echo '<p style="text-align:right;"><label for="newtagcloud-title">HEY counter ID: <input style="width: 200px;" id="heycounter-id" name="heycounter-id" type="text" value="'.$heycounterOptions['heycounter-id'].'" /></label></p>';
}


// Init widget
function heycounter_init()
{
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
	function print_heycounter() {
		echo heycounter_code();
	}
	register_sidebar_widget(array('FX HEY counter', 'widgets'), 'print_heycounter');
	register_widget_control(array('FX HEY counter', 'widgets'), 'heycounter_control', 50, 10);
}

add_action('widgets_init', 'heycounter_init');

?>
