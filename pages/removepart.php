<?php if (!isset($_POST['goremove'])){?>
	<div id="popup_header" class="cAlign">
		<form id="removepartForm">
			Are you sure you want to remove <b><?php echo $_POST['partname']?></b> from the DB?
			<br><br>
			<input type="submit" value="Remove">
			<input type="button" class="OkButton" value="Cancel">
			<input type="hidden" name="partname" value="<?php echo $_POST['partname']?>">
			<input type="hidden" name="partID" value="<?php echo $_POST['partID']?>">
			<input type="hidden" name="goremove" value="1">
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#removepartForm').live('submit', function(event){
				event.preventDefault();
				$.ajax({
					type: "POST",
					url: "pages/removepart.php",
					data: $(this).serialize(),
					dataType: "text",
					success: function(response){
						$.colorbox({html:response});
					}
				});
			});
		});
	</script>
<?php ;} else {
	include_once('../data/config.php');
	$st = $db -> prepare("DELETE FROM parts WHERE ID = ?");
	$st->bindParam(1, $_POST['partID']);
	$st -> execute();
	$partfile = "../data/".$_POST['partname'].".xml";
	if (file_exists($partfile)) unlink($partfile);
	echo '<div id="popup_header"><b>'.$_POST['partname'].'</b> removed from the DB!<br><br>
			<form action="index.html"><input type="submit" value="Ok"></form></div>';
}
?>	