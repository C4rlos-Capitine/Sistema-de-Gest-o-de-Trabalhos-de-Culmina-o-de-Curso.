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
if(($user->isLoggedIn()) && !$user->hasPermission('admin')){
    //if(!$user->hasPermission('admin')){
        $info_curso = Director_curso::getDadosDirector($user->data()->id);
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
    .popup{
          position: absolute;
          top:-100%;
          left:50%;
          padding:20px;
          transform: translate(-50%, -50%);
          width:650px;
          background: #fff;
          border-radius: 10px;
          box-shadow: 0px 2px 5px 5px rgba(0,0,0,1);
          margin-top: -25px;
          opacity:0;
          transition:top ease-in-out 0ms,
          opacity 300ms ease-in-out,
          margin-top 300ms ease-in-out;
       }

       .popup > *{
        margin: 15px 0px;
       }
       .popup .close-btn{
        position:absolute;
        top: -5px;
        right:10px;
        width: 20px;
        height: 20px;
        background:#eee;
        color:#111;
        border:none;
        outline:none;
        border-radius:50%;
        cursor:pointer;
       }
       body.active-popup{
        overflow:hidden;
       }
       .main{
        transition: filter 0ms ease-in-out 300ms; 
       }
       body.active-popup .main{
        filter:blur(5px);
        background:rgba(0,0,0,0.08);
        transition: filter 0ms ease-in-out 0ms;
       }

       body.active-popup .popup{
        top:50%;
        opacity:1;
        margin-top:0px;
        transition:top ease-in-out 0ms,
          opacity 300ms ease-in-out,
          margin-top 300ms ease-in-out;
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
    <div class="card2">
        <div class="row">
        <!--<div class="column">	-->		
        <div class="form-floating">
        <select class="form-select" id="minor" onchange="getEstudantes()" aria-label="Floating label select example">
            <?php
            $minor = Curso::getMinor($info_curso->id_curso);
            for($i=0; $i<sizeof($minor); $i++){
                ?><option value="<?php echo $minor[$i]->id_minor; ?>"><?php echo $minor[$i]->designacao_minor; ?></option><?php
            }
            ?>
        </select>
        <label for="floatingSelect">Selecione por minor</label>
        </div>
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
            
        <div class="form-floating mb-3">
            <input name="ano" type="number" class="form-control" id="ano" placeholder="ano">
            <label for="floatingInput">Ano de Ingresso</label>
        </div>
        <div class="form-floating mb-3">
        <button id="submit" class="btn btn-primary" onclick="buscarPorAno()">Buscar</button>
        </div>
        </div>
        <a href="relatorio_estudante.php?id_curso=<?php echo $info_curso->id_curso; ?>">Baixe a lista: <img style="width: 30px;height: 50px;" src="pdf.JPG"></a>
        </div>
        
        <table class="tb-data">
            <thead>
            <th colspan="6">Estudantes do Curso de <?php echo $info_curso->designacao; ?>
            <tr>
                <th>Nome completo</th>
                <th>Codigo</th>
                <th>Minor</th>
                <th colspan="3">Regime</th>
                
            </tr>
        </thead>
        <tbody id="dados">
        <?php
            $estudante = (array)Estudante::getEstudantesDoCurso($info_curso->id_curso);

            for($i = 0; $i < sizeof($estudante); $i++){
                ?>
                <tr>
                    <td><?php echo $estudante[$i]->nome_estudante.' '.$estudante[$i]->apelido; ?></td>
                    <td><?php echo $estudante[$i]->codigo_estudante; ?></td>
                    <td><?php echo $estudante[$i]->designacao_minor; ?></td>
                    <td><?php echo $estudante[$i]->regime; ?></td>
                    <td><td><button type="button" id="<?php echo $estudante[$i]->codigo_estudante; ?>" onclick="verTrabalho(this.id)" class="btn btn-primary btn-sm">Ver trabalho</button></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
		</table>
        
       
        </div>
	</main>
    <div class="popup">
            <label>Areas Cientificas</label>
        <span class="close-btn">&times;</span>
        <table border="0" class="tb-data">
        <thead>
            <th colspan="6">Trabalhos do Curso de <?php echo $info_curso->designacao; ?>
            <tr>
                <th>Nome completo</th>
                <th>Tema</th>
                <th>Descricao</th>
                <th>data de submissao</th>
                <th>ficheiro do trabalho</th>
                <th>estado do trabalho</th>
            </tr>
        </thead>
        <tbody id="tbody">

        </tbody>
      </table>
        </div>
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
    function buscarPorAno(){
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_estudantes_ano_ingresso.php?id_minor="+document.getElementById("minor").value+"&regime="+document.getElementById("regime").value+"&ano_ingresso="+document.getElementById("ano").value;
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

    function verTrabalho(id){
        
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_estudante_trabalho.php?codigo_estudante="+id;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
            console.log(data);
            var html = "";
            if(data.estado != 0){
                
                 var estado = "";
            
                    if(data.estado == 0){
                        estado = "tema nao submetido";
                    }else if(data.estado == 1){
                        estado = "tema por ser aprovado";
                    }else if(data.estado == 2){
                        estado = "tema aprovado";
                    }else if(data.estado == 3){
                        estado = "pre-projecto";
                    }else if(data.estado == 4){
                        estado = "pre-projecto aprovado";
                    }
                    else if(data.estado == -1){
                        estado = "tema reprovado";
                    }
                    html += "<tr><td>"+data.nome_estudante+" "+data.apelido+"</td><td>"+data.tema+"</td><td>"+data.descricao+"</td><td>"+data.data_submissao+"</td><td><a href="+data.ficheiro+">Ficheiro</a></td><td>"+estado+"</td></tr>";
        
            document.getElementById("tbody").innerHTML = html;
            }else{
                html += '<tr><td colspan="6">trabalho nao registado</td></tr>';
                document.getElementById("tbody").innerHTML
            }
        
            //select = document.getElementById("trabalho");
            
            document.body.classList.add("active-popup");
                }else{
                    console.log("erro");
                }
        }
    }
    document.querySelector(".close-btn").addEventListener("click", function(){
        document.body.classList.remove("active-popup");
    });
</script>

</html>

<?php
}else{
    Redirect::to("index.php");
}