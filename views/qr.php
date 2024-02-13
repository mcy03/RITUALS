<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Código QR</title>
</head>
<body>
    <h1>Generador de Código QR</h1>
    <input type="text" id="texto" placeholder="Introduce el texto para el QR">
    <button onclick="generarCodigoQR()">Generar QR</button>
    <div id="codigoQR"></div>

    <script>
        function generarCodigoQR() {
            var texto = document.getElementById("texto").value;
            var url = "https://api.example.com/generate_qr";
            var data = { text: texto };

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al generar el código QR");
                }
                return response.blob();
            })
            .then(blob => {
                var codigoQR = URL.createObjectURL(blob);
                document.getElementById("codigoQR").innerHTML = `<img src="${codigoQR}" alt="Código QR">`;
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    </script>
</body>
</html>
