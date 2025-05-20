<!DOCTYPE html>
<html>
<head>
  <title>Calculadora de Distância</title>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuBlsoW013a-ldunxfdkO38oamsER23nE&libraries=places"></script>
</head>
<body>
  <h1>Calculadora de Distância</h1>

  <label for="partida">Endereço de Partida:</label>
  <input type="text" id="partida">

  <label for="destino">Endereço de Destino:</label>
  <input type="text" id="destino">

  <button onclick="calcularDistancia()">Calcular</button>

  <div id="resultado"></div>

  <script src="script.js"></script>
</body>
</html>