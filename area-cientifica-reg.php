<?php 

require_once 'core/init.php';

//var_dump(Token::check(Input::get('token')));
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo Input::get('username');
		//echo 'i have been running';
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			
			'designacao' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
            'curso' => array(
                'required' => true,
            )
		));
		
		if($validation->passed()){
		
			try{
				$success = "";
                if(Area_cientifica::cadastrar(array(
                    'id_curso' => Input::get('curso'),
                    'designacao_area_cientifica' => Input::get('designacao')
                ))){

                    $success = "true";
                }else{
                    $success = "false";
                }
				Session::flash('home', 'You have been registered');
				Redirect::to('area-cientifica-reg.php?success='.$success);
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
$faculdade = (array)Faculdade::get();
$user = new User();

if(($user->isLoggedIn())){
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
    <style>
        #main{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            max-width: 900px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
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
            $curso = Curso::get();
        ?>
		<form class="card" method="POST">
			<h3>Registar Area Cientifica</h3>
            <?php
            if(isset($_REQUEST['success'])){
                if($_REQUEST['success'] == "false"){
                ?>
                <div class="alert alert-success">area Cientifica registada com sucesso</div>
                <?php
                }else{
                    ?><label>Registo falhou</label><?php
                }
        
            }
            
            ?>
			<div class="row">
				<div class="column">
					<div class="form-floating mb-3">
						<input type="text" name="designacao" class="form-control" id="floatingInput" placeholder="Designacao do minor">
						<label for="floatingInput">designacao da area</label>
					</div>
				</div>	
                
			</div>
            <div class="row">

            <div class="column">
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
			</div>
            <div class="column">
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Curso</label>
                <select name="curso" id="curso" class="form-select" id="validationCustom04" required>
                <option selected disabled value="">Escolha..</option>
               
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
}