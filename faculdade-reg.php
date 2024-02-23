<?php
require_once 'core/init.php';


//var_dump(Token::check(Input::get('token')));
//echo Input::exists();
if(Input::exists()){
	
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		//echo 'i have been running';
		//die();
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'nome' => array(
				'required' => true,
				'min' => 2,
				'max' => 180,
				'unique' => 'faculdade'
			)
		));
		
		if($validation->passed()){
			try{

				if(Faculdade::cadastrar(array(
                    'nome' => Input::get('nome'),
                    'sigla' => Input::get('sigla')
                ))){
					Redirect::to('faculdade-reg.php?success=true');
				}else{
					Redirect::to('faculdade-reg.php?success=false');
				}
                //Session::flash('succsess', 'chave resgistrada');
                
                
				
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
if(Session::exists('home')){
	echo '<p>'.Session::flash('home').'</p>';
}
//echo Session::get(Config::get('session/session_name'));
$user = new User();//current user
//if($user->isLoggedIn()){



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
	<script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
	<link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">

	<style>
		
	.main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card-form {
            max-width: 100vh;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Make form inputs responsive */
        .form-floating {
            margin-bottom: 20px;
        }

        /* Add more responsive CSS as needed */

        /* Center the button */
        .btn-primary {
            display: block;
            margin: 0 auto;
        }
        img{
            width:50px;
            height:50px;
        }
        .field{
            margin-bottom:20px;
        }
        .imagem{
            width: 100%;
            text-align:center;
        }
	</style>
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
		<p>Username: <?php echo $user->data()->nome; ?></p>
        </div>
        <div class="division"></div>
        <div>
            <i id="logout" class="bi bi-box-arrow-left"></i>
        </div>
    </div>
	<main class="main">
		<form class="card-form" method="POST">
			<h3>Registar Faculdade</h3>
			<?php
        if(isset($_REQUEST['success'])){
			if($_REQUEST['success'] == 'true'){
            ?>
            <div class="alert alert-success">Faculdade Registada com sucesso <a href="faculdade-ver.php">Vizualisar</a></div>
            <?php
			}else{
				?>
				<div class="alert alert-danger">Ocorreu uma falha ao registar</div>
				<?php
			}
        }
        ?>
			<div class="row">
				<div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="nome" class="form-control" id="floatingInput" placeholder="Nome do Estudante">
						<label for="floatingInput">Nome da faculdade</label>
					</div>
				</div>	
                <div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="sigla" class="form-control" id="floatingInput" placeholder="Sigla">
						<label for="floatingInput">Sigla</label>
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