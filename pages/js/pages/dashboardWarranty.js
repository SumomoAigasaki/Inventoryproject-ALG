
$(function () {
  'use strict' 
  //-------------
  // - PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var tonalidadesVerde = ['#1A3E1F','#145A2A','#0B7433','#008000','#208E37','#49A54A','#80C080'];
  var tonalidadesAzul = ['#112135','#132C48','#11385D','#003F6D','#1A527C','#4E7A99','#819FB5'];
  var escalaGrises = ['#191919','#232323','#2d2d2d','#323232','#474747','#707070','#99999'];


var colors = [];

// Suponiendo que ambas listas tienen la misma longitud
for (var i = 0; i < tonalidadesAzul.length; i++) {
    colors.push(tonalidadesVerde[i]);
    colors.push(tonalidadesAzul[i]);
    colors.push(escalaGrises[i]);
}

// var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

// $(document).ready(function() {
//   $.ajax({
//       url: '../views/dashboard_warranty.php', // Ruta a tu archivo PHP que devuelve los datos
//       method: 'GET',
//       dataType: 'json',
//       success: function(response) {
//           var labels = [];
//           var data = [];
          
//           // Extraer etiquetas y datos del JSON recibido
//           response.forEach(function(item) {
//               labels.push(item.label);
//               data.push(item.data);
//           });

//           var pieData = {
//               labels: labels,
//               datasets: [{
//                   data: data,
//                   backgroundColor: colors // Aquí se asignan los colores combinados
//               }]
//           };

//           // Create pie or doughnut chart
//           var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
//           var pieOptions = {
//               maintainAspectRatio: false,
//               responsive: true,
//               plugins: {
//                   legend: {
//                       position: 'right',
//                   },
//               }
//           };

//           var pieChart = new Chart(pieChartCanvas, {
//               type: 'pie',
//               data: pieData,
//               options: pieOptions
//           });

//           // Usa pieData aquí como lo necesites
//           console.log(pieData);
//       },
//       error: function(xhr, status, error) {
//           // Manejo de errores si la solicitud falla
//           console.error(error);
//       }
//   });
// });
  //-----------------
  // - END PIE CHART -
  //-----------------

  //----------------
  //- ScatterChart -
  //----------------
  // var $scatterChart= $('#scatterChart')

  //  // Datos proporcionados
  //  var nombresAreas = ['Agricola', 'Asotag', 'Asuntos Publicos', 'Finanzas', 'General', 'Industrial','Ing en procesos'];
  //  var cantidadDatos = [10, 20, 2, 50, 2,1,10]; // Cantidad de datos actualizada para coincidir con las áreas.

  //  // Obtener el tamaño del círculo basado en la cantidad de datos
  //  var minSize = 5;
  //  var maxSize = 30;

  //  var tonalidadesAzul = ['#003F6D','#112135','#132C48','#11385D','#1A527C','#4E7A99','#819FB5'];
  //  var tonalidadesVerde= ['#008000','#1A3E1F','#145A2A','#0B7433',,'#208E37','#49A54A','#80C080'];
  //  var escalaGrises = ['#191919','#232323','#2d2d2d','#323232','#474747','#707070','#99999'];

  //  var colors= [];
  //   // Suponiendo que ambas listas tienen la misma longitud
  // for (var i = 0; i < tonalidadesAzul.length; i++) {
  //   colors.push(tonalidadesVerde[i]);
  //   colors.push(tonalidadesAzul[i]);  
  //   colors.push(escalaGrises[i]);
  // }
  // //  //var colors = ['#008000','#003F6D', 'rgba(255, 205, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)','rgba(31,97,141,1.000)','rgba(21,67,96,1.000)' ];
   
   
  //  var data = {
  //   datasets: nombresAreas.map((area, index) => {
  //     return {
  //       label: `${area}`,
  //       message:`${cantidadDatos[index]} Dispositivo(s) en "${area}"`,
  //       data: [{
  //         x: index, // Coordenada X para la posición del punto (puedes usar index o cualquier otra cosa dependiendo de tus necesidades)
  //         y: cantidadDatos[index], // Coordenada Y para la posición del punto basado en la cantidad de datos
  //         r: (cantidadDatos[index]) / 2, // Calcular el tamaño del círculo basado en la cantidad de datos
  //       }], // Usar la cantidad de datos correspondiente a cada área como valor
  //       borderColor: colors[index % colors.length], // Usar un color del arreglo de colores para cada área
  //       backgroundColor: colors[index % colors.length], // Usar el mismo color como fondo para cada área
  //     };
  //   }),
  // };

  
  // const scatterChart = new Chart($scatterChart, {
  //   type: 'bubble',
  //   data: data,
  //   options: {
  //     responsive: true,
  //     plugins: {
  //       legend: {
  //         position: 'right',
  //       },
  //       tooltip: {
  //         callbacks: {
  //           label: function (context) {
  //             const label = context.dataset.message || '';
  //             if (context.parsed.y !== null) {
  //               return `${label} `;
  //             }
  //             return label;
  //           },
  //         },
  //       },
  //     },
  //   },
  // });
     
  //--------------------
  //- END ScatterChart -
  //--------------------

  //--------------------
  //-  Line/Bar Chart  -
  //--------------------
 
  // Supongamos que tienes datos reales para cada columna
  var colors = [ '#008000','#003F6D', '#323232', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)','rgba(31,97,141,1.000)','rgba(21,67,96,1.000)' ];
   
  const datosColumna1 = [17, 20, 30, 40, 50, 60, 70]; // Ejemplo de datos para columna1
  const datosColumna2 = [15, 25, 35, 45, 55, 65, 75]; // Ejemplo de datos para columna2
  const datosGrafica = [18, 30, 75, 50, 80, 80, 15]; // Ejemplo de datos para la gráfica
  const labelsInfo = ['21 nov 2023', '22 nov 2023', '23 nov 2023', '24 nov 2023', '25 nov 2023', '26 nov 2023', '27 nov 2023'];

  // setup 
  const dataGraphic = {
    labels: labelsInfo,
    
    datasets: [{
      type: 'bar',
      label: 'Dataset 1',
      backgroundColor: colors[0],
      borderColor: colors[0],
      // backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
      // borderColor: Utils.CHART_COLORS.red,
      data: datosColumna1,
    }, {
      type: 'bar',
      label: 'Dataset 2',
      backgroundColor: colors[1],
      borderColor: colors[1],
      data:datosColumna2,
    }, {
      type: 'line',
      label: 'Dataset 3',
      backgroundColor: colors[2],
      borderColor: colors[2],
      fill: false,
      data: datosGrafica,
    }]
  };

  // config 
  const configlineBar = {
    type: 'line',
    data:dataGraphic,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };

  // render init block
  const myChart = new Chart(
    document.getElementById('lineBar'),
    configlineBar
  );

  //------------------------
  //-  END Line/Bar Chart  -
  //------------------------
})
