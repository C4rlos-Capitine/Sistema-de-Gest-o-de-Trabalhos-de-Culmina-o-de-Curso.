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
            ),
            'curso' => array(
                'required' => true,
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
			$salt = Hash::salt(16);
			try{
				//date_default_timezone_set('America/Los_Angeles');
				$user->create(array(
					'nome' => Input::get('nome'),
					'apelido' => Input::get('apelido'),
					'username' => $cod_user,
					'password' => hash::make($cod_user, $salt),
					'group_id' => 2,
					'salt' =>  $salt,

				));
               // var_dump(Director_curso::getUserId($cod_user));
                $novo = Director_curso::getUserId($cod_user);
                //echo 'id '.$novo->id;
                
                Director_curso::cadastrar(array(
                    'id_curso' => Input::get('curso'),
                    'user_id' => $novo->id
                ));

				Session::flash('home', 'You have been registered');
				Redirect::to('index.php');
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

$user = new User();

if(($user->isLoggedIn())){
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
	<link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
	<script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>


</head>

<body>
	<div class="menu">
	<div class="home">
			<a href="index.php"><i class="fa-solid fa-house"></i></a>
		</div>
        <!--<div class="division"></div>-->
        <div>
            <h2>Sistema de Gestão de Trabalhos de Culminação de Curso </h2>
        </div>
        <div class="division"></div>
        <div>
		<p>Username: <?php echo $user->data()->username; ?></p>
        </div>
        <div class="division"></div>
        <div>
            <i id="logout" class="bi bi-box-arrow-left"></i>
        </div>
    </div>
	<main class="main">
        <?php
            $curso = Curso::get();
        ?>
		
		<form class="card" method="POST">
			<h3>Registar director de curso</h3>
			

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

            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Curso</label>
                <select name="curso" id="processo" class="form-select" id="validationCustom04" required>
                <option selected disabled value="">Escolha..</option>
                <?php 
                for($i=0; $i<sizeof($curso); $i++){
                    ?>
                    <option value="<?php echo $curso[$i]->id_curso; ?>"><?php echo $curso[$i]->designacao; ?></option>
                    <?php
                }
                ?>
                </select>
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
<?php
}else{
	Redirect::to("index.php");
}