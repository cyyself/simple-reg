<?php
class mainDB {
	var $conn;
	function __construct() {
		$this->conn = new PDO("sqlite:db/main.db");
		$this->conn->exec('PRAGMA foreign_keys=ON');
	}
}
class User extends mainDB{
	function __construct() {
		parent::__construct();
		$this->salt = "msc@cqu5212";
		$this->conn->exec("CREATE TABLE IF NOT EXISTS `user` (`username` TEXT PRIMARY KEY,`password` TEXT NOT NULL, `name` TEXT NOT NULL, `stu_id` TEXT, `region` TEXT NOT NULL);");
	}
	function register($user,$pass,$name,$stu_id,$region) {
		$pass = md5($pass . $this->salt);
		$stmt = $this->conn->prepare("INSERT INTO `user` VALUES (:user,:pass,:name,:stu_id,:region);");
		return $stmt->execute(array(':user'=>$user,':pass'=>$pass,':name'=>$name,':stu_id'=>$stu_id,':region'=>$region));
	}
	function check($user,$pass) {
		$pass = md5($pass . $this->salt);
		$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE `username` = :user AND `password` = :pass;");
		$stmt->execute(array(':user'=>$user,':pass'=>$pass));
		if (count($stmt->fetchAll()) != 0) return true;
		else return false;
	}
	function passwd($user,$pass) {
		$pass = md5($pass . $this->salt);
		$stmt = $this->conn->prepare("UPDATE `user` SET `password` = :pass WHERE `username` = :user;");
		return $stmt->execute(array(':user'=>$user,':pass'=>$pass));
	}
	function query_info($user) {
		$stmt = $this->conn->prepare("SELECT * FROM  `user` WHERE `username` = :user;");
		$stmt->execute(array(':user'=>$user));
		$res = $stmt->fetchAll();
		$res = $res[0];
		return array('name'=>$res['name'],'stu_id'=>$res['stu_id'],'region'=>$res['region']);
	}
}
class Team extends mainDB {
	function __construct() {
		parent::__construct();
		$this->conn->exec("CREATE TABLE IF NOT EXISTS `team` (`id` INTEGER CONSTRAINT team_pk PRIMARY KEY AUTOINCREMENT,`name` TEXT NOT NULL,`status` TEXT NOT NULL);CREATE UNIQUE INDEX IF NOT EXISTS `team_name_uindex` ON `team` (`name`);CREATE TABLE IF NOT EXISTS `team_join` (`tid` INTEGER, `username` TEXT, FOREIGN KEY (`username`) REFERENCES `user`(`username`));CREATE UNIQUE INDEX IF NOT EXISTS `team_join_uid_uindex` ON `team_join` (`username`);");
	}
	function add_team($name) {
		$stmt = $this->conn->prepare("INSERT INTO `team` VALUES (null,:name,'等待审核');");
		return $stmt->execute(array(':name'=>$name));
	}
	function get_team_belong($username) {
		$stmt = $this->conn->prepare("SELECT `tid` FROM `team_join` WHERE `username` = :name;");
		$stmt->execute(array(':name'=>$username));
		$res = $stmt->fetchAll();
		if (count($res)) return $res[0]['tid'];
		return false;
	}
	function query_member($tid) {
		$stmt = $this->conn->prepare("SELECT `username` FROM `team_join` WHERE `tid` = :tid LIMIT 4;");
		$stmt->execute(array(':tid'=>$tid));
		$res = $stmt->fetchAll();
		$member = array();
		foreach ($res as $each) {
			array_push($member,$each['username']);
		}
		return $member;
	}
	function get_team_info($tid) {
		$stmt = $this->conn->prepare("SELECT * FROM `team` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id'=>$tid));
		$res = $stmt->fetchAll();
		if (count($res)) {
			$teaminfo = array(
				'name'=>$res[0]['name'],
				'status'=>$res[0]['status'],
				'people'=>array(),
				'is_lock'=>$this->is_lock($tid)
			);
			$member = $this->query_member($tid);
			$User = new User;
			foreach ($member as $each) {
				$info = $User->query_info($each);
				array_push($teaminfo['people'],array('id'=>$each,'name'=>$info['name'],'stu_id'=>$info['stu_id'],'region'=>$info['region']));
			}
			return $teaminfo;
		}
		else return false;
	}
	function modify_team($tid,$name) {
		$ok = true;
		if ($name) {
			$stmt = $this->conn->prepare("UPDATE `team` SET `name` = :name WHERE `id` = :tid;");
			$ok &= $stmt->execute(array(':name'=>$name,':tid'=>$tid));
		}
		return $ok;
	}
	function join_team($tid,$username) {
		if (count($this->query_member($tid)) < 4) {
			$stmt = $this->conn->prepare("INSERT INTO `team_join` VALUES (:tid,:username);");
			return $stmt->execute(array(':tid'=>$tid,':username'=>$username));
		}
		else return false;
	}
	function is_lock($tid) {
		$stmt = $this->conn->prepare("SELECT `status` FROM `team` WHERE `id` = :id;");
		$stmt->execute(array(':id'=>$tid));
		$res = $stmt->fetchAll();
		return $res[0]['status'] == 'OK';
	}
	function leave_team($tid,$username) {
		$stmt = $this->conn->prepare("DELETE FROM `team_join` WHERE `tid`= :tid AND `username` = :username;");
		$ok = $stmt->execute(array(':tid'=>$tid,':username'=>$username));
		if (count($this->query_member($tid)) == 0) {
			$stmt = $this->conn->prepare("DELETE FROM `team` WHERE `id`= :id;");
			$stmt->execute(array(':id'=>$tid));
		}
		return $ok;
	}
	function has_permission($tid,$username) {
		$stmt = $this->conn->prepare("SELECT * FROM `team_join` WHERE `tid` = :tid AND `username` = :username LIMIT 1;");
		$stmt->execute(array(':tid'=>$tid,':username'=>$username));
		return count($stmt->fetchAll());
	}
	function get_tid($teamname) {
		$stmt = $this->conn->prepare("SELECT `id` FROM `team` WHERE `name` = :name;");
		$stmt->execute(array(':name'=>$teamname));
		$res = $stmt->fetchAll();
		if (count($res)) {
			return $res[0]['id'];
		}
		else return false;
	}
	function list_tid() {
		$stmt = $this->conn->prepare("SELECT `id` FROM `team` ORDER BY `id`;");
		$stmt->execute();
		$res = $stmt->fetchAll();
		$arr = array();
		foreach ($res as $each) {
			array_push($arr,$each['id']);
		}
		return $arr;
	}
}
?>
