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
				
                Trabalho::actualizar(Input::get('trabalho'), 'codigo_estudante', array('codigo_docente' => Input::get('docente')));

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
$info_curso = "";
if(($user->isLoggedIn())){
    if(!$user->hasPermission('admin')){
        $info_curso = Director_curso::getDadosDirector($user->data()->id);
    }
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
            <p>Username: Agostinho Ngonga</p>
        </div>
        <div class="division"></div>
        <div>
            <i id="logout" class="bi bi-box-arrow-left"></i>
        </div>
    </div>
    
    <main class="main">
    <form class="card" method="POST">
		<h3>Associar docente ao trabalho</h3><br>
        <label id="total">numero de trabalhos associados</label>
        <div class="row">
        <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Docente</label>
                <select name="docente" id="docente" class="form-select" id="docente" required>
                <option selected disabled value="">Escolha..</option>
                <?php
                    $docentes = (array)Curso::getDocentes($info_curso->id_curso);
                    if(!$user->hasPermission('admin')){
                        for($i=0; $i<sizeof($docentes); $i++){
                            ?>
                            <option <?php echo $docentes[$i]->codigo_docente; ?>><?php echo $docentes[$i]->nome_docente. ' '.$docentes[$i]->apelido; ?></option>
                            <?php
                        }
                    }
                ?>
                </select>
            </div>
            </div>
            <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Trabalhos</label>
                <select name="trabalho" id="trabalho" class="form-select" id="validationCustom04" required>
                <option selected disabled value="">Escolha..</option>
                <?php
                $trabalhos = (array)Trabalho::find2($info_curso->id_curso);
                //if(!$user->hasPermission('admin')){
                    for($i=0; $i<sizeof($trabalhos); $i++){
                        ?>
                        <option <?php echo $trabalhos[$i]->id_curso; ?>><?php echo $trabalhos[$i]->tema; ?></option>
                        <?php
                    }
                //}
                ?>
               
                </select>
            </div>
            </div>
            </div>
        </form>
    </main>
                
</body>
<?php
}else{
    Redirect::to("index.php");
}