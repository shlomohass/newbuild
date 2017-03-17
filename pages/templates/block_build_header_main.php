<?php
// TODO: Add some guards to prevent loading without $block defined!

// $block -> [{title},{img_path}];

?>
<h1>
<img src="<?php echo $block[1]; ?>" />
<?php echo $block[0]; ?>
</h1>