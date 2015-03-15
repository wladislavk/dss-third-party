<?php namespace Ds3\Libraries\Legacy; ?><?php

namespace Models;

	class DentalUsers extends Db
	{

		public function getLoginUser($username, $password)
		{
			$salt_query_string = "SELECT salt 
									FROM dental_users 
									WHERE username=:username";
			$salt_query = $this->dataBase->prepare($salt_salt_query_string);
			$salt_query->bindParam(':username', $userName);
			$salt_query->execute();
			$result = $salt_query->fetchAll();

			$salt_row = $result[0];

			$pass = $this->gen_password($password, $salt_row['salt']);

			$user_check_query = "SELECT dental_users.userid, username, name, first_name, last_name, user_access, status, 
							CASE docid
								WHEN 0 
									THEN dental_users.userid
									ELSE docid
							END as docid,
							user_type, uc.companyid 
						FROM dental_users 
						LEFT JOIN dental_user_company uc 
						ON uc.userid=(
							CASE docid
                                WHEN 0 THEN dental_users.userid
                                ELSE docid
                            END)
						WHERE username=:username and password=:password and status in (1, 3)";
						
			$user_check = $this->dataBase->prepare($user_check_query);
			$user_check->bindParam(':username', $userName);
			$user_check->bindParam(':password', $pass);
			$user_check->execute();
			$result = $user_check->fetchAll();

			return $result[0];
		}

		private function gen_password($p, $s){
			return hash('sha256', $p.$s);
		}


	}
?>
