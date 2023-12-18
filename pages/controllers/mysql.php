<?php
include 'config.php';

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
    /**
     * Extraer datos de conteo de las cards par Registros Nuevos
     */
    public function getCardsNew()
    {
        try {

            $jDatos = '';
            $CardsData = array();
            $i = 0;
            $getDatos = 0;

            $strQuery = "CALL sp_DashboardWarrantyCardsNew()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);
                $getDatos = $eQuery->fetchColumn();
            }
        } catch (PDOException $e) {
            echo "MySql.Get Cards " . $e->getMessage() . "\n";
            return false;
        }
        return $getDatos;
    }

    /**
     * Extraer datos de conteo de las cards par Registros con garantia full
     */
    public function getCardsWarrantyfull()
    {
        try {

            $jDatos = '';
            $CardsData = array();
            $i = 0;
            $getDatos = 0;

            $strQuery = "CALL sp_DashWCardsWarrantyF()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);
                $getDatos = $eQuery->fetchColumn();
            }
        } catch (PDOException $e) {
            echo "MySql.Get Cards " . $e->getMessage() . "\n";
            return false;
        }
        return $getDatos;
    }
    /**
     * Extraer datos de conteo de las cards par Registros Asignados sin garantia 
     */
    public function getCardsNonCoverage()
    {
        try {

            $jDatos = '';
            $CardsData = array();
            $i = 0;
            $getDatos = 0;

            $strQuery = "CALL sp_DashWCardsNonCoverage()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);
                $getDatos = $eQuery->fetchColumn();
            }
        } catch (PDOException $e) {
            echo "MySql.Get Cards " . $e->getMessage() . "\n";
            return false;
        }
        return $getDatos;
    }
      /**
     * Extraer datos de conteo de las cards par Registros Proximos a vencer con estado activo o Circulando
     */
    public function getCardsrUpcoming()
    {
        try {

            $jDatos = '';
            $CardsData = array();
            $i = 0;
            $getDatos = 0;

            $strQuery = "CALL sp_DashWCardrUpcoming()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);
                $getDatos = $eQuery->fetchColumn();
            }
        } catch (PDOException $e) {
            echo "MySql.Get Cards " . $e->getMessage() . "\n";
            return false;
        }
        return $getDatos;
    }
    /**
     * Extraer datos para grafica de Pastel 
     */
    public function getPieChartData()
    {
        $jDatosPie = '';
        $ArrayRecordsTypeGuarantee = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyPie()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataP = new PieData();
                    $oDataP->TipoGarantia = $row['TipoGarantia'];
                    $oDataP->CantidadRegistrosTG = $row['CantidadRegistrosTG'];

                    $ArrayRecordsTypeGuarantee[] = $oDataP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatosPie = json_encode($ArrayRecordsTypeGuarantee);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatosPie;
    }
    /**
     * Datos para Grafica comparativa
     */
    public function sp_DashboardWarrantyGraph()
    {
        $jDatosGraphComparative = '';
        $comparativeGraphData = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyGraph()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oData1 = new DataGraphic;
                    $oData1->Fecha = $row['Fecha'];
                    $oData1->Vigentes = $row['Vigentes'];
                    $oData1->Vencidos = $row['Vencidos'];
                    // $oData1->SinGarantia = $row['SinGarantia'];

                    $comparativeGraphData[] = $oData1; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatosGraphComparative = json_encode($comparativeGraphData);
        } catch (PDOException $e) {
            echo "MySql.Get Bar1 " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatosGraphComparative;
    }

   
    /**
     * Extraer datos para Grafica de dispersion 
     */
    public function getScatterPlotData()
    {
        $jDatos = '';
        $ArrayActiveRecordsManagement = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyScatter()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new ScatterData();
                    $oDataSP->Gerencia = $row['Gerencia'];
                    $oDataSP->CantidadRegistrosXGerencia = $row['CantidadRegistrosXGerencia'];

                    $ArrayActiveRecordsManagement[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayActiveRecordsManagement);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }


    
    /**
     * Extraer datos para tabla de nuevos Registros
     */
    public function getNewRegisterTable()
    {
        $jDatos = '';
        $ArrayNewRegisterTable = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyNewRegisterTable()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new newRegisterTableData();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->manofacturacion = $row['MFC_Description'];
                    $oDataSP->modelo = $row['MDL_Description'];
                    $oDataSP->tipoGarantía = $row['TG_Description'];
                    $NewRegisterTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($NewRegisterTable);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }
    

     /**
     * Extraer datos para tabla de nuevos Registros
     */
    public function getFullCoverageTable()
    {
        $jDatos = '';
        $ArrayFullCoverageTable = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyFullCoverageRecords()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new newRegisterTableData();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->manofacturacion = $row['MFC_Description'];
                    $oDataSP->modelo = $row['MDL_Description'];
                    $oDataSP->tipoGarantía = $row['TG_Description'];
                    $ArrayFullCoverageTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayFullCoverageTable);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

       /**
     * Extraer datos para tabla de registros sin covertura en uso 
     */
    public function getUncoveredRecordsUseTable()
    {
        $jDatos = '';
        $ArrayUncoveredRecordsUse = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashWarantyUncoveredRecordsUse()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new RegisterCoverageTableData();
                    $oDataSP->idAsignacionPc = $row['PCA_idTbl_PC_Assignment'];
                    $oDataSP->fechaAsignacion = $row['PCA_Date_Assignment'];
                    $oDataSP->fechaDevolucion = $row['PCA_Return_Date'];
                    $oDataSP->nombreColaborador = $row['NombreColaborador'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                    $ArrayUncoveredRecordsUse[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayUncoveredRecordsUse);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

    
     /**
     * Extraer datos para tabla de nuevos Registros
     */
    public function getExpiredRecordsTable()
    {
        $jDatos = '';
        $ArrayExpiredRecordsTable = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashboardWarrantyExpiredRecords()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new newRegisterTableData();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->manofacturacion = $row['MFC_Description'];
                    $oDataSP->modelo = $row['MDL_Description'];
                    $oDataSP->tipoGarantía = $row['TG_Description'];
                    $ArrayExpiredRecordsTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayExpiredRecordsTable);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

    /**
     * Extraer datos para tabla/Reporte de la Grafica Pastel
     */
    public function getDataPieTable()
    {
        $jDatos = '';
        $ArrayDataPieTable = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashWarrantyDataPieTable()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new RegisterPieTableData();
                    $oDataSP->idComputer = $row['CMP_idTbl_Computer'];
                    $oDataSP->fechaAdquisicion = $row['CMP_Acquisition_Date'];
                    $oDataSP->tipoGarantia = $row['TG_Description'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->servitag = $row['CMP_Servitag'];
                    $oDataSP->licensia = $row['CMP_License'];
                    $oDataSP->manofacturacion = $row['MFC_Description'];
                    $oDataSP->modelo = $row['MDL_Description'];
                    $oDataSP->fechaExpiracion = $row['CMP_Warranty_Expiration'];
                    $ArrayDataPieTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayDataPieTable);
        } catch (PDOException $e) {
            echo "MySql.Get Scatter " . $e->getMessage() . "\n";
            return false;
        }
        return $jDatos;
    }

     /**
     * Extraer datos para tabla/Reporte de la Grafica De Dispersion
     */
    public function getDataScatterTable()
    {
        $jDatos = '';
        $ArrayDataScatterTable = array();
        $i = 0;

        try {
            $strQuery = "CALL sp_DashWarrantyDataScatterTable()";

            if ($this->conBDPDO()) {
                $eQuery = $this->oConDB->prepare($strQuery);
                $eQuery->execute();
                $eQuery->setFetchMode(PDO::FETCH_ASSOC);

                while ($row = $eQuery->fetch()) {
                    $oDataSP = new RegisterScatterTableData();
                    $oDataSP->idPCAsigment = $row['PCA_idTbl_PC_Assignment'];
                    $oDataSP->fechaAsignacion = $row['PCA_Date_Assignment'];
                    $oDataSP->NombreColaborador = $row['NombreColaborador'];
                    $oDataSP->nombreTecnico = $row['CMP_Technical_Name'];
                    $oDataSP->Gerencia = $row['Gerencia'];
                    $oDataSP->Area = $row['AREA'];
                    $ArrayDataScatterTable[] = $oDataSP; // Agregar el objeto $oData1 al array
                    $i++;
                }
            }

            $jDatos = json_encode($ArrayDataScatterTable);
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
    public $Vigentes = 0;
    public $Vencidos = 0;
    public $SinGarantia = 0;
}
class ScatterData
{
    public $Gerencia = 0;
    public $CantidadRegistrosXGerencia = 0;
}
class PieData
{
    public $TipoGarantia = 0;
    public $CantidadRegistrosTG = 0;
}

class newRegisterTableData
{
    public $idComputer = 0;
    public $fechaExpiracion = 0;
    public $nombreTecnico = 0;
    public $manofacturacion = 0;
    public $modelo = 0;
    public $tipoGarantía = 0;
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

class RegisterPieTableData
{
    public $idComputer = 0;
    public $fechaAdquisicion = 0;
    public $tipoGarantia = 0;
    public $nombreTecnico = 0;
    public $servitag = 0;
    public $licensia = 0;
    public $manofacturacion = 0;
    public $modelo = 0;
    public $fechaExpiracion = 0;
}

class RegisterScatterTableData
{
    public $idPCAsigment = 0;
    public $fechaAsignacion = 0;
    public $NombreColaborador = 0;
    public $nombreTecnico = 0;
    public $Gerencia = 0;
    public $Area = 0;
}