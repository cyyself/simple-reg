<?php
	include_once 'framework/all.php';
	$team = new Team;
?>
<!DOCTYPE html>
<html>
<?php head("首页"); ?>
	<body>
<?php navi_bar(1); ?>
<?php if ($_SESSION['username']) { ?>
<?php 	if ($team->get_team_belong($_SESSION['username'])) { ?>
<?php 		$teaminfo = $team->get_team_info($team->get_team_belong($_SESSION['username'])); ?>
	<div class="container">
			<div class="jumbotron">
				<h2>我的队伍</h2>
				<h3>队名：<?php echo htmlspecialchars($teaminfo['name']); ?></h3>
				<h3>报名状态：<?php echo htmlspecialchars($teaminfo['status']); ?></h3>
				<h3>队员信息：</h3>
				<table class="table table-striped table-bordered">
				<tr>
					<td>用户名</td>
					<td>姓名</td>
					<td>学号</td>
					<td>赛区</td>
					<td>操作</td>
				</tr>
<?php 		foreach ($teaminfo['people'] as $each) { ?>
				<tr>
					<td><?php echo htmlspecialchars($each['id']); ?></td>
					<td><?php echo htmlspecialchars($each['name']); ?></td>
					<td><?php echo htmlspecialchars($each['stu_id']); ?></td>
					<td><?php echo htmlspecialchars($each['region']); ?></td>
					<td>
						<button class="btn btn-default" onclick="delmate('<?php echo htmlspecialchars($each['id']); ?>');">
							删除队友
						</button>
					</td>
				</tr>
<?php 		} ?>
				</table>
				<p>
					<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add_member">添加队友</button>
					<button class="btn btn-default btn-lg" data-toggle="modal" data-target="#leave_team">退出队伍</button>
					<button class="btn btn-default btn-lg" data-toggle="modal" data-target="#mod_team">修改队伍信息</button>
				</p>
			</div>
		</div>
<?php 	} else { ?>
	<div class="container">
			<div class="jumbotron">
				<h1>你还加入任何队伍</h1>
				<p>
					若要加入他人队伍，只能由他人对您进行添加。
					<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#new_team">创建队伍</button>
				</p>
			</div>
		</div>
<?php 	} ?>
<?php } else { ?>
		<div class="container">
			<div class="jumbotron">
				<h1>未登录</h1>
				<p>
					<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#login">这就去登录</button>
					<button class="btn btn-default btn-lg" data-toggle="modal" data-target="#register">这就去注册</button>
				</p>
			</div>
		</div>
<?php } ?>
<?php foot(); ?>
	</body>
</html>
