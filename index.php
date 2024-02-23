<?php
require_once 'core/init.php';
$user = new User();
$info_curso = "";
if($user->isLoggedIn()){
    //echo $user->hasPermission('admin');
    if(!$user->hasPermission('admin')){
        $info_curso = Director_curso::getDadosDirector($user->data()->id);
    }

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="icon-style.css">
	<link rel="stylesheet" href="css/index-style.css">
    <script src="Jquery/jq.js"></script>
    <script src="redirect.js"></script>
    <style>
        .links{
            color:white;
            text-decoration:none;
        }
       
    </style>
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
            <a href="user-logout.php"><i id="logout" class="fa-solid fa-arrow-right-from-bracket"></i><a>
        </div>
    </div>
    <main class="main">

        <div id="direita">
            <section class="opcoes">
                <nav id="side-bar">
                    <?php
                  /*  if($user->hasPermission('admin')){
                        ?><p>Administrador</p><?php
                    }else{
                        ?><p>Director(a) do curso <?php echo $info_curso->designacao; ?></p><?php
                    }*/
                    ?>
                    <p>Menu</p>
                    <ul>
                    <?php
                    if ($user->hasPermission('admin')) {
                        ?>
                        <li class="menu-option clickable" data-value="curso-reg.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Registar Curso</li>
                        <li class="menu-option clickable" data-value="faculdade-reg.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Registar Faculdade</li>
                        
                        <li class="menu-option clickable" data-value="faculdade-ver.php"><i class="fa-solid fa-table-list" style="color: #eff0f0;"></i> Visualizar Faculdades</li>
                        <li class="menu-option clickable" data-value="user-reg-dir_curso.php"><i class="fa-solid fa-user-plus" style="color: #eff1f6;"></i> Registar director de curso</li>
                        <li class="menu-option clickable" data-value="minor-reg.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Registar Minor</li>
                        <li class="menu-option clickable" data-value="curso-ver.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Visualizar Cursos</li>
                        <?php
                    }
                    if (!$user->hasPermission('admin') || $user->hasPermission('admin')) {
                        ?>
                        <!--<li><i class="bi bi-pencil-square"></i> Registar estudante</li>-->
                        <li class="menu-option clickable" data-value="estudante-importar.php"><i class="fa-solid fa-file-import"></i> Importar Estudantes</li>
                        <li class="menu-option clickable" data-value="area-cientifica-reg.php"><i class="bi bi-pencil-square"></i> Registar Area Cientifica</li>
                        <?php if ($user->hasPermission('admin')) { ?>
                        <li class="menu-option clickable" data-value="docente-reg.php"><i class="fa-solid fa-user-plus" style="color: #eff1f6;"></i> Registar Docente</li>
                        <?php } else { ?>
                        <li class="menu-option clickable" data-value="docente-reg2.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Registar Docente</li>
                        <?php } ?>
                        <li class="menu-option clickable" data-value="trabalho-ver.php"><i class="fa-solid fa-table-list" style="color: #eff0f0;"></i> Visualizar Trabalhos</li>
                        <li class="menu-option clickable" data-value="docente-ver.php"><i class="fa-solid fa-table-list" style="color: #eff0f0;"></i> Visualizar Docentes</li>
                        <li class="menu-option clickable" data-value="estudante-ver.php"><i class="fa-solid fa-table-list" style="color: #eff0f0;"></i> Vizualisar Estudantes</li>
                        <?php if (!$user->hasPermission('admin')) { ?>
                        <li class="menu-option clickable" data-value="docente-associar-trabalho.php"><i class="fa-solid fa-pen-to-square" style="color: #eff1f6;"></i> Associar docente a um tarabalho</li>
                        <li class="menu-option clickable" data-value="docente_trabalhos_ver.php"><i class="bi bi-list-columns"></i> Ver trabalhos associados a docentes</li>
                        <li class="menu-option clickable" data-value="docente-reg-area-cientifica.php"><i class="bi bi-list-columns"></i> Associar docente a area cientifica</li>
                        <li class="menu-option clickable" data-value="docente_associar_cadeira_tcc2.php"><i class="bi bi-list-columns"></i> Associar docente a um a cadeira TCC do curso</li>
                        <?php
                        }
                        ?>
                        <?php
                    }
                    if ($user->hasPermission('admin')) {
                        ?>
                        <li class="menu-option clickable" data-value="docente_associar_cadeira_tcc.php"><i class="bi bi-list-columns"></i> Associar docente a um a cadeira TCC do curso</li>
                        <?php
                    }
                    ?>
                    </ul>

                    
                </nav>
    
            </section>
            
        </div>
        
        <div class="imagem">
            <!--<img src="up-logo.png">-->
            <img src="desing2.png">
        </div>
    

    </main>
    
</body>
<?php
}else{
    Redirect::to("user-login.php");
}