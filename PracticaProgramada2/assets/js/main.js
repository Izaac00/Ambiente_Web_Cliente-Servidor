//Ejercicio 1

//Ejercicio 2

const cambiarTexto = () => {

    const parrafo = document.querySelector('#parrafo');
    parrafo.textContent = "Se cambio el texto del parrafo";
}

const button = document.querySelector('#btnCambiarTexto');

if (button) {

  button.addEventListener('click', cambiarTexto);

}
//Ejercicio 3

document.addEventListener("DOMContentLoaded", function () {

  const inputEdad = document.querySelector("#input-edad");
  inputEdad.addEventListener("change", verificarEdad);

});

const verificarEdad = (event)=> {

    const texto = document.querySelector("#texto-edad");
    const edad = parseInt(event.target.value);
    
    if (edad > 18) {

        texto.textContent = "Eres mayor de edad.";

    } else {

        texto.textContent = "Eres menor de edad.";

    }

}

//Ejercicio 4

const estudiantes = [
    { nombre: "John", apellido: "Alonso", nota: 85 },
    { nombre: "Lucía", apellido: "Campos", nota: 90 },
    { nombre: "Andrés", apellido: "Ramírez", nota: 70 },
    { nombre: "María", apellido: "Zúñiga", nota: 95 }
  ];    

const mostrarEstudiantes = () => {
 
    const listaEstudiante = document.querySelector("#listaEstudiantes");
    listaEstudiante.innerHTML = "";

    let total = 0;

    estudiantes.forEach(est => {
        const linea = document.createElement("div");
        linea.textContent = est.nombre + " " + est.apellido + " - Nota: " + est.nota;
        listaEstudiante.appendChild(linea);
        total += est.nota;
    });

    const promedio = total / estudiantes.length;

    const lineaPromedio = document.createElement("div");
    lineaPromedio.classList.add("alert", "alert-info");
    lineaPromedio.textContent = "Promedio de notas: " + promedio;

    listaEstudiante.appendChild(lineaPromedio);
};

const btnMostrarEstudiantes = document.querySelector("#btnMostrarEstudiantes");

    if (btnMostrarEstudiantes) {
        btnMostrarEstudiantes.addEventListener('click', mostrarEstudiantes);
    }