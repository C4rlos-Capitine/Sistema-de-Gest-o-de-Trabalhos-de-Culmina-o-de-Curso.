<?php
require_once 'core/init.php';

$faculdade = (array)Faculdade::get();
$user = new User();

if($user->isLoggedIn()){

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
    
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>

    
    <style>
     .tb-data tr:nth-child(even){background-color: #a4bdc9;}

    .tb-data tr:hover {background-color: rgb(154, 186, 215);}


    .tb-data {
        font-family: Arial, Helvetica, sans-serif;
        background-color: rgb(8, 161, 249);
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
        <div class="col-md-3">
            <label for="validationCustom04" class="form-label">Faculdade</label>
            <select name="faculdade" id="faculdade" class="form-select" required>
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
    
        <table class="tb-data">
            <thead >
                <tr>
                    <th>id</th>
                    <th>Nome</th>
                    <th>sigla</th>
                </tr>
            </thead>
            <tbody id="dados">
                
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
                var html = '';
                for(var a = 0; a< data.length; a++){
                    html += '<tr><td>'+data[a].id_curso+'</td><td>'+data[a].designacao+'</td><td>'+data[a].sigla+'</td></tr>';
                    console.log(data[a].designacao);
                }
                document.getElementById("dados").innerHTML = html;
                console.log(html);
                }else{
                    console.log("erro");
                }
        }
    });
</script>
</html>
<?php
}else{
    Redirect::to("user-login.php");
}