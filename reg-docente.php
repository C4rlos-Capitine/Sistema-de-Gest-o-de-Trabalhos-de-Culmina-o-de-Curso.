<?php
require_once 'core/init.php';
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
		<form class="card">
			<div class="imgem2">
				<img src="imagens/favicon.png">
			</div>
			<div class="row">
				<div class="column">
					<div class="form-floating mb-3">
						<input type="nome" class="form-control" id="floatingInput" placeholder="Nome do Estudante">
						<label for="floatingInput">Nome</label>
					</div>
					<div class="form-floating mb-3">
						<input type="nome" class="form-control" id="floatingInput" placeholder="Nome do Estudante">
						<label for="floatingInput">Codigo do docente</label>
					</div>
				</div>
				<div class="column">
					<div class="form-floating mb-3">
						<input type="nome" class="form-control" id="floatingInput" placeholder="E-mail">
						<label for="floatingInput">E-mail</label>
					</div>
				</div>
		
				<div class="column">
					<fieldset>
					Area Cientifica
					<input type="checkbox" name="#" value="">Eng. Redes
					<input type="checkbox" name="" value="">Desenvilvimento de sistemas
                    </fieldset>
                </div>	
				
			</div>
			<div class="row">
				<button id="submit" class="btn btn-primary" type="submit" >Submeter</button>
			</div>
		
        </form>
	</main>
</body>
</html>