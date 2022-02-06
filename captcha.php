<?php
if(empty($_POST['server'])) $_POST['server'] = "";
?>

<center><br><br><script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<form id="frmContact" action="" method="POST" novalidate="novalidate">
   <div class="g-recaptcha" data-sitekey="6Lel5DYUAAAAAP8ug3x37uloU_hnIEdLFapmhx64"></div>
   <br>Server : <input type="text" name="server" value="<?=$_POST['server']?>">
   <input type="Submit" name="Submit">
</form>
<br><br>Result  :<br>
<?php
if(!empty($_POST['g-recaptcha-response'])){
    $captcha = $_POST['g-recaptcha-response'];
    $password = "Agoda12345";
    $domain = "gmail.com";
    $server = $_POST['server'];
    $c = curl($server, $captcha, $password, $domain);
    echo $c;
    if(@json_decode($c, true)['success']) @file_put_contents("akun_agoda.txt", "$c\n", FILE_APPEND);
}

function curl($server, $captcha, $password, $domain){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://$server/api.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, "captcha=$captcha&password=$password&domain_mail=$domain");
    $headers = array();
    $headers[] = 'Host: '.$server;
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Connection: close';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
