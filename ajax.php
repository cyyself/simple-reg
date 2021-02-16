<?php
	include_once 'framework/all.php';
	$action = $_GET['action'];
	$res = array('code'=>0,'msg'=>'');
	switch ($action) {
		case 'register':
			$user = new User;
			if (!empty($_POST['pass'])) {
				if ($user->register($_POST['user'],$_POST['pass'],$_POST['name'],$_POST['stu_id'],$_POST['region'])) {
					$res['code'] = 1;
				}
				else $res['msg'] = "用户创建失败，可能是用户已经存在，若忘记密码请联系QQ群管理员。";
			}
			else $res['msg'] = "密码不可为空";
			break;
		case 'login':
			$user = new User;
			if ($user->check($_POST['user'],$_POST['pass'])) {
				$res['code'] = 1;
				$_SESSION['username'] = $_POST['user'];
			}
			else $res['msg'] = "用户或密码不正确";
			break;
		case 'logout':
			session_destroy();
			$res['code'] = 1;
			break;
		case 'passwd':
			$user = new User;
			if ($user->check($_SESSION['username'],$_POST['oldPass'])) {
				if ($user->passwd($_SESSION['username'],$_POST['newPass'])) {
					$res['code'] = 1;
				}
				$res['msg'] = "密码不合法";
			}
			else $res['msg'] = "旧密码不正确";
			break;
		case 'new_team':
			$team = new Team;
			if ($_SESSION['username']) {
				if (!$team->get_team_belong($_SESSION['username'])) {
					if ($team->add_team($_POST['name']) && $team->join_team($team->get_tid($_POST['name']),$_SESSION['username'])) {
						$res['code'] = 1;
					}
					else $res['msg'] = "队伍创建失败，可能是由于和别人重名";
				}
				else $res['msg'] = "已有队伍时不能创建队伍";
			}
			else $res['msg'] = "请先登录";
			break;
		case 'add_member':
			$team = new Team;
			if ($team->get_team_belong($_SESSION['username'])) {
				if ($team->join_team($team->get_team_belong($_SESSION['username']),$_POST['username'])) {
					$res['code'] = 1;
				}
				else $res['msg'] = "加入失败，对方可能已经有队伍或者对方还未注册。";
			}
			else $res['msg'] = "你没有加入任何队伍";
			break;
		case 'leave_team':
			$team = new Team;
			if ($team->get_team_belong($_SESSION['username'])) {
				if ($team->leave_team($team->get_team_belong($_SESSION['username']),$_SESSION['username'])) {
					$res['code'] = 1;
				}
				else $res['msg'] = "未知错误，建议联系QQ群中的管理员处理";
			}
			else $res['msg'] = "你没有加入任何队伍";
			break;
		case 'mod_team':
			$team = new Team;
			if ($_SESSION['username']) {
				$tid = $team->get_team_belong($_SESSION['username']);
				if ($tid) {
					if ($team->modify_team($tid,$_POST['name'])) {
						$res['code'] = 1;
					}
					else $res['msg'] = "队伍修改失败";
				}
				else $res['msg'] = "你似乎没有队伍";
			}
			else $res['msg'] = "请先登录";
			break;
		case 'del_mate':
			$team = new Team;
			$tid = $team->get_team_belong($_SESSION['username']);
			if ($tid) {
				if ($_SESSION['username'] != $_POST['id']) {
					if ($team->leave_team($tid,$_POST['id'])) {
						$res['code'] = 1;
					}
					else $res['msg'] = "未知错误，建议联系QQ群中的管理员处理";
				}
				else $res['msg'] = "若要删除自己，请使用退出队伍功能";
			}
			else $res['msg'] = "你没有加入任何队伍";
		default:
			break;
	}
	echo json_encode($res,true);
?>
