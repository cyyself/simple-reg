<?php
	function foot() {
?>
		<script>window.jQuery || document.write('<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"><\/script>')</script>
		<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script>
		$('#login_btn').on('click',function() {
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=login',
				data: {
					'user': $("#login_user").val(),
					'pass': $("#login_pass").val()
				},
				success: function(data){
					if (data.code) {
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});

		});
		$('#reg_btn').on('click',function() {
			if ($("#reg_pass").val() != $("#reg_pass2").val()) {
				alert("两次输入密码不符");
				return;
			}
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=register',
				data: {
					'user': $("#reg_user").val(),
					'stu_id': $("#reg_stuid").val(),
					'name': $("#reg_name").val(),
					'pass': $("#reg_pass").val(),
					'region': $("#reg_region").val()
				},
				success: function(data){
					if (data.code) {
						alert("注册成功，请登录");
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#logout_btn').on('click',function() {
			$.ajax({
				type: 'GET',
				url: 'ajax.php?action=logout',
				success: function(data){
					window.location.reload();
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#passwd_btn').on('click',function() {
			if ($("#passwd_new").val() != $("#passwd_new2").val()) {
				alert("两次输入密码不符");
				return;
			}
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=passwd',
				data: {
					'oldPass': $("#passwd_old").val(),
					'newPass': $("#passwd_new").val()
				},
				success: function(data){
					if (data.code) {
						alert("修改成功");
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#new_team_btn').on('click',function() {
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=new_team',
				data: {
					'name': $("#new_team_name").val()
				},
				success: function(data){
					if (data.code) {
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#add_member_btn').on('click',function() {
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=add_member',
				data: {
					'username': $("#member_username").val(),
				},
				success: function(data){
					if (data.code) {
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#leave_team_btn').on('click',function() {
			$.ajax({
				type: 'GET',
				url: 'ajax.php?action=leave_team',
				success: function(data){
					if (data.code) {
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#mod_team_btn').on('click',function() {
			$.ajax({
				type: 'POST',
				url: 'ajax.php?action=mod_team',
				data: {
					'name': $("#mod_team_name").val()
				},
				success: function(data){
					if (data.code) {
						window.location.reload();
					}
					else alert(data.msg);
				},
				dataType: 'json',
				error: function(){
					alert("网络错误");
				}
			});
		});
		$('#login_show').on('click',function() {
			$('#login').modal('show');
		});
		$('#reg_show').on('click',function() {
			$('#register').modal('show');
		});
		$('#passwd_show').on('click',function() {
			$('#passwd').modal('show');
		});
		function delmate(id) {
			if (confirm("你真的要删除这名队友吗？")) {
				$.ajax({
					type: 'POST',
					url: 'ajax.php?action=del_mate',
					data: {
						'id': id,
					},
					success: function(data){
						if (data.code) {
							window.location.reload();
						}
						else alert(data.msg);
					},
					dataType: 'json',
					error: function(){
						alert("网络错误");
					}
				});
			}
		}
		</script>
<?php
	}
?>
