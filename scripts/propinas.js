window.addEventListener("load", function() {
    let usuario = JSON.parse(localStorage.getItem('user'));
    console.log(usuario);

    
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
    }else{
        propina = 3;
        inputPropina.value = 3;
    }
    costeInicial = parseFloat(costeInicialPedido.replace(',', '.'));
    mostrarCoste.innerHTML = (costeInicial + (costeInicial * (propina/100))).toFixed(2) + " €";

    mostrarSumaPropina((costeInicial * (propina/100)).toFixed(2));
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


const botonPagar = document.getElementById('pagar');
botonPagar.addEventListener('click', guardarPropina);

function guardarPropina() {
    let propina = document.getElementById('costePropina').innerText;
    console.log(typeof parseFloat(propina));
    localStorage.setItem('propina', parseFloat(propina));
}