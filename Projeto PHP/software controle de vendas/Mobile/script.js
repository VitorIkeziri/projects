function initialize() {
    var autocompletePartida = new google.maps.places.Autocomplete(document.getElementById('partida'));
    var autocompleteDestino = new google.maps.places.Autocomplete(document.getElementById('destino'));
  }
  
  google.maps.event.addDomListener(window, 'load', initialize);
  
  function calcularDistancia() {
    var partida = document.getElementById("partida").value;
    var destino = document.getElementById("destino").value;
  
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
      {
        origins: [partida],
        destinations: [destino],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
      },
      callback
    );
  }
  
  function callback(response, status) {
    if (status == "OK") {
      var origem = response.originAddresses[0];
      var destino = response.destinationAddresses[0];
      var distancia = response.rows[0].elements[0].distance.text;
      var duracao = response.rows[0].elements[0].duration.text;
  
      document.getElementById("resultado").innerHTML =
        "Origem: " + origem + "<br>" +
        "Destino: " + destino + "<br>" +
        "Distância: " + distancia + "<br>" +
        "Duração: " + duracao;
    } else {
      document.getElementById("resultado").innerHTML = "Erro ao calcular a distância.";
    }
  }
  