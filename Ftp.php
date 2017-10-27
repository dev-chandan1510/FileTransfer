session_start();

        if(isset($_SESSION['view'])){
          $_SESSION['view']=$_SESSION['view']+1;
        }else{
          $_SESSION['view']=1;
        }
        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $date = date("Y-m-d h-i-s",$date_array[1]);
        $sec = $date."-".$date_array[0];

        
        $makeName = (100000 + $_SESSION['view'])."-".$sec;

        set_include_path(get_include_path() . PATH_SEPARATOR . 'sshlib');
      
        include('sshlib/Net/SSH2.php');
        include 'sshlib/Net/SFTP.php';

        $sftp = new Net_SFTP('$host', 2222);

        if (!$sftp->login('$username', '$password')) {
            exit('Login Failed');
        }
        $sftp->chdir('remoteFolder');  // Folder to upload in
        $file = "filename";
        $sftp->put("/remoteFolder/".$file, "./localFolder/".$file, NET_SFTP_LOCAL_FILE);
        $sftp->rename("filename", $makeName.".csv");
