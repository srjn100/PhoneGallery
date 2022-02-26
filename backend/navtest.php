<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="../library/bootstrap-4.3.1-dist/css/bootstrap.min.css" />

	<link rel="stylesheet" href="../library/bootstrap-4.3.1-dist/css/bootstrap-grid.css">
	<link rel="stylesheet" href="../library/css/custom.css" type="text/css">
	<script src="../library/js/custom.js"></script>
	<link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">

</head>
<body>
	<div>

		<nav class="navbar navbar-expand-sm bg-light fixed-top w-100 justify-content-end py-0 topB" >
			<ul class="navbar-nav font-weight-bold align-content-end">
				<li class="nav-item">
					<a class="nav-link" href="#">Link1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link 2</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link 3</a>
				</li>
			</ul>
		</nav>
		<nav class="navbar bg-dark fixed-top sideB" onmouseover="expand();" onmouseleave="//collapse();">
			<ul class="nav flex-column nav-pills w-100 vh-100 font-weight-bold">
				<li class="nav-item">
                    <i class="fas fa-tachometer-alt fa-1x icn"></i>
					<a class="nav-link active link"  href="#">Dashboard</a>
				</li>
				<li class="nav-item" onmouseover="toggle(0);">
					<i class="fas fa-bold fa-1x icn"></i>
					<a class="nav-link link"  href="#">Brands</a>
					<ul class="nav flex-column bg-light nav-pills w-100">
						<li class="nav-item slink">
							<a class="nav-link"   href="#">Insert Images</a>
							<a class="nav-link"   href="#">View Images</a>
						</li>
					</ul>
				</li>


				</li>
				<li class="nav-item" onmouseover="toggle(1)">
					<i class="fas fa-phone fa-1x icn"></i>
					<a class="nav-link link"   href="#">Phones</a>
				</li>
				<li class="nav-item slink">
					<ul class="nav flex-column bg-light nav-pills w-100">
						<li class="nav-item ">
							<a class="nav-link"   href="#">Insert Images</a>
							<a class="nav-link"   href="#">View Images</a>
						</li>
					</ul>
				</li>
				<li class="nav-item"  onmouseover="toggle(2);">
					<i class="fas fa-images fa-1x icn"></i>
				<a class="nav-link link"   href="#" >Images</a>
				</li>
				<li class="nav-item slink">
					<ul class="nav flex-column bg-light nav-pills w-100">
						<li class="nav-item ">
							<a class="nav-link"   href="#">Insert Images</a>
							<a class="nav-link"   href="#">View Images</a>
						</li>
					</ul>
				</li>

			</ul>
		</nav>
	</div>
	<div>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">First item</li>
            <li class="list-group-item">Second item</li>
            <li class="list-group-item">Third item</li>
            <li class="list-group-item">Fourth item</li>
        </ul>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">First item</li>
            <li class="list-group-item">Second item</li>
            <li class="list-group-item">Third item</li>
            <li class="list-group-item">Fourth item</li>
        </ul>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">First item</li>
            <li class="list-group-item">Second item</li>
            <li class="list-group-item">Third item</li>
            <li class="list-group-item">Fourth item</li>
        </ul>
		<br></div>
</body>
</html>