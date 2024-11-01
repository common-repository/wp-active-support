<div class="contentarea">
	<div class="leftarea">
		<div style="float: left; width: 97%; background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding: 13px;">				<div><p>Simple and easy to use. Add your email address to this page and you will receive a weekly update about the status of your website only if there are any issues.</p>	<p>You can simply choose to turn off notifications, but you are advised to keep your website up to date. Get someone else to look after it for you by subscribing to our premium service, <a href="http://www.marketing-optimiser.co.uk/active-support">click here</a>.</p></div>			
	<?php 
	if(isset($_POST['save_changes_data'])) { 
	$wp_notification = serialize($_POST['wp_notification']); 
	$metavalue = serialize($_POST['wp_information']); 
	$wp_notificationeamil = serialize($_POST['wp_notificationeamil']); 
	update_post_meta('1', 'information_key',$metavalue);
	update_post_meta('1', 'wp_notification',$wp_notification);
	update_post_meta('1', 'wp_notificationeamil',$wp_notificationeamil);
	
		?>
			<script> 
			jQuery(function(){ 
			jQuery(".loadinbackscreanhide").show();
			window.location.href ='<?php echo site_url() ?>/wp-admin/admin.php?page=main-dashboard&tab=initiate';
			});
			 </script>	
		<?php
		
	}
	$wp_information = get_post_meta ('1', 'information_key');
	$wp_notification = get_post_meta ('1', 'wp_notification');
	$wp_notificationeamil = get_post_meta ('1', 'wp_notificationeamil');
	if(empty($wp_notificationeamil['0'])) {
		$wp_notificationeamil = get_option('admin_email'); 
	} else {
		$wp_notificationeamil = $wp_notificationeamil['0'];
	}
	?>
	<form action="" method="post" name="settings_form" id="settings_form">     
		<table width="100%" class="form-table">     
		<tbody>       
		<tr>              
		<td width="30%"><b>Toggle Notifications On/Off (Select to receive notification emails)</b></td>      
        <td width="70%" align="left"><input type="checkbox" name="wp_notification" value="1"  <?php if(unserialize($wp_notification['0'])=="1") { ?>   checked  <?php } ?> /></td></tr> 
		
		<tr><td><b>Activate Plugin* ( sends Support Data to Marketing Optimiser Servers)</b></td>
		<td><input type="checkbox" name="wp_information" value="1"  <?php if(unserialize($wp_information['0'])=="1") { ?>   checked  <?php } ?> /></td></tr> 
		
		<tr><td><b>Set Notification Email Address</b></td>
		<td><input type="text" name="wp_notificationeamil" value="<?php echo unserialize($wp_notificationeamil); ?>"/></td></tr> 
		    
		
		
		<tr>          <th></th>          <td>            <p class="submit">              <input type="submit" class="button-primary" value="Save Changes" name="save_changes_data" id="save_changes" />            </p>          </td>        </tr>           </tbody>    </table>  </form>
		
		</div>
		
	</div>
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