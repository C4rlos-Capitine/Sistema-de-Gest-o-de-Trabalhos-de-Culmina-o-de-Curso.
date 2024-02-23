<?php
require_once 'core/init.php';


$user = new User();
$info_curso = "";
if(($user->isLoggedIn())){
    if(!$user->hasPermission('admin')){
        $info_curso = Director_curso::getDadosDirector($user->data()->id);
        $docente = Curso::getDocentes($info_curso->id_curso);
    
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
    <link rel="stylesheet" href="css/index-style.css">
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="fontawsome/css/all.min.css" rel="stylesheet">
    <link href="fontawsome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/form-style.css">
    <script src="Jquery/jq.js"></script>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>

    
    <style>
     .tb-data tr:nth-child(even){background-color: #a4bdc9;}

    .tb-data tr:hover {background-color: rgb(154, 186, 215);}


    .tb-data {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: 100px;
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
        
		<table class="tb-data">
            <thead>
                <tr><th colspan="3">Docentes do Curso de <?php echo $info_curso->designacao; ?></th></tr>
                <tr><th>Nome</th><th>codigo</th><th></th></tr>
            </thead>
            <tbody>
                <?php
                for($i=0; $i<sizeof($docente); $i++){
                    ?>
                    <tr>
                        <td><?php echo $docente[$i]->nome_docente.' '.$docente[$i]->apelido; ?></td>
                        <td><?php echo $docente[$i]->codigo_docente; ?></td>
                        <td><button type="button" id="<?php echo $docente[$i]->codigo_docente; ?>" onclick="verAreasCientificas(this.id)" class="btn btn-primary btn-sm">Ver Areas Cientificas</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
	</main>
    <div class="popup">
            <label>Areas Cientificas</label>
        <span class="close-btn">&times;</span>
        <table border="0" class="tb-data">
          <thead>
            <tr><th colspan="8" id="nome"></th></tr>
            <tr><th>Area</th></tr>
        </thead>
        <tbody id="tbody">

        </tbody>
      </table>
        </div>
</body>
<script>
    
	function verAreasCientificas(id){
			//window.location.href = "docente-ver-disciplinas.php?id_docente="+id;
      console.log(id);
      var ajax = new XMLHttpRequest();
      var method = "GET";
      var url = "get_areas_cientificas_docente.php?id_docente="+id;
      var asynchronous = true;
      ajax.open(method, url, asynchronous); 
      ajax.send();
      ajax.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
              var areas = JSON.parse(this.responseText);
              console.log(areas);
          
              //select = document.getElementById("trabalho");
              var html = "";
             for(var a = 0; a< areas.length; a++){
                  
                    html += "<tr><td>"+areas[a].designacao_area_cientifica+"</td></tr>"
                }
                
              document.getElementById("tbody").innerHTML = html;
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
    }
}else{
    Redirect::to("index.php");
}