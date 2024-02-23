<?php 

require_once 'core/init.php';

//var_dump(Token::check(Input::get('token')));
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		//echo 'i have been running';
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
            'docente' => array(
                'required' => true,
            )
		));
		
		if($validation->passed()){
		
			try{
				$success = "false";
                if(!Docente::actualizar_funcao(Input::get('curso'), 'id_curso', array('codigo_docente'=>Input::get('codigo_docente')))){
                    //echo "<script>alert docente da cadeira tcc associado com sucesso</script>";
                    $success = "true";
                }else{
                    $success = "false";
                }

				Session::flash('home', 'You have been registered');
				Redirect::to("docente_associar_cadeira_tcc2.php?success={$success}");
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

if(($user->isLoggedIn()) && !$user->hasPermission('admin')){
    $info_curso = Director_curso::getDadosDirector($user->data()->id);
	?>

<html lang="pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    
    <script src="Jquery/jq.js"></script>

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
        <?php
            //$curso = Curso::get();
            $faculdade = (array)Faculdade::get();
        ?>
		<form class="card" method="POST">
			<h3>Associar docente a cadeira de TCC</h3>
            <?php
            if(isset($_REQUEST['success'])){
                if($_REQUEST['success'] == "false"){
                ?>
                <div class="alert alert-success">docente da cadeira tcc associado com sucesso</div>
                <?php
                }else{
                    ?><label>Registo falhou</label><?php
                }
        
            }
            
            ?>

            <input type="hidden" name="curso" id="curso" value="<?php echo $info_curso->id_curso; ?>">
            <div class="row">
            <div class="column">
            <div class="form-floating mb-3">
						<input type="text" name="docente" class="form-control" id="docente" placeholder="Nome">
						<label for="floatingInput">nome do docente</label>
                        <ul class="list"></ul>
					</div>
            </div>
            </div>
			<input type="hidden" name="codigo_docente" id="codigo_docente">
			<div class="row">
				<button id="submit" class="btn btn-primary" type="submit" >Submeter</button>
			</div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		
        </form>
	</main>
</body>
</html>
<script src="search_docentes2.js"></script>
<script>

   /* function getDocentes(){
        console.log(document.getElementById("curso").value);
    }
    getDocentes();*/
</script>
<?php
}else{
    Redirect::to('user-login.php');
}