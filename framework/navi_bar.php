<?php
	function navi_bar($id) {
		$project_name = "报名系统";
		$username = $_SESSION['username'];
		$items = array(
			array("name"=>"首页","url"=>"index.php"),
			array("name"=>"报名管理","url"=>"console.php")
		);
		?>
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">登录</h4>
					</div>
					<div class="modal-body">
						用户名：<input id='login_user' type="text" class="form-control" placeholder="" required autofocus>
						密码：<input id='login_pass' type="password" class="form-control" placeholder="123456" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="login_btn" type="button" class="btn btn-primary">登录</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">注册</h4>
					</div>
					<div class="modal-body">
						用户名：<input id='reg_user' type="text" class="form-control" placeholder="" required autofocus>
						学号：<input id='reg_stuid' type="text" class="form-control" placeholder="20198765" required>
						姓名：<input id='reg_name' type="text" class="form-control" placeholder="张三" required>
						密码：<input id='reg_pass' type="password" class="form-control" placeholder="123456" required>
						确认密码：<input id='reg_pass2' type="password" class="form-control" placeholder="123456" required>
						赛区：<select id='reg_region' class="form-control" required>
							<option value="赛区1">赛区1</option>
							<option value="赛区2">赛区2</option>
							<option value="赛区3">赛区3</option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="reg_btn" type="button" class="btn btn-primary">注册</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="passwd" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">修改密码</h4>
					</div>
					<div class="modal-body">
						旧密码：<input id='passwd_old' type="password" class="form-control" placeholder="123456" required>
						新密码：<input id='passwd_new' type="password" class="form-control" placeholder="abcdef" required>
						确认新密码：<input id='passwd_new2' type="password" class="form-control" placeholder="abcdef" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="passwd_btn" type="button" class="btn btn-primary">修改</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="new_team" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">创建队伍</h4>
					</div>
					<div class="modal-body">
						队伍名称：<input id="new_team_name" type="text" class="form-control" placeholder="队伍名称" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="new_team_btn" type="button" class="btn btn-primary">提交</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="mod_team" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">修改队伍信息</h4>
					</div>
					<div class="modal-body">
						队伍名称：<input id="mod_team_name" type="text" class="form-control" placeholder="若不修改这里可放空" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="mod_team_btn" type="button" class="btn btn-primary">提交</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="leave_team" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">退出队伍</h4>
					</div>
					<div class="modal-body">
						<p>
							确定要退出队伍吗？如果队伍里还有其他人，队伍将被保留。其他人依然在队伍中。
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="leave_team_btn" type="button" class="btn btn-primary">确定</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="add_member" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">添加队友</h4>
					</div>
					<div class="modal-body">
						队友用户名：<input id="member_username" type="text" class="form-control" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button id="add_member_btn" type="button" class="btn btn-primary">提交</button>
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><?php echo $project_name; ?></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
<?php
foreach ($items as $key => $value) {?>
						<li class="<?php echo $id==$key?'active':''; ?>"><a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a></li>
<?php } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
<?php if ($_SESSION['username']) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" id="passwd_show">修改密码</a></li>
								<li><a href="#" id="logout_btn">注销</a></li>
							</ul>
						</li>
<?php } else { ?>
						<li><a herf="#" id="login_show">登录</a></li>
						<li><a href="#" id="reg_show">注册</a></li>
<?php } ?>

					</ul>
				</div>
			</div>
		</nav><?php
	}
?>
