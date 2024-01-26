
<?php
include 'config.php';
// <!-- Archivo para realiaz peticiones mediante php hacia la base de datos y extraer datos -->
class MySQL
{

    private $usernamePDO;
    private $passwordPDO;
    private $ipBDPDO;
    private $dbnamePDO;
    private $oConDB = null;

    public function __construct()
    {
        global $usernamePDO, $passwordPDO, $ipBDPDO, $dbnamePDO;
        $this->usernamePDO = $usernamePDO;
        $this->passwordPDO = $passwordPDO;
        $this->ipBDPDO = $ipBDPDO;
        $this->dbnamePDO = $dbnamePDO;
    }

    /**
     * Conexion Orientada a objeto
     */
    public function conBDOB()
    {
        // echo "MySql. valor del dato servidor -" .$this->ipBDPDO."- \n";
        // echo "MySql. valor del dato username -" .$this->usernamePDO."- \n";
        // echo "MySql. valor del dato passwordPDO -" .$this->passwordPDO."- \n";
        // echo "MySql. valor del dato dbnamePDO -" .$this->dbnamePDO."- \n";

        $oConDB = new mysqli($this->ipBDPDO, $this->usernamePDO, $this->passwordPDO, $this->dbnamePDO);
        $oConDB->set_charset("utf8");
        // Verifica si la conexión fue exitosa
        if (mysqli_connect_errno()) {
            echo "MySql. Error al conectar a la base de datos -" . $this->oConDB->connect_error . " - \n";
            return false;
        }
        // else{
        //     echo "MySql.Conexion exitosa..." . "\n";
        //     return true;
        // }


    }

    /**
     * Conexion a Base de Datos con PDO
     */
    public function conBDPDO()
    {
        try {
            $this->oConDB = new PDO("mysql:host=localhost;dbname=dbinventorywarrantyalg", $this->usernamePDO, $this->passwordPDO);
            // echo "<p>MySql.conBDPDO Conexion existosa... </p>" . "\n";
            return true;
        } catch (PDOException $e) {
            echo "MySql.conBDPDO Error al conectar a la base de datos -" . $e->getMessage() . " - \n";
            return false;
        }
    }

    // CARDS
    // RQ 1 Extraer datos para tabla de nuevos Registros
        public function modalRecNewRegister()
        {
            $jDatos = '';
            $ArrayNewRegisterTable = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_RecNewPDF()";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new newRegisterTableData();
                        $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                        $oDataSP->fechaAdquisicion = $row['CMP_Inventory_Date'];
                        $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                        $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                        $oDataSP->manofacturacion = $row['MFC_Description'];
                        $oDataSP->modelo = $row['MDL_Description'];
                        $oDataSP->tipoGarantía = $row['TG_Description'];
                        $ArrayNewRegisterTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }

                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $ArrayNewRegisterTable,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }

    // RQ 2 Extraer datos para tabla de registros RAMS 

        public function modalrecRams()
        {
            $jDatos = '';
            $ArrayRAMS = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_recRamsPDF()";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new RegisterEspecificaciones();
                        $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                        $oDataSP->fechaExpiracion = $row['CMP_Acquisition_Date'];
                        $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                        $oDataSP->especificaciones = $row['Especificacion'];
                        $oDataSP->marcaModelo = $row['marcaModelo'];
                        $oDataSP->tipoGarantía = $row['TG_Description'];
                        $oDataSP->localizacion = $row['LCT_Description'];
                        $oDataSP->estado = $row['STS_Description'];
                        $oDataSP->usuario = $row['User_Username'];
                        $ArrayRAMS[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }
                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $ArrayRAMS,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }

    // RQ 3 Extraer datos para tabla de registros CPU

    public function modalRecCPU()
    {
        $jDatos = '';
        $ArrayCPU = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_recCPUPDF()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new RegisterEspecificaciones();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaExpiracion = $row['CMP_Acquisition_Date'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->especificaciones = $row['Especificacion'];
                    $oDataSP->marcaModelo = $row['marcaModelo'];
                    $oDataSP->tipoGarantía = $row['TG_Description'];
                    $oDataSP->localizacion = $row['LCT_Description'];
                    $oDataSP->estado = $row['STS_Description'];
                    $oDataSP->usuario = $row['User_Username'];
                    $ArrayCPU[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }

                // Obtener el número total de registros
                $total_registros = $eQuery->rowCount();;

                // Combinar los datos y el total de registros en un array final
                $response = array(
                    "data" => $ArrayCPU,
                    "total_registros" => $total_registros
                );
            }
            $jDatos = json_encode($response);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

    // RQ 4 Extraer datos para tabla de registros Discos Duros

    public function modalRecDisk()
    {
        $jDatos = '';
        $ArrayDisk = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_recDiskPDF()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new RegisterEspecificaciones();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaExpiracion = $row['CMP_Acquisition_Date'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->especificaciones = $row['Especificacion'];
                    $oDataSP->marcaModelo = $row['marcaModelo'];
                    $oDataSP->tipoGarantía = $row['TG_Description'];
                    $oDataSP->localizacion = $row['LCT_Description'];
                    $oDataSP->estado = $row['STS_Description'];
                    $oDataSP->usuario = $row['User_Username'];
                    $ArrayDisk[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
                // Obtener el número total de registros
                $total_registros = $eQuery->rowCount();;

                // Combinar los datos y el total de registros en un array final
                $response = array(
                    "data" => $ArrayDisk,
                    "total_registros" => $total_registros
                );
            }

            $jDatos = json_encode($response);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

// GRAFICOS Y MODALS 
   
    //RQ 5  Extraer datos para modal de la Tabla para el Grafico de Barras

        public function modalComparativeBarGraph($year)
        {
            $jDatos = '';
            $barGraphInformationModal = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_modalComparativeBarGraph(:sp_year)";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->bindParam(':sp_year', $year, PDO::PARAM_INT); // Enlazar el parámetro :sp_year con el valor $year
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new RegisterTableData();
                        $oDataSP->idComputer = $row['ID'];
                        $oDataSP->fecha = $row['Fecha'];
                        $oDataSP->nombreTecnico = $row['nombreTecnico'];
                        $oDataSP->tipoEquipo = $row['tipoEquipo'];
                        $oDataSP->modelo = $row['Modelo'];
                        $oDataSP->servitag = $row['Servitag'];
                        $oDataSP->especificaciones = $row['Especificaciones'];
                        $oDataSP->sTS_Description = $row['STS_Description'];
                        $oDataSP->user_Username = $row['User_Username'];
                        $barGraphInformationModal[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }
                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $barGraphInformationModal,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }
    
    //RQ 6 Extraer datos para el modal del Grafica Pastel Desktop
        public function modalpieGraphInformationDesktop($year)
        {
            $jDatos = '';
            $ArrayDataPieTable = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_modalPieGraphInformationDesktop(:sp_year)";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->bindParam(':sp_year', $year, PDO::PARAM_INT); // Enlazar el parámetro :sp_year con el valor $year
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new RegisterPieTableData();
                        $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                        $oDataSP->fechaAdquisicion = $row['CMP_Acquisition_Date'];
                        $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                        $oDataSP->especificaciones = $row['Especificaciones'];
                        $oDataSP->modelo = $row['Modelo'];
                        $oDataSP->estado = $row['STS_Description'];
                        $oDataSP->usuario = $row['User_Username'];
                        $ArrayDataPieTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }
                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $ArrayDataPieTable,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }
    
    //RQ 7 Extraer datos para el modal del Grafica Pastel Laptos
        public function modalpieGraphInformationLaptop($year)
        {
            $jDatos = '';
            $ArrayDataPieTable = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_modalPieGraphInformationLaptos(:sp_year)";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->bindParam(':sp_year', $year, PDO::PARAM_INT); // Enlazar el parámetro :sp_year con el valor $year
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new RegisterPieTableData();
                        $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                        $oDataSP->fechaAdquisicion = $row['CMP_Acquisition_Date'];
                        $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                        $oDataSP->especificaciones = $row['Especificaciones'];
                        $oDataSP->modelo = $row['Modelo'];
                        $oDataSP->estado = $row['STS_Description'];
                        $oDataSP->usuario = $row['User_Username'];
                        $ArrayDataPieTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }
                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $ArrayDataPieTable,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }

    //RQ 8  Extraer datos para tabla/Reporte de la Grafica De Dispersion

        public function modalScatterPlotInformationLocation($year)
        {
            $jDatos = '';
            $ArrayDataScatterTable = array();
            $i = 0;

            try {
                $strQuery = "CALL sp_scatterPlotInformationModalLocation(:sp_year)";

                if ($this->conBDPDO()) {
                    $eQuery = $this->oConDB->prepare($strQuery);
                    $eQuery->bindParam(':sp_year', $year, PDO::PARAM_INT); // Enlazar el parámetro :sp_year con el valor $year
                    $eQuery->execute();
                    $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                    while ($row = $eQuery->fetch()) {
                        $oDataSP = new RegisterScatterTableData();
                        $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                        $oDataSP->fechaAdquisicion = $row['CMP_Acquisition_Date'];
                        $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                        $oDataSP->tipoEquipo = $row['CT_Description'];
                        $oDataSP->Localizacion = $row['Localizacion'];
                        $oDataSP->modelo = $row['Modelo'];
                        $oDataSP->especificaciones = $row['Especificaciones'];
                        $oDataSP->estado = $row['STS_Description'];
                        $oDataSP->usuario = $row['User_Username'];
                        $ArrayDataScatterTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                        $i++;
                    }
                    // Obtener el número total de registros
                    $total_registros = $eQuery->rowCount();;

                    // Combinar los datos y el total de registros en un array final
                    $response = array(
                        "data" => $ArrayDataScatterTable,
                        "total_registros" => $total_registros
                    );
                }

                $jDatos = json_encode($response);
            } catch (PDOException $e) {
                echo "MySql.Get Scatter " . $e->getMessage() . "\n";
                return false;
            }
            return $jDatos;
        }
}

class Cards1
{
    public $RecentRecordsCard = 0;
}
class Cards2
{
    public $RecordsCardCoverage = 0;
}

class Cards3
{
    public $NonCoverageRecordsCard = 0;
}
class Cards4
{

    public $UpcomingRecordsCardDue = 0;
}

class DataGraphic
{
    public $Fecha = 0;
    public $Laptops = 0;
    public $Escritorios = 0;
    public $Total = 0;
}
class ScatterData
{
    public $Localizacion = 0;
    public $CantidadRegistrosLCT = 0;
}
class PieData
{
    public $Marca = 0;
    public $CantidadRegistrosMFC = 0;
}

class newRegisterTableData
{
    public $idComputer = 0;
    public $fechaAdquisicion = 0;
    public $nombreTecnico = 0;
    public $marcaModelo = 0;
    public $tipoGarantía = 0;
    public $usuario = 0;
    public $estado = 0;
}


class RegisterTableData
{
    public $idComputer = 0;
    public $fecha = 0;
    public $nombreTecnico = 0;
    public $tipoEquipo = 0;
    public $modelo = 0;
    public $servitag = 0;
    public $especificaciones = 0;
    public $sTS_Description = 0;
    public $user_Username = 0;
}

class RegisterEspecificaciones
{
    public $idComputer = 0;
    public $fechaExpiracion = 0;
    public $nombreTecnico = 0;
    public $especificaciones = 0;
    public $marcaModelo = 0;
    public $tipoGarantía = 0;
    public $localizacion = 0;
    public $estado = 0;
    public $usuario = 0;
}
class RegisterCoverageTableData
{
    public $idAsignacionPc = 0;
    public $fechaAsignacion = 0;
    public $fechaDevolucion = 0;
    public $nombreColaborador = 0;
    public $nombreTecnico = 0;
    public $fechaExpiracion = 0;
}
class RegisterSoonExpiredTableData
{
    public $idComputer = 0;
    public $fechaExpiracion = 0;
    public $nombreTecnico = 0;
    public $manofacturacion = 0;
    public $modelo = 0;
    public $tipoGarantía = 0;
    public $estado = 0;
}


class RegisterPieTableData
{
    public $idComputer = 0;
    public $fechaAdquisicion = 0;
    public $nombreTecnico = 0;
    public $especificaciones = 0;
    public $modelo = 0;
    public $estado = 0;
    public $usuario = 0;
}

class RegisterScatterTableData
{
    public $idComputer = 0;
    public $fechaAdquisicion = 0;
    public $nombreTecnico = 0;
    public $tipoEquipo = 0;
    public $Localizacion = 0;
    public $modelo = 0;
    public $especificaciones = 0;
    public $estado = 0;
    public $usuario = 0;
}
