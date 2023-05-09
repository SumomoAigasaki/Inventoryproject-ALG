<?php 
 include "../../includes/conecta.php";
 
 function validate_data() {

    // Verifica si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Verifica si el campo 'nombre' no está vacío
        if (empty($_POST["acquisitionDate"]) ) {
            echo"la fecha esta vacia";
        $errors[] = 'La Fecha de Compra esta vacio(a).Por favor Ingrese una fecha valida';
        }
            //validaremos que la fecha ingreso no sea la actual
            $acquisitionDate = ($_POST['acquisitionDate']); // asumiendo que el valor viene por POST

            // Convertir la fecha ingresada a timestamp
            $acquisitionDateTimestamp = strtotime($acquisitionDate);
    
            // Obtener la fecha actual como timestamp
            $currentTimestamp = time();
    
            // Verificar si la fecha de expiración de garantía es menor o igual a la fecha actual
            if ($acquisitionDateTimestamp <= $currentTimestamp) {
                $errors[] = 'La Fecha de Compra debe ser Distinta a la fecha actual.';
            }
        
        else if (empty($_POST['select_manufacturer']) && isset($_POST['select_manufacturer'])) {
            $errors[] = 'La Marca esta vacio(a).Por favor Ingrese una Marca valida';
        }

        else if (empty($_POST['select_model']) && isset($_POST['select_model'])) {
            $errors[] = 'El Modelo esta vacio(a).Por favor Ingrese un Modelo valida';
        }

        else if (empty($_POST['select_computerType']) && isset($_POST['select_computerType '])) {
            $errors[] = 'El tipo de computadora esta vacio(a).Por favor Ingrese un tipo de computadora valido';
        }

        else if (empty($_POST['txt_nombre']) && isset($_POST['txt_nombre'])) {
            $errors[] = 'El nombre técnico esta vacio(a).Por favor Ingrese un Nombre valido';
        }

        else if (empty($_POST['txt_servitag']) && isset($_POST['txt_servitag'])) {
            $errors[] = 'El servitag esta vacio(a).Por favor Ingrese una servitag valido';
        }

        else  if (empty($_POST['warrantyExpiration']) && isset($_POST['warrantyExpiration'])) {
            $errors[] = 'La Fecha Límite Garantía esta vacio(a).Por favor Ingrese una Fecha Límite Garantía valida';
        }

            //validaremos que la fecha ingreso no sea la actual
            $warrantyExpiration = ($_POST['acquisitionDate']); // asumiendo que el valor viene por POST

            // Convertir la fecha ingresada a timestamp
            $warrantyExpirationTimestamp = strtotime($warrantyExpiration);

            // Obtener la fecha actual como timestamp
            $currentTimestamp = time();

            // Verificar si la fecha de expiración de garantía es menor o igual a la fecha actual
            if ($warrantyExpirationTimestamp <= $currentTimestamp) {
                $errors[] = 'La Fecha Límite Garantía debe ser Distinta a la fecha actual.';
            }

        else if (empty($_POST['yearExpiration']) && isset($_POST['yearExpiration'])) {
            $errors[] = 'El Año Limite Garantía esta vacio(a).Por favor Ingrese una Año Limite Garantía valida';
        }

        else if (empty($_POST['select_statu']) && isset($_POST['select_statu'])) {
            $errors[] = 'El Estado del Computador esta vacio(a).Por favor Ingrese una Estado del Computador valida';
        }

        else if (empty($_POST['select_location']) && isset($_POST['select_location'])) {
            $errors[] = 'La Localizacion del Computador esta vacio(a).Por favor Ingrese una Localizacion del Computador valida';
        }
        
        // Verifica si se encontraron errores durante la validación
        if (!empty($errors)) {
            // Si hay errores, muestra los mensajes de error
            foreach ($errors as $error) {
                echo '<script src="../../public/jquery/jquery.min.js" ></script>
                <script src="../../public/js/toastr.min.js"></script>
                <script>
                   $(function() {
                    // Agrega un controlador de eventos click a cualquier elemento con la clase "toastrDefaultWarning"
                    $(".toastrDefaultWarning").click(function() {
                      // Utiliza la función warning de Toastr para mostrar una notificación de advertencia
                        toastr.warning('. $error .', "Advertencia", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000,
                        extendedTimeOut: 1000
                        });
                      });
                  });
                </script>';
            }
        } else {
            // Si no hay errores, procesa los datos enviados
            $opcion = $_POST['opciones'];
            echo'document.getElementById("formulario").submit();';
            // Realiza las operaciones necesarias con los datos
            // ...
        }
        echo'return false;';
    }

}



 class Computer {
     // Función para validar los datos ingresados en el formulario
     public function validate_data() {
         //Lógica de validación
         

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