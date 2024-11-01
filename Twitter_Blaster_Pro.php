<?php
/*
Plugin Name: Twitter Blaster Pro Beta
Plugin URI: http://MyBlogIt.net/plugins
Description: Allow your visitor the ability to post to your Twitter.
Version: 0.5
Author: David Span
Author URI: http://davidspan.com/
*/



/*  Copyright 2008  David Span  (email :davidwspan@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
add_action('admin_menu', 'TB_my_magic_function');


function TB_my_magic_function(){
add_submenu_page('options-general.php', 'Twitter Blaster', 'Twitter Blaster', 10, __FILE__, 'TB_display_magic_function');

}

function TB_display_magic_function(){

echo '<div class="wrap"><h2>Twitter Blaster</h2>';

if(isset($_POST['update_twitter'])){

	// set vars
	$TBuser = $_POST['TBuser'];
	$TBpassword = $_POST['TBpassword'];
	$Post_Twist = $_POST['Post_Twist'];
update_option("TBuser", $TBuser);
update_option("TBpassword", $TBpassword);
update_option("Post_Twist", $Post_Twist);


        }

		$Display_TBusename = get_option("TBuser");
		$Dispaly_TBPassword = get_option("TBpassword");


?>

<h3>Directions</h3>
		<p>Entire your Twitter username and password below.</p> <p>Add this code &lt;?php TB_Twitt4me(); ?&gt; to the theme where you would like it your user to twitt from. The best place to put it would be in your theme's index.php file right above &lt;?php if (have_posts()) : ?&gt;</p><p>
		A good place to see this plugin in use would be <a href="http://onlinebarterclub.com/">OnlineBarterClub</a></p>
<form action="" method="post" name="update_twitter" id="adduser" class="add:users: validate">
<inputt type="hidden" id="_wpnonce" name="do" value="update_user" />
<table class="form-table">
	<tr class="form-field form">
		<th scope="row">Twitter Username(required)</th>
		<td ><input name="TBuser" type="text"  value="<?PHP echo $Display_TBusename; ?>" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row">Twitter Password (required)</th>
		<td><input name="TBpassword" type="text"  value="<?PHP echo $Dispaly_TBPassword; ?>" /></td>
	</tr>
		<tr class="form-field">
		<th scope="row">Post Twitts as Post (required)</th>
		<td><select name="Post_Twist" id="Post_Twist" >
					<option value="yes">Yes</option>
					<option value="no">No</option>
					
				</select></td>
	</tr>

</table>
<p class="submit">
		<input name="update_twitter" type="submit" id="addusersub" value="update_twitter" />
</p>
</form>

<p>Stay up to date.</p>
				<iframe id="ak_readme" src="http://myblogit.net/2008/05/09/wordpress-plugin-twitter-blaster/" style="height:300px; width: 95%;"></iframe>
			</div>



<?php


echo '</div>';

}

function TB_Twitt4me(){
echo '

<center>Update My Twitter:<form method=post action="">
	<textarea name="message" rows="2" cols="40" style="height: 2.5em; width: 400px; padding: 5px; font: 1.15em/1.1 \'Lucida Grande\', sans-serif; overflow: auto;"></textarea><br><input type="submit" name="submit" value="Update" style="background-color: #E6E6E6; border: 1px solid #ccc; padding:5px; font-size: 1em; margin-left:5px; width:50px;">
</form></center>';

if(isset($_POST['message'])){
if(($_POST['message'])===''){
	echo 'Your empty post is indeed truly empty!';
}else{

	$message = $_POST['message'];
	


// add post to blog
include_once(ABSPATH . 'wp-includes/post.php');
global $wpdb;
// create post object

class wm_mypost {
    var $post_title;
    var $post_content;
    var $post_status;
    var $post_author;    /* author user id (optional) */
    var $post_name;      /* slug (optional) */
    var $post_type;      /* 'page' or 'post' (optional, defaults to 'post') */
    var $comment_status; /* open or closed for commenting (optional) */
}

// initialize post object
$wm_mypost = new wm_mypost();

// fill object
$wm_mypost->post_title = $message;
$wm_mypost->post_content = $message;
$wm_mypost->post_status = 'pending';
$wm_mypost->post_author = 1;

// Optional; uncomment as needed
// $wm_mypost->post_type = 'page';
// $wm_mypost->comment_status = 'closed';

// feed object to wp_insert_post
wp_insert_post($wm_mypost);

echo 'Your post is pending review.';
}
}
}


add_action('admin_notices', 'TB_warning');

function TB_warning(){


	if ( !get_option('TBuser')){
echo "
		<div id='warning' class='updated fade'><p><strong>".__('Twitter Blaster is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Twitter Username & Password</a> for it to work.'), "options-general.php?page=Twitter_Blaster_Pro.php")."</p></div>
		";
	}
}


//manage twits
add_action('admin_menu', 'TB_Modarate');

function TB_Modarate(){
add_submenu_page('edit.php', 'Twitter Blaster', 'Twitter Blaster', 10, __FILE__, 'TB_display_Modarate');

}

function TB_display_Modarate(){
?>
<div class="wrap"><h2>Twitter Blaster</h2>
<?php
if(isset($_GET['Approve'])){
if($_GET['Approve']=='y'){

//logic get post from id set post 

    //$recentPosts = new WP_Query();
    //$recentPosts->query('post_status=pending');

// while ($recentPosts->have_posts()) : $recentPosts->the_post();

//get_post($_GET['My_Id'])
//$message = the_content($_GET['My_Id']);

$Post_Twist = get_option("Post_Twist");
if ($Post_Twist == "yes"){
		//echo $_GET['My_ID'];
		$post['ID'] = $_GET['My_ID'];
		$post['post_status'] = 'publish';
		 wp_update_post($post);
			}ELSE{
				$post['ID'] = $_GET['My_ID'];
				wp_delete_post($_GET['My_ID']);
			}
//endwhile; 


$post_id_7 = get_post($_GET['My_ID']); 
$message = $post_id_7->post_content;

//get_post($_GET['My_ID'])


//$message = the_content($_GET['My_ID']);

	//$message = $_POST['message'];
	$Display_TBusename = get_option("TBuser");
	$Dispaly_TBPassword = get_option("TBpassword");

  //start curl call

$url = 'http://twitter.com/statuses/update.xml';

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "$url");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
curl_setopt($curl_handle, CURLOPT_USERPWD, "$Display_TBusename:$Dispaly_TBPassword");
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);
// check for success or failure
if (empty($buffer)) {
    echo 'fail';
} else {
echo 'Twitt Submitted';
}


}
if($_GET['Approve']=='n'){

$post['ID'] = $_GET['My_ID'];
wp_delete_post($_GET['My_ID']);



}
}
?>

<ul>
<?php
    $recentPosts = new WP_Query();
    $recentPosts->query('post_status=pending');
?>
<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
    <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>&nbsp;&nbsp;<?php edit_post_link('Edit'); ?>&nbsp;&nbsp;&nbsp;<a href="?page=Twitter_Blaster_Pro.php&Approve=y&My_ID=<?php the_id(); ?>">Approve</a>&nbsp;&nbsp;&nbsp;<a href="?page=Twitter_Blaster_Pro.php&Approve=n&My_ID=<?php the_id(); ?>">Deny/Delete</a></li>
<?php endwhile; ?>
</ul>
</div>

<?
}
?>