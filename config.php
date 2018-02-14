<?php
// all setting are here...

$db_host		=	"localhost";
$db_user		=	"mobilepayment";
$db_password	=	"mobilepayment";
$db_name		=	"mobilepayment"; 
$page = basename($_SERVER['PHP_SELF']);
$dir  = dirname($_SERVER['PHP_SELF']);

//on local.
$site_url =	"http://$_SERVER[HTTP_HOST]$dir";

if(!defined('MOBILEPAYMENT_DB_HOST'))
	define( 'MOBILEPAYMENT_DB_HOST', $db_host );

if(!defined('MOBILEPAYMENT_DB_USER'))
	define( 'MOBILEPAYMENT_DB_USER', $db_user );

if(!defined('MOBILEPAYMENT_DB_PASSWORD'))
	define( 'MOBILEPAYMENT_DB_PASSWORD',$db_password );

if(!defined('MOBILEPAYMENT_DB_NAME'))
	define( 'MOBILEPAYMENT_DB_NAME', $db_name  );

if (!defined('MOBILEPAYMENT_SITEURL'))
    define( 'MOBILEPAYMENT_SITEURL', $site_url );

if(!defined('MOBILEPAYMENT_EMAIL_TEMPLATE_PATH'))
	define( 'MOBILEPAYMENT_EMAIL_TEMPLATE_PATH', '../email-templates/' );

if(!defined('MOBILEPAYMENT_EMAIL_FOR_EMAILHEADER'))
	define( 'MOBILEPAYMENT_EMAIL_FOR_EMAILHEADER', 'contact@test.com' );

if(!defined('MOBILEPAYMENT_SUPLIER_TRIAL_DAY'))
	define( 'MOBILEPAYMENT_SUPLIER_TRIAL_DAY', 30 );


if(!isset($_SESSION)){
	session_start();
}

$clearUrlValue=basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$file = basename($clearUrlValue, ".php");

require_once("classes/database-class.php");
$DB    = new DB;


$superAdminAccess = array('dashboard','signup-login-manage','supercompany-manage','supercompany','order-detail','reminder_email','dashboard-account','customerlist','view-orders-super','all_users','add_user','sign-up','user-list','user-manage','user-class','user','edit_user_super','setting','create_user_super','news','add_news','news-manage','edit_news_super','resend_mobile_code','voucher','edit-voucher','admin-user-list','create-admin-super','edit-admin-user');  

$customerAccess = array('dashboard','signup-login-manage','supercompany-manage','supercompany','order-detail','reminder_email','dashboard-account','customerlist','view-orders-super','all_users','add_user','sign-up');  

if(!isset($_SESSION['MOBILEPAYMENT_USERTYPE'])){
		
		if( isset($_COOKIE['MOBILEPAYMENT_UTYPE'])){
			
			$DB->remember_me();	
			
		}else{
			
			if($file == 'login' || $file == 'sign-up' || $file == 'signup-login-manage' || $file == 'confirm-user' || $file == 'confirm-user-success' || $file == 'forgot-password' || $file == 'reset-password' || $file == 'confirm-subscriber' ){
				
			}else{
				//header("Location:login.php?page=$file"); 

				
				header("Location:login.php"); 
				exit();
			}		
		}
	}else{

		if($file == 'login'){
			header("Location:index.php"); 
		}
		
	}

if(isset($_SESSION['MOBILEPAYMENT_USERTYPE'])){
	if($_SESSION['MOBILEPAYMENT_USERTYPE'] == 1){
		if(!in_array($file,$superAdminAccess)){
			header("Location:dashboard.php"); 
			exit();
		}
	}elseif($_SESSION['MOBILEPAYMENT_USERTYPE'] == 1){
		if(!in_array($file,$customerAccess)){
			header("Location:dashboard.php"); 
			exit();
		}
	}
}

require_once("classes/signup-login-class.php");
require_once("classes/user-class.php");
require_once("classes/news-class.php");
