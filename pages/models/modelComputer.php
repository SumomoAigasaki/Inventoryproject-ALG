<?php 
 include "../../includes/conecta.php";
 include "../../includes/constantes.php"; 
 
 class Computer {
     // Función para validar los datos ingresados en el formulario
     public function validate_data($data) {
         //Lógica de validación
         
         $errors = array();
        // Validación de la fecha de compra
        if (isset($data['acquisitionDate']) && empty($data['acquisitionDate'])) {
            
            $errors[] = 'La Fecha esta vacia, por favor ingrese Fecha valido.';
        }

        // Validación del ID de marca
        if (isset($data['select_manufacturer']) && empty($data['select_manufacturer'])) {
            $errors[] = 'El Modelo esta vacio, por favor seleccione un Modelo valido.';
        }

        // Validación del ID de modelo
        if (isset($data['select_model']) && empty($data['select_model'])) {
            $errors[] = 'El Modelo esta vacio, por favor seleccione un Modelo valido.';
        }

         // Validación del ID tipo de computadora
         if (isset($data['select_computerType']) && empty($data['select_computerType'])) {
               $errors[] = 'El tipo de computadora esta vacio, por favor Seleccione un tipo de computadora valido.';
           }
   

        // Validación del nombre técnico
        if (isset($data['txt_nombre']) && empty($data['txt_nombre'])) {
            $errors[] = 'El nombre técnico esta vacio, por favor ingrese un nombre valido.';
            // el campo está vacío, mostrar un mensaje de error o hacer algo al respecto
        }

        // Validación del serial
        if (isset($data['txt_servitag']) && empty($data['txt_servitag'])) {
            $errors[] = 'El servitag esta vacio, por favor ingrese un servitag valido.';
        }

        // Validación del serial
        if (isset($data['warrantyExpiration']) && empty($data['warrantyExpiration'])) {
            $errors[] = 'La Fecha Límite Garantía esta vacio, por favor ingrese una Fecha Límite Garantía valida.';
        }
            //validaremos que la fecha ingreso no sea la actual
            $warrantyExpiration = ($data['warrantyExpiration']); // asumiendo que el valor viene por POST

            // Convertir la fecha ingresada a timestamp
            $warrantyExpirationTimestamp = strtotime($warrantyExpiration);

            // Obtener la fecha actual como timestamp
            $currentTimestamp = time();

            // Verificar si la fecha de expiración de garantía es menor o igual a la fecha actual
            if ($warrantyExpirationTimestamp <= $currentTimestamp) {
                $errors[] = 'La Fecha Límite Garantía debe ser posterior a la fecha actual.';
            }

        if (isset($data['yearExpiration']) && empty($data['yearExpiration'])) {
            $errors[] = 'El Año Limite Garantía esta vacio, por favor ingrese un Año Límite Garantía valida.';
        }

        
        // Validación de la licencia
        if (isset($data['txt_licencia']) && empty($data['txt_licencia'])) {
            $errors[] = 'La licencia esta vacio, por favor ingrese una licencia valida.';
        }

        // Validación de la status
        if (isset($data['select_statu']) && empty($data['select_statu'])) {
            $errors[] = 'El Estado del Computador esta vacio, por favor ingrese un Estado del Computador valido.';
        }
        // Validación de la location
        if (isset($data['select_location']) && empty($data['select_location'])) {
            $errors[] = 'La Localizacion del Computador esta vacio, por favor ingrese una Localizacion del Computador valido.';
        }
        
        
        // Convertir el array de errores en una cadena separada por comas
        //$error_message = implode(", ", $errors);

        // Comprobar si hay errores y mostrar la alerta de Toastr
        //if (!empty($error_message)) {
        //    echo '<script src="../../public/js/toastr.min.js">
       //     $(function() {
                // Agrega un controlador de eventos click a cualquier elemento con la clase "toastrDefaultWarning"
       //         $(".toastrDefaultWarning").click(function() {
                  // Utiliza la función warning de Toastr para mostrar una notificación de advertencia
        //          toastr.warning('. $error_message .', "Advertencia", {
         //           closeButton: true,
          //          progressBar: true,
           //         positionClass: "toast-top-right",
            //        timeOut: 3000,
             //       extendedTimeOut: 1000
              //    });
               // });
            //  });
           
            //</script>';
        //}

     }
     
     // Funciones para realizar las operaciones CRUD en la base de datos
     public function create_computer($data) {
         // La lógica para insertar un registro en la tabla de computadoras
     }
     
     public function read_computer($id) {
         // La lógica para obtener un registro de la tabla de computadoras
     }
     
     public function update_computer($id, $data) {
         // La lógica para actualizar un registro en la tabla de computadoras
     }
     
     public function delete_computer($id) {
         // La lógica para eliminar un registro de la tabla de computadoras
     }
 }   
?>