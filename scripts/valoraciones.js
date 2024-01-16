

const datosResenas = [
    { nombre: 'Ana', pedido: 10, puntuacion: 5, comentario: '¡Los cócteles son simplemente deliciosos! La presentación es encantadora y la calidad de los ingredientes es inigualable. Definitivamente, mi nueva opción para cualquier celebración.' },
    { nombre: 'Juan', pedido: 5, puntuacion: 4, comentario: 'Probé varios cócteles y quedé impresionado con la diversidad de sabores. Los ingredientes frescos y la atención al detalle hacen que cada sorbo sea una experiencia única. ¡Recomiendo probarlos todos!' },
    { nombre: 'María', pedido: 3, puntuacion: 2, comentario: 'Pedí un pack variado y quedé decepcionado. Los sabores no eran tan vibrantes como esperaba, y algunos cócteles tenían un gusto artificial. No cumplió con mis expectativas.' }
];

const reverseDatosResenas = datosResenas.reverse();
crearTablaResenas(reverseDatosResenas);

let formulario = document.getElementById("formularioValoracion");
formulario.addEventListener("submit", comprobarDatos);
formulario.addEventListener("submit", resetEstrellas);

// Función para crear las estrellas
function crearEstrellas(puntuacion, id) {
    const estrellasContainer = document.getElementById(id);
    estrellasContainer.innerHTML = ''; // Limpia el contenido previo

    // Crea un ícono de estrella para cada punto de puntuación
    for (let i = 0; i < puntuacion; i++) {
        const estrella = document.createElement('i');
        estrella.className = 'fas fa-star'; // Clase de FontAwesome para la estrella resaltada
        estrellasContainer.appendChild(estrella);
    }

    // Crea un ícono de estrella vacía para el resto
    for (let i = puntuacion; i < 5; i++) {
        const estrellaVacia = document.createElement('i');
        estrellaVacia.className = 'far fa-star'; // Clase de FontAwesome para la estrella vacía
        estrellasContainer.appendChild(estrellaVacia);
    }
}

function crearTablaResenas(data) {
    const contenedorTabla = document.getElementById('resenas');
    const tabla = document.createElement('table');
    tabla.className = 'tabla_resenas';
    let cont = 1;
    data.forEach(resena => {
        const trNombre = document.createElement('tr');
        trNombre.className = 'tr_resenas';

        const tdIcono = document.createElement('td');
        tdIcono.className = 'td_resenas_icon';
        const icono = document.createElement('img');
        icono.src = './img/user-icon-black.png';
        icono.width = '50';
        tdIcono.appendChild(icono);

        const tdNombre = document.createElement('td');
        tdNombre.className = 'td_resenas_name';
        tdNombre.textContent = resena.nombre;

        trNombre.appendChild(tdIcono);
        trNombre.appendChild(tdNombre);

        const trPuntuacion = document.createElement('tr');
        const tdEspacio = document.createElement('td');
        tdEspacio.rowSpan = '3';
        tdEspacio.className = 'td_space';
        trPuntuacion.appendChild(tdEspacio);

        const tdPuntuacion = document.createElement('td');
        tdPuntuacion.id = 'td_resenas_puntuacion'+cont;
        tdPuntuacion.className = 'td_resenas_estrellas';
        trPuntuacion.appendChild(tdPuntuacion);

        const trPedido = document.createElement('tr');
        const tdPedido = document.createElement('td');
        tdPedido.id = 'td_resenas_pedido'+cont;
        tdPedido.className = 'td_resenas_estrellas';
        tdPedido.textContent = "Pedido: " + resena.pedido;
        trPedido.appendChild(tdPedido);

        const trComentario = document.createElement('tr');
        const tdComentario = document.createElement('td');
        tdComentario.className = 'td_resenas_comentario';
        const textarea = document.createElement('textarea');
        textarea.disabled = true;
        textarea.textContent = resena.comentario;
        tdComentario.appendChild(textarea);
        trComentario.appendChild(tdComentario);

        const trEspacio = document.createElement('tr');
        trEspacio.className = 'tr_space';

        tabla.appendChild(trNombre);
        tabla.appendChild(trPuntuacion);
        tabla.appendChild(trPedido);
        tabla.appendChild(trComentario);
        tabla.appendChild(trEspacio);

        cont++;
    });

    contenedorTabla.appendChild(tabla);
    cont = 1;
    data.forEach(resena => {
        crearEstrellas(resena.puntuacion, 'td_resenas_puntuacion'+cont);
        cont++;
    });
}

function comprobarDatos(event) {
    event.preventDefault();
    const pedido = document.getElementById('pedido').value;
    if (pedido == "undefined") {
        modal("errorId");
    }else{
        const nombre = document.getElementById('nombre').value;
        let puntuacion = 0;
        let b_checked = false;
        let radios = document.getElementsByName('estrellas');
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                puntuacion = i;
                b_checked = true;
                break;
            }
        }
        if (puntuacion == 0 && b_checked) {
            puntuacion = 5;
        }else if(puntuacion > 0 && puntuacion < 5){
            puntuacion = 5 - puntuacion;
        }

        

        const comentario = document.getElementById('comentario').value;

        const nuevaResena = {
            nombre: nombre,
            pedido: pedido,
            puntuacion: puntuacion,
            comentario: comentario
        };  
        datosResenas.unshift(nuevaResena);

        const contenedorTabla = document.getElementById('resenas');
        contenedorTabla.innerHTML = "";
        
        document.getElementById('comentario').value = "";

        crearTablaResenas(datosResenas);
    }
}

function resetEstrellas(event) {
    event.preventDefault();
    let radios = document.getElementsByName('estrellas');

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            radios[i].checked = false;
        }
        
    }
}

function modal(mensaje){
    resetModal();
    switch (mensaje) {
        case "errorId":
            modalErrorId();
            break;
        case "confirmarResena":
            modalConfResena();
            botonesConfCanc();
            break;
        default:
            break;
    }

}

function resetModal(){
    var containerHead = document.getElementsByClassName("modal-header")[0];
    var containerBody = document.getElementsByClassName("modal-body")[0];
    var containerFooter = document.getElementsByClassName("modal-footer")[0];

    containerHead.textContent = "";
    containerBody.textContent = "";
    containerFooter.textContent = "";
}

function modalErrorId(){
    // Crea elementos y agrega clases y atributos
    var h5 = document.createElement("h5");
    h5.className = "modal-title";
    h5.textContent = "Error!";

    var closeButton = document.createElement("button");
    closeButton.type = "button";
    closeButton.className = "btn-close";
    closeButton.setAttribute("data-bs-dismiss", "modal");
    closeButton.setAttribute("aria-label", "Close");

    // Contenedor para los elementos creados
    var containerHead = document.getElementsByClassName("modal-header")[0];

    // Agrega los elementos al contenedor
    containerHead.appendChild(h5);
    containerHead.appendChild(closeButton);

    var p = document.createElement("p");
    p.textContent = "Seleccione un pedido por favor";

    var containerBody = document.getElementsByClassName("modal-body")[0];
    containerBody.appendChild(p);
}

function modalConfResena(){
    var h5 = document.createElement("h5");
    h5.className = "modal-title";
    h5.textContent = "Confirmar reseña";

    var closeButton = document.createElement("button");
    closeButton.type = "button";
    closeButton.className = "btn-close";
    closeButton.setAttribute("data-bs-dismiss", "modal");
    closeButton.setAttribute("aria-label", "Close");

    var containerHead = document.getElementsByClassName("modal-header")[0];

    containerHead.appendChild(h5);
    containerHead.appendChild(closeButton);

    var p = document.createElement("p");
    const comentario = document.getElementById('comentario').value;
    p.textContent = comentario;

    var containerBody = document.getElementsByClassName("modal-body")[0];
    containerBody.appendChild(p);
}


function botonesConfCanc() {
    var botonCerrar = document.createElement("button");
    botonCerrar.type = "button";
    botonCerrar.className = "btn btn-cancelar";
    botonCerrar.setAttribute("data-bs-dismiss", "modal");
    botonCerrar.textContent = "Cancelar";
    botonCerrar.addEventListener("click", cancelarSubmit);

    var botonConfirmar = document.createElement("button");
    botonConfirmar.type = "button";
    botonConfirmar.className = "btn btn-confirmar";
    botonConfirmar.textContent = "Confirmar";
    //botonConfirmar.addEventListener("click", realizarAccion);

    var contenedorFooter = document.getElementsByClassName("modal-footer")[0];

    contenedorFooter.appendChild(botonCerrar);
    contenedorFooter.appendChild(botonConfirmar);
}


function cancelarSubmit(e) {
    
}