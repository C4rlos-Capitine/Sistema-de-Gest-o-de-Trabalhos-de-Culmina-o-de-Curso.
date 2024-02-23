<?php 

require_once 'core/init.php';
//require 'excelReader/excel_reader2.php';
//require 'excelReader/SpreadsheetReader.php';

//var_dump(Token::check(Input::get('token')));
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		//echo 'i have been running';
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			
            'curso' => array(
                'required' => true,
            )
		));
		
		if($validation->passed()){


            if(isset($_FILES['arquivo'])){
                //echo 'arquivo carregado';
                $arquivo = $_FILES['arquivo'];
                if($arquivo['error']){
                    die("falha ao enviar");
                }
                $pasta = "arquivos/";

                $nome_arquivo = $arquivo['name'];
                //$novoNomeArquivo = uniqid();
                $extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);
                //die($extensao);
                if($extensao != 'xlsx'){
                    die("tipo de arquivo nao aceito");
                }
                //$targetDirectory = "uploads/" . $newFileName;
                $path = $pasta . $nome_arquivo;
                $deu_certo = move_uploaded_file($arquivo["tmp_name"], $pasta . $nome_arquivo);
                try{
                    
                    Ficheiro::cadastrar(array(
                        'id_curso' => Input::get('curso'),
                        'path' => $path,
                        'nome' => date("d-m-y") . $nome_arquivo
                    ));
                    
                    //error_reporting(0);
                    //ini_set('display_errors', 0);

                    require 'excelReader/excel_reader2.php';
                    require 'excelReader/SpreadsheetReader.php';

                    $reader = new SpreadsheetReader($path);
                    //var_dump($reader);
                  // die();
                    $indice = 0;
                    //print_r($reader->SharedStringCache());
                    
                    
                    foreach($reader as $row){
                        if($indice>0){
                            //print_r($row);
                            $query = Estudante::cadastrar(array(
                                'codigo_estudante' => $row[0],
                                'nome_estudante' => $row[1],
                                'apelido' => $row[2],
                                'id_curso' => Input::get('curso'),
                                'ano_ingresso' => $row[3],
                                'sexo' => $row[4],
                                'id_minor' => $row[5],
                                'regime' => $row[6]
                         ));
                         Trabalho::cadastrar(array('codigo_estudante' => $row[0], 'estado'=>0, 'id_minor'=>$row[5]));
                        }
                        //echo '<br>';

                            $indice +=1;
                    }

                    //Session::flash('home', 'You have been registered');
                    Redirect::to('estudante-importar.php?success=true');
                    //header('location:index.php');
                }catch(Exception $e){
                    die($e->getMessage());
                }
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
	<link rel="stylesheet" type="text/css" href="CSS/estudantReg.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <style>
        #main{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            max-width: 700px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Make form inputs responsive */
        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-top: 10px;
        }

        /* Add more responsive CSS as needed */

        /* Center the button */
        .btn-primary {
            display: block;
            margin: 0 auto;
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
	<main id="main" class="main">
        <?php
            
            $faculdade = (array)Faculdade::get();
        ?>
        
		<form class="card" enctype="multipart/form-data" method="POST">
        <h3>Importar Estudantes</h3>
        <label>Ficheiros[xls/xlsx]</label>
        <?php
        if(isset($_REQUEST['success'])){
            ?>
            <div class="alert alert-success">Estudantes importados com sucesso <a href="estudante-ver.php">Vizualisar</a></div>
            <?php
        }
        ?>
        <div class="row">
            <?php 
            if($user->hasPermission('admin')){
                //$info_curso = Director_curso::getDadosDirector($user->data()->id);
            ?>
        <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Faculdade</label>

                <select name="faculdade" id="faculdade" class="form-select" id="validationCustom04" required>
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
            <div class="column">
            <!--<i class="fa-solid fa-upload"></i>-->
            <input type="file" name="arquivo" class="form-control" id="floatingInput" placeholder="xls">
            <!--<i class="fa-regular fa-upload"></i>-->
            
            </div>
            
            </div>
        <div class="row">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Curso</label>
                <select name="curso" id="curso" class="form-select" id="validationCustom04" required>
                <option selected disabled value="">Escolha..</option>
                <?php 
                ?>
                </select>
        
            </div>
            </div>
            <?php
            }else{
                ?>
                <input type="file" name="arquivo" class="form-control" id="floatingInput" placeholder="xls">
                <input type="hidden" name="curso" value="<?php echo $info_curso->id_curso; ?>">
                <?php
            }
            ?>
			
			<div class="row">
				<button id="submit" class="btn btn-primary" type="submit" >Submeter</button>
			</div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>

	</main>
</body>

<script>
    document.getElementById("faculdade").addEventListener('change', (event) => {
        console.log(event.target.value)

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_cursos.php?id_faculdade="+event.target.value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
                console.log(data);
            
                select = document.getElementById("curso");
                var html = "";
                for(var a = 0; a< data.length; a++){
                    html += "<option value="+data[a].id_curso+">"+data[a].designacao+"</option>";
                }
                document.getElementById("curso").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
    });
</script>
</html>

<?php
}else{
    Redirect::to("index.php");
}