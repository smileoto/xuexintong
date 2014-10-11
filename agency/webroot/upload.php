<?php
ini_set('date.timezone','Asia/Shanghai');//时区
//error_reporting(E_ALL);
//ini_set('display_errors', 'On'); 

/*********************************************************************************/
require_once '../lib/bcs/bcs.class.php';
$baiduBCS = new BaiduBCS ( BCS_AK, BCS_SK, BCS_HOST );
/*********************************************************************************/
$err = "";
$msg = "''";
$tempPath  = dirname(__FILE__).'/upload/'.date("YmdHis").mt_rand(10000,99999).'.tmp';
$localName = '';
$maxAttachSize = 2097152;//最大上传大小，默认是2M
$upExt='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名

$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;//立即上传模式，仅为演示用

if( isset($_SERVER['HTTP_CONTENT_DISPOSITION']) && 
	preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info))
{
	//HTML5上传
	file_put_contents($tempPath, file_get_contents("php://input"));
	$localName=urldecode($info[2]);
} else {
	//标准表单式上传
	$upfile = @$_FILES[$inputName];
	if( !isset($upfile) ) {
		$err='文件域的name错误';
	} elseif (!empty($upfile['error']) ) {
		switch($upfile['error'])
		{
			case '1':
				$err = '文件大小超过了php.ini定义的upload_max_filesize值';
				break;
			case '2':
				$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
				break;
			case '3':
				$err = '文件上传不完全';
				break;
			case '4':
				$err = '无文件上传';
				break;
			case '6':
				$err = '缺少临时文件夹';
				break;
			case '7':
				$err = '写文件失败';
				break;
			case '8':
				$err = '上传被其它扩展中断';
				break;
			case '999':
			default:
				$err = '无有效错误代码';
		}
	} elseif ( empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none' ) {
		$err = '无文件上传';
	} else{
		move_uploaded_file($upfile['tmp_name'], $tempPath);
		$localName = $upfile['name'];
	}
}

if ( $err == '' ) {
	$fileInfo  = pathinfo($localName);
	$extension = $fileInfo['extension'];
	if( preg_match('/^('.str_replace(',','|',$upExt).')$/i',$extension) )
	{
		$bytes = filesize($tempPath);
		
		if ( $bytes > $maxAttachSize ) {
			$err = '请不要上传大小超过'.formatBytes($maxAttachSize).'的文件';
		} else {
			$object =  '/images/'.date('Ymd').'_'. uniqid().'.'.$extension;
			$response = $baiduBCS->create_object( BCS_BUCKET, $object, $tempPath );
			$url = '';
			if ( $response->isOK() ) {
				$opt = array ();
				$opt["time"] = time() + 3600;
				$url = $baiduBCS->generate_get_object_url( BCS_BUCKET, $object, $opt );
			} else {
				$err = 'bcs('.$response->status.')['.$response->body.']'; 
			}
			
			$msg = "{'url':'".$url."','localname':'".jsonString($localName)."','id':'1'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID
		}
		
	} else {
		$err = '上传文件扩展名必需为：'.$upExt;
	}

	@unlink($tempPath);
}

echo "{'err':'".jsonString($err)."','msg':".$msg."}";

function jsonString( $str )
{
	return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
}

function formatBytes( $bytes ) 
{
	if($bytes >= 1073741824) {
		$bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
	} elseif($bytes >= 1048576) {
		$bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
	} elseif($bytes >= 1024) {
		$bytes = round($bytes / 1024 * 100) / 100 . 'KB';
	} else {
		$bytes = $bytes . 'Bytes';
	}
	return $bytes;
}
