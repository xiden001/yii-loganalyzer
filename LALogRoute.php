<?php
/**
 * LALogRoute class file.
 *
 * @author Samuel Adoga <samuel.adoga1@gmail.com>
 * @see forked from https://github.com/d4rkr00t/yii-loganalyzer
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version 0.3

 */
class LALogRoute extends CFileLogRoute
{
    /**
     * Formats a log message given different fields.
     * @param string $message message content
     * @param integer $level message level
     * @param string $category message category
     * @param integer $time timestamp
     * @return string formatted message
     */
    protected function formatLogMessage($message,$level,$category,$time)
    {
        $message .= '.-==-.';
        
        $ip = @$this->get_ip();
        if ($ip) {
            return @date('Y/m/d H:i:s',$time)." [ip:".$ip."] [$level] [$category] $message\n";
        } else {
            parent::formatLogMessage($message, $level, $category, $time);
        }
        
    }

    /**
     * @return ip
     */
    protected function get_ip()
    {
        $ip = false;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipa[] = trim(strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ','));
        
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipa[] = $_SERVER['HTTP_CLIENT_IP'];       
        
        if (isset($_SERVER['REMOTE_ADDR']))
            $ipa[] = $_SERVER['REMOTE_ADDR'];
        
        if (isset($_SERVER['HTTP_X_REAL_IP']))
            $ipa[] = $_SERVER['HTTP_X_REAL_IP'];
        

        foreach($ipa as $ips)
        {

            if($this->is_valid_ip($ips))
            {                    
                $ip = $ips;
                break;
            }
        }
        return $ip;
    }
    
    /**
     * @return boolean
     */
    protected function is_valid_ip($ip=null)
    {
        if(preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip))
            return true;
        
        return false;
    }

}
