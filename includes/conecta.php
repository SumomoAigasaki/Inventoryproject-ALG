<?php
//declarar variables de conexion 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "dbinventorywarrantyalg";

// Crea una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Verifica si la conexión fue exitosa
if (mysqli_connect_errno()) {
  die("La conexión con la base de datos falló: " . mysqli_connect_errno());
}



// una vez realizada la conexion validamos las tablas que esten llenas 
//NACIONALIDAD
 // Verificar si la tabla de nationality está vacía
  $verificarNacionalidad = "SELECT COUNT(*) as count FROM tbl_nationality";
  $resultado = $conn->query($verificarNacionalidad);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de nationality está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionNacionalidad = "INSERT INTO tbl_nationality (NTL_idTbl_Nationality, NTL_Description) VALUES 
            (NULL, ?), 
            (NULL, ?), 
            (NULL, ?), 
            (NULL, ?), 
            (NULL, ?), 
            (NULL, ?), 
            (NULL, ?)";

      // Valores para los placeholders
      $valores = array(
        'Hondureña(\'o\')',
        'Costarricense',
        'Dominicano',
        'Guatemalteca(\'o\')',
        'Indefinida',
        'Nicaragüense',
        'Salvadoreña'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionNacionalidad);

      // Vincular valores a los placeholders
      $stmt->bind_param("sssssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de nationality.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de nationality: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de nationality: " . $conn->error;
  }

// GENERO
  // Verificar si la tabla de genero está vacía
  $verificarGenero = "SELECT COUNT(*) as count FROM tbl_gender";
  $resultado = $conn->query($verificarGenero);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Genero está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionGenero = "INSERT INTO tbl_gender (GD_idTbl_Gender, GD_Description) VALUES 
      (NULL, ?),
      (NULL, ?),  
      (NULL, ?)";

      // Valores para los placeholders
      $valores = array(
        'Indefinida',
        'Femenino',
        'Masculino'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionGenero);

      // Vincular valores a los placeholders
      $stmt->bind_param("sss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Genero.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Genero: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Genero: " . $conn->error;
  }

// PROCESO
 // Verificar si la tabla de genero está vacía
   $verificarProcesos = "SELECT COUNT(*) as count FROM tbl_process";
   $resultado = $conn->query($verificarProcesos);
 
   if ($resultado) {
     $fila = $resultado->fetch_assoc();
     $cantidadRegistros = $fila['count'];
 
     if ($cantidadRegistros == 0) {
       // La tabla de Proceso está vacía, realizar la inserción
 
       // Inserción de registros utilizando placeholders
       $insercionProceso = "INSERT INTO tbl_process (PCS_idTbl_Process, PCS_Description) VALUES 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?),
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?), 
       (NULL,?)";
 
       // Valores para los placeholders
       $valores = array(
         'Admon Asotag',
         'Admon Mantto',
         'Agricola',
         'Agronomia',
         'Alce y Transporte',
         'Almacén',
         'Apliacaciones Aereas',
         'Asuntos publicos',
         'Auditoria',
         'Automatización',
         'Bascula',
         'Bodega',
         'Bodega Agroquímicos',
         'Calidad',
         'Club Social',
         'Compensaciones',
         'Compras',
         'Consecha Mecanizada',
         'Contabilidad',
         'Control Picklist',
         'Cumbas2',
         'Diseño',
         'Dispenario',
         'Electricidad',
         'Energia'
       );
 
       // Preparar la consulta
       $stmt = $conn->prepare($insercionProceso);
 
       // Vincular valores a los placeholders
       $stmt->bind_param("sssssssssssssssssssssssss", ...$valores);
 
       // Ejecutar la consulta
       $stmt->execute();
 
       // Verificar si la inserción fue exitosa
       if ($stmt->affected_rows > 0) {
         echo "Se insertaron datos en la tabla de Procesos.";
       } else {
         echo "Error-Conecta.-  al insertar datos en la tabla de Procesos: " . $stmt->error;
       }
 
       // Cerrar la declaración preparada
       $stmt->close();
     }
   } else {
     echo "Error-Conecta.-  al verificar la tabla de Proceso: " . $conn->error;
   }


// GERENCIA
  // Verificar si la tabla de genero está vacía
  $verificarGerencia = "SELECT COUNT(*) as count FROM tbl_management";
  $resultado = $conn->query($verificarGerencia);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Gerencia está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionGerencia = "INSERT INTO tbl_management (MNG_idTbl_Management, MNG_Description) VALUES 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?),
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?)";

      // Valores para los placeholders
      $valores = array(
        'N/A No Aplica',
        'Agricola',
        'Asotag',
        'Asuntos Publicos',
        'Finanzas',
        'General',
        'Industrial',
        'Ing. Procesos',
        'Las cumbas',
        'Logistica',
        'Productores independientes',
        'T & S'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionGerencia);

      // Vincular valores a los placeholders
      $stmt->bind_param("ssssssssssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Gerencia.";
      } else {
        echo "Error-Conecta.- al insertar datos en la tabla de Gerencia: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Gerencia: " . $conn->error;
  }

// Estado
  // Verificar si la tabla de genero está vacía
  $verificarEstado = "SELECT COUNT(*) as count FROM tbl_status";
  $resultado = $conn->query($verificarEstado);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Estado está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionStatus = "INSERT INTO tbl_status (STS_idTbl_Status, STS_Description) VALUES 
      (NULL, ?),
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?),        
      (NULL, ?), 
      (NULL, ?), 
      (NULL, ?)";

      // Valores para los placeholders
      $valores = array(
        'No Aplica',
        'Activo(a)',
        'Cancelado',
        'Circulacion',
        'Deshabilitado',
        'Desintalado',
        'Espera',
        'Inactivo(a)',
        'Instalado',
        'Retirado',
        'Sin Respuesta',
        'Solucionado'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionStatus);

      // Vincular valores a los placeholders
      $stmt->bind_param("ssssssssssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Estados.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Estados: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Estados: " . $conn->error;
  }

//Grado Academico 
  // Verificar si la tabla de Grado Academico está vacía
  $verificarAcademicGrade = "SELECT COUNT(*) as count FROM tbl_academicdegree";
  $resultado = $conn->query($verificarAcademicGrade);

  if ($resultado) {
      // Obtener el número de registros en la tabla
      $fila = $resultado->fetch_assoc();
      $cantidadRegistros = $fila['count'];

      if ($cantidadRegistros == 0) {
          // La tabla de Grado Academico está vacía, realizar la inserción

          // Inserción de registros utilizando placeholders
          $insercionGradoAcademico = "INSERT INTO tbl_academicdegree (AD_idtbl_academicDegree, AD_Description, AD_Abbreviation) VALUES 
          (NULL, ?,?), 
          (NULL, ?,?), 
          (NULL, ?,?), 
          (NULL, ?,?), 
          (NULL, ?,? ), 
          (NULL, ?,?), 
          (NULL, ?,?)";

          // Valores para los placeholders
          $valores = array(
              'Bachillerato Profesional', 'Br.',
              'Bachillerato Técnico Profesional', 'Téc(n).',
              'Catedrá', 'Cat.',
              'Ingeniería', 'Ing.',
              'Licenciatura', 'Lic.',
              'Máster/Maestría', 'MSc.',
              'Doctorado', 'PHd.'
          );

          // Preparar la consulta
          $stmt = $conn->prepare($insercionGradoAcademico);

          // Vincular valores a los placeholders
          $stmt->bind_param("sssssss", ...$valores);

          // Ejecutar la consulta
          $stmt->execute();

          // Verificar si la inserción fue exitosa
          if ($stmt->affected_rows > 0) {
              echo "Se insertaron datos en la tabla de Grado Academico.";
          } else {
              echo "Error-Conecta.-  al insertar datos en la tabla de Grado Academico: " . $stmt->error;
          }

          // Cerrar la declaración preparada
          $stmt->close();
      }
  } else {
      echo "Error-Conecta.-  al verificar la tabla de Grado Academico: " . $conn->error;
  }


// Tipo Contrato
  // Verificar si la tabla de genero está vacía
  $verificarTipoContrato = "SELECT COUNT(*) as count FROM tbl_typecontract";
  $resultado = $conn->query($verificarTipoContrato);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Tipo de Contrato está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionTipoContrato = "INSERT INTO tbl_typecontract (TCNT_idtbl_typeContract, TCNT_Description) VALUES 
      (NULL, ?), 
      (NULL, ?)";

      // Valores para los placeholders
      $valores = array(
        'Temporal',
        'Permanente '
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionTipoContrato);

      // Vincular valores a los placeholders
      $stmt->bind_param("ss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Tipo de Contrato.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Tipo de Contrato: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Tipo de Contrato: " . $conn->error;
  }


// Rol
  // Verificar si la tabla de Rol está vacía
  $verificarRol = "SELECT COUNT(*) as count FROM tbl_roles";
  $resultado = $conn->query($verificarRol);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Rol está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionRol = "INSERT INTO tbl_roles (RLS_idTbl_Roles, RLS_Description, RLS_InventoryDate, STS_idTbl_Status) VALUES 
      (NULL, ?,?,?), 
      (NULL, ?,?,?), 
      (NULL, ?,?,? )";

      // Valores para los placeholders
      $valores = array(
        'Colaborador', NULL, '2',
        'Administrador', NULL, '2',
        'Lector', NULL, '2'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionRol);

      // Vincular valores a los placeholders
      $stmt->bind_param("sss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Rol.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Rol: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Rol: " . $conn->error;
  }

// Modulos
  // Verificar si la tabla de Modulo está vacía
  $verificarModulo = "SELECT COUNT(*) as count FROM tbl_module";
  $resultado = $conn->query($verificarModulo);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Modulo está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionRol = "INSERT INTO tbl_module (MDU_idtbl_Module, MDU_Descriptions) VALUES
       (NULL, ?), 
       (NULL, ?),
       (NULL, ?), 
       (NULL, ?),
       (NULL, ?),  
       ";

      // Valores para los placeholders
      $valores = array(
        'Dashboard',
        'Transaction',
        'MasterData',
        'Security',
        'Reading'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionRol);

      // Vincular valores a los placeholders
      $stmt->bind_param("sssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Modulo.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Modulo: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Modulo: " . $conn->error;
  }

// Privilegios
  // Verificar si la tabla de Privilegios está vacía
  $verificarPrivilegios = "SELECT COUNT(*) as count FROM tbl_privileges";
  $resultado = $conn->query($verificarPrivilegios);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Privilegios está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionPrivilegios = "INSERT INTO tbl_privileges (PRV_idTbl_Privileges, PRV_Name, PRV_Descriptions, PRV_Nomenclature, MDU_idtbl_Module) VALUES 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?),
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?), 
      (NULL, ?,?,?,?)";

      // Valores para los placeholders
      $valores = array(
        'Software', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Software.', 'SFT', '3',
        'Perifericos', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Perifericos', 'PRL', '3',
        'Colaborador(es)', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Colaboradores', 'CBT', '3',
        'Computadoras', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Computadoras', 'CMP', '2',
        'Asignacion de PC', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Asignacion Pc.', 'PCA', '2',
        'Garantia', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Garantia.', 'WR', '2',
        'Roles/Permisos', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Permisos.', 'RLS', '4',
        'Usuario', 'Concede permiso para la creacion, visualizacion, actualización y deshabiltación de los registros de los datos de Usuarios', 'USER', '4',
        'Reportes Garantia', 'Concede permiso para la visaulizacion de los reportes sobre Garantia ', 'DWR', '1',
        'Reportes Computadoras', 'Concede permiso para la visaulizacion de los reportes sobre Computadoras', 'DCMP', '1',
        'Lectura Computadoras', 'Concede permiso a la Lectura de registros de computadoras', 'RCMP', '5',
        'Lectura Asignacion PC', 'Concede permiso a la Lectura de registros de asignacion de PC', 'RPCA', '5',
        'Lectura Garantia', 'Concede permiso a la Lectura de registros de grantia', 'RWR', '5',
        'Lectura Software', 'Concede permiso a la Lectura de registros de Software', 'RSFT', '5',
        'Lectura Perifericos', 'Concede permiso a la Lectura de registros de Perifericos', 'RPRL', '5',
        'Lectura Colaboradores', 'Concede permiso a la Lectura de registros de Colaborador', 'RCBT', '5'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionPrivilegios);

      // Vincular valores a los placeholders
      $stmt->bind_param("ssssssssssssssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Privilegios.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Privilegios: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Privilegios: " . $conn->error;
  }

// Colaborador
  // Verificar si la tabla de Colaborador está vacía
  $verificarColaborador = "SELECT COUNT(*) as count FROM tbl_collaborator";
  $resultado = $conn->query($verificarColaborador);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Colaborador está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $Colaborador = "INSERT INTO tbl_roles (INSERT INTO tbl_collaborator (CBT_idTbl_Collaborator, CBT_Employee_Code, NTL_idTbl_Nationality, CBT_Image, CBT_First_Name, CBT_Second_Name, CBT_First_Surname, CBT_Second_Surname, GD_idTbl_Gender, CBT_Address, CBT_Phone_Number, CBT_Birth_Date, PCS_idTbl_Process, MNG_idTbl_Management, CBT_Inventory_Date, User_idTbl_User, STS_idTbl_Status, CBT_employee_position, AD_idtbl_academicDegree, TCNT_idtbl_typeContract, CBT_Date_Hire_Start, CBT_Hiring_Months) VALUES 
      (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?), 
      (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

      // Valores para los placeholders
      $valores = array(
        '0', '1', '/resources/Collaborator/default.jpg', 'Colaborador', '', 'Indefinido', '', '1', '000', '00008', '2023-01-01', '1', '1', '2023-06-28', '1', '2', '', '1', '1', '2023-01-01', '12',
        '12345', '2', '/resources/Collaborator/default.jpg', 'Favio', '', 'Calderon', '', '3', 'san francisco', '00009', '1997-03-12', '73', '5', '2023-06-28', '30', '2', 'Co-Coordinador de It', '4', '1', '2023-01-01', '36',
    
      );

      // Preparar la consulta
      $stmt = $conn->prepare($Colaborador);

      // Vincular valores a los placeholders
      $stmt->bind_param("ss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Colaborador.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Colaborador: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Colaborador: " . $conn->error;
  }

// Usuario
  // Verificar si la tabla de Usuario está vacía
  $verificarUsuario = "SELECT COUNT(*) as count FROM tbl_user";
  $resultado = $conn->query($verificarUsuario);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Usuario está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionUsuario = "INSERT INTO tbl_user (User_idTbl_User, User_DataRegister, User_Username, User_Email, User_Password, CBT_idTbl_Collaborator, STS_idTbl_Status, User_img, RLS_idTbl_Roles) VALUES 
      (NULL, ?,?,?,?,?,?,?,?),
      (NULL, ?,?,?,?,?,?,?,?)";

      // Valores para los placeholders
      $valores = array(
        '2023-06-28', 'fcalderon', 'fcalderon@alg.com', 'admin', '2', '2', '/resources/User/Fcalderon.jpg', '2',
        '2023-06-28', 'root', 'root@alg.com', 'root', '1', '2', '/resources/User/Fcalderon.jpg', '2'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionUsuario);

      // Vincular valores a los placeholders
      $stmt->bind_param("ss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Usuario.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Usuario: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Usuario: " . $conn->error;
  }


// Usuario-Privilegios
  // Verificar si la tabla de Usuario-Privilegios está vacía
  $verificarUsuarioPrivilegios = "SELECT COUNT(*) as count FROM tbl_user_privileges";
  $resultado = $conn->query($verificarUsuarioPrivilegios);

  if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $cantidadRegistros = $fila['count'];

    if ($cantidadRegistros == 0) {
      // La tabla de Usuario-Privilegios está vacía, realizar la inserción

      // Inserción de registros utilizando placeholders
      $insercionUsuario = "INSERT INTO tbl_user_privileges (USP_IDtbl_user_privileges, RLS_idTbl_Roles, MDU_idtbl_Module, PRV_idTbl_Privileges, USP_Inventory_Date, STS_idTbl_Status, User_idTbl_User) VALUES 
      (NULL, ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,? ),
      (NULL,  ?,?,?,?,?,? ),
      (NULL,  ?,?,?,?,?,? ),
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?), 
      (NULL,  ?,?,?,?,?,?)";

      // Valores para los placeholders
      $valores = array(
        '2', '3', '1', '0000-00-00', '6', '1',
        '2', '3', '2', '0000-00-00', '2', '1',
        '2', '3', '3', '0000-00-00', '2', '1',
        '2', '2', '4', '0000-00-00', '2', '1',
        '2', '2', '5', '0000-00-00', '2', '1',
        '2', '2', '6', '0000-00-00', '2', '1',
        '2', '4', '7', '0000-00-00', '2', '1',
        '2', '4', '8', '0000-00-00', '2', '1',
        '2', '3', '1', '2023-11-08', '2', '30',
        '2', '5', '11', '2024-01-22', '2', '1',
        '2', '5', '12', '2024-01-22', '2', '1',
        '2', '5', '13', '2024-01-22', '2', '1',
        '2', '5', '14', '2024-01-22', '2', '1',
        '2', '5', '15', '2024-01-22', '2', '1',
        '2', '5', '16', '2024-01-22', '2', '1',
        '2', '1', '9', '2024-01-23', '2', '1',
        '2', '1', '10', '2024-01-23', '2', '1'
      );

      // Preparar la consulta
      $stmt = $conn->prepare($insercionUsuario);

      // Vincular valores a los placeholders
      $stmt->bind_param("sssssssssssssssss", ...$valores);

      // Ejecutar la consulta
      $stmt->execute();

      // Verificar si la inserción fue exitosa
      if ($stmt->affected_rows > 0) {
        echo "Se insertaron datos en la tabla de Usuario Privilegios.";
      } else {
        echo "Error-Conecta.-  al insertar datos en la tabla de Usuario Privilegios: " . $stmt->error;
      }

      // Cerrar la declaración preparada
      $stmt->close();
    }
  } else {
    echo "Error-Conecta.-  al verificar la tabla de Usuario Privilegios: " . $conn->error;
  }
//Retorna la conexion
  return $conn;
?>