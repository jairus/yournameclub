<?php
$controller = $this->router->class;
$method = $this->router->method;
?>
<ul class='menu'>
	<li <?php if($controller=="categories"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url("categories");?>"'>
		<a href='<?php echo site_url("categories");?>'>Product Categories</a>
	</li>
	<li <?php if($controller=="brands"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url("brands");?>"'>
		<a href='<?php echo site_url("brands");?>'>Brands</a>
	</li>
	<li <?php if($controller=="products"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url("products");?>"'>
		<a href='<?php echo site_url("products");?>'>Products</a>
	</li>
	<li <?php if($controller=="slideshows"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url("slideshows");?>"'>
		<a href='<?php echo site_url("slideshows");?>'>SlideShow Items</a>
	</li>
	<li <?php if($controller=="users"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url("users");?>"'>
		<a href='<?php echo site_url("users");?>'>Admin Users</a>
	</li>
	
</ul>