window.addEventListener("load", function() {
    let usuario = JSON.parse(localStorage.getItem('user'));

});

const costeInicialPedido = document.getElementsByName('costePedido')[0].value;

const enlacePropina = document.getElementById('dar-propina');
enlacePropina.addEventListener('click', mostrarInputPropina); 

const formPropina = document.getElementById('form-propina');
formPropina.addEventListener('submit', aplicarPropina); 
ocultar(formPropina);

const infoPropina = document.getElementsByClassName('totalPropina')[0];
infoPropina.style.display = "none";

function aplicarPropina(e){
    e.preventDefault();
    const inputPropina = document.getElementsByName('porcentaje-propina')[0];
    console.log("aplicarPropina");
    
    let mostrarCoste = document.getElementsByClassName('total-price')[0];
    if (inputPropina.value >= 3 && inputPropina.value <= 100) {
        propina = inputPropina.value;
        success('propina aplicada: '+ propina);

        costeAnteriorPedido = document.getElementsByName('costePedido')[0].value;
        costeInicial = parseFloat(costeAnteriorPedido.replace(',', '.'));
        
        let precioFinal = (costeInicial + (costeInicial * (propina/100))).toFixed(2);
        let costePedido = document.getElementsByName('costePedido')[0];
        costePedido.value = precioFinal;
        mostrarCoste.innerHTML = precioFinal + " €";

        mostrarSumaPropina((costeInicial * (propina/100)).toFixed(2));
    }else if (inputPropina.value <= 3){
        error('propina minima 3%');
    }else{
        error('propina minima 3% y maxima 100%');
    }
    

    
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

function mostrarSumaPropina(coste){
    ocultar(formPropina);

    infoPropina.style.display = "block";

    document.getElementById("costePropina").innerHTML = coste;

    const quitarPropina = document.getElementById('quitar-propina');
    quitarPropina.addEventListener('click', eliminarPropina);
}

function mostrarInputPropina(e) {
    e.preventDefault();
    ocultar(enlacePropina);
    mostrar(formPropina);
}

function eliminarPropina(e) {
    e.preventDefault();
    ocultar(infoPropina);
    mostrar(enlacePropina);

    resetCoste(document.getElementById('costePropina').innerText);
}

function resetCoste(costePropina){
    document.getElementsByClassName('total-price')[0].innerHTML = costeInicialPedido;
}

function mostrar(a) {
    a.style.display = "block";
}

function ocultar(a) {
    a.style.display = "none";
}


let botonPagar = document.getElementById('pagar');
botonPagar.addEventListener('click', guardarPropina);

function guardarPropina() {
    let propina = document.getElementById('costePropina').innerText;
    localStorage.setItem('propina', parseFloat(propina));
}