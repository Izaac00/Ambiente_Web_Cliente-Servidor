
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#formulario");
    const tbody = document.querySelector("#tbody-estudiantes");


    const cargarEstudiantes = () => {

        const estudiantesJson = localStorage.getItem('estudiantes');
        const estudiantesArray = JSON.parse(estudiantesJson);
        tbody.innerHTML = "";

        estudiantesArray.forEach(est => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${est.nombre}</td>
                <td>${est.apellidos}</td>
                <td>${est.nota}</td>
            `;
            tbody.appendChild(fila);
        });
    };

    cargarEstudiantes();

    const submitFormulario = (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());


        if (!data.nombre || !data.apellidos || !data.nota) {
            Swal.fire({
                icon: "error",
                title: "Campos vacios",
                text: "Tiene que llenar todos los campos."
            });

            return;
        }

        if (isNaN(data.nota) || data.nota < 0 || data.nota > 100) {
            Swal.fire({
                icon: "error",
                title: "Nota no aceptada",
                text: "La nota tiene que ser un número entre 0 y 100."
            });
            return;
        }

        let estudiantes = JSON.parse(localStorage.getItem("estudiantes"));
        estudiantes.push(data);
        localStorage.setItem("estudiantes", JSON.stringify(estudiantes));

        Swal.fire({
            icon: "success",
            title: "Se registro el estudiante",
            text: "Estudiante agregado."
        });

        form.reset();

        cargarEstudiantes();

    };

    form.addEventListener("submit", submitFormulario);

});