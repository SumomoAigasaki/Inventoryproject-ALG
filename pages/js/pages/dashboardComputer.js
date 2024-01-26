function index(){
    this.ini = function(){
        //Extraccion de datos  para las cards
            this.dataModalRecNew();
            this.dataModalRAMS();
            this.dataModalCPU();
            this.dataModalDISK();
        //Extraccion de datos  para las Graficas de Barra y Modals
            this.dataBarGraph();
            this.dataModalBarGraph();
        //Extraccion de datos  para las Graficas de Escritorio de Pastel y Modals
            this.dataPieGraphDesktop();
            this.dataModalPieGraphDesktop();
        //Extraccion de datos  para las Graficas de Laptos de Pastel y Modals
            this.dataPieGraphLaptos();
            this.dataModalPieGraphLaptops();
        //Extraccion de datos  para las Graficas de Dispersion y Modals
            this.dataScatterPlot();
            this.dataModalScatterPlot();
     
  
      
      }
  
      // Extraccion de datos  para las cards
        // Extraer datos para las consultas de los card Cards par Registros Nuevos  Datos para la tabla modal      
            this.dataModalRecNew = function() 
            {
            $.ajax({
                statusCode: {
                    404: function() {
                        console.log("Esta pagina no existe");
                    }
                },
                url: '../controllers/dashboardComputerService.php',
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
                        //   console.log("JS RQ 1");
                        //   console.log(registros);
                        for (var i in registros) {
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].marcaModelo + '</td><td>' + registros[i].tipoGarantía + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');
                        }      
                    }  
                    $("#rNuevos").text(parseFloat(totalRegistros).toLocaleString());
                    $("#mNuevos").text(parseFloat(totalRegistros).toLocaleString());          
                });
            } 
            
        // Extraer datos para las consultas de los Card de RAMS      
            this.dataModalRAMS = function() 
            {
            $.ajax({
                statusCode: {
                    404: function() {
                        console.log("Esta pagina no existe");
                    }
                },
                url: '../controllers/dashboardComputerService.php',
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
                        var table = $('#modal-xl-Rams').find('.table tbody');
                        console.log("JS RQ 2");
                        console.log(registros);
                        for (var i in registros) {
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].marcaModelo + '</td><td>' + registros[i].tipoGarantía + '</td><td>' + registros[i].localizacion + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');
                        }      
                    } 
                    //Asigno lo datos del conteo 
                    //1 a la card  
                    $("#cRams").text(parseFloat(totalRegistros).toLocaleString());
                    //el espacio que hay dentro del  modal
                    $("#mRams").text(parseFloat(totalRegistros).toLocaleString());       
                });
            } 
  
        // *Extraer datos para las consultas de los CPU      
            this.dataModalCPU = function() {
                $.ajax({
                    statusCode: {
                        404: function() {
                            console.log("Esta pagina no existe");
                        }
                    },
                    url: '../controllers/dashboardComputerService.php',
                    method: 'POST',
                    data: {
                        rq: "3"
                    }
                }).done(function(datos){
                        if(datos != ''){
                            const parsedData = JSON.parse(datos);
        
                    
                            var registros =parsedData.data; // Array de objetos con los datos
                            var totalRegistros = parsedData.total_registros; // Total de registros
        
                            var table = $('#modal-xl-CPU').find('.table tbody');
                            //   console.log("JS RQ 3");
                            //   console.log(registros);
                            for (var i in registros) {
                                table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].marcaModelo + '</td><td>' + registros[i].tipoGarantía + '</td><td>' + registros[i].localizacion + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');    
                            }
        
                        }
                        //Asigno lo datos del conteo 
                    //1 a la card  
                    $("#cCpu").text(parseFloat(totalRegistros).toLocaleString());
                    //el espacio que hay dentro del  modal
                    $("#mCpu").text(parseFloat(totalRegistros).toLocaleString()); 
                        
                    });
                
            };
  
        //  Extraer datos para los Discos
            this.dataModalDISK= function() {
                $.ajax({
                    statusCode: {
                        404: function() {
                            console.log("Esta pagina no existe");
                        }
                    },
                    url: '../controllers/dashboardComputerService.php',
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
                            var table = $('#modal-xl-Disk').find('.table tbody');
                            //   console.log("JS RQ 4");
                            //   console.log(registros);
                            for (var i in registros) {
                                var estadoIcon = '';
        
                                // Agrega la validación del estado aquí
                                if (registros[i].estado == 2) {
                                    estadoIcon='<i class="fas fa-exclamation-triangle" style="color: #74C0FC;" title="Estado actual: Activo"></i>';
                                    
                                } else if (registros[i].estado == 9) {
                                    estadoIcon = '<i class="fas fa-check-circle" style="color: #63E6BE;" title="Estado actual: En Circulación"></i>';
                                    // estadoIcon = '<i class="fas fa-redo-alt" style="color: #FFD43B;"></i>' ;
                                }
                                
                                table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaExpiracion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].marcaModelo + '</td><td>' + registros[i].tipoGarantía + '</td><td>' + registros[i].localizacion + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');    
                            }
        
                        }
                        //Asigno lo datos del conteo 
                    //1 a la card  
                    $("#rDisco").text(parseFloat(totalRegistros).toLocaleString());
                    //el espacio que hay dentro del  modal
                    $("#mDisk").text(parseFloat(totalRegistros).toLocaleString()); 
                        
                    });
                
            };
  
       //Extraccion de datos  para las Graficas
        function obtenerYearSeleccionado() {
            var yearSeleccionado = localStorage.getItem('yearSeleccionado');
            return yearSeleccionado;
        }
  
    //Graficos
      //Grafica de Barra
        //Informacion Grafica de Barra
        this.dataBarGraph= function(){
            var yearSeleccionado = obtenerYearSeleccionado();
            
            $.ajax({
                statusCode:{
                    404:function(){
                        console.log("Esta pagina no existe");
                    }
                },
                url:'../controllers/dashboardComputerService.php', 
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
                let dataLaptos =new Array();
                let dataDesktop =new Array();
                let dataTotal =new Array();
                var jDatos = JSON.parse(datos);

    
                //    console.log("JS RQ 5");
                //    console.log(jDatos);
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
                        dataLaptos.push(jDatos[i].Laptops);
                        dataDesktop.push(jDatos[i].Escritorios);
                        dataTotal.push(jDatos[i].Total);
                        // dataSinGarantia.push(jDatos[i].SinGarantia);
                    }
    
                    let dataGraph = {
                        
                        labels: etiquetaFecha,
                        datasets: [{
                        type: 'bar',
                        label: 'Dispositivos Laptops',
                        backgroundColor: colors[0],
                        borderColor: colors[0],
                        // backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                        // borderColor: Utils.CHART_COLORS.red,
                        data: dataLaptos,
                        }, {
                        type: 'bar',
                        label: 'Dispositivos Escritorio ',
                        backgroundColor: colors[1],
                        borderColor: colors[1],
                        data: dataDesktop,
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
                                    text: `Resumen Mensual : Dispositivos Laptos y Escritorios, Año-"${yearSeleccionado}"`,
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
        
        //Informacion para el Modal deGrafica de Barra
        this.dataModalBarGraph= function() {
            var yearSeleccionado = obtenerYearSeleccionado();
    
            $.ajax({
                statusCode: {
                    404: function() {
                        console.log("Esta pagina no existe");
                    }
                },
                url: '../controllers/dashboardComputerService.php',
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
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fecha + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].tipoEquipo + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].servitag + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].sTS_Description + '</td><td>' + registros[i].user_Username + '</td></tr>');
                    }
                    $("#dataCountLinel").text(parseFloat(totalRegistros).toLocaleString());
                    }
                });          
        };
      
      //Grafica de Pastel Escritorio
  
        // Informacion Grafica de Pastel Desktop
        this.dataPieGraphDesktop= function(){
            var yearSeleccionado = obtenerYearSeleccionado();

            $.ajax({
                statusCode:{
                    404:function(){
                        console.log("Esta pagina no existe");
                    }
                },
                url:'../controllers/dashboardComputerService.php', 
                method:'POST',
                data:{
                    rq:"7",
                    sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
                }
            }).done(function(datos){
                if(datos != ''){
                    // console.log("JS RQ 7");
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
                        etiquetas.push(jDatos[i].Marca);
                        dataPie.push(jDatos[i].CantidadRegistrosMFC);
                    }
                    

                    var ctx= document.getElementById('pieChartDesktop').getContext('2d');   
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
                                    text: `Distribución de Registros de Marcas en Equipos de Escritorio, Año-"${yearSeleccionado}"`,
                                },
                            }
                        }
                    });
                }            
            });
        }

        // Informacion Modal la Grafica de Pastel Desktop
        this.dataModalPieGraphDesktop = function() {
            var yearSeleccionado = obtenerYearSeleccionado();

            $.ajax({
                statusCode: {
                    404: function() {
                        console.log("Esta pagina no existe");
                    }
                },
                url: '../controllers/dashboardComputerService.php',
                method: 'POST',
                data: {
                    rq: "8",
                    sp_year: yearSeleccionado 
                }
            }).done(function(datos){
                    if(datos != ''){
                        const parsedData = JSON.parse(datos);
                        // console.log("JS RQ 8");
                        // console.log(datos);
                        var registros =parsedData.data; // Array de objetos con los datos
                        var totalRegistros = parsedData.total_registros; // Total de registros                    
                        
                        var table = $('#modal-xl-PastelEscritorio').find('.table tbody');

                        for (var i in registros) {
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');   }
                    }
                    $("#dataCountPie").text(parseFloat(totalRegistros).toLocaleString());
                    
                });
            
        };

     //Grafica de Pastel Laptops
  
        // Informacion Grafica de Pastel Laptops
        this.dataPieGraphLaptos= function(){
            var yearSeleccionado = obtenerYearSeleccionado();

            $.ajax({
                statusCode:{
                    404:function(){
                        console.log("Esta pagina no existe");
                    }
                },
                url:'../controllers/dashboardComputerService.php', 
                method:'POST',
                data:{
                    rq:"9",
                    sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
                }
            }).done(function(datos){
                if(datos != ''){
                    // console.log("JS RQ 7");
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
                        etiquetas.push(jDatos[i].Marca);
                        dataPie.push(jDatos[i].CantidadRegistrosMFC);
                    }
                    

                    var ctx= document.getElementById('pieChartLaptop').getContext('2d');   
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
                                    text: `Distribución de Registros de Marcas en Equipos de Laptops, Año-"${yearSeleccionado}"`,
                                },
                            }
                        }
                    });
                }            
            });
        }

        // Informacion Modal la Grafica de Pastel Laptops
        this.dataModalPieGraphLaptops = function() {
            var yearSeleccionado = obtenerYearSeleccionado();

            $.ajax({
                statusCode: {
                    404: function() {
                        console.log("Esta pagina no existe");
                    }
                },
                url: '../controllers/dashboardComputerService.php',
                method: 'POST',
                data: {
                    rq: "10",
                    sp_year: yearSeleccionado 
                }
            }).done(function(datos){
                    if(datos != ''){
                        //  console.log("JS RQ 10");
                        //  console.log(datos);
                        const parsedData = JSON.parse(datos);
                    
                        var registros =parsedData.data; // Array de objetos con los datos
                        var totalRegistros = parsedData.total_registros; // Total de registros                    
                        
                        var table = $('#modal-xl-PastelLaptop').find('.table tbody');

                        for (var i in registros) {
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');   }
                    }
                    $("#dataCountPieLaptos").text(parseFloat(totalRegistros).toLocaleString());
                    
                });
            
        };
    //Grafica de Dispersion
  
        // Informacion Grafica de Dispersion
            this.dataScatterPlot = function () {
                var yearSeleccionado = obtenerYearSeleccionado();
            
                $.ajax({
                    statusCode: {
                        404: function () {
                            console.log("Esta pagina no existe");
                        }
                    },
                    url: '../controllers/dashboardComputerService.php',
                    method: 'POST',
                    data: {
                        rq: "11",
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
                        var ctx = document.getElementById("scatterChartLocation").getContext("2d");
        
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
                            etiquetasScatter.push(jDatos[i].Localizacion);
                            dataScatter.push(jDatos[i].CantidadRegistrosLCT);
                        }
        
                        let data = {
                            datasets: etiquetasScatter.map((localizacion, index) => {
                                return {
                                    label: `${localizacion}`,
                                    message: `${dataScatter[index]} Dispositivo(s) Localizados en: "${localizacion}"`,
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
        
                        var ctx = document.getElementById("scatterChartLocation").getContext("2d");
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
                                        text: `Cantidad de Computadoras por Localizacion, Año-"${yearSeleccionado}"`,
                                    },
                                },
                            
                            },
                        });
                    }    
                            
            
                }).fail(function () {
                    document.getElementById("scatterChart").innerHTML = "Error al obtener datos del servidor";
                });
        
            }
            
        // Informacion Modal la Grafica de Dispersion
            this.dataModalScatterPlot = function() {
                var yearSeleccionado = obtenerYearSeleccionado();
        
                $.ajax({
                    statusCode: {
                        404: function() {
                            console.log("Esta pagina no existe");
                        }
                    },
                    url: '../controllers/dashboardComputerService.php',
                    method: 'POST',
                    data: {
                        rq: "12",
                        sp_year: yearSeleccionado // Enviar el año seleccionado o null al servidor
                    }
                }).done(function(datos) {
                    const parsedData = JSON.parse(datos);
                
                    if (parsedData.data && parsedData.data.length > 0) {
                        var registros = parsedData.data; // Array de objetos con los datos
                        var totalRegistros = parsedData.total_registros; // Total de registros
                
                        var table = $('#modal-xl-ScatterLocation').find('.table tbody');
                        table.empty(); // Limpia el cuerpo de la tabla
                        //   console.log("JS RQ 11");
                        //   console.log(registros);
                        for (var i in registros) {
                            table.append('<tr><td>' + registros[i].idComputer + '</td><td>' + registros[i].fechaAdquisicion + '</td><td>' + registros[i].nombreTecnico + '</td><td>' + registros[i].tipoEquipo + '</td><td>' + registros[i].Localizacion + '</td><td>' + registros[i].modelo + '</td><td>' + registros[i].especificaciones + '</td><td>' + registros[i].estado + '</td><td>' + registros[i].usuario + '</td></tr>');   
                        }
                        $("#dataCountScatter").text(parseFloat(totalRegistros).toLocaleString());
                    } else {
                        // No hay datos, agregar mensaje a la tabla
                        var table = $('#modal-xl-ScatterLocation').find('.table tbody');
                        table.empty(); // Limpia el cuerpo de la tabla
                        
                        // Agregar una fila con una celda que contiene el mensaje centrado
                        table.append('<tr><td colspan="6" style="text-align: center;">Lo sentimos, no se encontraron registros para el año seleccionado</td></tr>');
                        $("#dataCountScatter").text("0");
                    }
                });
            };
  
  
      
  
  };
  
  var oIndex = new index();
  setTimeout(function(){oIndex.ini(); },100);
  
  