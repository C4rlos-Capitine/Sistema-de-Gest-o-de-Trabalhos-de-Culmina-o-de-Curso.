<?php

require_once 'core/init.php';
/*
echo Config::get('mysql/host');//127.0.0.1
$user = DB::getInstance();
$user->update('user', 2, array(
	'password' => 'Newpassword',
	'name' => 'Alex Gomis'
));
*/

$user = new User();

if (!$user->isLoggedIn()) {
	// code...
	Redirect::to('index.php');
}

if (Input::exists()) {
	// code...
	if (Token::check(Input::get('token'))) {
		// code...
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if($validation->passed()){
			//update
			try {
				$user->update(array(
					'name' => Input::get('name')
				));
				Session::flash('home', 'Your details have been updated.');
				//Redirect::to('index.php');
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}else{
			foreach ($validation as $error) {
				// code...
				echo $error, '<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">
		<input type="submit" value="Update" name="">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</div>
</form>
