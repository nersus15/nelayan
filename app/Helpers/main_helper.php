<?php

use Config\Database;

if (!function_exists('getMimeType')) {
    function getMimeType($ext)
    {
        switch ($ext) {
            case "pdf":
                $ctype = "application/pdf";
                break;
            case "exe":
                $ctype = "application/octet-stream";
                break;
            case "zip":
                $ctype = "application/zip";
                break;
            case "docx":
                $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                break;
            case "doc":
                $ctype = "application/msword";
                break;
            case "csv":
            case "xls":
            case "xlsx":
                $ctype = "application/vnd.ms-excel";
                break;
            case "ppt":
                $ctype = "application/vnd.ms-powerpoint";
                break;
            case 'pptx':
                $ctype = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                break;
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            case "tif":
            case "tiff":
                $ctype = "image/tiff";
                break;
            case "psd":
                $ctype = "image/psd";
                break;
            case "bmp":
                $ctype = "image/bmp";
                break;
            case "ico":
                $ctype = "image/vnd.microsoft.icon";
                break;
            default:
                $ctype = "application/force-download";
        }

        return $ctype;
    }
}

if (!function_exists('response')) {
    function response($message = '', $code = 200, $type = 'success', $format = 'json')
    {
        http_response_code($code);
        $responsse = array();
        if ($code != 200)
            $type = 'Error';

        if (is_object($message))
            $message = (array) $message;
        if (is_string($message) || is_int($message) || is_bool($message))
            $responsse['message'] = $message;
        else
            $responsse = $message;

        if (!isset($message['type']))
            $responsse['type'] = $type;
        else
            $responsse['type'] = $message['type'];

        if ($code != 200 && $format == 'json')
            header("message: " . json_encode($responsse));

        if ($format == 'json') {
            header('Content-Type: application/json');
            echo json_encode($responsse);
        } elseif ($format == 'html') {
            echo '<script> var path = "' . base_url() . '"</script>';
            echo $responsse['message'];
        }
        exit();
    }
}

if (!function_exists('httpmethod')) {
    function httpmethod($method = 'POST')
    {
        return $_SERVER['REQUEST_METHOD'] == strtoupper($method);
    }
}
if (!function_exists('reverse')) {
    function reverse($str)
    {
        return ($str === '') ? '' :  reverse(substr($str, 1)) . $str[0];
    }
}

if (!function_exists('sessiondata')) {
    function sessiondata($index = 'login', $kolom = null, $default = null)
    {
        $session = session();
        $data = $session->get($index);
        if (is_null($data)) return $data;
        if (is_array($data) && !empty($kolom))
            return isset($data[$kolom]) ? $data[$kolom] : $default;

        return $data;
    }
}

if (!function_exists('waktu')) {
    function waktu($waktu = null, $format = MYSQL_TIMESTAMP_FORMAT)
    {
        $waktu = empty($waktu) ? time() : $waktu;
        return date($format, $waktu);
    }
}

if (!function_exists('myOS')) {
    function myOS()
    {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }

        return $os_platform;
    }
}
if (!function_exists('config_sidebar')) {
    function config_sidebar($sidebar, int $activeMenu = 0, int $activeSubMenu = null, $configName = 'menu')
    {
        // $ci = '';

        // $ci->load->config($configName);
        // $compConf = $ci->config->item('menu');
        // $sidebarConf = $compConf[$sidebar];
        // if (!is_null($activeMenu))
        //     $sidebarConf[$activeMenu]['active'] = true;

        // if (!is_null($activeSubMenu) && isset($sidebarConf[$activeMenu]['sub'])) {
        //     $sidebarConf[$activeMenu]['sub'][$activeSubMenu]['active'] = true;
        // }

        // // Tandai sebagai menu sidebar
        // foreach ($sidebarConf as $k => $m) {
        //     $sidebarConf[$k]['parrent_element'] = 'sidebar';
        //     $sidebarConf[$k]['id'] = '-';
        // }

        // $menus = [];
        // $subMenus = [];

        // foreach ($sidebarConf as $v) {
        //     $menus[] = $v;
        //     if (isset($v['sub']) && !empty($v['sub'])) {
        //         $subMenus[] = ['induk' => str_replace('#', '', $v['link']), 'menus' => $v['sub']];
        //     }
        // }

        // foreach ($menus as $k => $v) {
        //     if (isset($v['sub']))
        //         unset($menus[$k]['sub']);
        // }

        // if (!empty($subMenus)) {
        //     foreach ($subMenus as $k => $sb) {
        //         foreach ($sb['menus'] as $k2 => $v2) {
        //             $subMenus[$k]['menus'][$k2]['parrent_element'] = 'sidebar';
        //         }
        //     }
        // }
        // return ['menus' => $menus, 'subMenus' => $subMenus];
    }
}

if (!function_exists('random')) {
    function random($length = 5, $type = 'string')
    {
        $characters = $type == 'string' ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $type == 'string' ? $randomString : intval($randomString);
    }
}
if (!function_exists('is_login')) {
    function is_login($role = null, $user = null, $callback = null)
    {
        $session = session();
        $db = Database::connect();

        $userdata = $session->get('login');
        if (!empty($userdata) && SYNC_DATAUSER) {
            $u  = $db->table('users')->select('*')
                ->where('username', $userdata['username'])
                ->get()->getResultArray();

            if (count($u) > 1 || empty($u))
                return false;
            else
                $session->set('login', $u[0]);

            $userdata = $u[0];
        }

        if (!empty($callback) && is_callable($callback))
            return $callback($role, $user, $userdata);

        if (!empty($userdata) && !isset($userdata['role'])) {
            if (!empty($user)) {
                return $userdata['username'] == $user;
            } else {
                return !empty($userdata);
            }
        } elseif (empty($userdata)) return false;

        if (empty($role) && empty($user)) {
            return !empty($userdata);
        } elseif (!empty($userdata) && !empty($role) && empty($user)) {
            return is_array($role) ? in_array($userdata['role'], $role) : $userdata['role'] == $role;
        } elseif (!empty($userdata) && empty($role) && !empty($user)) {
            return is_array($user) ? in_array($userdata['username'], $user) : $userdata['username'] == $user;
        } elseif (!empty($userdata) && !empty($role) && !empty($user)) {
            return $userdata['username'] == $user && $userdata['role'] == $role;
        }
    }
}

if (!function_exists('verify_token')) {

    function verfify_token($token)
    {
        // if (empty($token)) {
        //     return [false, ['messaage' => 'Token kosong!', 'type' => 'error']];
        // }

        // try {
        //     $data = JWT::decode($token, 'penerbit.nahnumedia.by.kamscode', array('HS256'));
        //     return [true, $data];
        // } catch (\Throwable $err) {
        //     response(['messaage' => 'Token Invalid!', 'type' => 'error', 'error' => $err], 500);
        // }
    }
}

if (!function_exists('addResourceGroup')) {
    // function addResourceGroup($names, $removed = [], $type = null, $pos = null, $return = true)
    // {

    //     $type = empty($type) ? 'semua' : $type;
    //     $pos = empty($pos) ? 'head' : $pos;

    //     /** @var CI_Controller $ci */
    //     $ci = &get_instance();
    //     $isLoaded = $ci->load->config('themes');
    //     $resourceText = '';
    //     $configitem = $ci->config->item('themes');
    //     // Remove From Group
    //     foreach ($names as $name) {
    //         if (!empty($removed) && in_array($name, array_keys($removed)) && in_array($name, array_keys($configitem))) {
    //             $currentItem = $removed[$name];
    //             $Tcss = isset($configitem[$name]['css']) ? $configitem[$name]['css'] : [];
    //             $Tjs = isset($configitem[$name]['js']) ? $configitem[$name]['js'] : [];

    //             $css = array_map(function ($arr) {
    //                 return $arr['src'];
    //             }, $Tcss);

    //             $js = array_map(function ($arr) {
    //                 return $arr['src'];
    //             }, $Tjs);

    //             $Fcss = array_diff($css, $currentItem);
    //             $Fjs = array_diff($js, $currentItem);

    //             // Re Assemble Sources
    //             $configitem[$name]['css'] = array_filter($Tcss, function ($arr) use ($Fcss) {
    //                 return in_array($arr['src'], $Fcss);
    //             });

    //             $configitem[$name]['js'] = array_filter($Tjs, function ($arr) use ($Fjs) {
    //                 return in_array($arr['src'], $Fjs);
    //             });
    //             log_message('INFO', "=================== REMOVE RESOURECE FROM RESOURCES GROUOP ==============" . print_r(['Tcss' => $Tcss, 'Tjs' => $Tjs, 'css' => $css, 'js' => $js, 'reoved' => $removed, 'Fcss' => $Fcss, 'Fjs' => $Fjs, 'reassemble' => $configitem[$name]], true));
    //         }
    //         if (!isset($configitem[$name]) || empty($configitem[$name])) return null;
    //         if ($type == 'semua') {
    //             if (!$isLoaded || empty($configitem[$name]))
    //                 return null;
    //             foreach ($configitem[$name] as $k => $v) {
    //                 foreach ($v as $resource) {
    //                     if (isset($resource['type']) && $resource['type'] == 'inline') {
    //                         if ($k == 'js')
    //                             $resourceText .= $resource['pos'] == $pos ? "<script>" . $resource['src'] . "</script>" : null;
    //                         elseif ($k == 'css')
    //                             $resourceText .= $resource['pos'] == $pos ?  "<style>" . $resource['src'] . "</style>" : null;
    //                     } else {
    //                         $resource['src'] = isset($resource['type']) && $resource['type'] == 'cdn' ? $resource['src'] : base_url('public/assets/' . $resource['src']);
    //                         if ($k == 'js')
    //                             $resourceText .= $resource['pos'] == $pos ? "<script src='{$resource['src']}'></script>" : null;
    //                         elseif ($k == 'css')
    //                             $resourceText .= $resource['pos'] == $pos ? "<link rel='stylesheet' href='{$resource['src']}'></link>" : null;
    //                     }
    //                 }
    //             }
    //         } else {
    //             if (!$isLoaded || empty($configitem[$name][$type]))
    //                 return null;
    //             foreach ($configitem[$name][$type] as $k => $v) {
    //                 if (isset($v['type']) && $v['type'] == 'cdn')
    //                     $v['src'] = $v['src'];
    //                 else
    //                     $v['src'] = base_url('public/assets/' . $v['src']);

    //                 if ($type == 'js') {
    //                     if ($v['pos'] == $pos)
    //                         $resourceText .= "<script src='{$v['src']}'></script>";
    //                 }
    //                 if ($type == 'css') {
    //                     if ($v['pos'] == $pos)
    //                         $resourceText .= "<link rel='stylesheet' href='{$v['src']}'></link>";
    //                 }
    //             }
    //         }
    //     }
    //     if ($return)
    //         return $resourceText;
    //     else
    //         echo $resourceText;
    // }
}


if (!function_exists('rupiah_format')) {
    function rupiah_format($angka)
    {
        $hasil_rupiah = "Rp. " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}


// CONVERT PATH
if (!function_exists('get_path')) {
    function get_path($path)
    {
        return DIRECTORY_SEPARATOR == '/' ? str_replace('\\', '/', $path) : str_replace('/', '\\', $path);
    }
}

if (!function_exists('attribut_ke_str')) {
    function attribut_ke_str($attribute, $delimiter = ' ', $dg_quote = true)
    {
        $str = '';
        if (is_array($attribute)) {
            foreach ($attribute as $key => $value) {
                if ($value !== '0' && empty($value))
                    $str .= $key;
                else {
                    $str .= $key . '=';
                    if (is_array($value))
                        $value = implode(' ', $value);
                    $str .= $dg_quote ? '"' . $value . '"' : $value;
                }
                $str .= $delimiter;
            }

            $str = substr($str, 0, strlen($str) - strlen($delimiter));
        }
        return $str;
    }
}

if (!function_exists('str_ke_attribut')) {
    function str_ke_attribut($str, $delimiter = '/[=\n]/')
    {
        $attribute = array();

        $a = preg_split($delimiter, $str, -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($a); $i += 2) {
            $attribute[$a[$i]] = $a[$i + 1];
        }
        return $attribute;
    }
}

if (!function_exists('toolbar_items')) {
    function toolbar_items($toolbar, &$items = array())
    {
        if ((isset($toolbar['tipe']) && ($toolbar['tipe'] == 'link' || $toolbar['tipe'] == 'dropdown')) || isset($toolbar['href'])) {
            $items[] = $toolbar;
            return;
        }
        if (!is_array($toolbar))
            return;

        foreach ($toolbar as $t) {
            if (!is_array($t))
                continue;

            foreach ($t as $n) {
                toolbar_items($n, $items);
            }
        }
    }
}

if (!function_exists('starWith')) {
    function startWith($haystack, $needle)
    {
        $length = strlen($needle);
        return substr($haystack, 0, $length) === $needle;
    }
}

if (!function_exists('endWith')) {
    function endWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }
}

if (!function_exists('sandi')) {
    /**
     * @param String $text
     * @param String $type ['AN', 'AZ'] - [default: 'AN']
     * @return String
     */
    function sandi($text, $type = "AN")
    {
        $result = null;
        $an = [
            'a' => 'n',
            'b' => 'o',
            'c' => 'p',
            'd' => 'q',
            'e' => 'r',
            'f' => 's',
            'g' => 't',
            'h' => 'u',
            'i' => 'v',
            'j' => 'w',
            'k' => 'x',
            'l' => 'y',
            'm' => 'z',
            'A' => 'N',
            'B' => 'O',
            'C' => 'P',
            'D' => 'Q',
            'E' => 'R',
            'F' => 'S',
            'G' => 'T',
            'H' => 'U',
            'I' => 'V',
            'J' => 'W',
            'K' => 'X',
            'L' => 'Y',
            'M' => 'Z',
            '-' => '+',
            '_' => '=',
            '@' => '#',
            '&' => '!',
            ' ' => '*',
        ];
        $az = [
            'a' => 'z',
            'b' => 'y',
            'c' => 'x',
            'd' => 'w',
            'e' => 'v',
            'f' => 'u',
            'g' => 't',
            'h' => 's',
            'i' => 'r',
            'j' => 'q',
            'k' => 'p',
            'l' => 'o',
            'm' => 'n',
            'n' => 'm',
            'o' => 'l',
            'p' => 'k',
            'q' => 'j',
            'r' => 'i',
            's' => 'h',
            't' => 'g',
            'u' => 'f',
            'v' => 'e',
            'w' => 'd',
            'x' => 'c',
            'y' => 'b',
            'z' => 'a',

            'A' => 'N',
            'B' => 'O',
            'C' => 'P',
            'D' => 'Q',
            'E' => 'R',
            'F' => 'S',
            'G' => 'T',
            'H' => 'U',
            'I' => 'V',
            'J' => 'W',
            'K' => 'X',
            'L' => 'Y',
            'M' => 'Z',

            '-' => '+',
            '_' => '=',
            '@' => '#',
            '&' => '!',
            ' ' => '*',
        ];
        $an_flip = array_flip($an);
        $az_flip = array_flip($az);
        if ($type == "AN") {
            foreach (str_split($text) as $char) {
                if (isset($an[$char]))
                    $result .= $an[$char];
                elseif (isset($an_flip[$char]))
                    $result .= $an_flip[$char];
            }
        } else if ($type == "AZ") {
            foreach (str_split($text) as $char) {
                if (isset($az[$char]))
                    $result .= $az[$char];
                elseif (isset($az_flip[$char]))
                    $result .= $az_flip[$char];
            }
        }
        return $result;
    }
}

if (!function_exists('assets_url')) {
    function assets_url($path = null)
    {
        return base_url('assets/' . $path);
    }
}

if (!function_exists('contentview_url')) {
    function contentview_url($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "futsal", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}
if (!function_exists('buat_tabel')) {
    function buat_tabel($header, $data)
    {
    }
}
if (!function_exists('kapitalize')) {
    function kapitalize($string, $tipe = 'firstword')
    {
        if ($tipe == 'all') {
            return strtoupper($string);
        } elseif ($tipe == 'first') {
            return ucfirst(strtolower($string));
        } elseif ($tipe == 'firstword') {
            $str = explode(' ', $string);
            $tmp = [];
            foreach ($str as $s) {
                $tmp[] = ucfirst(strtolower($s));
            }

            return join(' ', $tmp);
        }
    }
}

if (!function_exists('getAuthorizationHeader')) {
    /** 
     * Get header Authorization
     * */
    function getAuthorizationHeader()
    {
        $headers =  sessiondata('login', 'token');

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}

if (!function_exists('getBearerToken')) {
    /**
     * get access token from header
     * */
    function getBearerToken()
    {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return $headers;
    }
}

if (!function_exists('post_curl')) {
    function post_curl($url, $data, $opsi = [])
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
            curl_close($curl);
            return json_decode($response);
        } catch (\Throwable $th) {
            //throw $th;
            response(['message' => 'Terjadi kesalahan', 'err' => $th->getMessage()]);
        }
    }
}
if (!function_exists('get_curl')) {
    function get_curl($url, $opsi = [])
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return json_decode($response);
        } catch (\Throwable $th) {
            //throw $th;
            response(['message' => 'Terjadi kesalahan', 'err' => $th->getMessage()]);
        }
    }
}
if (!function_exists('url_safe_base64_encode')) {
    function url_safe_base64_encode($data)
    {
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($data));
    }
}

if (!function_exists('url_safe_base64_decode')) {
    function url_safe_base64_decode($data)
    {
        $base_64 = str_replace(array('-', '_'), array('+', '/'), $data);
        return base64_decode($base_64);
    }
}

if (!function_exists('base64_to_url_safe_base64')) {
    function base64_to_url_safe_base64($data)
    {
        return str_replace(array('+', '/', '='), array('-', '_', ''), $data);
    }
}

if (!function_exists('url_safe_base64_to_base64')) {
    function url_safe_base64_to_base64($data)
    {
        return str_replace(array('-', '_'), array('+', '/'), $data);
    }
}
if (!function_exists('getExt')) {
    function getExt($filename, $extOnly = false)
    {
        $tmp = explode('.', $filename);
        $ext = end($tmp);
        $fname = str_replace('.' . $ext, '', $filename);

        return $extOnly ? $ext : ['extension' => $ext, 'filename' => $fname];
    }
}
if(!function_exists('c_isset')){
    function c_isset($arr, $key){
        $keys = array_keys(is_object($arr) ? (array) $arr : $arr);
        return in_array($key, $keys);
    }
}

if(!function_exists('fieldmapping')){
    function fieldmapping($config, $input, $defaultValue = array(), $petaNilai = array()){
        $configitem = config('Forms');
        $adaDefault = count($defaultValue) > 0;
        $adaPeta = count($petaNilai) > 0;
        $field = array();
        if(!file_exists(APPPATH . 'config/Forms.php') || empty($configitem->$config))
            response(['message' => 'Config form ' . $config . ' Tidak ditemukan'], 404);
        
        foreach($configitem->$config as $k => $v){
            if($adaDefault && c_isset($defaultValue, $k)){
                if(c_isset($input, $k) && (is_null($input[$k]) || $input[$k] == ''))
                    $field[$v] = $defaultValue[$k];
                else
                    $field[$v] = $input[$k];
            }elseif((!$adaDefault || !c_isset($defaultValue, $k)) && c_isset($input, $k))
                $field[$v] = $input[$k];
        }
        
        
        if($adaPeta){
            foreach($petaNilai as $key => $f){
                foreach($f as $k => $v){
                    if($field[$key] == $k)
                        $field[$key] = $v;
                }
            }
        }
        foreach($field as $k => $f){
            if($f == '#unset') // nanti jika dia defaultnya unset dia dihapus dari arraya agar tidak update kolom itu
                unset($field[$k]);
        }
        return $field;
    }
}

if(!function_exists('reversemapping')){
    function reversemapping($config, $input, $defaultValue = array(), $petaNilai = array(), $batch = false){
        $configitem = config('Forms');
        $adaDefault = count($defaultValue) > 0;
        $adaPeta = count($petaNilai) > 0;
        $field = array();
        $input = (array) $input;
        if(!file_exists(APPPATH . 'config/Forms.php') || empty($configitem->$config))
            response(['message' => 'Config form ' . $config . ' Tidak ditemukan'], 404);
        if($batch){
            foreach($input as $k => $v){
                $field[$k] = reversemapping($config, $v, $defaultValue, $petaNilai);
            }
            return $field;
        }

        foreach($configitem->$config as $k => $v){
            if($adaDefault && c_isset($defaultValue, $v)){
                if(c_isset($input, $v) && (is_null($input[$v]) || $input[$v] == ''))
                    $field[$k] = $defaultValue[$v];
                else
                    $field[$k] = $input[$v];
            }elseif((!$adaDefault || !c_isset($defaultValue, $v)) && c_isset($input, $v))
                $field[$k] = $input[$v];
        }
        
        
        if($adaPeta){
            foreach($petaNilai as $key => $f){
                foreach($f as $k => $v){
                    if($field[$key] == $k)
                        $field[$key] = $v;
                }
            }
        }
        foreach($field as $k => $f){
            if($f == '#unset') // nanti jika dia defaultnya unset dia dihapus dari arraya agar tidak update kolom itu
                unset($field[$k]);
        }
        return $field;
    }
}
if ( ! function_exists('prefiks_wilayah'))
{
	function prefiks_wilayah($wilayah)
	{
		if (empty($wilayah) || strlen($wilayah) != 13) return null;
		return $wilayah == '00.00.00.0000' ? '' : str_replace(array('.0000', '.00'), array('', ''), $wilayah);
	}
}
if ( ! function_exists('level_wilayah'))
{
	function level_wilayah($wilayah)
	{
		$ln = strlen($wilayah);
		if ($ln == 13)
			$ln = strlen(prefiks_wilayah($wilayah));
		return intval(($ln + 1) / 3);
	}
}