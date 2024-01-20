function index(){
  this.ini = function(){
    //   console.log("Inicio  Dashbord js...");
       //Extraccion de datos  para las cards
      this.dataModalRecNew();
      this.dataModalCovUnAsign();
      this.dataModalRecNonCov();
      this.dataModalRecSoonExpired();
       //Extraccion de datos  para las Graficas de Barra y Modals
      this.dataBarGraph();
      this.dataModalBarGraph();
      //Extraccion de datos  para las Graficas de Dispersion y Modals
      this.dataScatterPlot();
      this.dataModalScatterPlot();
    //Extraccion de datos  para las Graficas de Pastel y Modals
      this.dataPieGraph();
      this.dataModalPieGraph();

    
    }

    //Extraccion de datos  para las cards
    /**
   * Extraer datos para las consultas de los card Cards par Registros Nuevos
    Datos para la tabla modal
    */
   
    this.dataModalRecNew = function() 
   {
    $.ajax({
        statusCode: {
            404: function() {
                console.log("Esta pagina no existe");
            }
        },
        url: '../controllers/dashWaService.php',
        method: 'POST',
        data: {
            rq: "1"
        }
    }).done(function(datos){
            if(datos != ''){
                const parsedData = JSON.parse(datos);

            
                var registros =parsedData.data; // Array de objetos con los datos
                var totalRegistros = parsedData.total_registros; // Total de registros
               
                // var registros = JSON.parse(datos);
                var table = $('#modal-xl-newRegister').find('.table tbody');
                // console.log("JS RQ 1");
                // console.log(registros);
                for (var i in registros) {
                    table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].manofacturacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].tipoGarantía + '</td></tr>');
                }      
            }  
            $("#rNuevos").text(parseFloat(totalRegistros).toLocaleString());
            $("#mNuevos").text(parseFloat(totalRegistros).toLocaleString());          
        });
    } 
    
     /**
     * Extraer datos para las consultas de los Card de Registros con Covertura sin Asignar 
     * 1- Datos para la tabla modal
    */
    
     this.dataModalCovUnAsign = function() 
   {
    $.ajax({
        statusCode: {
            404: function() {
                console.log("Esta pagina no existe");
            }
        },
        url: '../controllers/dashWaService.php',
        method: 'POST',
        data: {
            rq: "2"
        }
    }).done(function(datos){
            if(datos != ''){
                const parsedData = JSON.parse(datos);

            
                var registros =parsedData.data; // Array de objetos con los datos
                var totalRegistros = parsedData.total_registros; // Total de registros
               
                // var registros = JSON.parse(datos);
                var table = $('#modal-xl-Coverage').find('.table tbody');
                // console.log("JS RQ 2");
                // console.log(registros);
                for (var i in registros) {
                    table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].manofacturacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].tipoGarantía + '</td></tr>');    
                }      
            } 
            //Asigno lo datos del conteo 
            //1 a la card  
            $("#rCoverage").text(parseFloat(totalRegistros).toLocaleString());
            //el espacio que hay dentro del  modal
            $("#mCoverage").text(parseFloat(totalRegistros).toLocaleString());       
        });
    } 

    /**
     * Extraer datos para las consultas de los Card de Registros sin Cobertura (En uso o Asignado)
     * 1- Datos para la tabla modal
    */
    
    this.dataModalRecNonCov = function() {
        $.ajax({
            statusCode: {
                404: function() {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "3"
            }
        }).done(function(datos){
                if(datos != ''){
                    const parsedData = JSON.parse(datos);

            
                    var registros =parsedData.data; // Array de objetos con los datos
                    var totalRegistros = parsedData.total_registros; // Total de registros

                    var table = $('#modal-xl-Uncovered').find('.table tbody');
                    // console.log("JS RQ 3");
                    // console.log(registros);
                    for (var i in registros) {
                        table.append('<tr><td>' + registros[i].idAsignacionPc + '</td><td>' + registros[i].fechaAsignacion + '</td><td>' + registros[i].fechaDevolucion + '</td><td>' + registros[i].nombreColaborador + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].fechaExpiracion + '</td></tr>');
                    }

                }
                 //Asigno lo datos del conteo 
            //1 a la card  
            $("#rNonCoverage").text(parseFloat(totalRegistros).toLocaleString());
            //el espacio que hay dentro del  modal
            $("#mNonCoverage").text(parseFloat(totalRegistros).toLocaleString()); 
                
            });
        
    };

     /**
     * Extraer datos para las consultas de los Card de Asignar  datos al modal de Registros prox. Vencer Activos y Circulando
     * 1- Datos para la tabla modal
    */
    
    this.dataModalRecSoonExpired = function() {
        $.ajax({
            statusCode: {
                404: function() {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "4"
            }
        }).done(function(datos){
                if(datos != ''){
                    const parsedData = JSON.parse(datos);

            
                    var registros =parsedData.data; // Array de objetos con los datos
                    var totalRegistros = parsedData.total_registros; // Total de registros

                    // var registros = JSON.parse(datos);
                    var table = $('#modal-xl-Expired').find('.table tbody');
                    console.log("JS RQ 4");
                    console.log(registros);
                    for (var i in registros) {
                        var estadoIcon = '';

                        // Agrega la validación del estado aquí
                        if (registros[i].estado == 2) {
                            estadoIcon='<i class="fas fa-exclamation-triangle" style="color: #74C0FC;" title="Estado actual: Activo"></i>';
                            
                        } else if (registros[i].estado == 9) {
                            estadoIcon = '<i class="fas fa-check-circle" style="color: #63E6BE;" title="Estado actual: En Circulación"></i>';
                            // estadoIcon = '<i class="fas fa-redo-alt" style="color: #FFD43B;"></i>' ;
                        }
                        
                        table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + estadoIcon + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].manofacturacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].tipoGarantía + '</td></tr>');
                     }

                }
                 //Asigno lo datos del conteo 
            //1 a la card  
            $("#rUpcoming").text(parseFloat(totalRegistros).toLocaleString());
            //el espacio que hay dentro del  modal
            $("#mUpcoming").text(parseFloat(totalRegistros).toLocaleString()); 
                
            });
        
    };

     //Extraccion de datos  para las Graficas
     function obtenerYearSeleccionado() {
        var yearSeleccionado = localStorage.getItem('yearSeleccionado');
        return yearSeleccionado;
    }

        /**
        * Grafica de Barra
        */
   
    this.dataBarGraph= function(){
        var yearSeleccionado = obtenerYearSeleccionado();
        
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/dashWaService.php', 
            method:'POST',
            data:{
                rq:"5",
                sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
                
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

            //  console.log("JS RQ 5");
            if (jDatos.length === 0) {
                var ctx = document.getElementById("scatterChart").getContext("2d");

                var myChart = new Chart(ctx, {
                    options: {
                        responsive: true,
                     
                    },
                });
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                var noDataText = "Lo sentimos, no se encontraron registros para el año seleccionado";
                ctx.textAlign = 'center';
                ctx.fillText(noDataText, ctx.canvas.width / 2, ctx.canvas.height / 2);

              
                return; // Detener la ejecución ya que no hay datos
            }
            else{
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
                    label: 'Dispositivos con Garantía Activa',
                    backgroundColor: colors[0],
                    borderColor: colors[0],
                    // backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                    // borderColor: Utils.CHART_COLORS.red,
                    data: dataVigentes,
                    }, {
                    type: 'bar',
                    label: 'Dispositivos con Garantía Próxima a Vencer ',
                    backgroundColor: colors[1],
                    borderColor: colors[1],
                    data:dataVencidos,
                    }
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
                                
                            },
                            title: {
                                display: true,
                                text: `Resumen Mensual : Dispositivos con Garantía Activa y Próxima a Vencer, Año-"${yearSeleccionado}"`,
                            },
                        },
                    },
                });
             }
        });

         // Mostrar los datos antes de enviar la solicitud AJAX
        //  console.log("Datos a enviar en RQ-5:");
        //  console.log({
        //      rq: "5",
        //      sp_year: yearSeleccionado // yearSeleccionado es una variable que contiene el año seleccionado
        //  });
    }

    this.dataModalBarGraph= function() {
        var yearSeleccionado = obtenerYearSeleccionado();

        $.ajax({
            statusCode: {
                404: function() {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "6",
                sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
            }
        }).done(function(datos){
                if(datos != ''){
                    const parsedData = JSON.parse(datos);

                    // console.log("JS RQ 6");
                   //  console.log(parsedData);
                    
                    var registros =parsedData.data; // Array de objetos con los datos
                    var totalRegistros = parsedData.total_registros; // Total de registros
                    // console.log('registros:',registros);
                    // console.log('total :',totalRegistros);

                    // var jDatos = JSON.parse(datos);
                    var table = $('#modal-xl-LineBar').find('.table tbody');
                    // Limpia el cuerpo de la tabla
                    // $('.table tbody').empty();
                    // console.log("tabla LineBar");
                    // console.log(jDatos);
                    for (var i in registros) {
                        table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].manofacturacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].tipoGarantía + '</td></tr>');
                }
                $("#dataCountLinel").text(parseFloat(totalRegistros).toLocaleString());
                }
            });

            // Mostrar los datos antes de enviar la solicitud AJAX
            // console.log("Datos a enviar en RQ-6:");
            // console.log({
            //     rq: "6",
            //     sp_year: yearSeleccionado // yearSeleccionado es una variable que contiene el año seleccionado
            // });
        
    };
    

     /**
        * Grafica de Dispersion
        */

     this.dataScatterPlot = function () {
        var yearSeleccionado = obtenerYearSeleccionado();
    
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "7",
                sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
            }
        }).done(function (datos) {
            var tonalidadesVerde = ['#1A3E1F', '#145A2A', '#0B7433', '#008000', '#208E37', '#49A54A', '#80C080'];
            var tonalidadesAzul = ['#112135', '#132C48', '#11385D', '#003F6D', '#1A527C', '#4E7A99', '#819FB5'];
            var escalaGrises = ['#191919', '#232323', '#2d2d2d', '#323232', '#474747', '#707070', '#99999'];
            var colors = [];
            for (var i = 0; i < tonalidadesAzul.length; i++) {
                colors.push(tonalidadesVerde[i]);
                colors.push(tonalidadesAzul[i]);
                colors.push(escalaGrises[i]);
            }
    
            let etiquetasScatter = new Array();
            let dataScatter = new Array();
            var jDatos = JSON.parse(datos);
            
            if (jDatos.length === 0) {
                var ctx = document.getElementById("scatterChart").getContext("2d");

                var myChart = new Chart(ctx, {
                    options: {
                        responsive: true,
                     
                    },
                });
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                var noDataText = "Lo sentimos, no se encontraron registros para el año seleccionado";
                ctx.textAlign = 'center';
                ctx.fillText(noDataText, ctx.canvas.width / 2, ctx.canvas.height / 2);

              
                return; // Detener la ejecución ya que no hay datos
            }
            else{
                for (let i in jDatos) {
                    etiquetasScatter.push(jDatos[i].Gerencia);
                    dataScatter.push(jDatos[i].CantidadRegistrosXGerencia);
                }

                let data = {
                    datasets: etiquetasScatter.map((gerencia, index) => {
                        return {
                            label: `${gerencia}`,
                            message: `${dataScatter[index]} Dispositivo(s) en "${gerencia}"`,
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

                var ctx = document.getElementById("scatterChart").getContext("2d");
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
                            title: {
                                display: true,
                                text: `Cantidad de Computadoras ubicadas por Gerencia, Año-"${yearSeleccionado}"`,
                            },
                        },
                    
                    },
                });
            }    
                    
    
        }).fail(function () {
            document.getElementById("scatterChart").innerHTML = "Error al obtener datos del servidor";
        });

        //  // Mostrar los datos antes de enviar la solicitud AJAX
        //  console.log("Datos a enviar en RQ-7:");
        //  console.log({
        //      rq: "7",
        //      sp_year: yearSeleccionado // yearSeleccionado es una variable que contiene el año seleccionado
        //  });
    }
        
        
    

     /**
    * Modal de Tabla de la Grafica de Dispersion
    */

     this.dataModalScatterPlot = function() {
        var yearSeleccionado = obtenerYearSeleccionado();

        $.ajax({
            statusCode: {
                404: function() {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "8",
                sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
            }
        }).done(function(datos) {
            const parsedData = JSON.parse(datos);
        
            if (parsedData.data && parsedData.data.length > 0) {
                var registros = parsedData.data; // Array de objetos con los datos
                var totalRegistros = parsedData.total_registros; // Total de registros
        
                var table = $('#modal-xl-Scatter').find('.table tbody');
                table.empty(); // Limpia el cuerpo de la tabla
        
                for (var i in registros) {
                    table.append('<tr><td>' + registros[i].idPCAsigment + '</td><td>' + registros[i].fechaAsignacion + '</td><td>' + registros[i].Gerencia + '</td><td>' + registros[i].Area + '</td><td>' + registros[i].NombreColaborador + '</td><td>' + registros[i].nombreTecnico + '</td></tr>');
                }
                $("#dataCountScatter").text(parseFloat(totalRegistros).toLocaleString());
            } else {
                // No hay datos, agregar mensaje a la tabla
                var table = $('#modal-xl-Scatter').find('.table tbody');
                table.empty(); // Limpia el cuerpo de la tabla
                
                // Agregar una fila con una celda que contiene el mensaje centrado
                table.append('<tr><td colspan="6" style="text-align: center;">Lo sentimos, no se encontraron registros para el año seleccionado</td></tr>');
                $("#dataCountScatter").text("0");
            }
        });
         // Mostrar los datos antes de enviar la solicitud AJAX
        //  console.log("Datos a enviar en RQ-7:");
        //  console.log({
        //      rq: "7",
        //      sp_year: yearSeleccionado // yearSeleccionado es una variable que contiene el año seleccionado
        //  });
        
    };

    /**
    * Grafica de Pastel
    */
     this.dataPieGraph= function(){
        var yearSeleccionado = obtenerYearSeleccionado();

        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta pagina no existe");
                }
            },
            url:'../controllers/dashWaService.php', 
            method:'POST',
            data:{
                rq:"9",
                sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
            }
        }).done(function(datos){
            if(datos != ''){
                // console.log("JS RQ 9");
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
                            
                            data: dataPie,
                            label: 'Cantidad de Dispositivos',
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
                            },
                            title: {
                                display: true,
                                text: `Distribución de Registros por Tipo de Garantía, Año-"${yearSeleccionado}"`,
                            },
                        }
                    }
                });
            }            
        });
         // Mostrar los datos antes de enviar la solicitud AJAX
        //  console.log("Datos a enviar en RQ-9:");
        //  console.log({
        //      rq: "9",
        //      sp_year: yearSeleccionado // yearSeleccionado es una variable que contiene el año seleccionado
        //  });
    }

    /**
    * Asignar  datos al modal de tabla/Reporte de la Grafica Pastel
    */
    this.dataModalPieGraph = function() {
        var yearSeleccionado = obtenerYearSeleccionado();

        $.ajax({
            statusCode: {
                404: function() {
                    console.log("Esta pagina no existe");
                }
            },
            url: '../controllers/dashWaService.php',
            method: 'POST',
            data: {
                rq: "10",
                sp_year: yearSeleccionado 
            }
        }).done(function(datos){
                if(datos != ''){
                    const parsedData = JSON.parse(datos);
                  
                    var registros =parsedData.data; // Array de objetos con los datos
                    var totalRegistros = parsedData.total_registros; // Total de registros                    
                    
                    var table = $('#modal-xl-Pastel').find('.table tbody');

                    for (var i in registros) {
                        table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].tipoGarantia + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].servitag + '</td><td>' + registros[i].licensia + '</td><td>' + registros[i].manofacturacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].fechaExpiracion + '</td></tr>');   }
                }
                $("#dataCountPie").text(parseFloat(totalRegistros).toLocaleString());
                
            });
        
    };
    

};

var oIndex = new index();
setTimeout(function(){oIndex.ini(); },100);

