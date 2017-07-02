<br/><br/><br/>
<button id="checkALL">checkALL</button><button id="delete">delete</button>
<script>
	$('#checkALL').click(function(){
		$("input[name=delete]:checkbox").each(function() {	
			$(this).attr("checked", true);
		});
	});
	$('#delete').click(function(){
		var tmp = '';
		var $form = $('<form></form>');
		$form.attr('action', 'index.php?page=delete&mode=multi');	
		$form.attr('method', 'POST');
		$form.appendTo('body');

		var uploader = $('<input type="hidden" value="'+getCookie("id")+'" name="uploader">');
		$form.append(uploader);
		$("input[name=delete]:checked").each(function() {
			var idx_valude = $(this).val();
			var idx = $('<input type="hidden" value="'+idx_valude+'" name="idx[]">');
			$form.append(idx);
		});
		$form.submit();
	});
	function getCookie(name) {
		var value = "; " + document.cookie;
		var parts = value.split("; " + name + "=");
		if (parts.length == 2) return parts.pop().split(";").shift();
	}
</script>