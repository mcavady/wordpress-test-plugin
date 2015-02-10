<?php
/**
* Plugin Name: myPlugin
* Plugin URI: http://responsivedeveloper.com
* Description: Testing out plugin headers
* Version: 1.0.0
* Author: James Mcavady
* Author URI: http://responsivedeveloper.com
* Text Domain: 
* Domain Path:
* Network: true
* License: not made yet
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please');//secure that shizzle

//add the option to the admin menu under the settings heading
function display_text() {
	add_options_page('myPlugin', 'My Plugin', 'manage_options', '__FILE__', 'myPlugin_control_options');
}

add_action( 'admin_menu', 'display_text' );

//display the plugin page with the data and options you want
function myPlugin_control_options() {
?>
	<div class="wrap">
		<h4>Find all draft posts</h4>
		<br/>
		<form action="" method="POST" >
			<input type="submit" name="search_draft_posts" value="Find More Drafts" class="button-primary" />
		</form>
		</br>

		<table class="widefat">
			<thead>
				<tr>
					<th> Post Title </th>
					<th> Post ID </th>
				<tr>
			</thead>
			<tfoot>
				<tr>
					<th> Post Title </th>
					<th> Post ID </th>
				<tr>
			</tfoot>
		<tbody>
		<?php
			global $wpdb; //wp DB var as global
			$mytestdrafts = array(); //array for storing the draft data
			if(isset($_POST['search_draft_posts']))
			{
				//mysqlquery
				$mytestdrafts = $wpdb->get_results ("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'draft' ");
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
