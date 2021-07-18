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
		if((int)$_POST['phoneotp'] != (int)$_SESSION['otp']){
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
} else if($action == 'resendcode' && $config['signup_system'] == 'on') {
		$phone = $_SESSION['phone_number'];

	//	$error = lang('one_minute_delay');

		if(User::checkSMSlimit($phone) >2){
			$error = lang('daily_limit_reached');
		} else if (User::checkOneMinDelay($phone) >0) {
			$error = lang('one_minute_delay');
		} 

		if (empty($error)) {
			$otp = random_int(100000, 999999);
			$_SESSION["otp"] = $otp;

			$send = User::sendotp($phone,$otp);
			if($send){
				$data['message'] = lang('code_sent_to_your_number');
			$insertsms  = User::insertSmsTime($phone);
			$data['status']  = 225;
			$_SESSION['totalsms']  = User::checkSMSlimit($phone);
			}
		}
		else {
		$data['status']  = 400;
		$data['message'] = $error;
	}

}
