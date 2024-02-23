<?php
require_once 'core/init.php';
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if($validation->passed()){
            //logIn
            $user = new User();
            $remember = (Input::get('remember') === 'on') ? true:false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);
            if($login){
               // echo 'Succsess';
               Redirect::to('index.php');
            }else{
                echo '<script>alert("login falhou!!")</script>'; 
            }
        }else{
            foreach($validation->errors() as $erro){
                echo $erro.'<br>';
            }
        }

    }
}
?>

<html lang="pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin=""></script>
    <!--<link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/form-style.css">-->
    <script src="Jquery/jq.js"></script>
    <style>
        

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card-form {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Make form inputs responsive */
        .form-floating {
            margin-bottom: 20px;
        }

        /* Add more responsive CSS as needed */

        /* Center the button */
        .btn-primary {
            display: block;
            margin: 0 auto;
        }
        img{
            width:50px;
            height:50px;
        }
        .field{
            margin-bottom:20px;
        }
        .imagem{
            width: 100%;
            text-align:center;
        }



    </style>

<body>
    <form class="card-form" action="" method="post">
        <div class="imagem"><img src="up-logo.png"></div>
        <div class="field">
            <label>Sistema de Gestão de Trabalhos de Culminação de Curso</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="floatingInput" type="text" name="username" autocomplete="off" placeholder="nome do user">
            <label for="floatingInput">Nome</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="floatingInput" type="password" type="password" name="password" placeholder="senha">
            <label for="floatingInput">senha</label>
        </div>
        <div class="field">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember">guardar a sessao
            </label>
        </div>
        <input class="bt_submit" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <div class="imagem"><button class="btn btn-primary" type="submit">Login</button></div>
    </form>
</body>
</html>
