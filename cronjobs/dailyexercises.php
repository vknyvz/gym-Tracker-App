<?php
/**
 * This file is intended to run on the shell
 */
require_once 'cronMaster.php';

$modelUsers = new Model_Users();
foreach($modelUsers->fetchAll("notifications != 'disable'")->toArray() as $users) {
	$db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
	$db->getConnection();
	
	if($users['notifications'] == 'senddailyifnolog'){
		$sql = "SELECT * FROM daily_exercises WHERE date = '" . date('Y-m-d') . "' and userId = " . $users['userId'];
		
		if(count($db->fetchAll($sql, 2)) == 0){
			$user = $modelUsers->fetch($users['userId']);
			$params = array (
					'subject'   => 'Did you add your exercise log for today?',
					'firstName' => $users['firstName'],
					'version'   => vkNgine_Version::VERSION,
			);
				
			$email = new vkNgine_Email();
			$email->sendWithTemplate('FORGOT_ADD_EXERCISE', $params, $user->getFullName(), array($users['email']));
		}
	}
	else {
		$sql = "SELECT * FROM daily_exercises WHERE date = '" . date('Y-m-d') . "' and userId = " . $users['userId'];
		
		$user = $modelUsers->fetch($users['userId']);
		$params = array (
				'subject'   => 'Did you add your exercise log for today?',
				'firstName' => $users['firstName'],
				'version'   => vkNgine_Version::VERSION,
		);
			
		$email = new vkNgine_Email();
		$email->sendWithTemplate('FORGOT_ADD_EXERCISE', $params, $user->getFullName(), array($users['email']));
	}
}
