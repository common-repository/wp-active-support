<?php
$wp_dashboard = new WP_Active_Support();
?>

<div class="wrap">
			  <h2 class='opt-title'>
				<?php echo __( 'Active Support'); ?>
			  </h2>
			 <div class="loadinbackscreanhide" style="display:none;">
				<h3>ACTIVATING</h3>
				<p>please wait...</p>	
				<img src="<?php  echo $wp_dashboard->imagesurl; ?>loading_spinner.gif"  style="width: 48px;">	
			  </div>
				<script>
				jQuery(function(){ 
					jQuery(".Active").click(function(){
						
						jQuery(".loadinbackscreanhide").show();
					});  
				}); 
				</script>
			  <?php
			  if (isset($update_message)) echo $update_message;
			  
			  if ( isset ( $_GET['tab'] ) ) $wp_dashboard->wp_active_dashboard_tab($_GET['tab']); 
			  else $wp_dashboard->wp_active_dashboard_tab( 'preferences' );

			  if ( isset ( $_GET['tab'] ) ) 
				$tab = $_GET['tab']; 
			  else 
				$tab = 'preferences';

			  if( $tab == 'initiate') { 
			  $all_plugins = get_plugins();	
				include('page/dashboardpage.php');
			  } else if($tab == 'userlist'){
				include('page/userlistpage.php');
			  } else if($tab == 'preferences'){
				include('page/contactus.php');
			  } 
			  ?>
</div>
</div>
</div>