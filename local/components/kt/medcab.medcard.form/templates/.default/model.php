<?
CJSCore::RegisterExt('babylon', array(
	'js' => array(
				$templateFolder.'/babylon.js',
				$templateFolder.'/model.js'
				),
	'skip_core' => true
));
CJSCore::Init('babylon');
?>
<?
echo "model";
?>
<BR>
<canvas id="renderCanvas"></canvas>
<script>
document.addEventListener("DOMContentLoaded", run("<?echo $templateFolder;?>"), false);
</script>