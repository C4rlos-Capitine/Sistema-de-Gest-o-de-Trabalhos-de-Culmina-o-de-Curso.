<?php
require_once 'core/init.php';

//var_dump(Token::check(Input::get('token')));
//echo Input::get('id_curso');

if(Input::exists()){
	
	if(!Token::check(Input::get('token'))){
		//echo Input::get('username');
		echo 'i have been running';
		//die();
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'id_curso' => array(
				'required' => true
			),
			'id_disciplina' => array(
				'required' => true
			),
			'ano_academico' => array(
				'required' => true

			),
			'semestre' => array(
				'required' => true
			),
			'horas_contacto' => array(
				'required' => true
			),
		));
		
		if($validation->passed()){
			try{
				
				Disciplina::associarAoCurso(array(
					'id_curso' => Input::get('id_curso'),
					'id_disciplina' => Input::get('id_disciplina'),
					'ano_academico' => Input::get('ano_academico'),
					'semestre' => Input::get('semestre'),
					'horas_contacto' => Input::get('horas_contacto'))
				);
				
                Session::flash('succsess', 'docente registado com sucesso');
                
                Redirect::to("cursos-ver-disciplinas.php?id_curso=".Input::get('id_curso'));
				
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
if(Session::exists('home')){
	echo '<p>'.Session::flash('home').'</p>';
}
//echo Session::get(Config::get('session/session_name'));
//$user = new User();//current user
//if($user->isLoggedIn()){
	
?>
<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="javascript/funcoes.js"></script>
		<link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
		<script>
			//getCursos();
		</script>
		<style>
			 @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css");
			*{
				margin: 0;
				font-family: sans-serif;
			
			}

			input[type="text"] {
				width: 100%;
				padding: 15px 10px;
				/*border: none;*/
				border-bottom: 1px solid #645979;
				/*outline: none;*/
				border-radius: 5px 5px 0 0;
				background-color: #ffffff;
				font-size: 16px;
			}
			ul {
				list-style: none;
			}
			.list {
				width: 100%;
				background-color: #ffffff;
				border-radius: 0 0 5px 5px;
			}
			.list-items {
				padding: 10px 5px;
			}
			.list-items:hover {
			background-color: #dddddd;
			}

			.card{
				margin-top: 100px;
				margin-left: 200px;
				margin-right: 200px;
				padding-bottom: 30px;
				height: auto;
				margin-bottom: 100px;
				box-shadow: 0 0 40px 20px rgba(0, 1, 3, 0.39);
				perspective: 1000px;
				border-radius: 20px;

				/*background-color:#D9D9D9 ;*/

			}
			.row{
				margin-left: 70px;
				margin-top: 40px;
				margin-right: 70px;
                /*width: 80%;*/
                display: flex;
                flex-direction: row;
				text-align: center;
            }
			.column{
				width: 50%;
				display: flex;
				flex-direction: column;
			}
			#submit{
				width:auto;
			}

		</style>
	</head>
	<body>
	<header>
        
    </header>
	<main class="section-main">
		<!--<div class="card">-->
		
			<form class="card" id="formulario" action="" method="post" class="row g-3 needs-validation" novalidate>
				<div class="row">
					<p>Associar Trabalho ao Supervisor</p>
				</div>
				<div class="row">
                    <div class="column">
                            <div class="form-floating mb-3">
                                <input required="true" type="text" class="form-control" id="curso" name="curso" placeholder="curso" autocomplete="off">
                                <label class="input-label" for="floatingInput">Trabalho</label>
								<ul class="list"></ul>
                            </div>
                         </div>
                        <div class="column">
                            <div class="form-floating mb-3">
                                <input required="true" type="text" class="form-control" id="disciplina" name="disciplina" placeholder="disciplina" autocomplete="off">
                                <label class="input-label" for="floatingInput">Supervisor</label>
								<ul class="list2"></ul>
                            </div>
                        </div>
				    </div>
                </div>
				<div class="row">
				    <div class="column">
                        <div class="form-floating mb-3">
                            <input required="true" type="number" class="form-control" id="floatingInput" name="horas_contacto" placeholder="Horas de contacto" autocomplete="off">
                            <label class="input-label" for="floatingInput">Nome do estudante</label>
                        </div>
                    </div>
                    <!--<div class="column">-->
					<div class="col-md-3">
                        <label for="validationCustom04" class="form-label">Ano</label>
                        <select id="ano_academico" name="ano_academico" class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Escolha..</option>
                        <option value="1">1 Ano</option>
                        <option value="2">2 Ano</option>
                        <option value="3">3 Ano</option>
                        <option value="4">4 Ano</option>
                        </select>
                    </div>
					<div class="col-md-3">
                        <label for="validationCustom04" class="form-label">Semestre</label>
                        <select id="semestre" name="semestre" class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Escolha..</option>
                        <option value="1">1 Semestre</option>
						<option value="2">2 Semestre</option>
                        
                        </select>
                    </div>
                    <!---</div>-->
				</div>
				</div>
				<div class="row">
					<button id="submit" class="btn btn-primary" onclick="validarForm()" >Submit</button>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="hidden" name="id_curso" id="id_curso">
				<input type="hidden" name="id_disciplina" id="id_disciplina">
			</form>
		<!--</div>-->
       </main>
		</body>
		<script>


			
		</script>
</html>
<?php
//}
