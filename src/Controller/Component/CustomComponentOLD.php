<?php

namespace App\Controller\Component;

use Cake\Mailer\Email;
use Cake\Controller\Component;

class CustomComponent extends Component {

    function __construct($prompt = null) {
        
    }

    public function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    function uploadFile($tmpName, $name, $path) {
        if ($name) {
            $file = strtolower($name);
            $fileExtention = $this->getExtension($file); //$extname = substr(strrchr($image, "."), 1);            
            if (!in_array($fileExtention, ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'doc', 'docx', 'pdf'])) {
                return false;
            } else {
                if (!is_dir($path)) {
                    mkdir($path);
                }
                $fileName = md5(time() . rand(100, 999)) . "." . $fileExtention;
                move_uploaded_file($tmpName, "$path/$fileName");
                return $fileName;
            }
        }
    }

    function uploadImage($tmp_name, $name, $path, $imgWidth) {
        if ($name) {
            $image = strtolower($name);
            $extname = $this->getExtension($image); //$extname = substr(strrchr($image, "."), 1);
            if (($extname != 'gif') && ($extname != 'jpg') && ($extname != 'jpeg') && ($extname != 'png') && ($extname != 'bmp')) {
                return false;
            } else {
                if ($extname == "jpg" || $extname == "jpeg") {
                    $src = imagecreatefromjpeg($tmp_name);
                } else if ($extname == "png") {
                    $src = imagecreatefrompng($tmp_name);
                } else {
                    $src = imagecreatefromgif($tmp_name);
                }
                list($width, $height) = getimagesize($tmp_name);

                if ($extname == 'gif' || $width <= $imgWidth) {
                    $time = time() . rand(100, 999);
                    $filepath = md5($time) . "." . $extname;
                    $targetpath = $path . $filepath;
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    move_uploaded_file($tmp_name, $targetpath);
                    return $filepath;
                } else {
                    $newwidth = $imgWidth;
                    $newheight = ($height / $width) * $newwidth;
                    $tmp = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    $time = time();
                    $filepath = md5($time) . "." . $extname;
                    $filename = $path . $filepath;
                    imagejpeg($tmp, $filename, 100);

                    imagedestroy($src);
                    imagedestroy($tmp);
                    return $filepath;
                }
            }
        }
    }

    function formatText($value) {
        $value = str_replace("“", "\"", $value);
        $value = str_replace("�?", "\"", $value);
        //$value = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $value);
        $value = stripslashes($value);
        $value = html_entity_decode($value, ENT_QUOTES);
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        $value = strtr($value, $trans);
        $value = stripslashes(trim($value));
        return $value;
    }

    function shortLength($value, $len) {
        $value_format = $this->formatText($value);
        $value_raw = html_entity_decode($value_format, ENT_QUOTES);

        if (strlen($value_raw) > $len) {
            $value_strip = substr($value_raw, 0, $len);
            $value_strip = $this->formatText($value_strip);
            $lengthvalue = "<span title='" . $value_format . "' rel='tooltip'>" . $value_strip . "...</span>";
        } else {
            $lengthvalue = $value_format;
        }
        return $lengthvalue;
    }

    function makeSeoUrl($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "-", $url);
            $value = trim($value, "-");
            return strtolower($value);
        }
    }

    function formatCustomField($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "_", $url);
            $value = trim($value, "_");
            return strtolower($value);
        }
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function generate_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    function generatePassword($length) {
        $vowels = 'aeuy';
        $consonants = '3@Z6!29G7#$QW4';
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    function generateUniqNumber($id = NULL) {
        $uniq = uniqid(rand());
        if ($id) {
            return md5($uniq . time() . $id);
        } else {
            return md5($uniq . time());
        }
    }

    function getRealIpAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function get_ip_address() {
        if (isSet($_SERVER)) {
            if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }

        return $realip;
    }

    function hashSSHA($password = NULL) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    public function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }

    function emailText($value) {
        $value = stripslashes(trim($value));
        $value = str_replace('"', "\"", $value);
        $value = str_replace('"', "\"", $value);
        $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        return stripslashes($value);
    }

    function formatEmail($msg, $arrData) {
        foreach ($arrData as $key => $value) {
            if (strstr($msg, "[" . $key . "]")) {
                $msg = str_replace("[" . $key . "]", $value, $msg);
            }
        }
        if (strstr($msg, "[SITE_NAME]")) {
            $msg = str_replace('[SITE_NAME]', "<a href='" . HTTP_ROOT . "'>" . SITE_NAME . "</a>", $msg);
        }
        if (strstr($msg, "[SUPPORT_EMAIL]")) {
            $msg = str_replace('[SUPPORT_EMAIL]', "<a href='mailto:" . SUPPORT_EMAIL . "'>" . SUPPORT_EMAIL . "</a>", $msg);
        }
        return $msg;
    }

    function sendEmail($to, $from, $subject, $message, $header = 1, $footer = 1) {

        if ($header) {
            $hdr = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
    <html>
    <head>
    <title>Free4lancer</title>
    </head>
    <body>
    <table width="750" style="font-family:arial helvetica sans-serif" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
        <td><table width="750" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td><a href="' . HTTP_ROOT . '"><img alt="" src="' . HTTP_ROOT . 'img/logo/smarthub-logo.png"/></a> </td>
                <td align="right" valign="bottom" style="font-family:arial;color:#0093dd;font-size:20px;padding:0 10px 10px 0">
                    <table border="0" align="right" cellspacing="0" cellpadding="0">
                    <tbody><tr><td height="25"></td></tr></tbody></table>
                </td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr> <td bgcolor="#0077b1"><div style="font-size:3px;color:#28a4e2">&nbsp;</div></td></tr>
        <tr> <td bgcolor="#b3efae"><div style="font-size:3px;color:#a6d9f3">&nbsp;</div></td> </tr>
        <tr> <td colspan="3" style="border:1px solid #c6c6c6"><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
            <tr>
                <td colspan="2" style="padding-left:12px;padding-right:12px;font-family:trebuchet ms,arial;font-size:13px">';
        }
        if ($footer) {

            $ftr = '</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr>
        <td height="34" bgcolor="#f1f1f1" style="border:solid 1px #c6c6c6;border-top:0px;font-family:arial;font-size:13px;text-align:center"><p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td width="150" style="font:12px Helvetica,sans-serif;color:#7b7b7b">EMAIL:<a target="_blank" style="text-decoration:none" href="' . SUPPORT_EMAIL . '"><font color="#f67d2c"> ' . SUPPORT_EMAIL . ' </font></a></td>
    <td width="150" style="font:12px Helvetica,sans-serif;color:#7b7b7b">&nbsp;</td>
    <td width="70" align="left" style="font:12px Helvetica,sans-serif;color:#7b7b7b;text-transform:uppercase"><strong>Follow Us On</strong></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Facebook" style="display:block;color:#ffffff" alt="Facebook" src="' . HTTP_ROOT . '/img/social/facebook.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Google Plus" style="display:block;color:#ffffff" alt="Google Plus" src="' . HTTP_ROOT . '/img/social/twitter_bird.png"></a></td>
    <!--<td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Pinterest" style="display:block;color:#ffffff" alt="Pinterest" src="' . HTTP_ROOT . '/img/social/googleplus.png"></a></td>-->
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="YouTube" style="display:block;color:#ffffff" alt="YouTube" src="' . HTTP_ROOT . '/img/social/pinterest.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Instagram" style="display:block;color:#ffffff" alt="Instagram" src="' . HTTP_ROOT . '/img/social/youtube.png"></a></td>
    </tr></tbody></table>
        </p></td>
        </tr>
    </tbody>
    </table>
    </body>
    </html>';
        }

        $message = $hdr . $message . $ftr;
        $to = $this->emailText($to);
        $subject = $this->emailText($subject);
        $message = $this->emailText($message);
        $message = str_replace("<script>", "&lt;script&gt;", $message);
        $message = str_replace("</script>", "&lt;/script&gt;", $message);
        $message = str_replace("<SCRIPT>", "&lt;script&gt;", $message);
        $message = str_replace("</SCRIPT>", "&lt;/script&gt;", $message);

//        echo $message;    exit;
        //Send Email by using Cakephp3.x
        $email = new Email('default');
        $email->from([$from => SITE_NAME])
                ->emailFormat('html')
                ->template(NULL)
                ->to($to)
                ->bcc("pradeepta20@gmail.com")
                ->subject($subject)
                ->send($message);

        //Send Email by core php        
//        $from = "Free4lancer<" . $from . ">";
//        $bcc = "prakash.kumarguru@gmail.com";
//        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers.= 'From:' . $from . "\r\n";
//        $headers.= 'BCC:' . $bcc . "\r\n";
//        if (mail($to, $subject, $message, $headers)) {
//            return true;
//        } else {
//            return false;
//        }
    }

    function random_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

}
