<?php
/*
Plugin Name: Announcements!
Plugin URI: http://www.codeoncall.com
Description: Schedule announcements to appear in a Widget or Shortcode on specific dates. Great for sales and event announcements or holiday and birthday greetings.
Author: Jerry Gonzalez
Version: 1.5.6
Author URI: http://www.codeoncall.com
Copyright 2012 Announcements! (email : jerry@codeoncall.com)
*/
//Activation 
	global $wpdb;
	$wpdb->show_errors();
	register_activation_hook( __FILE__, 'announcementPlugin_activate' );
	register_uninstall_hook( __FILE__, 'pluginUninstall' );
	$wpdb->hide_errors();
	global $aatable;
	$aatable = $wpdb->prefix."announcementplugin";
		
//Create Table if it does not exist
	function announcementPlugin_activate(){
		global $wpdb;
		global $aatable;
		$sql = "CREATE TABLE $aatable (`ID` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, `title` TEXT NOT NULL, `body` TEXT NOT NULL, `startdate` DATE NOT NULL, `enddate` DATE NOT NULL, `annual` TEXT NOT NULL, `weekdaystart` TEXT NOT NULL, `weekdayduration` TEXT NOT NULL, `monthlyslot` TEXT NOT NULL, `monthlyday` TEXT NOT NULL, `monthlyduration` TEXT NOT NULL, `order` INT NOT NULL) ENGINE = MyISAM;";
		createAATable($aatable, $sql); 
	}

	//See if table exists
	function createAATable($theTable, $sql){
	    global $wpdb;
	    if($wpdb->get_var("show tables like '". $theTable . "'") != $theTable) { 
		$wpdb->query($sql); 
	    }
	}
	
//Uninstall db and delete options upon delete
	function pluginUninstall() {
		global $wpdb;
		global $aatable;
		$wpdb->query("DROP TABLE IF EXISTS $aatable");
		delete_option('announcementPlugin_class');
		delete_option('announcementPlugin_tagopen');
		delete_option('announcementPlugin_tagclose');
	}

//Local Time
	global $wp_locale;
	$getdate=get_option('date_format');
	$gettime=get_option('time_format');
	$dateformat=date_i18n($getdate,strtotime("11/15-1976"));
	$timeformat=date_i18n($gettime,strtotime("11/15-1976"));
	$thedate = date('Y-m-d', strtotime($dateformat));
	




//Admin Section

//Create Admin Menu

	add_action('admin_menu', 'announcementPluginAdminMenu');
	add_filter( 'disable_captions', create_function('$a', 'return true;') );

	function announcementPluginAdminMenu() {

		$appName = 'Announcements!';
		$appID = 'announcementplugin';
		add_menu_page($appName, $appName, 'administrator', $appID . '-top-level', 'announcementPluginAdminScreen');

	}

//Page you see in admin section
	function announcementPluginAdminScreen() {

//Register scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		wp_enqueue_script('announcements-js',plugins_url('/announcements-js.js', __FILE__));
		wp_enqueue_style('announcements-css',plugins_url('/announcements-css.css', __FILE__));
//Set time		
		global $thedate;
		global $timeformat;
	?>
		<div class='wrap'>
		<h2>Announcements! - Display announcements in a widget or shortcode.</h2>
		<div id="message" class="updated" style="margin:0 0 10px 0;<?php if(!isset($_REQUEST['feedback']) || isset($_REQUEST['submite'])){echo 'display:none';} ?>"><p>Action Completed</p></div>
		<a href="<?php echo plugins_url('/instructions.html', __FILE__) ?>" target="_blank" style="padding-right:20px;">Instructions</a><a id="configurebtn" href="#">Configuration</a><br /><br />
	<div class="configure">
		
		<h4>ANNOUNCEMENTS!</h4>
		<p>Version 1.5.6 by Jerry Gonzalez / <a href="http://codecanyon.net/user/codeoncall" target="_blank">www.codecanyon.net</a> / <a href="http://www.codeoncall.com" target="_blank">www.codeoncall.com</a>
		</br></br></p>
		
		<hr class="line" />
		
		<h4>TIMEZONE</h4>
		<p>It is <span style="color:#000;font-weight:bold;"><?php echo $timeformat ?></span> on <span style="color:#000;font-weight:bold;"><?php echo date('l, F d, Y', strtotime($thedate)) ?></span>. See <a href="options-general.php">settings</a></strong> to make adjustments. <strong>Note</strong>: The time stamp was created the moment you entered this admin area and does not self-update so the time may be slightly off. This is normal. Reload this page and immediately look at the time stamp to determine if it is correct.</br></br></p>
		
		<hr class="line" />
		
		<h4>Title CSS CLASS</h4>
		<?php
//Class for Title or set default
		$class = get_option('announcementPlugin_class');
		if($class == ''){
		$class = 'widget-title';
		}else{
		$class = get_option('announcementPlugin_class');
		}

		echo '<p>Current CSS title class: <strong>';
		echo $class.'</strong></p>';
		?>
		
	<form method="post">
		Enter a custom CSS title class: <span style="color:grey;">(name only, no period. example: my-widget-title)</span><br /><input type="text" name="class" required="">
		<input type="hidden" name="feedback" value="">
		<input class="button-primary" type="submit" name="submitc" value="Submit" />
	</form></br>
		
		<hr class="line" />
		
		<h4>Title HTML TAG</h4>
		<?php
//Tags for Title or set default
		//get tag
		$tagOpen = get_option('announcementPlugin_tagopen');
		if($tagOpen == ''){
		$tagOpen = 'h3';
		$tagClose = 'h3';
		}else{
		$tagOpen = get_option('announcementPlugin_tagopen');
		$tagClose = get_option('announcementPlugin_tagclose');
		}

		echo 'Current HTML title tag: <strong>';
		echo $tagOpen.'</strong>';
		?>
		<br /><br />
	<form method="post">
		Choose a custom HTML tag:<br />
		<select name="tag" required="">
		  <option value="h1">h1</option>
		  <option value="h2">h2</option>
		  <option value="h3">h3</option>
		  <option value="h4">h4</option>
		  <option value="h5">h5</option>
		  <option value="h6">h6</option>
		</select>
		<input type="hidden" name="feedback" value="">
		<input class="button-primary" type="submit" name="submitt" value="Submit" />
	</form>
	<br /><br />
	</div>
	<hr class="ramp" />
	
<?php
//For edit purposes
		if(isset($_REQUEST['submite'])){
	
		$id = $_REQUEST['id'];
	
		global $wpdb;
		global $aatable;
		$announcements=$wpdb->get_results("SELECT * FROM $aatable WHERE ID = '$id'");

			foreach ($announcements as $announcement){

				$updateID = $announcement->ID;
				$title = stripslashes($announcement->title);
				$body = stripslashes($announcement->body);
				$startdate = $announcement->startdate;
				$enddate = $announcement->enddate;
				$annual = $announcement->annual;
				$weekdaystart = $announcement->weekdaystart;
				$weekdayduration = $announcement->weekdayduration;
				$monthlyslot = $announcement->monthlyslot;
				$monthlyday = $announcement->monthlyday;
				$monthlyduration = $announcement->monthlyduration;
				
				if($startdate == '0000-00-00'){
				$editstartdate == '';
				}else{
				$editstartdate = date('m/d/Y', strtotime($announcement->startdate));
				}
				if($enddate == '0000-00-00'){
				$editenddate == '';
				}else{
				$editenddate = date('m/d/Y', strtotime($announcement->enddate));
				}
				
			}

		}
?>
	<form method="post">
		<h3>Create Announcement</h3><br />
		Title:<br /><input type="text" name="title" required="" value="<?php echo $title ?>">
		<br /><br />
		Body:<br />
		<?php
		$initial_data=$body;
		$settings = array(
		'quicktags' => array('buttons' => 'em,strong,link',),
		'textarea_name'=>'body',
		'textarea_rows' => 8, 
		'quicktags' => true,
    		'tinymce' => array(
    			'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
    			'bullist,blockquote,|,justifyleft,justifycenter' .
    			',justifyright,justifyfull,|,link,unlink,|' .
    			',wp_fullscreen,wp_adv'
    			)
		);
		$id = 'body';
		wp_editor($initial_data,$id,$settings);
		?>
		<br /><br />
		<strong>Choose from <u>one</u> of the following display options:</strong>
		<br /><br />
		A) Display from: <input name="startdate" type="text" class="displaydate datepicker" size="10" value="<?php echo $editstartdate ?>">
		to <input name="enddate" type="text" class="displaydate datepicker" size="10" value="<?php echo $editenddate ?>">. &nbsp;&nbsp;Display Annually:
		<input class="displaydateCB" type="checkbox" name="annual" value="Yes" <?php if(isset($annual) && $annual != ''){echo 'checked="checked"';}?>>
		<br /><br />
		B) Display weekly on: 
		<select name="weekdaystart" class="displayweekly">
		<?php
		if(isset($weekdaystart) && $weekdaystart != ''){
		echo '<option value="'.$weekdaystart.'" selected>'.$weekdaystart.'</option>';
		echo '<option value=""></option>';
		}else{
		echo '<option value="" selected></option>';
		}
		?>
		<option value="Monday">Monday</option>
		<option value="Tuesday">Tuesday</option>
		<option value="Wednesday">Wednesday</option>
		<option value="Thursday">Thursday</option>
		<option value="Friday">Friday</option>
		<option value="Saturday">Saturday</option>
		<option value="Sunday">Sunday</option>
		</select>
		for 
		<select name="weekdayduration" class="displayweekly">
		<?php
		if(isset($weekdayduration) && $weekdayduration != ''){
		$weekdaydurationplus = $weekdayduration + 1;
		echo '<option value="'.$weekdayduration.'" selected>'.$weekdaydurationplus.'</option>';
		echo '<option value=""></option>';
		}else{
		echo '<option value="" selected></option>';
		}
		?>		
		<option value="0">1</option>
		<option value="1">2</option>
		<option value="2">3</option>
		<option value="3">4</option>
		<option value="4">5</option>
		<option value="5">6</option>
		<option value="6">7</option>
		</select>
		 day(s).<br /><br />
		C) Display on the 
		<select name="monthlyslot" class="displaymonthly">
		<?php
		if(isset($monthlyslot) && $monthlyslot != ''){
		echo '<option value="'.$monthlyslot.'" selected>'.$monthlyslot.'</option>';
		echo '<option value=""></option>';
		}else{
		echo '<option value="" selected></option>';
		}
		?>			
		<option value="First">First</option>
		<option value="Second">Second</option>
		<option value="Third">Third</option>
		<option value="Fourth">Fourth</option>
		<option value="Fifth">Fifth</option>
		</select>
		<select name="monthlyday" class="displaymonthly">
		<?php
		if(isset($monthlyday) && $monthlyday != ''){
		echo '<option value="'.$monthlyday.'" selected>'.$monthlyday.'</option>';
		echo '<option value=""></option>';
		}else{
		echo '<option value="" selected></option>';
		}
		?>
		<option value="Monday">Monday</option>
		<option value="Tuesday">Tuesday</option>
		<option value="Wednesday">Wednesday</option>
		<option value="Thursday">Thursday</option>
		<option value="Friday">Friday</option>
		<option value="Saturday">Saturday</option>
		<option value="Sunday">Sunday</option>
		</select>
		of each month for 
		<select name="monthlyduration" class="displaymonthly">
		<?php
		if(isset($monthlyduration) && $monthlyduration != ''){
		$monthlydurationplus = $monthlyduration + 1;
		echo '<option value="'.$monthlyduration.'" selected>'.$monthlydurationplus.'</option>';
		echo '<option value=""></option>';
		}else{
		echo '<option value="" selected></option>';
		}
		?>
		<option value="0">1</option>
		<option value="1">2</option>
		<option value="2">3</option>
		<option value="3">4</option>
		<option value="4">5</option>
		<option value="5">6</option>
		<option value="6">7</option>
		</select>				
		day(s).
		<br /><br />		
		<input type="hidden" name="feedback" value="">
		<input type="hidden" name="updateid" value="<?php echo $updateID ?>">
		<input class="button-primary" type="submit" name="submit" value="Save" />
	</form>
	<br /><br />
	<hr class="ramp" />




	<?php
//Show existing announcements
	global $wpdb;
	global $aatable;
	global $thedate;
	
	$thecount = $wpdb->get_var("SELECT count(*) FROM $aatable");
	if($wpdb->get_var("SELECT count(*) FROM $aatable") <= 0){
	$thecount = '0';	
	}
	?>
	<h3>Total Announcements: <?php echo $thecount; ?></h3><br />

	<?php
	
	$announcements=$wpdb->get_results("SELECT * FROM $aatable");

	echo '<table class="hovertable"><tr><th>Status</th><th>Title</th><th>Body</th><th>Specific Date</th><th>Weekly</th><th>Monthly</th><th>Edit</th><th>Delete</th></tr>';

	foreach($announcements as $announcement){

		//Comparisons. Date. Is not Annual.
		if($announcement->startdate != '0000-00-00' && $announcement->enddate != '0000-00-00' && $announcement->annual == ''){		
			if($announcement->enddate < $thedate) {
			$datemessage = 'expired';
			$dateclass = 'dateExpired';
			}elseif($announcement->startdate <= $thedate && $announcement->enddate >= $thedate){
			$datemessage = 'live';
			$dateclass = 'dateLive';
			}else{
			$datemessage = 'pending';
			$dateclass = 'datePending';
			}
		}
		
		//Comparisons. Date. Is Annual.
		if($announcement->startdate != '0000-00-00' && $announcement->enddate != '0000-00-00' && $announcement->annual == 'Yes'){
			//strip years
			$newthedate = date('m-d', strtotime($thedate));
			$newstartdate = date('m-d', strtotime($announcement->startdate));
			$newenddate = date('m-d', strtotime($announcement->enddate));
			if($newenddate < $newthedate) {
			$datemessage = 'annual<br />pending';
			$dateclass = 'datePending';
			}elseif($newstartdate <= $newthedate && $newenddate >= $newthedate){
			$datemessage = 'live';
			$dateclass = 'dateLive';
			}else{
			$datemessage = 'pending';
			$dateclass = 'datePending';
			}
		}		
		
		//Comparisons. Weekly.
		if($announcement->weekdaystart != '' && $announcement->weekdayduration != ''){
		
			$weekdaystartlast = date('Y-m-d', strtotime($announcement->weekdaystart.' last week'));
			$weekdaystartthis = date('Y-m-d', strtotime($announcement->weekdaystart.' this week'));
			$weekdaydurationlast = date('Y-m-d', strtotime($weekdaystartlast.'+'.$announcement->weekdayduration.'days'));
			$weekdaydurationthis = date('Y-m-d', strtotime($weekdaystartthis.'+'.$announcement->weekdayduration.'days'));

			if( 
			($thedate >= $weekdaystartlast && $thedate <= $weekdaydurationlast) || ($thedate >= $weekdaystartthis && $thedate <= $weekdaydurationthis)
			){
			$datemessage = 'live';
			$dateclass = 'dateLive';			
			}else{
			$datemessage = 'pending';
			$dateclass = 'datePending';			
			}
		}

		//Comparisons. Monthly.
		if($announcement->monthlyslot != '' && $announcement->monthlyday != '' && $announcement->monthlyduration != ''){
		
			//Is it the X day of X month?
			$monthyear = date('F Y', strtotime($thedate));
			$daycheck = date('Y-m-d', strtotime($announcement->monthlyslot.' '.$announcement->monthlyday.' of '.$monthyear));
			
			//Add the desired number of days 
			$addedduration = date('Y-m-d', strtotime($daycheck.'+'.$announcement->monthlyduration.'days'));
			
		//how about last month?
			
			$monthyearlastmonth = date('F Y', strtotime($thedate.'- 1 month'));
			$daychecklastmonth = date('Y-m-d', strtotime($announcement->monthlyslot.' '.$announcement->monthlyday.' of '.$monthyearlastmonth));
			
			//Add the desired number of days 
			$addeddurationlastmonth = date('Y-m-d', strtotime($daychecklastmonth.'+'.$announcement->monthlyduration.'days'));
						
			if(($thedate >= $daycheck && $thedate <= $addedduration) || ($thedate >= $daychecklastmonth && $thedate <= $addeddurationlastmonth)){
			$datemessage = 'live';
			$dateclass = 'dateLive';			
			}else{
			$datemessage = 'pending';
			$dateclass = 'datePending';			
			}
		
		}		
		
		//Correcting 0000-00-00 dates		
		if($announcement->startdate == '0000-00-00'){
		$correctedstartdate = '';
		}else{
		$correctedstartdate = 'Display from '.date('l, m/d/Y', strtotime($announcement->startdate));
		}
		if($announcement->enddate == '0000-00-00'){
		$correctedenddate = '';
		}else{
		$correctedenddate = 'to '.date('l, m/d/Y', strtotime($announcement->enddate)).'.';
		}

		//Annual notice
		if($announcement->annual == 'Yes'){
		$annual = 'Yes';
		$correctedstartdate = '<span style="border:dotted #23769d 1px;color:#666666;background-color:#f2f2f2;font-weight:bold;font-size:10px;padding:4px;display:block;margin:0 0 4px 0;text-align:center;">ANNUAL</span> Display from '.date('F jS', strtotime($announcement->startdate));
		$correctedenddate = 'to '.date('F jS', strtotime($announcement->enddate)).'.';
		}else{
		$annual = '';
		}

		echo '<tr><td class="'.$dateclass.'"><form method="post">';
		echo '<input type="hidden" name="id" value="'.$announcement->ID.'">';
		echo '<input type="hidden" name="feedback" value="">';
		echo $datemessage.'</td>';
		echo '<td><strong>'.stripslashes($announcement->title).'</strong></td>';
		echo '<td>'.stripslashes($announcement->body).'</td>';
		if($correctedstartdate != '' && $correctedenddate != ''){
		echo '<td class="hasentry">'.$correctedstartdate.' '.$correctedenddate.'</td>';
		}else{
		echo '<td></td>';
		}
		if($announcement->weekdaystart != '' && $announcement->weekdayduration != ''){
		$weekdayduration = $announcement->weekdayduration+1;
		echo '<td class="hasentry">Display every '.$announcement->weekdaystart.' for '.$weekdayduration.' day(s).</td>';
		}else{
		echo '<td></td>';
		}
		if($announcement->monthlyslot != '' && $announcement->monthlyday != '' && $announcement->monthlyduration != ''){
		$monthlyduration = $announcement->monthlyduration + 1;
		echo '<td class="hasentry">Display on the '.ucfirst($announcement->monthlyslot).' '.ucfirst($announcement->monthlyday).' of every month for '.$monthlyduration.' day(s).</td>';
		}else{
		echo '<td></td>';
		}
		echo '<td><input class="button-primary" type="submit" name="submite" value="Edit" /></td>';
		echo '<td><input class="confirmdelete button-primary" type="submit" name="submitd" value="Delete" /></form></td>';
	}
	
	echo '</tr></table>';
	echo '</div>';
	echo '<div class="cocfooter">This plugin brought to you by <a href="http://codecanyon.net/user/codeoncall/">CodeOnCall</a> - <a href="http://www.codeoncall.com">CodeOnCall.com</a></div>';
	
	}//end announcementPluginAdminScreen

//Admin Form Option Submit CSS Class Function

	if($_REQUEST['submitc']) {
		update_class();
	}

	function update_class() {
		update_option('announcementPlugin_class',trim($_REQUEST['class']));
	}

//Admin Form Option Submit CSS Tag Function

	if($_REQUEST['submitt']) {
		update_tags();
	}

	function update_tags() {
	
		update_option('announcementPlugin_tagopen',trim($_REQUEST['tag']));
		update_option('announcementPlugin_tagclose',trim($_REQUEST['tag']));
	}

//Admin Announcements Form Submit Announcement Function

	if($_REQUEST['submit']) {
		update_announcement();
	}
	
	function update_announcement(){
	
		if(isset($_REQUEST['updateid']) && $_REQUEST['updateid'] != ''){
		
			$updateID = $_REQUEST['updateid'];
			$where = array('ID' => $updateID);
			global $post, $wpdb; //wordpress post and wpdb global object
		    	global $aatable;
			if(trim($_REQUEST['startdate']) == ''){
			$modifiedstartdate = '0000-00-00';
			}else{
			$modifiedstartdate = date('Y-m-d', strtotime(trim($_REQUEST['startdate'])));
			}
			if(trim($_REQUEST['enddate']) == ''){
			$modifiedenddate = '0000-00-00';
			}else{
			$modifiedenddate = date('Y-m-d', strtotime(trim($_REQUEST['enddate'])));
			}
		    	$currentpage["title"]=trim($_REQUEST['title']); 
		    	$currentpage["body"]=trim($_REQUEST['body']);
		    	$currentpage["startdate"]=$modifiedstartdate;
		    	$currentpage["enddate"]=$modifiedenddate;
		    	$currentpage["annual"]=trim($_REQUEST['annual']);
		    	$currentpage["weekdaystart"]=trim($_REQUEST['weekdaystart']);
		    	$currentpage["weekdayduration"]=trim($_REQUEST['weekdayduration']);
		    	$currentpage["monthlyslot"]=trim($_REQUEST['monthlyslot']);
		    	$currentpage["monthlyday"]=trim($_REQUEST['monthlyday']);
		    	$currentpage["monthlyduration"]=trim($_REQUEST['monthlyduration']);
			if(empty($currentpage["title"])){
			
			//if all values are empty do nothing
			}else{
		    	$wpdb->update($aatable, $currentpage, $where);//update the captured values
			}

		}else{
		
			global $post, $wpdb; //wordpress post and wpdb global object
			global $aatable;
			if(trim($_REQUEST['startdate']) == ''){
			$modifiedstartdate = '0000-00-00';
			}else{
			$modifiedstartdate = date('Y-m-d', strtotime(trim($_REQUEST['startdate'])));
			}
			if(trim($_REQUEST['enddate']) == ''){
			$modifiedenddate = '0000-00-00';
			}else{
			$modifiedenddate = date('Y-m-d', strtotime(trim($_REQUEST['enddate'])));
			}			
		    	$currentpage["title"]=trim($_REQUEST['title']); 
		    	$currentpage["body"]=trim($_REQUEST['body']);
		    	$currentpage["startdate"]=$modifiedstartdate;
		    	$currentpage["enddate"]=$modifiedenddate;
		    	$currentpage["annual"]=trim($_REQUEST['annual']);
		    	$currentpage["weekdaystart"]=trim($_REQUEST['weekdaystart']);
			$currentpage["weekdayduration"]=trim($_REQUEST['weekdayduration']);
			$currentpage["monthlyslot"]=trim($_REQUEST['monthlyslot']);
		    	$currentpage["monthlyday"]=trim($_REQUEST['monthlyday']);
		    	$currentpage["monthlyduration"]=trim($_REQUEST['monthlyduration']);
			if(empty($currentpage["title"])){
			
			//if all values are empty do nothing
			}else{
		    	$wpdb->insert($aatable, $currentpage);//insert the captured values
			}
		}
	
	}

//Admin Announcement Form Delete Announcement Function

	if($_REQUEST['submitd']) {
		delete_announcement();
	}

	function delete_announcement(){
	
		$id = $_REQUEST['id'];
	
		global $wpdb;
		global $aatable;
		$wpdb->query("DELETE FROM $aatable WHERE ID = '$id'");
	}




//Widget Section

	//Get data
	function widget_announcementPlugin($args) {

		extract($args, EXTR_SKIP);

	//Get valid entries
		global $thedate;
		global $wpdb;
		global $aatable;
		$announcements=$wpdb->get_results("SELECT * FROM $aatable");
		//var_dump($announcements);
		
	//Show widget only if at least one record exists
		if(!empty($announcements)){
		echo $before_widget;
		announcementPlugin();
		echo $after_widget;
		}
	}

	//Register widget
	function widget_announcementPlugin_init() {

		wp_register_sidebar_widget(
			ANNOUNCEMENT_WIDGET_WIDGET_ID,
			__('Announcements!'), 
			'widget_announcementPlugin'
		);
	}

	add_action("plugins_loaded", "widget_announcementPlugin_init");


//Widget and Shortcode data

	function announcementPlugin() {
		
		global $thedate;
		global $wpdb;
		global $aatable;
		
		//get class from options
		$class = get_option('announcementPlugin_class');
		if($class == ''){
		$class = 'widget-title';
		}else{
		$class = get_option('announcementPlugin_class');
		}

		//get tag from options
		$tagOpen = get_option('announcementPlugin_tagopen');
		if($tagOpen == ''){
		$tagOpen = 'h3';
		$tagClose = 'h3';
		}else{
		$tagOpen = get_option('announcementPlugin_tagopen');
		$tagClose = get_option('announcementPlugin_tagclose');
		}
		
		//Get announcements
		
		//date related. not annual.
		$announcementsDate=$wpdb->get_results("SELECT * FROM $aatable");
				
		foreach($announcementsDate as $announcementDate){
		
			if($announcementDate->startdate != '' && $announcementDate->enddate != '' && $announcementDate->annual == ''){
				if($announcementDate->startdate <= $thedate && $announcementDate->enddate >= $thedate){

				echo '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementDate->title).'</'.$tagClose.'></div>';
				echo '<p>'.stripslashes($announcementDate->body).'</p>';

				}
			}
		
		}		


		//date related. annual.
		foreach($announcementsDate as $announcementDateA){
		
			if($announcementDateA->startdate != '' && $announcementDateA->enddate != '' && $announcementDateA->annual == 'Yes'){
				//strip years
				$newthedate = date('m-d', strtotime($thedate));
				$newstartdate = date('m-d', strtotime($announcementDateA->startdate));
				$newenddate = date('m-d', strtotime($announcementDateA->enddate));						
				if($newstartdate <= $newthedate && $newenddate >= $newthedate){

				echo '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementDateA->title).'</'.$tagClose.'></div>';
				echo '<p>'.stripslashes($announcementDateA->body).'</p>';

				}
			}
		
		}

		//week related
		foreach($announcementsDate as $announcementWeek){
		
			if($announcementWeek->weekdaystart != '' && $announcementWeek->weekdayduration != ''){
				$weekdaystartlast = date('Y-m-d', strtotime($announcementWeek->weekdaystart.' last week'));
				$weekdaystartthis = date('Y-m-d', strtotime($announcementWeek->weekdaystart.' this week'));
				$weekdaydurationlast = date('Y-m-d', strtotime($weekdaystartlast.'+'.$announcementWeek->weekdayduration.'days'));
				$weekdaydurationthis = date('Y-m-d', strtotime($weekdaystartthis.'+'.$announcementWeek->weekdayduration.'days'));

				if( 
				($thedate >= $weekdaystartlast && $thedate <= $weekdaydurationlast) || ($thedate >= $weekdaystartthis && $thedate <= $weekdaydurationthis)
				){
				echo '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementWeek->title).'</'.$tagClose.'></div>';
				echo '<p>'.stripslashes($announcementWeek->body).'</p>';

				}
			}
		
		}		


		//month related		
		foreach($announcementsDate as $announcementMonth){

			if($announcementMonth->monthlyslot != '' && $announcementMonth->monthlyduration != ''){
				//Is it the X day of X month?
				$monthyear = date('F Y', strtotime($thedate));
				$daycheck = date('Y-m-d', strtotime($announcementMonth->monthlyslot.' '.$announcementMonth->monthlyday.' of '.$monthyear));

				//Add the desired number of days 
				$addedduration = date('Y-m-d', strtotime($daycheck.'+'.$announcementMonth->monthlyduration.'days'));
				
				//how about last month?
			
				$monthyearlastmonth = date('F Y', strtotime($thedate.'- 1 month'));
				$daychecklastmonth = date('Y-m-d', strtotime($announcementMonth->monthlyslot.' '.$announcementMonth->monthlyday.' of '.$monthyearlastmonth));
			
				//Add the desired number of days 
				$addeddurationlastmonth = date('Y-m-d', strtotime($daychecklastmonth.'+'.$announcementMonth->monthlyduration.'days'));				
				
				
				if(($thedate >= $daycheck && $thedate <= $addedduration) || ($thedate >= $daychecklastmonth && $thedate <= $addeddurationlastmonth)){
				echo '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementMonth->title).'</'.$tagClose.'></div>';
				echo '<p>'.stripslashes($announcementMonth->body).'</p>';

				}
			}
		}
	}



	add_shortcode("myannouncements", "announcementPluginSC");

	function announcementPluginSC() {
		
		global $thedate;
		global $wpdb;
		global $aatable;
		
		$announcementsSC = '';
		
		//get class from options
		$class = get_option('announcementPlugin_class');
		if($class == ''){
		$class = 'widget-title';
		}else{
		$class = get_option('announcementPlugin_class');
		}

		//get tag from options
		$tagOpen = get_option('announcementPlugin_tagopen');
		if($tagOpen == ''){
		$tagOpen = 'h3';
		$tagClose = 'h3';
		}else{
		$tagOpen = get_option('announcementPlugin_tagopen');
		$tagClose = get_option('announcementPlugin_tagclose');
		}
		
		//Get announcements
		
		//date related. not annual.
		$announcementsDate=$wpdb->get_results("SELECT * FROM $aatable");
				
		foreach($announcementsDate as $announcementDate){
		
			if($announcementDate->startdate != '' && $announcementDate->enddate != '' && $announcementDate->annual == ''){
				if($announcementDate->startdate <= $thedate && $announcementDate->enddate >= $thedate){

				$announcementsSC .= '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementDate->title).'</'.$tagClose.'></div><p>'.stripslashes($announcementDate->body).'</p>';

				}
			}
		
		}		


		//date related. annual.
		foreach($announcementsDate as $announcementDateA){
		
			if($announcementDateA->startdate != '' && $announcementDateA->enddate != '' && $announcementDateA->annual == 'Yes'){
				//strip years
				$newthedate = date('m-d', strtotime($thedate));
				$newstartdate = date('m-d', strtotime($announcementDateA->startdate));
				$newenddate = date('m-d', strtotime($announcementDateA->enddate));						
				if($newstartdate <= $newthedate && $newenddate >= $newthedate){

				$announcementsSC .= '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementDateA->title).'</'.$tagClose.'></div><p>'.stripslashes($announcementDateA->body).'</p>';

				}
			}
		
		}

		//week related
		foreach($announcementsDate as $announcementWeek){
		
			if($announcementWeek->weekdaystart != '' && $announcementWeek->weekdayduration != ''){
				$weekdaystartlast = date('Y-m-d', strtotime($announcementWeek->weekdaystart.' last week'));
				$weekdaystartthis = date('Y-m-d', strtotime($announcementWeek->weekdaystart.' this week'));
				$weekdaydurationlast = date('Y-m-d', strtotime($weekdaystartlast.'+'.$announcementWeek->weekdayduration.'days'));
				$weekdaydurationthis = date('Y-m-d', strtotime($weekdaystartthis.'+'.$announcementWeek->weekdayduration.'days'));

				if( 
				($thedate >= $weekdaystartlast && $thedate <= $weekdaydurationlast) || ($thedate >= $weekdaystartthis && $thedate <= $weekdaydurationthis)
				){
				$announcementsSC .= '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementWeek->title).'</'.$tagClose.'></div><p>'.stripslashes($announcementWeek->body).'</p>';

				}
			}
		
		}		


		//month related		
		foreach($announcementsDate as $announcementMonth){

			if($announcementMonth->monthlyslot != '' && $announcementMonth->monthlyduration != ''){
				//Is it the X day of X month?
				$monthyear = date('F Y', strtotime($thedate));
				$daycheck = date('Y-m-d', strtotime($announcementMonth->monthlyslot.' '.$announcementMonth->monthlyday.' of '.$monthyear));

				//Add the desired number of days 
				$addedduration = date('Y-m-d', strtotime($daycheck.'+'.$announcementMonth->monthlyduration.'days'));
				
				//how about last month?
			
				$monthyearlastmonth = date('F Y', strtotime($thedate.'- 1 month'));
				$daychecklastmonth = date('Y-m-d', strtotime($announcementMonth->monthlyslot.' '.$announcementMonth->monthlyday.' of '.$monthyearlastmonth));
			
				//Add the desired number of days 
				$addeddurationlastmonth = date('Y-m-d', strtotime($daychecklastmonth.'+'.$announcementMonth->monthlyduration.'days'));				
				
				
				if(($thedate >= $daycheck && $thedate <= $addedduration) || ($thedate >= $daychecklastmonth && $thedate <= $addeddurationlastmonth)){
				$announcementsSC .= '<div class="'.$class.'"><'.$tagOpen.'>'.stripslashes($announcementMonth->title).'</'.$tagClose.'></div><p>'.stripslashes($announcementMonth->body).'</p>';

				}
			}
		}
		
	return $announcementsSC;
	
	}


?>