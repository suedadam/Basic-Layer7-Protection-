<?php
/*
Free Layer 7 protection script. 
   ------------------------------------------------------------


   ================= Setup ============================
   ------------------------------------------------------------
   Copy this file and folder to same as index.php.
   Add following line to your ndex.php
   "<?php" 
   include("l7.php");
*/

  //   Set Value as ur choice
  $crlf=chr(13).chr(10);
  $itime=3;  // minimum number of seconds between one-visitor visits
  $imaxvisit=10;  // maximum visits in $itime x $imaxvisits seconds
  $ipenalty=($itime * $imaxvisit);  // minutes for waitting
  $iplogdir="./l7/";
  $iplogfile="AttackersIPs.Log";
  
  // Time
  $today = date("Y-m-j,G");
  $min = date("i");
  $sec = date("s");
  $r = substr(date("i"),0,1);
  $m =  substr(date("i"),1,1);
  $minute = 0;
  
//Email Notification. 
  $to      = 'suedadam@gmail.com';  //Your Admin Email
  $headers = 'From: Possible DDoS Attack. ' . "\r\n" .   // Set to what you want. 
    		 'X-Mailer: yourdomain.com Is under Attack';
  $subject = "Warning of Possible DoS Attack @ $today:$min:$sec";
  

  //     Warning Messages:
  $message1='<font color="red">Under Possible DDoS Attack.</font><br>';
  $message2='Please Wait. ';
  $message3='Please try in a few minutes. <br>';
  $message4='<font color="blue">Protected by CDNSolutions Free L7 Block Script</font><br>If you are a human, change IP. <br>We temporarily banned IP <b>'.$_SERVER["REMOTE_ADDR"].' </b>from a possible DoS attack.';
  $message5=' Your site got attacked by :'.$_SERVER["REMOTE_ADDR"];
  $message6='<br><img src="./l7/cross.gif" alt="" border="0">'; //Set your own Image to your wish, I will give you one if you want.  
//---------------------- End of Basic Config.  ---------------------------------------  

  //     Get time:
  $ipfile=substr(md5($_SERVER["REMOTE_ADDR"]),-3);  // -3 means 4096 possible files
  $oldtime=0;
  if (file_exists($iplogdir.$ipfile)) $oldtime=filemtime($iplogdir.$ipfile);

  //     Update times:
  $time=time();
  if ($oldtime<$time) $oldtime=$time;
  $newtime=$oldtime+$itime;

  //     Bot Detect
  if ($newtime>=$time+$itime*$imaxvisit)
  {
    touch($iplogdir.$ipfile,$time+$itime*($imaxvisit-1)+$ipenalty);
    header("HTTP/1.0 503 Service Temporarily Unavailable");
    header("Connection: close");
    header("Content-Type: text/html");
    echo '<html><head><title>Overload Warning by CDNSolutions free Layer 7 block Script</title></head><body><p align="center"><strong>'
          .$message1.'</strong>'.$br;
    echo $message2.$ipenalty.$message3.$message4.$message6.'</p></body></html>'.$crlf;
   //    Mail sending
     {
	@mail($to, $subject, $message5, $headers);	
     }
    //     logging
    $fp=@fopen($iplogdir.$iplogfile,"a");
    if ($fp!==FALSE)
    {
      $useragent='<unknown user agent>';
      if (isset($_SERVER["HTTP_USER_AGENT"])) $useragent=$_SERVER["HTTP_USER_AGENT"];
      @fputs($fp,$_SERVER["REMOTE_ADDR"].' on '.date("D, d M Y, H:i:s").' as '.$useragent.$crlf);
    }
    @fclose($fp);
    exit();

  }

  //     Modifying File Time. 
  touch($iplogdir.$ipfile,$newtime);

?>