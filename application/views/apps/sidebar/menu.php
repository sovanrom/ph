<div class="treeview-animated">
<ul class="list-unstyled treeview-animated-list mb-">
	<li><a href="#" ><i class="fas fa-tachometer-alt"></i>Dashbord</a></li>
	<li class="treeview-animated-items" id="tree" ><a href="#">Product</a>
		<ul class="nested" id="sub" style="display: none;">
			<li><a href="#">IPHONE</a></li>
			<li><a href="#">OPPO</a></li>
			<li><a href="#">VIVO</a></li>
			<li><a href="#">SAMSUNG</a></li>
			<li><a href="#">MI</a></li>
			<li><a href="#">Ohter</a></li>
		</ul>
	</li>
	<li><a href="#">Category</a></li>
	<li><a href="#">Sale</a></li>
</ul>
</div>
<style type="text/css">
	a:link, a:visited {
	  width: 100%;
	  color: white;
	  padding: 14px 25px;
	  text-align: left;
	  text-decoration: none;
	  display: inline-block;
	}
	a:hover, a:active {
	  background-color: #ffff;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
	  $('#tree').on('click',  function(event) {
	  	event.preventDefault();
	  	$('#sub').toggle();
	  });
	});
</script>