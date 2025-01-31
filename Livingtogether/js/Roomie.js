let indiceDiapositiva = 0;
const contenidoEquipo = document.getElementById('contenido-equipo');
const perfilesPorPagina = 6; // Perfiles visibles por página

function obtenerPerfiles() {
    fetch('vistas/Roomie/obtener_perfiles.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            contenidoEquipo.innerHTML = ''; // Limpiar el contenido anterior

            // Limitar a solo 6 perfiles
            const perfilesLimitados = datos.slice(0, perfilesPorPagina);

            // Almacenar perfiles en un array
            const perfiles = perfilesLimitados.map(perfil => {
                const cajaPerfil = document.createElement('div');
                cajaPerfil.classList.add('team-box');
                cajaPerfil.innerHTML = `
                    <img src="${perfil.fotop ? 'data:image/jpeg;base64,' + perfil.fotop : 'ruta/default.jpg'}" 
                         alt="Perfil de ${perfil.nombre}">
                    <h2>${perfil.nombre} ${perfil.segundo_nombre || ''} ${perfil.apellidos}</h2>
                    <span class="edad">${perfil.edad} años</span>
                    <br>
                    <span>${perfil.profesion}</span>
                    <p>${perfil.descripcion}</p>
                `;
                return cajaPerfil; // Devuelve el elemento creado
            });

            // Agregar los perfiles al contenedor
            perfiles.forEach(perfil => {
                contenidoEquipo.appendChild(perfil);
            });

            // Ajustar el ancho del contenedor
            contenidoEquipo.style.width = `${(perfilesPorPagina * 100)}%`;

            // Inicializar la vista de perfiles
            actualizarVisibilidadPerfiles();
        })
        .catch(error => console.error('Error al obtener perfiles:', error));
}

function actualizarVisibilidadPerfiles() {
    const perfiles = contenidoEquipo.children;

    // Ocultar todos los perfiles
    for (let i = 0; i < perfiles.length; i++) {
        perfiles[i].style.display = 'block'; // Mostrar todos ya que solo hay 6
    }
}

function moverDiapositiva(n) {
    // No se necesita lógica de diapositivas si solo hay 6 perfiles
}

window.onload = () => obtenerPerfiles();
