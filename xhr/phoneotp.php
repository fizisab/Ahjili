<?php 



if ($action == 'phoneotp' && $config['signup_system'] == 'on') {
	$error  = false;
	$isemail = 0;
	$post   = array();
	$post[] = (empty($_POST['email']));
	$post[] = (empty($_POST['password']));
	$post[] = (empty($_POST['phoneotp']));
	$post[] = (empty($_POST['otp']));

	if(empty($_POST['phoneotp'])){
			$error = lang('empty_otp');
		} 
		if((int)$_POST['phoneotp'] != (int)$_POST['otp']){
			$error = lang('otp_invalid');
		}
	

	if (empty($error)) {

				$register = User::registerUser();
				$data['status']  = 200;
				if ($config['email_validation'] == 'on') {
				$data['message'] = lang('successfully_joined_created');
				} else {
				$data['message'] = lang('successfully_joined_desc');
				}

		
	}
	else {
		$data['status']  = 400;
		$data['message'] = $error;
	}
} else {
	$data['message'] = "Nothing";
}
