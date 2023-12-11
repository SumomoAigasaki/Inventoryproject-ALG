function index(){
    this.ini = function(){
        console.log("Inicio...");
        this.getDataCardsRN();
        this.getDataCardsRWF();
        this.getDataCardsRNC ();        
        this.getDataCardsRUC ();    
        this.getDataLine();
        this.getScatterData();
        this.getPieData();
       
    }

     /**
     * Asignar  datos a la card de  rNuevos
     */
    this.getDataCardsRN = function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"1"
            }
        }).done(function(datos){
            $("#rNuevos").text(parseFloat(datos).toLocaleString());
        });

    }
     /**
     * Asignar  datos a la card de  rCoverage
     */
    this.getDataCardsRWF = function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"2"
            }
        }).done(function(datos){
            $("#rCoverage").text(parseFloat(datos).toLocaleString());
        });

    }
      /**
     * Asignar  datos a la card de  rNonCoverage
     */
      this.getDataCardsRNC = function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"3"
            }
        }).done(function(datos){
            $("#rNonCoverage").text(parseFloat(datos).toLocaleString());
        });

    }
    /**
    * Asignar  datos a la card de  rUpcoming
    */
    this.getDataCardsRUC = function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"4"
            }
        }).done(function(datos){
            $("#rUpcoming").text(parseFloat(datos).toLocaleString());
        });

    }
      /**
    * Asignar  datos a la Grafica Lineal
    */

    this.getDataLine= function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"5"
            }
        }).done(function(datos){
            var tonalidadesVerde = ['#008000'];
            var tonalidadesAzul = ['#003F6D'];
            var escalaGrises = ['#323232'];
            var colors = [];
            for (var i = 0; i < tonalidadesAzul.length; i++) {
                        colors.push(tonalidadesVerde[i]);
                        colors.push(tonalidadesAzul[i]);
                        colors.push(escalaGrises[i]);
                  }
          
        
            let etiquetaFecha=new Array();
            let dataVigentes =new Array();
            let dataVencidos =new Array();
            let dataSinGarantia =new Array();
            var jDatos = JSON.parse(datos);

            

            for(let i in jDatos ){
                etiquetaFecha.push(jDatos[i].Fecha);
                dataVigentes.push(jDatos[i].Vigentes);
                dataVencidos.push(jDatos[i].Vencidos);
                // dataSinGarantia.push(jDatos[i].SinGarantia);
            }

            let dataGraph = {
                
                labels: etiquetaFecha,
                datasets: [{
                  type: 'bar',
                  label: 'Dispositivos Vigentes con Garantía',
                  backgroundColor: colors[0],
                  borderColor: colors[0],
                  // backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                  // borderColor: Utils.CHART_COLORS.red,
                  data: dataVigentes,
                }, {
                  type: 'bar',
                  label: 'Dispositivos Vencidos sin Garantía',
                  backgroundColor: colors[1],
                  borderColor: colors[1],
                  data:dataVencidos,
                }, 
                // {
                //   type: 'line',
                //   label: 'Dispositivos No Garantizados',
                //   backgroundColor: colors[2],
                //   borderColor: colors[2],
                //   fill: false,
                //   data: dataSinGarantia,
                // }
                ]
              };

            var ctx= document.getElementById("lineBar").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data:dataGraph,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                                    },
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                    },
                },
            });
        });
    }

    /**
    * Asignar  datos a la Grafica de Dispersion
    */
    this.getScatterData= function(){
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"6"
            }
        }).done(function(datos){
            var tonalidadesVerde = ['#1A3E1F','#145A2A','#0B7433','#008000','#208E37','#49A54A','#80C080'];
            var tonalidadesAzul = ['#112135','#132C48','#11385D','#003F6D','#1A527C','#4E7A99','#819FB5'];
            var escalaGrises = ['#191919','#232323','#2d2d2d','#323232','#474747','#707070','#99999'];
            var colors = [];
            for (var i = 0; i < tonalidadesAzul.length; i++) {
                        colors.push(tonalidadesVerde[i]);
                        colors.push(tonalidadesAzul[i]);
                        colors.push(escalaGrises[i]);
                  }
          
        
            let etiquetasScatter=new Array();
            let dataScatter =new Array();
            var jDatos = JSON.parse(datos);


            for(let i in jDatos ){
                etiquetasScatter.push(jDatos[i].Gerencia);
                dataScatter.push(jDatos[i].CantidadRegistrosXGerencia);
            }
            

            let data = {
                
                datasets: etiquetasScatter.map((gerencia, index) => {
                  return {
                    label: `${gerencia}`,
                    message:`${dataScatter[index]} Dispositivo(s) en "${gerencia}"`,
                    data: [{
                      x: index, // Coordenada X para la posición del punto (puedes usar index o cualquier otra cosa dependiendo de tus necesidades)
                      y: dataScatter[index], // Coordenada Y para la posición del punto basado en la cantidad de datos
                      r: (dataScatter[index]) / 2, // Calcular el tamaño del círculo basado en la cantidad de datos
                    }], // Usar la cantidad de datos correspondiente a cada área como valor
                    borderColor: colors[index % colors.length], // Usar un color del arreglo de colores para cada área
                    backgroundColor: colors[index % colors.length], // Usar el mismo color como fondo para cada área
                  };
                }),
              };

            var ctx= document.getElementById("scatterChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'bubble', 
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                      legend: {
                        position: 'right',
                      },
                      tooltip: {
                        callbacks: {
                          label: function (context) {
                            const label = context.dataset.message || '';
                            if (context.parsed.y !== null) {
                              return `${label} `;
                            }
                            return label;
                          },
                        },
                      },
                    },
                  },
            });
            
        })
        
    }

     /**
    * Asignar  datos a la Grafica de Pastel
    */
    this.getPieData= function(){
       
      
     
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/ajaxservice.php', 
            method:'POST',
            data:{
                rq:"7"
            }
        }).done(function(datos){
            if(datos != ''){
                var tonalidadesVerde = ['#1A3E1F','#145A2A','#0B7433','#008000','#208E37','#49A54A','#80C080'];
                var tonalidadesAzul = ['#112135','#132C48','#11385D','#003F6D','#1A527C','#4E7A99','#819FB5'];
                var escalaGrises = ['#191919','#232323','#2d2d2d','#323232','#474747','#707070','#99999'];
                var colors = [];
                for (var i = 0; i < tonalidadesAzul.length; i++) {
                            colors.push(tonalidadesVerde[i]);
                            colors.push(tonalidadesAzul[i]);
                            colors.push(escalaGrises[i]);
                      }
              
            
                let etiquetas=new Array();
                let dataPie =new Array();
                var jDatos = JSON.parse(datos);

                for(let i in jDatos ){
                    etiquetas.push(jDatos[i].TipoGarantia);
                    dataPie.push(jDatos[i].CantidadRegistrosTG);
                }
                

                var ctx= document.getElementById('pieChart').getContext('2d');   
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: etiquetas,
                        datasets: [{
                            label: 'Cantidad de Dispositivos',
                            data: dataPie,
                            backgroundColor: colors,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'right', // Colocar la leyenda a la derecha
                                labels: {
                                    boxWidth: 20, // Ancho de la caja de la leyenda
                                    padding: 15, // Espaciado entre las etiquetas de la leyenda
                                }
                            }
                        }
                    }
                });
            }
            
        });

    }
}

var oIndex = new index();
setTimeout(function(){oIndex.ini(); },100);