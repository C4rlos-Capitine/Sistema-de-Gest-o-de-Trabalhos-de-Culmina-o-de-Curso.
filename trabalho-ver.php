<?php 

require_once 'core/init.php';



$user = new User();
$info_curso ="";
if(($user->isLoggedIn()) && !$user->hasPermission('admin')){
    //if(!$user->hasPermission('admin')){
        $info_curso = Director_curso::getDadosDirector($user->data()->id);
        //var_dump($info_curso);
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
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <link rel="stylesheet" href="css/index-style.css">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="css/form-style.css">-->
    <script>

    </script>

    <style>

    .card2{
        width: 20%;
        margin-top: 100px;
    }
    .col-md-3{
        width:100%
    }
    .dados{
        
    }
     .tb-data tr:nth-child(even){background-color: #a4bdc9;}

    .tb-data tr:hover {background-color: rgb(154, 186, 215);}


    .tb-data {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 80%;
        margin-top: 100px;
       
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
            <p><?php echo $user->data()->nome;?></p>
        </div>
        <div class="division"></div>
        <div>
            <i id="logout" class="bi bi-box-arrow-left"></i>
        </div>
    </div>
	<main class="main">
    <div class="card2">
    <div class="row">
        <?php
        if($info_curso == ""){
        ?>
        <div class="col-md-3">
        <label for="validationCustom04" class="form-label">Faculdade</label>

        <select name="faculdade" id="faculdade" class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Escolha..</option>
        <?php 
        $faculdade = (array)Faculdade::get();
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
    <div class="col-md-3">
        <label for="validationCustom04" class="form-label">Curso</label>
        <select name="curso" id="curso" class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Escolha..</option>
    
        </select>
    </div>
    </div>
    <?php }
    else{
     ?>
     <div class="form-floating">
        <select class="form-select" id="minor" onchange="getTrabalhos()" aria-label="Floating label select example">
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
        <label for="floatingSelect">Selecione por periodo</label>
        </div>
        </div>
        <div class="row">
        <div class="form-floating">
        <select class="form-select" id="fase" onchange="getByFase()" aria-label="Floating label select example">
            <option value="2">tema</option>
            <option value="3">pre-projecto</option>
            <option value="5">Monografia</option>
            <option value="6">Monografia defendida</option>
        </select>
        <label for="floatingSelect">Selecione por fase</label>
        </div>
        </div>
        <?php
    } ?>
    </div>
        <table id="dados" class="tb-data">
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
            <?php
            if($info_curso != ""){
                $trabalhos = Trabalho::find2($info_curso->id_curso);
                //var_dump($trabalhos);
                if(sizeof($trabalhos) == 0){
                    ?><td colspan="6">Sem Trabalhos</td><?php
                }
                for($i=0; $i<sizeof($trabalhos); $i++){
                    $estado = "";
                    if($trabalhos[$i]->estado == 0){
                        $estado = "sem tema";
                    }else if($trabalhos[$i]->estado == 1){
                        $estado = "tema por aprovar aprovado";
                    }else if($trabalhos[$i]->estado == 2){
                        $estado = "tema aprovado";
                    }else if($trabalhos[$i]->estado == 3){
                        $estado = "pre-projecto";
                    }else if($trabalhos[$i]->estado == 4){
                        $estado = "pre-projecto aprovado";
                    }
                    else if($trabalhos[$i]->estado == -1){
                        $estado = "reprovado";
                    }
                    $ficheiro = "";
                    if($trabalhos[$i]->ficheiro == NULL){
                        $ficheiro = "nao submetido";
                    }else{
                        $ficheiro = "Ficheiro";
                    }
                
                    ?><tr><td><?php echo $trabalhos[$i]->nome_estudante .' '. $trabalhos[$i]->apelido; ?></td><td><?php echo $trabalhos[$i]->tema; ?></td><td><?php echo $trabalhos[$i]->descricao; ?></td><td><?php echo $trabalhos[$i]->data_submissao; ?></td><td><a href="<?php echo $trabalhos[$i]->ficheiro; ?>"><?php echo $ficheiro; ?></a></td><td><?php echo $estado; ?></td></tr><?php
                }
            } 
            ?>

        </tbody>
		</table>
    </div>
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
document.getElementById("curso").addEventListener('change', (event) => {
    console.log(event.target.value)

    var ajax = new XMLHttpRequest();
    var method = "GET";
    var url = "get_trabalhos_curso2.php?id_curso="+event.target.value;
    var asynchronous = true;
    ajax.open(method, url, asynchronous); 
    ajax.send();
    ajax.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){
            var data = JSON.parse(this.responseText);
            console.log(data);
        
            //select = document.getElementById("trabalho");
            var html = "";
            var estado = "";
            for(var a = 0; a< data.length; a++){
                    if(data[a].estado == 0){
                        estado = "tema nao submetido";
                    }else if(data[a].estado == 1){
                        estado = "tema por ser aprovado";
                    }else if(data[a].estado == 2){
                        estado = "tema aprovado";
                    }else if(data[a].estado == 3){
                        estado = "pre-projecto";
                    }else if(data[a].estado == 4){
                        estado = "pre-projecto aprovado";
                    }
                    else if(data[a].estado == -1){
                        estado = " tema reprovado";
                    }
                    html += "<tr><td>"+data[a].nome_estudante+" "+data[a].apelido+"</td><td>"+data[a].tema+"</td><td>"+data[a].descricao+"</td><td>"+data[a].data_submissao+"</td><td><a href="+data[a].ficheiro+">Ficheiro</a></td><td>"+estado+"</td></tr>";
            }
            document.getElementById("tbody").innerHTML = html;
            }else{
                console.log("erro");
            }
    }
        
});



function getTrabalhos(){
        console.log(document.getElementById("minor").value);

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_trabalhos_minor.php?id_minor="+document.getElementById("minor").value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
            console.log(data);
        
            //select = document.getElementById("trabalho");
            var html = "";
            var estado = "";
            for(var a = 0; a< data.length; a++){
                    if(data[a].estado == 0){
                        estado = "tema nao submetido";
                    }else if(data[a].estado == 1){
                        estado = "tema por ser aprovado";
                    }else if(data[a].estado == 2){
                        estado = "tema aprovado";
                    }else if(data[a].estado == 3){
                        estado = "pre-projecto";
                    }else if(data[a].estado == 4){
                        estado = "pre-projecto aprovado";
                    }
                    else if(data[a].estado == -1){
                        estado = "tema reprovado";
                    }
                    html += "<tr><td>"+data[a].nome_estudante+" "+data[a].apelido+"</td><td>"+data[a].tema+"</td><td>"+data[a].descricao+"</td><td>"+data[a].data_submissao+"</td><td><a href="+data[a].ficheiro+">Ficheiro</a></td><td>"+estado+"</td></tr>";
            }
            document.getElementById("tbody").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
        
    }

    function getByRegime(){
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_trabalhos_regime.php?id_minor="+document.getElementById("minor").value+"&regime="+document.getElementById("regime").value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
            console.log(data);
        
            //select = document.getElementById("trabalho");
            var html = "";
            var estado = "";
            for(var a = 0; a< data.length; a++){
                    if(data[a].estado == 0){
                        estado = "tema nao submetido";
                    }else if(data[a].estado == 1){
                        estado = "tema por ser aprovado";
                    }else if(data[a].estado == 2){
                        estado = "tema aprovado";
                    }else if(data[a].estado == 3){
                        estado = "pre-projecto";
                    }else if(data[a].estado == 4){
                        estado = "pre-projecto aprovado";
                    }
                    else if(data[a].estado == -1){
                        estado = " tema reprovado";
                    }
                    html += "<tr><td>"+data[a].nome_estudante+" "+data[a].apelido+"</td><td>"+data[a].tema+"</td><td>"+data[a].descricao+"</td><td>"+data[a].data_submissao+"</td><td><a href="+data[a].ficheiro+">Ficheiro</a></td><td>"+estado+"</td></tr>";
            }
            document.getElementById("tbody").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
    }

    function getByFase(){
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_trabalhos_fase.php?id_minor="+document.getElementById("minor").value+"&regime="+document.getElementById("regime").value+"&estado="+document.getElementById("fase").value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
            console.log(data);
        
            //select = document.getElementById("trabalho");
            var html = "";
            var estado = "";
            for(var a = 0; a< data.length; a++){
                    if(data[a].estado == 0){
                        estado = "tema nao submetido";
                    }else if(data[a].estado == 1){
                        estado = "tema por ser aprovado";
                    }else if(data[a].estado == 2){
                        estado = "tema aprovado";
                    }else if(data[a].estado == 3){
                        estado = "pre-projecto";
                    }else if(data[a].estado == 4){
                        estado = "pre-projecto aprovado";
                    }
                    else if(data[a].estado == -1){
                        estado = " tema reprovado";
                    }
                    html += "<tr><td>"+data[a].nome_estudante+" "+data[a].apelido+"</td><td>"+data[a].tema+"</td><td>"+data[a].descricao+"</td><td>"+data[a].data_submissao+"</td><td><a href="+data[a].ficheiro+">Ficheiro</a></td><td>"+estado+"</td></tr>";
            }
            document.getElementById("tbody").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
    }


</script>
</html>

<?php
//}else{
  //  Redirect::to("index.php");
//}