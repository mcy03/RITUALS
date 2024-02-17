
    console.log(costeInicialPedido);

    const clickAplicar = document.getElementById('poner-puntos');

    const formPuntos = document.getElementById('form-puntos');
    formPuntos.style.display = "none";
    formPuntos.addEventListener('submit', aplicarDescuento);

    const mostrarPuntos = document.getElementById('descuentoPuntos');
    mostrarPuntos.style.display = "none";

    clickAplicar.addEventListener('click', mostrarInput);


function mostrarInput(e) {
    e.preventDefault();
    clickAplicar.style.display = "none";
    formPuntos.style.display = "block";
}



async function aplicarDescuento(e) {
    e.preventDefault();
    

    const inputPuntos = document.getElementById('puntos-aplicados');
    let puntosSelect = inputPuntos.value;
    console.log(puntosSelect);
    const puntosUser = await obtenerPuntosUser();
    console.log(puntosUser);
    if (puntosSelect > 0) {
        if (puntosSelect <= puntosUser) {
            const puntosRestantes = puntosUser - puntosSelect;
            const descuento = puntosSelect/100;
            console.log('restantes: '+ puntosRestantes);
            console.log('descuento: '+ descuento);
            success('Has seleccionado '+ puntosSelect + ' puntos, te quedaran '+puntosRestantes);
            
            let h3Mostrar = document.getElementById('h3descuento');

            h3Mostrar.innerHTML = '- '+descuento + ' €';

            

            let costePedido = document.getElementsByName('costePedido')[0];
            let mostrarCoste = document.getElementsByClassName('total-price')[0];
            let precioCalculado = parseFloat(costePedido.value.replace(',', '.')) -  parseFloat(descuento);

            costePedido.value = precioCalculado.toFixed(2);
            mostrarCoste.innerHTML = precioCalculado.toFixed(2) + " €";


            let hiddenPuntos = document.getElementsByName('puntosUsados')[0];

            hiddenPuntos.value = puntosSelect;
            formPuntos.style.display = "none";
            mostrarPuntos.style.display = "block";
        }else{
            warning('Cuidado, tienes solo '+puntosUser+' puntos.');
        }
    }else{
        warning('Selecciona una cantidad de puntos valida');
    }
    

    
}

async function obtenerPuntosUser() {
    if (localStorage.getItem('user')) {
        const user = JSON.parse(localStorage.getItem('user'));
        let formData = new FormData();
        formData.append('accion', 'get_points_user');
        formData.append('user_id', user[0].USUARIO_ID);

        const url = 'https://testcaler.com/testCaler/RITUALS/?controller=ApiUser&action=api';

        try {
            const response = await axios.post(url, formData);

            return await response.data;
        } catch (error) {
            console.error('Error:', error.message);
        }
    }else{
        return 0;
    }
}

const quitarPuntos = document.getElementById('quitar-puntos');
quitarPuntos.addEventListener('click', reiniciarPuntos);

function reiniciarPuntos(e) {
    e.preventDefault();
    mostrarPuntos.style.display = "none";
    clickAplicar.style.display = "block";
}





function success (mensaje) {
    notie.setOptions({
        alertTime: 2
      })
    notie.alert({ type: 1, text: mensaje, time: 2 })
}

function warning (mensaje) {
    notie.setOptions({
        alertTime: 2
      })
    notie.alert({ type: 2, text: mensaje, time: 2 })
}

function error (mensaje) {
    notie.setOptions({
        alertTime: 2
      })
    notie.alert({ type: 3, text: mensaje, time: 2 })
}

let botonPagarDesc = document.getElementById('pagar');
botonPagarDesc.addEventListener('click', guardarPuntos);

function guardarPuntos() {
    let hiddenPuntos = document.getElementsByName('puntosUsados')[0];
    localStorage.setItem('puntos', parseFloat(hiddenPuntos.value));
}