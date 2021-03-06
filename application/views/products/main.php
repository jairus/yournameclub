<?php
if(!$cats){
	$sql = "select * from `categories` where 1";
	$q = $this->db->query($sql);
	$cats = $q->result_array();
	$cats_temp = array();
	foreach($cats as $value){
		$cats_temp[$value['id']] = $value['name'];
	}
	$cats = $cats_temp;
}
if(!$brands){
	$sql = "select * from `brands` where 1";
	$q = $this->db->query($sql);
	$brands = $q->result_array();
	$brands_temp = array();
	foreach($brands as $value){
		$brands_temp[$value['id']] = $value['name'];
	}
	$brands = $brands_temp;
}
?>
<script>
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

function searchRecord(){
	self.location = "<?php echo site_url(); ?><?php echo $controller; ?>/search/?search="+jQuery("#search").val()+"&filter="+jQuery("#sfilter").val();
}
function addRecord(){
	self.location = "<?php echo site_url(); echo $controller; ?>/add";
}
</script>
<center>
<div class='pad10' >
<form action="<?php echo site_url(); ?><?php echo $controller; ?>/search/" class='inline' >
	Filter: <select name='filter' id='sfilter'>
	<!--
	<option value="name">Name</option>
	<option value="id">ID</option>	
	-->
	<option value="name">Product Name</option>	
<option value="description">Product Description</option>	
<option value="image_url">Image URL</option>	
<option value="link">Product URL</option>	
<option value="category_ids">Category</option>	
<option value="brand_id">Brand</option>	

	</select>
	Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' />
	<input type='button' class='button normal' value='search' onclick='searchRecord()'>
	<input type='button' class='button normal' value='add' onclick='addRecord()'>
</form>
<?php
if(trim($filter)){
	?>
	<script>
	jQuery("#sfilter").val("<?php echo sanitizeX($filter); ?>")
	</script>
	<?php
}
$t = count($records);
?>
</center>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<!--
		<th>Name</th>
		-->
		<th>Product Name</th>
<th>Product Description</th>
<th>Price</th>
<th>Image URL</th>
<th>Product URL</th>
<th>Category</th>
<th>Brand</th>
<th>Featured</th>
<th>Hidden</th>
<th>Views</th>

		<th></th>
	</tr>
	<?php
	
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentitiesX($records[$i]['id']); ?>" class="row" >
			
			<td><?php echo $start+$i+1; ?></td>	
			<!--<td><?php //echo $records[$i]['name'];?></td>-->		
			<td><?php echo $records[$i]['name'];?></td>
<td><?php echo $records[$i]['description'];?></td>
<td><?php  echo number_format($records[$i]['price'], "2", ".", ","); ?></td>
<td><?php echo $records[$i]['image_url'];?></td>
<td><?php echo $records[$i]['link'];?></td>
<td><?php 
		
		$category_ids = explode(",", $records[$i]['category_ids']);
		$cat_ids = array();
		foreach($category_ids as $cat_id){
			$cat_ids[trim($cat_id, "|")] = $cats[trim($cat_id, "|")];
		}
		foreach($cat_ids as $key=>$value){
			echo "<a href='".site_url("products/search/?filter=category_ids&search=".$value)."'>".$value."</a> ";
		}

?></td>
<td><?php 
		
		$brand_id = $records[$i]['brand_id'];
		echo "<a href='".site_url("products/search/?filter=brand_id&search=".$brands[$brand_id])."'>".$brands[$brand_id]."</a> ";

?></td>
<td><?php 
		
		$featured = $records[$i]['featured'];
		if($featured){
			echo "Yes";
		}
		else{
			echo "No";
		}

?></td>
<td><?php 
		
		$hidden = $records[$i]['hidden'];
		if($hidden){
			echo "Yes";
		}
		else{
			echo "No";
		}

?></td>
<td><?php echo $records[$i]['views'];?></td>

			<td width='300px'>
			[ <a href="<?php echo site_url(); ?><?php echo $controller; ?>/edit/<?php echo $records[$i]['id']?>" >Edit</a> ] 
			[ <a style='color: red; cursor:pointer; text-decoration: underline' onclick='deleteRecord("<?php echo htmlentitiesX($records[$i]['id']) ?>"); ' >Delete</a> ]
			
			</td>
		</tr>
		<?php
	}
	if($pages>0){
		?>
		<tr>
			<td colspan="50" class='center font12' >
				There is a total of <?php echo $cnt; ?> <?php if($cnt>1) { echo "records"; } else{ echo "record"; }?> in the database. 
				Go to Page:
				<?php
				if($search){
					?>
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&filter=<?php echo sanitizeX($filter); ?>&start="+this.value'>
					<?php

				}
				else{
					?>
					<select onchange='self.location="?start="+this.value'>
					<?php
				}
				for($i=0; $i<$pages; $i++){
					if(($i*$limit)==$start){
						?><option value="<?php echo $i*$limit?>" selected="selected"><?php echo $i+1; ?></option><?php
					}
					else{
						?><option value="<?php echo $i*$limit?>"><?php echo $i+1; ?></option><?php
					}
				}
				?>
				</select>
			</td>
		</tr>
		<?php
	}
	?>
</table>
</div>
