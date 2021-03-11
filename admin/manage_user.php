<?php
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-user" method="post">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $_POST['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $_POST['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $_POST['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($_POST['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(isset($_POST['type']) && $_POST['type'] == 3): ?>
			<input type="hidden" name="type" value="3">
		<?php else: ?>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($_POST['type']) && $_POST['type'] == 2 ? 'selected': '' ?>>Admin</option>
				<option value="1" <?php echo isset($_POST['type']) && $_POST['type'] == 1 ? 'selected': '' ?>>Staff</option>
			</select>
		</div>
		<?php endif; ?>
		<?php endif; ?>


	</form>
</div>
<script>
    $('.text-jqte').jqte();

    $('#manage-user').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=admin_class.php',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',

			success:function(resp){
                if(resp ==1){
                    alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				 else{
				$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
				 	end_load()
				}
			}
		})


    })

</script>