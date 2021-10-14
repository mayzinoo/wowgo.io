<?php
foreach($user->result() as $row):
?>
<h1><?php echo $row->id; ?></h1>
<h1><?php echo $row->name; ?></h1>
<h1><?php echo $row->address; ?></h1>
<h1><?php echo $row->phone; ?></h1>
<?php 
    $i++;
	endforeach; ?>