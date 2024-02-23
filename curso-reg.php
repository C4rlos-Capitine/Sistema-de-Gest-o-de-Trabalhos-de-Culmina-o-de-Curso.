<?php
require_once 'core/init.php';



if(Input::exists()){
	
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		echo 'i have been running';
		//die();
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'designacao' => array(
				'required' => true,
				'min' => 2,
				'max' => 180,
				'unique' => 'curso'
            ),
            'sigla' => array(
				'required' => true,
				'min' => 2,
				'max' => 6,
				'unique' => 'curso'
            ),
            'faculdade' => array(
				'required' => true,
            )
		));
		
		if($validation->passed()){
			try{

				$id = Curso::cadastrar(array(
					'id_faculdade' => Input::get('faculdade'),
                    'designacao' => Input::get('designacao'),
                    'sigla' => Input::get('sigla')
                ))->getLastId();//->getQuery()->lastInsertId();
				//var_dump($id);
				//die($id);
				
                //Session::flash('succsess', 'curso registado');
                Curso::cadastrar_docente_tcc(array('id_curso'=>$id));
                //Redirect::to('faculdade-cursos.php?id_faculdade='.Input::get('faculdade'));
				Redirect::to('curso-reg.php?success=true&id_faculdade='.Input::get('faculdade'));
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
if($user->isLoggedIn()){



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
	<link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
<style>
	
	.main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card-form {
            max-width: 1000px;
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
			<h3>Registar Curso</h3>
			<?php
        if(isset($_REQUEST['success'])){
			if($_REQUEST['success'] == 'true'){
            ?>
            <div class="alert alert-success">curso Registado com sucesso <a href="faculdade-cursos.php?id_faculdade=<?php echo $_REQUEST['id_faculdade']; ?>">Vizualisar</a></div>
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
						<input type="text" name="designacao" class="form-control" id="floatingInput" placeholder="designacao do curso">
						<label for="floatingInput">Nome do curso</label>
					</div>
				</div>	
                <?php 
                    $faculdade = (array)Faculdade::get();
                ?>
			
			
                <div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="sigla" class="form-control" id="floatingInput" placeholder="Sigla">
						<label for="floatingInput">Sigla</label>
					</div>
				</div>
                
</div>
            <div class="row">
            <div class="col-md-3">
                        <label for="validationCustom04" class="form-label">Faculdade</label>
                        <select name="faculdade" id="processo" class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Escolha..</option>
                        <?php 
                        for($i=0; $i<sizeof($faculdade); $i++){
                            ?>
                            <option value="<?php echo $faculdade[$i]->id_faculdade; ?>"><?php echo $faculdade[$i]->nome; ?></option>
                            <?php
                        }
                        ?>
                        </select>
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
	Redirect::to('user-login.php');
}