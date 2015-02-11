<?php
/**
* Plugin Name: Product Data Plugin
* Plugin URI: http://responsivedeveloper.com
* Description: Post Data plugin - show all posts and data about them
* Version: 1.0.0
* Author: James Mcavady - Responsive Developer
* Author URI: http://responsivedeveloper.com
* Text Domain:
* Domain Path:
* Network: true
* License: not made yet do what you wish ;)
*/

/* Version Check */

global $wp_version;
$exit_msg='';
if (version_compare($wp_version,"4.1","<"))
{
	exit ($exit_msg . "Please use wordpress version 4.1 and up");
}

defined( 'ABSPATH' ) or die( 'No script kiddies please');//secure that shizzle

/* === Plugin Start === */

//add the option to the admin menu under the settings heading
function display_text() {
	add_options_page('myPlugin', 'Simple Product Data', 'manage_options', '__FILE__', 'myPlugin_control_options');
}
add_action( 'admin_menu', 'display_text' );

//display the plugin page with the data and options you want
function myPlugin_control_options() {
?>
	<div class="wrap">
		<h4>Find All Products</h4>
		<br/>
		<form action="" method="POST" >
			<input type="submit" name="search_draft_posts" value="Resfresh Product Data" class="button-primary" />
		</form>
		</br>
		<table class="widefat">
			<thead>
				<tr>
					<th> Product Title </th>
					<th> Product ID </th>
					<th> Product Date </th>
					<th> Product Status </th>
					<th> Product Content </th>
					<th> Product Comment Status</th>
					<th> Product Author </th>
					<th> Product Link </th>
				<tr>
			</thead>
			<tfoot>
				<tr>
					<th> Product Title </th>
					<th> Product ID </th>
					<th> Product Date </th>
					<th> Product Status </th>
					<th> Product Content </th>
					<th> Product Comment Status</th>
					<th> Product Author </th>
					<th> Product Link </th>
				<tr>
			</tfoot>
		<tbody>
		<?php
			global $wpdb; //wp DB var as global
			$mytestdrafts = array(); //array for storing the draft data
			if(isset($_POST['search_draft_posts']))
			{
				//mysqlquery
				$mytestdrafts = $wpdb->get_results ("SELECT ID, post_title, post_date, post_status, post_content, post_author, comment_status, guid FROM $wpdb->posts WHERE post_type = 'product'");
				//store the data from this qeury in the wp option so that the results display if this query has been run before
				update_option('mytestdrafts_draft_posts', $mytestdrafts);
			}
			else if (get_option('mytestdrafts_draft_posts'))//if the option has data then set the array with it
			{
				$mytestdrafts = get_option('mytestdrafts_draft_posts');
			}
			foreach($mytestdrafts as $mytestdraft)//loop through and display the data from the array for each match
			{
		?>
			<tr>
			<?php
				echo"<td>".$mytestdraft->post_title."</td>";
				echo"<td>".$mytestdraft->ID."</td>";
				echo"<td>".$mytestdraft->post_date."</td>";
				echo"<td>".$mytestdraft->post_status."</td>";
				echo"<td>".$mytestdraft->post_content."</td>";
				echo"<td>".$mytestdraft->comment_status."</td>";
				echo"<td>".$mytestdraft->post_author."</td>";
				echo"<td><a href='" .$mytestdraft->guid. "'>Go to Product</a></td>";
			?>
			</tr>
			<?php
			}
			?>

		</tbody>
	<div>
<?php
}
?>
