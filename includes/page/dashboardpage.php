<?php 


if (!function_exists( 'plugins_api' ) ) {  require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); }
if ( ! function_exists( 'get_plugins' ) ) {	require_once ABSPATH . 'wp-admin/includes/plugin.php'; }
$all_plugins = get_plugins();		
function currentpluginverstion($slug) {
	$args = array(
		'slug' => $slug,    
		'fields' => array(
			'version' => true,
		)
	);
	$call_api = plugins_api( 'plugin_information', $args );
	 if(!empty( $call_api->version)) {

		return  $version_latest = $call_api->version;

		}
	}
$wp_version = get_bloginfo('version');	
function curlRequest($url) {

			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			return($response);
	}
	?>
<div class="contentarea">
	<div class="leftarea">
				<table border="0" cellpadding="15" cellspacing="0" width="100%" class="dashboard_table" id="myTable">
				<thead>
				<tr>
				<th>Serial No</th>
				<th>Plugin Name</th>
				<th>Description</th>
				<th>Version</th>
				<th>Current Version</th>
				<th>Update Status</th>
				<th>Active/Inactive</th>
				</tr>
				</thead>
				<tbody id="list">
				<?php 
				$counter="1"; 
				$wp_numberofplugn="0";
				$wp_activeplugins="0";
				$wp_deactiveplugins="0";
				$wp_uptodate="0";
				$wp_updaterequired="0";
				
				foreach($all_plugins as $key=>$plugin) {
					$explodeslug  = explode("/" , $key); 
					$pluginslug=$plugin['Name'];		
					if(empty($explodeslug['1'])) { $slugpaths = $explodeslug['0']; }
					else {  $slugpaths =  $explodeslug['1']; }	
					$slug=str_replace(".php" ,"",$slugpaths);					
					$oldvertion = str_replace(".","",$plugin['Version']);					
					$curentversionpluing = currentpluginverstion($pluginslug); 
					$currentverstion = str_replace(".","",$curentversionpluing); 
					if(empty($currentverstion) or empty($oldvertion)) {
						
						$update="No Information";
						
					} else if($currentverstion==$oldvertion) {
						$wp_uptodate++; 
						$update="<img src='".$wp_dashboard->imagesurl."uptodate.png' style='width:20px' title='Up to update' >";
					 } else {
						$wp_updaterequired++;  
						 $update="<img src='".$wp_dashboard->imagesurl."required.png' style='width:20px' title='Need to Update'>";
					 }
				if(is_plugin_active($key))  { $status="Active"; $wp_activeplugins++; } else { $status="Inactive"; $wp_deactiveplugins++; }
				?>
				<tr>
					<td align="center"><?php echo $counter; ?></td>
					<td align="center">
					<?php $titlename = str_replace(" ","-",$plugin['Name']); ?>
					
					<a target="_blank" href="<?php echo site_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=<?php echo $titlename ?>&TB_iframe=true&width=600&height=550"><?php print($plugin['Name']); ?></a>
					
					</td> 
					<td><?php print($plugin['Description']); ?></td>
					<td align="center"><?php print($plugin['Version']); ?></td>
					<td align="center"><?php echo $curentversionpluing; ?></td>
					<td align="center"><?php echo $update; ?></td>
					<td align="center"><?php echo $status; ?></td>
				</tr>
					<?php 
					 $counter++; 
					$wp_numberofplugn++; 	
					 }
					?>
				</tbody>
				</table>
	</div>
	<?php 
			$wp_email = get_option('admin_email'); 
			$wp_siteurl = urldecode(site_url()); 	
			$wp_childvesion = $wp_dashboard->version; 
			global $wpdb;
			global $administratorid; 
			$queryrun="select * from $wpdb->usermeta where meta_key='last_login' AND meta_value!='' order by meta_value DESC ";
			$lasturldetails = $wpdb->get_results($queryrun);
			$userid=array(); 
			foreach($lasturldetails as $key=>$id) {
				$user = new WP_User($id->user_id);
				if($user->roles[0]=="administrator") {
					
					$administratorid = $id->user_id;
					
				} else {
					
					$userid[] = $id->user_id; 
					
				}

			}
			
			global $wpdb;
			$queryrun="select * from $wpdb->usermeta where user_id='$administratorid' and meta_key='last_login' AND meta_value!=''  ";
			$lasturldetails = $wpdb->get_results($queryrun);
			$admindetails = $lasturldetails['0']->user_id;
			
			$username=$wpdb->get_results("select * from $wpdb->users where ID='$admindetails'");
			$adminname = urlencode($username['0']->display_name);
			$adminlastlogin =  urlencode($lasturldetails['0']->meta_value);
			
			$userid = $userid['0']; 
			
			$queryrun="select * from $wpdb->usermeta where user_id='$userid' and meta_key='last_login' AND meta_value!=''  ";
			$lasturldetails = $wpdb->get_results($queryrun);
			$userid = $lasturldetails['0']->user_id;
			
			$username=$wpdb->get_results("select * from $wpdb->users where ID='$userid'");
			$wp_username = urlencode($username['0']->display_name);
			$wp_lastlogin =  urlencode($lasturldetails['0']->meta_value);
			
			$wp_information = get_post_meta('1', 'information_key');
			
			$wp_notification = get_post_meta('1', 'wp_notification');
			$wp_notification = unserialize($wp_notification['0']);
			$wp_notificationeamil = get_post_meta ('1', 'wp_notificationeamil');
			$wp_notificationeamil = unserialize($wp_notificationeamil['0']);
			if(empty($wp_notificationeamil)) { $wp_notificationeamil = $wp_email; }
			 $masterpluginpaths =  $wp_dashboard->mainpluginuser; 
			 
			$wp_sitename = urlencode(get_option('blogname'));
			
			$querstring="$masterpluginpaths?action=request&wp_email=$wp_email&wp_siteurl=$wp_siteurl&wp_version=$wp_version&wp_username=$wp_username&wp_lastlogin=$wp_lastlogin&wp_adminname=$adminname&wp_adminlastlogin=$adminlastlogin&wp_numberofplugn=$wp_numberofplugn&wp_activeplugins=$wp_activeplugins&wp_deactiveplugins=$wp_deactiveplugins&wp_uptodate=$wp_uptodate&wp_updaterequired=$wp_updaterequired&wp_notification=$wp_notification&wp_notificationeamil=$wp_notificationeamil&wp_childvesion=$wp_childvesion&wp_sitename=$wp_sitename";
			if(unserialize($wp_information['0'])=="1") { 
				$respoce = curlRequest($querstring); 
				
			}
	?>
	<script>jQuery(function(){ jQuery(".loadinbackscreanhide").hide(); }); </script>
	<div class="rightarea">
					<div class="imgdiv">
						<a href="http://www.marketing-optimiser.co.uk/products/active-support-broken-down/">
							<img src="<?php echo $wp_dashboard->imagesurl ?>top_img.png">
						</a>
					</div>
					<div class="imgdiv">
						<a href="http://www.marketing-optimiser.co.uk/products/active-support-broken-down/">
							<img src="<?php echo $wp_dashboard->imagesurl ?>buynow.png">
						</a>
					</div>
					<div class="imgdiv">
						<a href="http://www.marketing-optimiser.co.uk/products/active-support-broken-down/">
							<img src="<?php echo $wp_dashboard->imagesurl ?>marketing.png">
						</a>
					</div>
					<div class="support_text">
						<p><strong>Get Active Support Premium</strong></p>
						<p>UK based Active Web master service<br/> Core/Plugin Updates<br/> Round The Clock Hacker/Malware<br/> Monitoring and Support<br/> Cost Effective<br/> Proactive</p>
						<p><a href="http://www.marketing-optimiser.co.uk/products/active-support-broken-down/">Subscribe to Active Support</a></p>
					</div>			
	</div>
</div>