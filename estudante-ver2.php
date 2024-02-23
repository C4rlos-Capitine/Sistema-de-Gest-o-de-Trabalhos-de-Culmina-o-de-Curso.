<?php 

require_once 'core/init.php';

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
                //    var_dump($reader);
                
                    foreach($reader as $key => $row){
                        print_r($row);
                        Estudante::cadastrar(array(
                            'codigo_estudante' => $row[0],
                            'nome_estudante' => $row[1],
                            'apelido' => $row[2],
                            'id_curso' => Input::get('curso'),
                            'ano_ingresso' => $row[3],
                            'sexo' => $row[4],
                            'id_minor' => $row[5]
                        ));
                        //$conn->query("INSERT INTO tb_data (name, age, country) VALUES('$name', '$age', '$country')") or die($conn->error);
                    }

                    Session::flash('home', 'You have been registered');
                    Redirect::to('index.php');
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
global $info_curso;
//if(($user->isLoggedIn()) && !$user->hasPermission('admin')){
    //if(!$user->hasPermission('admin')){
        //$info_curso = Director_curso::getDadosDirector($user->data()->id);
        //var_dump($info_curso);
    //}
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
     .tb-data tr:nth-child(even){background-color: #a4bdc9;}

    .tb-data tr:hover {background-color: rgb(154, 186, 215);}


    .tb-data {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: 20px;
    }

    .tb-data th{
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: rgb(16, 169, 234);
        color: white;
    }

    .tb-data td, #dados th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .tb-data tr td button:hover{
        color: aqua;
        transition: 0.2s ease-in;
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
        <div class="row">
        <!--<div class="column">	-->		
        
        <!--</div>-->
        </div>
        <div class="row">
        <div class="form-floating">
        <select class="form-select" id="regime" onchange="getByRegime()" aria-label="Floating label select example">
            <option value="laboral">Laboral</option>
            <option value="pos-laboral">Pos-Laboral</option>
        </select>
        </div>
        </div>
        <div class="row">
        <table class="tb-data">
            <thead>
            <tr>
                <th>Nome completo</th>
                <th>Codigo</th>
                <th>Minor</th>
                <th>Regime</th>
            </tr>
        </thead>
        <tbody id="dados">
        <?php
            $estudante = (array)Estudante::get();
            //print_r($estudante);
            for($i = 0; $i < sizeof($estudante); $i++){
                ?>
                <tr>
                    <td><?php echo $estudante[$i]->nome_estudante.' '.$estudante[$i]->apelido; ?></td>
                    <td><?php echo $estudante[$i]->codigo_estudante; ?></td>
                    <td><?php echo $estudante[$i]->id_minor; ?></td>
                    <td><?php echo $estudante[$i]->regime; ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
		</table>
        <a href="relatorioEstudantepdf.php">pdf</a>
        </div>
	</main>
</body>
<script>
function getEstudantes(){
        console.log(document.getElementById("minor").value);

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_estudantes_minor.php?id_minor="+document.getElementById("minor").value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var estudante = JSON.parse(this.responseText);
                console.log(estudante);
            
                //select = document.getElementById("trabalho");
                var html = "";
                for(var a = 0; a< estudante.length; a++){
                    if(estudante[a].codigo_docente="null"){
                        html += "<tr><td>"+estudante[a].nome_estudante+"</td><td>"+estudante[a].codigo_estudante+"</td><td>"+estudante[a].designacao_minor+"</td><td>"+estudante[a].regime+"</td></tr>"
                    }
                    
                }
                document.getElementById("dados").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
        
    }

    function getByRegime(){
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_estudantes_regime.php?id_minor="+document.getElementById("minor").value+"&regime="+document.getElementById("regime").value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var estudante = JSON.parse(this.responseText);
                console.log(estudante);
            
                //select = document.getElementById("trabalho");
                var html = "";
                for(var a = 0; a< estudante.length; a++){
                    if(estudante[a].codigo_docente="null"){
                        html += "<tr><td>"+estudante[a].nome_estudante+"</td><td>"+estudante[a].codigo_estudante+"</td><td>"+estudante[a].designacao_minor+"</td><td>"+estudante[a].regime+"</td></tr>"
                    }
                    
                }
                document.getElementById("dados").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
    }
</script>

</html>

