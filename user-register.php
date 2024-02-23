<?php 

require_once 'core/init.php';

//var_dump(Token::check(Input::get('token')));
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		//echo 'i have been running';
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			
			'nome' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'apelido' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));
		
		if($validation->passed()){
			//register user
			echo 'passed';
			Session::flash('succsess', 'Utilizador registado');
			//header('Location: index.php');
			$cod_user = strtolower(strrev(substr(strrev(Input::get('nome')), -2)).''.strrev(substr(strrev(Input::get('apelido')), -2)));
       	 	$codigo = Codigo::gerarCodigo();
        	$cod_user = "01.".$codigo.".".$cod_user;
			//die($cod_user);
			$user = new User();
			$salt = Hash::salt(32);
			try{
				//date_default_timezone_set('America/Los_Angeles');
				$user->create(array(
					'nome' => Input::get('nome'),
					'apelido' => Input::get('apelido'),
					'username' => $cod_user,
					'password' => hash::make($cod_user, $salt),
					'group_id' => 1,
					'salt' =>  $salt,

				));
				Session::flash('home', 'You have been registered');
				//Redirect::to('index.php');
				//header('location:index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			//output erro
			foreach($validate->errors() as $erro){
				echo $erro, '<br>';
			}
			print_r($validate->errors());
		}
	}
	
}

//$user = new User();

//if(($user->isLoggedIn())){
	?>

<html lang="pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="CSS/estudantReg.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="Jquery/jq.js"></script>

</head>

<body>
	<div class="menu">
        <div class="icon-div">
            <i id="menu-toggle" class="bi bi-list"></i>
        </div>
        <!--<div class="division"></div>-->
        <div>
            <h2>Sistema de Gestão de Trabalhos de Culminação de Curso </h2>
        </div>
        <div class="division"></div>
        <div>
		<p>Username: <?php echo $user->data()->nome; ?></p>
        </div>
        <div class="division"></div>
        <div>
            <i id="logout" class="bi bi-box-arrow-left"></i>
        </div>
    </div>
	<main class="main">
		<form class="card" method="POST">
			<div class="imgem2">
				<img src="imagens/favicon.png">
			</div>
			<div class="row">
				<div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="nome" class="form-control" id="floatingInput" placeholder="Nome do Estudante">
						<label for="floatingInput">Nome</label>
					</div>
				</div>	
                <div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="apelido" class="form-control" id="floatingInput" placeholder="Sigla">
						<label for="floatingInput">apelido</label>
					</div>
				</div>
			</div>
			
			<div class="row">
				<button id="submit" class="btn btn-primary" type="submit" >Submeter</button>
			</div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		
        </form>
	</main>
</body>
</html>