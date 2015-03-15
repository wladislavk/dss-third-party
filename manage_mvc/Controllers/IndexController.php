<?php namespace Ds3\Libraries\Legacy; ?><?php

namespace Controllers;
// use Models\Db;
use Core\Controller;
use Core\View;
use Models\DentalUsers;
use Models\DentalDocumentCategory;

class IndexController extends Controller
{
	public function index()
	{
		$sql = "SELECT homepage, manage_staff, use_course, use_eligible_api FROM dental_users WHERE userid='" . /*mysql_real_escape_string*/($_SESSION['docid']) . "'";
		$r = $this->db->getRowPDO($sql);

		$doc_category = new DentalDocumentCategory();
		$sq = $doc_category->getAll();


		$course_sql = "SELECT s.use_course, d.use_course_staff FROM dental_users s
                       JOIN dental_users d ON d.userid = s.docid
                       WHERE s.userid='" . /*mysql_real_escape_string*/($_SESSION['userid']). "'";
        $course_r = $this->db->getRowPDO($course_sql);

		$m_sql = "SELECT * FROM memo_admin WHERE off_date <= CURDATE()";
		$m_q = $this->db->getResultsPDO($m_sql);

                    
		$data = array(
					'r' => $r,
					'sq' => $sq,
					'course_sql' => $course_sql,
					'm_q' => $m_q
					);

		$this->view->generate('', '/index/index.phtml', $data);
	}

	public function login()
	{
		if(isset($_POST["loginsub"]))
		{
			$dental_users_model = new DentalUsers();
			$check_myarray = $dental_users_model->getLoginUser($_POST['username'], $_POST['password']);

			if($check_myarray) 
			{
				if($check_myarray['status']=='3'){
					$msg='This account has been suspended.';
				}else{
					/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($ins_sql);*/
					
					$_SESSION['userid']=$check_myarray['userid'];
					$_SESSION['username']=$check_myarray['username'];
					$_SESSION['name']=$check_myarray['first_name']." ".$check_myarray['last_name'];
					$_SESSION['user_access']=$check_myarray['user_access'];
					$_SESSION['companyid']=$check_myarray['companyid'];

					if($check_myarray['docid'] != 0)
					{
						$_SESSION['docid']=$check_myarray['docid'];
						$ut_sql = "SELECT user_type FROM dental_users WHERE userid='"./*mysql_real_escape_string*/($check_myarray['docid'])."'";
			 			$ut_r = $this->db->getRowPDO($ut_sql);
						$_SESSION['user_type']=$ut_r['user_type'];
					}
					else
					{
						$_SESSION['docid']=$check_myarray['userid'];
						$_SESSION['user_type']=$check_myarray['user_type'];
					}

					$_SERVER['QUERY_STRING'];
					$ins_sql = "insert into dental_login (docid,userid,login_date,ip_address) values('".$_SESSION['docid']."','".$_SESSION['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
					$this->db->queryPDO($ins_sql);

					$ins_id = mysql_insert_id();
					
					$_SESSION['loginid']=$ins_id;
				
					header('Location: index');
					die();
				}
			}
			else
			{
				$msg='Wrong username or password';
			}
		}

		if(isset($_SESSION['loginid']) &&$_SESSION['loginid'] <> '')
		{
			$cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
			$cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
			$this->db->queryPDO($cur_ins_sql);
		}

		if(strpos($_SERVER['PHP_SELF'],'q_page') === false && strpos($_SERVER['PHP_SELF'],'ex_page') === false && strpos($_SERVER['PHP_SELF'],'q_sleep') === false && strpos($_SERVER['PHP_SELF'],'q_image') === false)
		{
			$unload = 0 ;
		}
		else
		{
			$unload = 1 ;
		}

		if($msg=='' && isset($_GET['msg']))
		{ 
			$msg = $_GET['msg'];
		}

		$data = array(
					'msg' => $msg
			);

		$this->view->generate('', '/index/login.phtml', $data);
	}

	public function check()
	{
echo "<pre>"; var_dump('ok'); die();
		include_once(APP_PATH.'/views/index/login.phtml');
	}

	private function gen_password($p, $s){
		return hash('sha256', $p.$s);
	}
}
