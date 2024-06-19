<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Donaciones">
    <meta name="keywords" content="donaciones, payu, pagos">
    <title>Donaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Fondo oscuro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Evita el desplazamiento vertical */
            perspective: 1000px; /* Perspectiva para las animaciones 3D */
        }
        form, #resumen {
            background-color: rgba(255, 255, 255, 0.1); /* Fondo semitransparente */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1); /* Sombra con efecto de luz */
            max-width: 400px;
            width: 100%;
            position: relative; /* Posicionamiento relativo para el reloj */
            transform-style: preserve-3d; /* Conservar la perspectiva en los elementos hijos */
            animation: floatForm 10s linear infinite alternate; /* Animación de flotar */
            display: none; /* Ocultar inicialmente */
        }
        form {
            display: block; /* Mostrar el formulario por defecto */
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #fff; /* Color del texto */
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        select,
        button {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            color: #333; /* Color del texto */
            background-color: #f0f0f0; /* Color de fondo del formulario */
            transition: transform 0.5s; /* Transición al enfocar */
            animation: slideIn 2s ease-in-out; /* Animación de deslizamiento */
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        select:focus,
        button:focus {
            transform: scale(1.1); /* Escala al enfocar */
            border-color: #007bff; /* Color del borde al enfocar */
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            animation: pulse 2s 3 alternate; /* Animación de pulso */
        }
        button:hover {
            background-color: #0056b3;
        }
        .donate-real {
            text-align: center;
            margin-top: 20px;
        }
        .donate-real img {
            max-width: 250px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .donate-real p {
            margin-top: 10px;
            font-size: 14px;
            color: #eee; /* Color del texto */
        }
        #hora_actual {
            margin-top: 20px;
            font-size: 24px; /* Tamaño de fuente grande */
            text-align: center;
            color: #fff; /* Color del texto */
            font-weight: bold;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8); /* Sombra al texto */
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        .fade {
            animation: fadeInOut 1s ease-in-out; /* Animación de desvanecimiento */
        }
        #img {
            max-width: 150px;
            width: 10%;
            height: auto;
            display: block;
            margin: 0 auto;
            animation: rotateImg 16s linear infinite; 
            position: relative;
            top: -20px;
        }
        #resumen h2 {
            color: #fff;
            text-align: center;
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        #resumen p {
            color: #fff;
            font-size: 18px;
            margin: 10px 0;
            animation: fadeIn 2s ease-in-out; /* Animación de aparición */
        }
        #resumen button {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            color: #333; /* Color del texto */
            background-color: #f0f0f0; /* Color de fondo del formulario */
            cursor: pointer;
            transition: background-color 0.3s;
            animation: pulse 2s 3 alternate; /* Animación de pulso */
        }
        #resumen button:hover {
            background-color: #0056b3;
        }
        
        @keyframes rotateImg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }
        @keyframes slideIn {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(0); }
        }
        @keyframes floatForm {
            0% { transform: translateY(0); }
            100% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>

<form id="paymentForm" action="src/procesar_pago.php" method="POST">
    <label for="nombre_completo">Nombre Completo:</label>
    <input type="text" id="nombre_completo" name="nombre_completo" required>
    
    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" required>
    
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" required>
    
    <label for="monto">Monto:</label>
    <input type="number" id="monto" name="monto" required>
    
    <button type="button" onclick="mostrarResumen()">Pagar con nequi
    </button>
    
    <div class="donate-real">
        <a href="https://biz.payulatam.com/B0f650147B1A412"><img src="https://ecommerce.payulatam.com/img-secure-2015/boton_pagar_grande.png"></a>
        <p>¡Haz una diferencia real con tu donación!</p>
    </div>
    
    <p id="hora_actual"></p>
    
    <img id="img" src="https://christianmoralopez.github.io/images/logo.svg" data-dis-type="simultaneous">
</form>

<div id="resumen" style="display:none;">
    <h2>Resumen de la Transacción</h2>
    <p><strong>Nombre Completo:</strong> <span id="resumen_nombre"></span></p>
    <p><strong>Correo:</strong> <span id="resumen_correo"></span></p>
    <p><strong>Teléfono:</strong> <span id="resumen_telefono"></span></p>
    <p><strong>Monto:</strong> <span id="resumen_monto"></span></p>
    <button type="button" onclick="confirmarPago()">Confirmar y Continuar con el Pago</button>
    <button type="button" onclick="regresarFormulario()">Regresar y Corregir</button>
</div>

<script>
    function actualizarHora() {
        var ahora = new Date();
        var horas = ahora.getHours().toString().padStart(2, '0');
        var minutos = ahora.getMinutes().toString().padStart(2, '0');
        var segundos = ahora.getSeconds().toString().padStart(2, '0');
        var horaActual = horas + ':' + minutos + ':' + segundos;
        
        var horaElemento = document.getElementById('hora_actual');
        horaElemento.classList.remove('fade');
        void horaElemento.offsetWidth;  // Reinicia la animación
        horaElemento.classList.add('fade');
        horaElemento.textContent = 'Hora actual: ' + horaActual;
    }

    setInterval(actualizarHora, 1000);

    function mostrarResumen() {
        var nombre = document.getElementById('nombre_completo').value;
        var correo = document.getElementById('correo').value;
        var telefono = document.getElementById('telefono').value;
        var monto = document.getElementById('monto').value;

        document.getElementById('resumen_nombre').textContent = nombre;
        document.getElementById('resumen_correo').textContent = correo;
        document.getElementById('resumen_telefono').textContent = telefono;
        document.getElementById('resumen_monto').textContent = monto;

        document.getElementById('paymentForm').style.display = 'none';
        var resumen = document.getElementById('resumen');
        resumen.style.display = 'block';
        
        resumen.scrollIntoView({ behavior: 'smooth' });
    }

    function confirmarPago() {
        document.getElementById('paymentForm').submit();
    }

    function regresarFormulario() {
        document.getElementById('resumen').style.display = 'none';
        document.getElementById('paymentForm').style.display = 'block';
        document.getElementById('paymentForm').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</body>
</html>
