<?php
error_reporting(0);

if(empty($_GET["v_site"])) {
echo 'v4 hata : site boş';
exit;
}

echo '<div class="col-md-5"><table class="table">
  <thead>
    <tr>
<th scope="col">Link</td>
<th scope="col">Durum</td>
</tr>
<tbody class="table">';

$ch = curl_init($_GET["v_site"]);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);
$v4t1 = curl_exec($ch);
if($v4t1=="") {
echo 'Siteye ulaşılamıyor.';
exit;
}
preg_match_all('@href="(.*?)"@si',$v4t1,$href);

function site_kontrol($site, $site_post) {
$strm = str_replace("https://", "", $site);
$str = str_replace("http://", "", $strm);
$strr = str_replace("//", "", $str);
$chh = curl_init("http://".$strr."");
curl_setopt($chh, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36");
curl_setopt($chh, CURLOPT_REFERER, $site_post);
curl_setopt ($chh, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt ($chh, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($chh, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($chh, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chh, CURLOPT_VERBOSE, 1);
curl_setopt($chh, CURLOPT_NOBODY, 0);
$v4t1_2 = curl_exec($chh);
if($v4t1_2=="") {
echo '<tr>';
echo '<td>'.htmlspecialchars("http://".$strr."").'</td>';
echo '<td>Kırık</td>';
echo '</tr>';
} else {
echo '<tr>';
echo '<td>'.htmlspecialchars("http://".$strr."").'</td>';
echo '<td>Aktif</td>';
echo '</tr>';
}
}

for($i=0; $i<100; $i++)
{

site_kontrol($href[1][$i], $_GET["v_site"]);

}

echo '</table>
</tbody></div>';
?>
