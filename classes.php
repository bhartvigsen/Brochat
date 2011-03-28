<?php

class chat {
        function register() {
        	include 'register.view';
	}
        function refresh() {
		SQL::idleping();
		include 'chatbox.view';
        }
        function pageview() {
		SQL::regcheck();
                if(isset($_POST['inputpane'])) {
			include 'jq.inc';
                        $chatdata = $_POST['inputpane'];
                        SQL::dbadd($chatdata);
                        chat::refresh();
                }
                if(isset($_POST['nickname'])) {
			include 'jq.inc';
			$nickname = $_POST['nickname'];
			$_SESSION['id'] = session_id();
                        $_SESSION['nickname'] = $nickname;
                        SQL::dbregister($nickname);
			SQL::idleping();
                        chat::refresh();
                }
		if(isset($_GET['register'])) {
			chat::register();	
			exit;
		}
		if(isset($_GET['refresh'])) {
			include 'jq.inc';
			chat::refresh();
		}
		if(!$_POST) {
			chat::refresh();
			SQL::idleping();
		}
        }
}

class SQL {
        function dbconnect() {
        	$link =  mysql_connect(DBHOST, DBNAME, DBPASS);
		if (!$link) {
				die('Could not connect: ' . mysql_error());
                        }
        }
	function dbregister($qstring) {
		if(!$qstring) {	
			include 'nonick.view';			
			exit;
		}
		SQL::dbconnect();
		mysql_real_escape_string($qstring);
		$qstring = htmlentities($qstring, ENT_QUOTES);
		$entered = '<span class="green"> *** ' . $qstring . ' has entered the room<br /></span>';
		$sesid = $_SESSION['id'];
		mysql_query("INSERT INTO brochat.chatlog(chat) VALUES('$entered')");
		mysql_query("INSERT INTO brochat.userlist (username, sessionid) VALUES ('$qstring', '$sesid')");
		SQL::dbclose();
	}
	function regcheck() {
		SQL::dbconnect();
		$xtime = time();
		$xtime -= 10;
		//$exited = '<span class="blue"> *** ' . $qstring . ' has left the room<br /></span>';
		$checkarray =  mysql_query('SELECT * from brochat.userlist WHERE ping <' . '"' . $xtime . '"');
		while ($tmpar = mysql_fetch_array($checkarray)) {
			$exited = '<span class="blue"> *** ' . $tmpar[1] . ' has left the room<br /></span>';
			mysql_query("INSERT INTO brochat.chatlog(chat) VALUES('$exited')");
			$delq = 'DELETE FROM brochat.userlist WHERE username = \'' . $tmpar[1] . '\'';
			mysql_query($delq);
		}
		SQL::dbclose();
	}
	function dbadd($freshdata) {
		SQL::dbconnect();
		$freshdata = substr($freshdata, 0, 255);
		$nvar = $_SESSION['nickname'];
		$nvar = htmlentities($nvar, ENT_QUOTES);
		$freshdata = htmlentities($freshdata, ENT_QUOTES);
		$freshdata = '&lt;' . $nvar . '&gt; ' . $freshdata . '<br />';
		mysql_real_escape_string($freshdata);
		mysql_query("INSERT INTO brochat.chatlog(chat) VALUES('$freshdata')");
		SQL::dbclose();
	}
	function dbclose() {
		mysql_close();
	}
	function getUsers() {
		SQL::dbconnect();
		$userlist  = mysql_query("SELECT * FROM brochat.userlist");
		$i = 0;
		while($names = mysql_fetch_array($userlist)) {
			$i++;
			echo '<option value="' . $i . '">' .  $names["username"] . '</option>';
		}
		SQL::dbclose();
	}
	function getChat() {
		SQL::dbconnect();
		$chatq = mysql_query("SELECT * FROM brochat.chatlog ORDER BY postid ASC");
		while($chattmp = mysql_fetch_array($chatq)) {
			echo misc::wrapline($chattmp["chat"], 65);
		}
		SQL::dbclose();
	}
	function idleping() {
		$sesid = $_SESSION['id'];
		SQL::dbconnect();
		$pingvar = time();
		$pingquery = 'UPDATE brochat.userlist SET ping="' . $pingvar . '" WHERE sessionid="' . $sesid . '"';
		mysql_query ($pingquery);
		SQL::dbclose();
	}
}

class misc {
        function wrapline($string,$width) {
                $s=explode(" ", $string);
                foreach ($s as $k=>$v) {
                $cnt=strlen($v);
                if($cnt>$width) $v=wordwrap($v, $width, "<br />", true);
                $new_string.="$v ";
        }
        return $new_string;
        }
}

?>
