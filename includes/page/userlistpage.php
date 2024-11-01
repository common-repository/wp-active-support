<table border="0" cellpadding="0" cellspacing="0" width="100%" class="dashboard_table">
<thead>
<tr>
<th>Serial Number</th>
<th>User Name</th>
<th>Last Login</th>
<th>Number Of post</th>
<th>Last Create post</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php 
global $wpdb;
$results = $wpdb->get_results("select * from $wpdb->usermeta where meta_key='last_login'  order by meta_value DESC");
$count="1";
foreach($results as $key=>$val){
	$suername = get_userdata($val->user_id);	
	$lastcreation=$wpdb->get_results("SELECT post_date FROM $wpdb->posts WHERE post_author='".$val->user_id."' and ( post_type='page' or post_type='post' ) order by ID DESC limit 1 ");
?>
<tr>
<td><?php echo $count;?></td>
<td><?php echo $suername->user_login ?></td> 
<td><?php echo $val->meta_value ?></td>
<td><?php echo count_user_posts($val->user_id);?></td>
<td><?php if(!empty($lastcreation[0]->post_date)) { echo $lastcreation[0]->post_date; }else { echo "No Date"; } ?></td>
<td>Active</td>
</tr>
<?php $count++; } ?>	
</tbody>
</table>


 
