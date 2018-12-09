<?php require_once 'resources/views/partials\header.tmpl.php';?>
<?php require_once 'resources/views/partials/nav.tmpl.php'; ?>
<h1>Main Page</h1>
<div>All goods</div>
<ul>
<?php foreach ($users as $Lname=>$name):?>
	<li><span><?=$name?></span> <span><?=$Lname?></span></li>
		<?php endforeach; ?>
</ul>
<div><?=$all?></div>
<?php require_once 'resources/views/partials/footer.tmpl.php'; ?>