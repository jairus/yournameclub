<?php
@session_start();
$sid = session_id()."_".time();
?>
<script>
function saveRecord(approve){	
	extra = "";
	jQuery("#savebutton").val("Saving...");
	formdata = jQuery("#record_form").serialize();
	jQuery("#record_form *").attr("disabled", true);
	jQuery.ajax({
		<?php
		if($record['id']){
			?>url: "<?php  echo site_url(); echo $controller ?>/ajax_edit"+extra,<?php
		}
		else{
			?>url: "<?php echo site_url(); echo $controller ?>/ajax_add"+extra,<?php
		}
		?>
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(data){
			//alert(data);
		}
	});	
	
}
function deleteRecord(co_id){
	if(confirm("Are you sure you want to delete this record?")){
		formdata = "id="+co_id;
		jQuery.ajax({
			url: "<?php echo site_url(); echo $controller ?>/ajax_delete/"+co_id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				jQuery("#tr"+co_id).fadeOut(200);
				self.location = "<?php echo site_url(); echo $controller ?>";
			}
		});
		
	}
}
</script>

<input type='hidden' id='tempcreatelabel' />
<form id='record_form'>

<?php
if($record['id']){
	?>
	<input type='hidden' name='id' id='co_id'  value="" />
	<?php
}
else{
	?>
	<input type='hidden' name='sid' value="<?php echo sanitizeX($sid); ?>">
	<?php
}


?>
<table width="100%" cellpadding="10px">
<?php
if(!$record['id']){
	?>
	<tr>
	<td class='font18 bold'>Add a New Record</td>
	<td></td>
	</tr>
	<?php
}
else{
	?>
	<tr>
	<td class='font18 bold'>Edit Record</td>
	<td></td>
	</tr>
	<?php
}

?>
<tr>
<td width='50%'> 
	<table width="100%">
		<!--
		<tr class="even required">
		  <td>* Name:</td>
		  <td><input type="text" name="name" size="40"></td>
		</tr>
		-->
		<tr class="even required"><td>* Product Name:</td><td><input type="text" name="name" size="40"></td></tr>
<tr class="odd required"><td>* Product Description:</td><td><textarea name="description"></textarea></td></tr>
<tr class="even required"><td>* Price:</td><td><input type="text" name="price" size="40"></td></tr>
<tr class="odd required"><td>* Image URL:</td><td><input type="text" name="image_url" size="40"></td></tr>
<tr class="even required"><td>* Product URL:</td><td><input type="text" name="link" size="40"></td></tr>
	</table>
</td>
<td width='50%'>
	<table width="100%">
		<tr class="even required"><td>* Category:</td><td>
		<?php
		$sql = "select * from `categories` where 1";
		$q = $this->db->query($sql);
		$cats = $q->result_array();
		
		$category_ids = explode(",", $record['category_ids']);
		
		$cat_ids = array();
		foreach($category_ids as $cat_id){
			$cat_ids[] = trim($cat_id, "|");
		}
		
		
		$t = count($cats);
		if($t){
			echo "<select name='category_ids[]' multiple>";
			for($i=0; $i<$t; $i++){
				if(in_array($cats[$i]['id'], $cat_ids)){
					echo "<option value='|".$cats[$i]['id']."|' selected>".$cats[$i]['name']."</option>";
				}
				else{
					echo "<option value='|".$cats[$i]['id']."|'>".$cats[$i]['name']."</option>";
				}
			}
			echo "</select>";
		}
		?>
		</td>
		</tr>
		<tr class="odd required"><td>Brand:</td><td>
		<?php
		$sql = "select * from `brands` where 1";
		$q = $this->db->query($sql);
		$brands = $q->result_array();
		
		
		$t = count($brands);
		if($t){
			echo "<select name='brand_id'>";
			for($i=0; $i<$t; $i++){
				if($record['brand_id']==$brands[$i]['id']){
					echo "<option value='".$brands[$i]['id']."' selected>".$brands[$i]['name']."</option>";
				}
				else{
					echo "<option value='".$brands[$i]['id']."'>".$brands[$i]['name']."</option>";
				}
			}
			echo "</select>";
		}
		?>
		</td>
		</tr>
		<tr class="even required"><td>Featured:</td><td>
		<?php
		if($record['featured']){
			echo "<input type='checkbox' checked value=1 name='featured'>";
		}
		else{
			echo "<input type='checkbox' value=1 name='featured'>";
		}
		?>
		</td>
		</tr>
		<tr class="odd required"><td>Hidden:</td><td>
		<?php
		if($record['hidden']){
			echo "<input type='checkbox' checked value=1 name='hidden'>";
		}
		else{
			echo "<input type='checkbox' value=1 name='hidden'>";
		}
		?>
		</td>
		</tr>
		<tr class="even required"><td>Views:</td><td><input type="text" name="views" size="15"></td></tr>
	</table>
</td>
</tr>

<tr>
	<td colspan="2" class='center'>
		<table width='100%'>
		<tr>
			<td width=100%>
				<input type="button" id='savebutton' value="Save" onclick="saveRecord()" />
			</td>
			<?php 
			if($record['id']){
				?><td><input type="button" style='background:red; color:white' value="Delete" onclick="deleteRecord('<?php echo $record['id']; ?>')" /></td><?php
			}
			?>
		</tr>
		</table>
	</td>
</tr>
</td>
</table>
</form>

<script>
<?php

if(is_array($pictures)){
	?>
	html = "";
	<?php
}
if($record){
	foreach($record as $key=>$value){	
		if($key=='category_ids'){
		}
		else if($key=='brand_id'){
		}
		else if($key=='featured'){
		}
		else if($key=='hidden'){
		}
		else if($key=='price'){
			?>
			jQuery('[name="<?php echo $key; ?>"]').val("<?php echo number_format($value, "2", ".", ","); ?>");
			<?php
		}
		else if(trim($value)||1){
			?>
			jQuery('[name="<?php echo $key; ?>"]').val("<?php echo sanitizeX($value); ?>");
			<?php
		}		
	}
}
?>
</script>
