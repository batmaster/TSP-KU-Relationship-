<head>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>

<?php
require_once ('inc/Product.php');
require_once ('inc/ProductDao.php');
	if (isset($_GET["id"])) {
		$result = Product::GetProduct($_GET["id"]);
	}
	
	
?>
<div style="width: 90%; height: 90%; border-radius: 6px; background-color: #eee;">

Name:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="name" placeholder="Title">
</div>

Code:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="code" placeholder="Text">
</div>

Price:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
	<input type="number" class="form-control" id="price" placeholder="Number">
</div>

Description:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="desc" placeholder="Description (should change to textarea?)">
</div>

Category:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
	<input type="text" class="form-control" id="category" placeholder="(Select below or input for a new category)">
	<div class="btn-group btn-group-sm" style="width: 100%">
			<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
				Category <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="category-dropdown"style="background-color: black" role="menu">
				<li><a style = "color: white">Shirt</a></li>
			    <li><a style = "color: white">Equipment</a></li>
			    <li><a style = "color: white">Balls</a></li>
			    <li><a style = "color: white">Forbidden stuffs</a></li>
			</ul>
		</div> 
</div>

Tag:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
	<input type="text" class="form-control" id="tag" placeholder="Separated with comma ,">
</div>

Quantity:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span></span>
	<input type="number" class="form-control" id="quan" placeholder="Integer">
</div>

Brand:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="brand" placeholder="Text">
</div>

<table class="table">
	<tr>
		<?php
			if (isset($_GET["id"])) {
				echo "<th><button type=\"button\" class=\"btn btn-info\" id=\"button-save\" style=\"width: 100%\">Save</button></th>";
			}
			else {
				echo "<th><button type=\"button\" class=\"btn btn-success\" id=\"button-add\" style=\"width: 100%\">Add</button></th>";
			}
		?>
		<th><button type="button" class="btn btn-danger" id="button-clear" style="width: 100%">Clear</button></th>
	</tr>
</table>

<script type="text/javascript">
	$("#category-dropdown li").click(function() {
		$("#category").val($(this).text());
	});

	$("#button-add").click(function() {
		var data = {
			    "submit": "add",
			    "name": $("#name").val(),
			    "code": $("#code").val(),
			    "price": $("#price").val(),
			    "desc": $("#desc").val(),
			    "category": $("#category").val(),
			    "tag": $("#tag").val(),
			    "quan": $("#quan").val(),
			    "brand": $("#brand").val(),
			};
		console.log(JSON.stringify(data));
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {"submit":"add","name": $("#name").val(),
				"code": $("#code").val(),
				"price": $("#price").val(),
				"desc": $("#desc").val(),
				"category": $("#category").val(),
				"tag": $("#tag").val(),
				"quan": $("#quan").val(),
				"brand": $("#brand").val()}
// 				JSON.stringify(data)
		}).done(function(response) {
			alert(response);
			console.log(response);
			window.parent.closeModal();
		});
	});

	$("#button-clear").click(function() {
		$("#name").val(""); 
		$("#code").val("") ;
		$("#price").val("") ;
		$("#desc").val("") ;
		$("#category").val("") ;
		$("#tag").val("") ;
		$("#quan").val("") ;
		$("#brand").val("") ;		
	});

	$("#button-save").click(function() {

	});

	
</script>

<?php
	if (isset($_GET["id"])) {
		require_once ('inc/Product.php');
		require_once ('inc/ProductDescription.php');
		require_once ('inc/Category.php');
		require_once ('inc/Brand.php');
	
		$product = Product::GetProduct($_GET["id"]);
		$productdescs = $product->productDescription;	
		
		echo " 
			<script>
				$(\"#name\").val(\"{$productdescs->productName}\");
				$(\"#price\").val(\"{$product->price}\");
				$(\"#desc\").val(\"{$productdescs->description}\");
				$(\"#category\").val(\"{$productdescs->category->value}\");
				$(\"#tag\").val(\"{$productdescs->additiontag}\");
				$(\"#quan\").val(\"0\");
				$(\"#brand\").val(\"{$productdescs->brand->value}\");
			</script>
		";
	}
?>
