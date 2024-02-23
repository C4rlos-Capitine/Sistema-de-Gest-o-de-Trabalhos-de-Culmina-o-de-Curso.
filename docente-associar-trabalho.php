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
		//die(Input::get('trabalho'));
		if($validation->passed()){
		
			try{
				
                if(Trabalho::actualizar(Input::get('trabalho'), 'codigo_estudante', array('codigo_docente' => Input::get('docente')))){
                    Redirect::to("docente-associar-trabalho.php?success=true");
                }else{
                    Redirect::to("docente-associar-trabalho.php?success=false");
                }
				Session::flash('home', 'You have been registered');
				
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
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script>
        function getCursos(val){
        console.log(document.getElementById("faculdade").value)

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_cursos.php?id_faculdade="+document.getElementById("faculdade").value;
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
    }
    </script>
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
			<h3>Associar docente ao trabalho</h3><br>
            <label id="total">numero de trabalhos associados</label>
            <?php
            if(isset($_REQUEST['success'])){
                if($_REQUEST['success'] == "true"){
                    ?>
                    <div class="alert alert-success">trabalho associado com sucesso</div><?php
                }else{
                    ?>
                    <label id="success">Houve erro</label><?php
                }
            }
            ?>
            <div class="row">
            <?php
                if($user->hasPermission('admin')){
                ?>
            <div class="column">
				<div class="col-md-3">
                
                <label for="validationCustom04" class="form-label">Faculdade</label>
                
                <select name="faculdade" id="faculdade" onchange="getCursos(this.id)" class="form-select"required>
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
            
            <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Curso</label>
                <select name="curso" id="curso" class="form-select" required>
                <option selected disabled value="">Escolha..</option>
               
                </select>
            </div>
            </div>
            <?php
                }
            ?>
            </div>

            <div class="row">
            <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Trabalhos</label>
                <select name="trabalho" id="trabalho" class="form-select"required>
                <option selected disabled value="">Escolha..</option>
                <?php
                $trabalhos = (array)Trabalho::find2($info_curso->id_curso);
                if(!$user->hasPermission('admin')){
                    for($i=0; $i<sizeof($trabalhos); $i++){
                        ?>
                        <option value="<?php echo $trabalhos[$i]->codigo_estudante; ?>"><?php echo $trabalhos[$i]->tema; ?></option>
                        <?php
                    }
                }
                ?>
               
                </select>
            </div>
            </div>
            <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Docente</label>
                <select name="docente" id="docente" class="form-select" onchange="getNum(this.id)" required>
                <option selected disabled value="">Escolha..</option>
                <?php
                    $docentes = (array)Curso::getDocentes($info_curso->id_curso);
                    if(!$user->hasPermission('admin')){
                        for($i=0; $i<sizeof($docentes); $i++){
                            ?>
                            <option value="<?php echo $docentes[$i]->codigo_docente; ?>"><?php echo $docentes[$i]->nome_docente. ' '.$docentes[$i]->apelido; ?></option>
                            <?php
                        }
                    }
                ?>
                </select>
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
<script>
 
    
    document.getElementById("curso").addEventListener('change', (event) => {
        console.log(event.target.value)

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_trabalhos_curso.php?id_curso="+event.target.value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
                console.log(data);
            
                //select = document.getElementById("trabalho");
                var html = "";
                for(var a = 0; a< data.length; a++){
                    if(data[a].codigo_docente="null"){
                        html += "<option value="+data[a].codigo_estudante+">"+data[a].tema+"</option>";
                    }
                    
                }
                document.getElementById("trabalho").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
        
    });

    
    document.getElementById("curso").addEventListener('change', (event) => {
        console.log(event.target.value)

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_docentes_curso.php?id_curso="+event.target.value;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
                console.log(data);
            
                //select = document.getElementById("trabalho");
                var html = "";
                for(var a = 0; a< data.length; a++){
                    //if(data[a].codigo_docente="null"){
                        html += "<option value="+data[a].codigo_docente+">"+data[a].nome_docente+"</option>";
                    //}
                    
                }
                document.getElementById("docente").innerHTML = html;
                }else{
                    console.log("erro");
                }
        }
        
    });
    function getNum(val){
        //console.log(val);
        console.log(document.getElementById("docente").value);
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "get_docente_count_trabalhos.php?id_docente="+document.getElementById("docente").value;;
        var asynchronous = true;
        ajax.open(method, url, asynchronous); 
        ajax.send();
        ajax.onreadystatechange = function(){

            if(this.readyState == 4 && this.status == 200){
                var data = JSON.parse(this.responseText);
                console.log(data);
                document.getElementById("total").innerHTML = "numero de trabalhos associados: "+data.total;
                }else{
                    console.log("erro");
                }
        }
    }

</script>
</html>
<?php 
}else{
    Redirect::to("index.php");
}