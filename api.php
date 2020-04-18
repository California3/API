<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php
/**
 * APIIIIIs
 *
 * @package custom
 */
?>
<?php
$keyword=$_REQUEST['key'];
if($keyword==""){
    exit;    
}
$redis = new redis();
$redis->connect('127.0.0.1', 6379);
$searchKey="ArtSearchResult-".urldecode($keyword);
if($redis->exists($searchKey)){
    $SearchData = $redis->get($searchKey);
    $apiRaw=json_decode($SearchData,true);
}else{
    $location='https://www.6zgm.com/video.html?mytype=result&qc='.urlencode($keyword).'&t='.urlencode($keyword).'&method=json';
    header("Location: ".$location);
    exit;
}
$api=array();
$api['HD']=json_decode($apiRaw['zhuliu'],true)['info'];
$api['FHD']=$apiRaw['FHDAPI'];
$api['song']=json_decode($apiRaw['musicAPI'],true);
$api['poet']=$apiRaw['poetAPI'];
$api['playlist']=json_decode($apiRaw['playlistquery'],true);
$api['channel']=json_decode($apiRaw['channelquery'],true);

$jsonApi=json_encode($api,true);
echo $jsonApi;