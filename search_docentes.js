var input;

document.addEventListener("DOMContentLoaded", function(){
  input = document.getElementById("docente");
  
  setupInputListener();
});


var docentes = []; // Variável global


var arrCursos = [];


function getCurso(callback) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = "get-docentes.php";
  var asynchronous = true;

  ajax.open(method, url, asynchronous);
  ajax.send();
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        docentes = JSON.parse(this.responseText); // Atribui o valor à variável global
      //console.log(cursos); 
      callback();
    }
  };
}

function imprimirCursos() {
  //console.log(cursos); 
  for(i = 0; i<docentes.length; i++){
    arrCursos[i] = docentes[i].nome_docente;
    console.log(arrCursos[i]);
  }
}



getCurso(imprimirCursos); 


//reference


// Rest of your code...

function setupInputListener() {
  //Sort names in ascending order
  let sorteCursos = arrCursos.sort();

  //Execute function on keyup
  input.addEventListener("keyup", (e) => {
    removeElements();
  for (let i of sorteCursos) {
      //convert input to lowercase and compare with each string

      if (i.toLowerCase().startsWith(input.value.toLowerCase()) && input.value != "") {
      //create li element
      let listItem = document.createElement("li");
      //One common class name
      listItem.classList.add("list-items");
      listItem.style.cursor = "pointer";
      listItem.setAttribute("onclick", "displayNames('" + i + "')");
      //Display matched part in bold
      let word = "<b>" + i.substr(0, input.value.length) + "</b>";
      word += i.substr(input.value.length);
      //display the value in array
      listItem.innerHTML = word;
      document.querySelector(".list").appendChild(listItem);
      }
  }
  });

}

  //Execute function on keyup
  function displayNames(value) {
  input.value = value;
  for(var i=0; i<docentes.length; i++){
    if(value == docentes[i].nome_docente){
      document.getElementById("codigo_docente").value = docentes[i].codigo_docente;
      console.log(document.getElementById("codigo_docente").value);
      
      break;
    }
  }
  removeElements();
  }


  function removeElements() {
  //clear all the item
  let items = document.querySelectorAll(".list-items");
  items.forEach((item) => {
      item.remove();
  });
  }

 

    function validarForm(){

      var nome_curso = document.getElementById("curso").value;
      var nome_disciplina = document.getElementById("disciplina").value;

      for(i=0; i<cursos.length; i++){
        if(cursos[i].designacao == nome_curso){
          document.getElementById("id_curso").value = cursos[i].id_curso;
          console.log("achado!!!");
          break
        }
      }
      
      for(i = 0; i<disciplinas.length; i++){
        if(disciplinas[i].nome == nome_disciplina){
          document.getElementById("codigo_disciplina").value = disciplinas[i].codigo_disciplina;
          console.log("achado!!!");
          break;
        }
      }
      
      
    }