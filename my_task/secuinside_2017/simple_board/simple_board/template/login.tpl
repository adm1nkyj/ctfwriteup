<form action='' id='form' method='POST'>
	id : <input type='text' name='id' id='id'><br/>
	nick : <input type='text' name='nick' id='nick'><br/>
	pw : <input type='password' name='pw' id='pw'><br/>
</form>
<button id='login'>login</button><button id='register'>register</button>
<script>
	$('#login').click(function(){
		$('#form').attr('action', 'index.php?page=login');
		document.getElementById('form').submit();
	});
	$('#register').click(function(){
		$('#form').attr('action', 'index.php?page=register');
		document.getElementById('form').submit();
	});
</script>