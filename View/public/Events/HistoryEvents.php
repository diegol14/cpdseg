<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once EVENT_SERVICE_PATH;
include_once EVENT_PATH;
include_once MODEL_EVENTS_PATH . '/SqlObj.php';


session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=description content="CPDSeg es una aplicación WEB de monitorización de sensores
     en remoto. Está orientada a supervisar instalaciones, como por ejemplo,Centros de Procesamiento de Datos" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="DiegolPereira" />
    <title>HistóricoEventos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https: //fonts.googleapis.com/css2? family = Roboto & display = swap " rel=" stylesheet ">
    <link href='../../styles/normalyze.css' rel='stylesheet' type='text/css' />
    <!-- Empieza favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="/View/public/assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/View/public/assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/View/public/assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/View/public/assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/View/public/assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/View/public/assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/View/public/assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/View/public/assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/View/public/assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/View/public/assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/View/public/assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/View/public/assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/View/public/assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="/View/public/assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/View/public/assets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--Termina favicon-->
</head>

<body>
    <?php
    if (!isset($_SESSION['rol']))  header('Location: /index.php');
    else {
        switch ($_SESSION['rol']) {
            case 'user':
                include_once HEADER_PATH . '/UserHeader.php';
                break;

            case 'admin':
                include_once HEADER_PATH . '/AdminHeader.php';
                break;
        } //End switch
    } //End else

    ?>
    <main>

        <div id="content">
            <header>
                <h1>CPDSeg</h1>
                <small>Monitoriza tu instalaci&oacute;n</small>
            </header>
<div class="container">
            <h2>Hist&oacute;rico de Eventos</h2>
            <!--             1_ Formulario que se envía a esta misma clase para crear un "SqlObj" que será enviado al 
            Dao con la consulta original a ser paginada -->
            <form action="" method="post" autocomplete="off">
                <input type="hidden" name="searchEvents" value="searchEvents">
                <div class="dates">
                    <div class="history">
                        <div><label for='date_start'>Inicio</label></div>
                        <div><input type='date' name='date_start' required> </div>
                    </div>
                    <div class="history2">
                        <div><label for='date_end'>Fin</label></div>
                        <div><input type='date' name='date_end' required> </div>
                    </div>
                </div>
                <div class="fieldhistory">
                    <fieldset>
                        <legend>
                            <h3>Filtros</h3>
                        </legend>
                        <table>

                            <tr>
                                <td><label for="sensor">Sensor que genera el evento</label></td>
                                <td><select name="sensor">
                                        <option></option>
                                        <option value='1'>1 Sensor de Luz ldr</option>
                                        <option value='2'>2 Sensor de Humedad</option>
                                        <option value='3'>3 Sensor de Temperatura</option>
                                        <option value='4'>4 Detector Volum&eacute;trico</option>
                                        <option value='5'>5 Detector de Incendio</option>
                                        <option value='6'>6 Detector de Inundación</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td><label for="statuschange">Por cambio de estado</label></td>
                                <td><input type="radio" name="statuschange-or-all" id="statuschange"
                                        value='statuschange' checked></td>
                            </tr>
                            <tr>
                                <td><label for="todos-los-eventos">Todos los eventos</label></td>
                                <td><input type="radio" name="statuschange-or-all" id="todos-los-eventos"
                                        value='todos-los-eventos'></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><label for="alarma">Alarma</label></td>
                                <td><input type="radio" name="status" id="alarma" value='alarma'></td>
                            </tr>
                            <tr>
                                <td><label for="reposo">Reposo</label></td>
                                <td><input type="radio" name="status" id='reposo' value='reposo'></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td><button type='submit' class='boton' id='search' name='search'
                                        value='search'>Buscar</button>
                                    <button type='reset' class='boton' id='reset' name='reset' value='reset'>Restablecer
                                        b&uacute;squeda</button>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
            </form>

            <?php
/* 2_ Si es recibido el formulario llamo a a la función showRequestEvents ->3*/
if (isset($_POST['searchEvents'])) {
    $objSqlPage = new SqlObj();
    $objSqlPage = HistoryEvents::showRequestEvents();
     $objSqlPage->setPage(1);//Para que me muestre la pge 1 first time
     $allEventspage = [];
     $allEventspage = EventService::searchTempEvents($objSqlPage);
     HistoryEvents::showTempEvents($allEventspage);
}


//Si recibo el formulario de paginación vuelvo a llamar a la función que lee formularios
if (isset($_POST["createformtempevents"])){ 
    $objSqlPage = new SqlObj();
    $objSqlPage = HistoryEvents::searchEvents();//13
    HistoryEvents::menuObj($objSqlPage);/*14 Vuelvo a mostrar la búsqueda original y llamoa 15 :*/
    $allEventspage = [];
     //16 _ devuelve un array de Event con el limit de la página seleccionada
    $allEventspage = EventService::searchTempEvents($objSqlPage);
    HistoryEvents::showTempEvents($allEventspage);
}
?>
</div>
        </div>
    </main>
            <script src="/View/js/jquery-3.6.0.min.js"></script>
            <script src="/View/js/pagination.js"></script>
            <link href='/View/styles/contenidoform.css' rel='stylesheet' type='text/css' />
</body>

</html>
<?php
/**
 * documented class
 * clase que realiza todas las funciones de vista del histórico
 *  y llama a EventService cuando es necesario
 */
class HistoryEvents
{
    /**
     * documented function long description
     * 3_ Función que llama a requestEvents() ->4 que a su vez llama a la
     * función receptora del formulario searchEvents -> y le pasa el SqlObj al servicio,
     * para que lo pase al DAO y recibir el SqlObj con los datos totales a paginar
     * Luego con el SqlObj recibido, crea el menú de paginación llamando a menuObj()y 
     * pasándole dicho objeto como parámetro
     * @return type SqlObj
     **/
    public static function showRequestEvents()//3
    {

        $objSqlReq = new SqlObj();


        $objSqlReq = self::requestEvents();//4 viene del 9 SqlObj con los datos de la consulta

        //objeto que crea el menu de paginacion
        self::menuObj($objSqlReq);//->10
        return $objSqlReq;
    } //End function showRequestEvents

        /**
     * documented function summary
     * 4_ Crea un SqlObj con la función que escucha al formulario, seachEvents() ->5
     * Con este objeto llamo al servicio y se lo paso como parámetro EventService::searchEvents($objSqlForm)->6
     * documented function long description
     *
     * @return type SqlObj object
     * @throws conditon que la llamada al servicio que llama al DAO sea correcta,
     * si no devuelve un objeto vacío
     **/
    public static function requestEvents()//4
    {

        //Creo el objeto a enviar y a recibir
        {
            //Este objeto es creado en searchEvents al recibir el form de búsqueda
            $objSqlForm = self::searchEvents();//5

        }  //End  searchEvents
        $objSqlReq = new SqlObj();
         if (isset($objSqlForm) and !empty($objSqlForm)) {

            try {

               $objSqlReq = EventService::searchEvents($objSqlForm);//6 al 9 
                //Va hasta el DAO y devuelve un SqlObj con los datos dela consulta
                return $objSqlReq;
            } catch (\Throwable $th) {
                echo $th->getFile();
                echo $th->getLine();
                echo $th->getMessage();
            }
        } //End if isset objSqlForm 
        return $objSqlReq;
    } //End requestEvents
    /**
     * documented function summary
     * 5_ y 13_ Función que recibe el formulario búsqueda 
     * en el historial de eventos y el botón de la paginación
     * documented function long description
     * @return type object SqlObj
     **/
    public static function searchEvents()//5 y 13
    {

        if (
            isset($_POST['date_start']) and !empty($_POST['date_start']) and
            (isset($_POST['date_end']) and !empty($_POST['date_end']))
        ) {
            //echo '<br>'.$_POST['datenowquery'].'<br>' ;
            $objSqlForm = new SqlObj();

            if (isset($_POST['sensor']) and !empty($_POST['sensor'])) {
                $objSqlForm->setSensor($_POST['sensor']);
                 //echo '<br><br><div><label>Sensor: </label><input type="text" readonly value='.$objSqlForm->getSensor() .' size=1></div>';
            }
            if (isset($_POST['status']) and !empty($_POST['status'])) {
                $objSqlForm->setStatus($_POST['status']);
                 //  echo '<br><label for = "Estado">Estado: </label><input type="text" name="status" readonly value='.$objSqlForm->getStatus() .' size=2></div>';
            }
            if (isset($_POST['date_start']) and !empty($_POST['date_start'])) {
                $objSqlForm->setDateStart($_POST['date_start']);
                   //echo '<br><br><br><div><label>Inicio: </label><input type="text" readonly value='.$objSqlForm->getDateStart() .' size=7></div>';
            }
            if (isset($_POST['date_end']) and !empty($_POST['date_end'])) {
                $objSqlForm->setDateEnd($_POST['date_end']);;
                //echo '<br><br><div><label>Fin:   </label><input type="text" readonly value='.$objSqlForm->getDateEnd() .' size=15></div></form>';
            }
            //Estas comprobaciones son para la paginacion
            if (isset($_POST['rowcount']) and !empty($_POST['rowcount'])) {
                $objSqlForm->setRowcount($_POST['rowcount']);
               // echo '<br><br><div><label>Fin:   </label><input type="text" readonly value='.$objSqlForm->getRowcount() .' size=15></div></form>';
            }
            if (isset($_POST['datenowquery']) and !empty($_POST['datenowquery'])) {
                $objSqlForm->setNowQuery($_POST['datenowquery']);
               // echo '<br><div><label>Fin:   </label><input type="text" readonly value='.$objSqlForm->getNowQuery() .' size=15></div></form>';
            }
            if (isset($_POST['page']) and !empty($_POST['page'])) {
                $objSqlForm->setPage($_POST['page']);
               // echo '<br><div><label>Fin:   </label><input type="text" readonly value='.$objSqlForm->getPage() .' size=15></div></form>';
            }
            if (isset($_POST['statuschange-or-all']) and !empty($_POST['statuschange-or-all'])) {
                //echo '<br><br>'.$_POST['statuschange-or-all'];
                if ($_POST['statuschange-or-all'] == 'statuschange') {
                   $statuschange = 'statuschange';
                    $objSqlForm->setStatuschange($statuschange);
                //echo '<br><div><label>status change   </label><input type="text" readonly value='.$objSqlForm->getStatuschange() .' size=15></div></form>';
                 }
            }
            return $objSqlForm;
        } else {
            echo "<h3> Debe seleccionar el Per&iacute;odo</h3>";
        } //End if else isset dates


    } //End function searchEvents


/**
 * documented function summary
 * 10_ Recibe desde el servicio y el DAO un SqlObj con los datos 
 * de la consulta original y los muestra
 * ->11 Llama a la funcion createFormTempEvents
 * que muestra los botones con número de página
 * documented function long description
 *
 * @param SqlObj 
 * @return type
 * @throws conditon
 **/
public static function menuObj($objSqlReq)//10
{

    $rowcount = 0;
    if (isset($objSqlReq) ) {
        if ($objSqlReq->getRowcount() != null ) {
            $rowcount = ($objSqlReq->getRowcount()) ? $objSqlReq->getRowcount() : 0;
 
            if ($rowcount > 16000) 
                echo "<p><h3 style='color:red; font-weight:bold;'>Demasiados eventos, acota tu b&uacute;squeda</h3></p><br>";
    }
        try {
            //también definí pageRecords en el dao para no enviarlo
            $pageRecords = 100;

            if ($rowcount >= 0) {

                echo "Evento buscado : ";
                $totalPages = ($rowcount > $pageRecords) ? ceil($rowcount / $pageRecords) : 1;
    ?>
<!--Pongo el total de páginas para saber cuantos option tiene que haber en el eselect de las páginas-->
<input type="hidden" value="<?php echo $totalPages ?>" id="totalpages">
<label for="sensor">Sensor: </label>
<input name="sensor" readonly value="<?php echo $objSqlReq->getSensor(); ?>" size=1>
<label for="status">Estado: </label>
<input name="status" readonly value="<?php echo $objSqlReq->getStatus(); ?>" size=3>
<label for="date_start">Inicio: </label>
<input name="date_start" readonly value="<?php echo $objSqlReq->getDateStart(); ?>" size=7>
<label for="date_end">Antes de : </label>
<input name="date_end" readonly value="<?php echo $objSqlReq->getDateEnd(); ?>" size=7>
<label for="rowcount">Eventos encontrados: </label>
<input name="rowcount" readonly value="<?php echo $objSqlReq->getRowcount(); ?>" size=1>
<label for="datenowquery">Hora de b&uacute;squeda: </label>
<input name="datenowquery" readonly value="<?php echo $objSqlReq->getNowQuery(); ?>" size=13>
<?php $change = ($objSqlReq->getStatuschange() == 'statuschange') ? 'Si' : 'No, todos los eventos'; ?>
<p>Por cambio de estado:<?php echo ' ' . $change ?></p>


<?php
            $totalPages = ($totalPages>160) ? 160 : $totalPages ;   
            //Solo creo el formulario si rowcount es diferente de 0
            if($rowcount == 0)
            echo "<p><h3 style='color:red; font-weight:bold;'>Eventos no encontrados</h3></p><br>";
            else {  
                echo "<button id='inicio' class='btn-ini-end'>Inicio</button>";

                // Construyo un select para elegir la pagina y enviarlo por javascript   
                ?>
 &nbsp; 
<label for="page">P&aacute;gina</label></td>
<td><select name="pagina" id="selcted" required>
        <?php
            echo "<option></option>"  ;  
                 for ($i = 1; $i <= $totalPages; $i++) 
                { ?>
        <option value="<?php  echo $i  ?>"><?php  echo $i  ?></option>
        <?php
                 }
                echo "</select>"; 
                echo  " &nbsp; &nbsp;";
                echo "<button id='fin' class='btn-ini-end'>Fin</button>";

                for ($i = 1; $i <= $totalPages; $i++) {
                    self::createFormTempEvents($objSqlReq, $i,$i);//11
                } //Enf for paginas  */

  
         
            }//End else rowcount = 0

            } //End if rowcount >0

        } catch (\Throwable $th) {
            echo $th->getFile();
            echo $th->getLine();
            echo $th->getMessage();
        } //End catch      
    } //End if isset objSqlReq  

} //End function menuObj


/**
 * documented function summary

 * documented function long description
 * 11_ Función que muestra los botones de las páginas
 * Cada botón tiene oculto un formulario con el objeto devuelto por el DAO
 * de las características de la consulta original y la página que queremos llamar
 * @param SqlObj $var Description SqlObj que contiene los parámetros devueltos por el DAO de la consulta original
 * Este form es recibido por la misma funcion que el otro: searchEvents();
 * @return type void
 **/
    public static function createFormTempEvents($objSqlReq, $i, $pag)//11 ->12
    {
?>

        <form action="" method="post" name="formTempEvents" id="<?php  $pag ?>" class="formtempevents">
            <input type="hidden" name="createformtempevents" value="createformtempevents">
            <input name="sensor" type="hidden" readonly value="<?php echo $objSqlReq->getSensor(); ?>" size=1>
            <input name="status" type="hidden" readonly value="<?php echo $objSqlReq->getStatus(); ?>" size=2>
            <input name="date_start" type="hidden" readonly value="<?php echo $objSqlReq->getDateStart(); ?>" size=6>
            <input name="date_end" type="hidden" readonly value="<?php echo $objSqlReq->getDateEnd(); ?>" size=6>
            <input name="rowcount" type="hidden" readonly value="<?php echo $objSqlReq->getRowcount(); ?>" size=1>
            <input name="datenowquery" type="hidden" readonly value="<?php echo $objSqlReq->getNowQuery(); ?>" size=6>
            <input name="statuschange-or-all" type="hidden" readonly
                value="<?php echo $objSqlReq->getStatuschange(); ?>" size=2>
            <br>
            <input name="page" type="hidden" value="<?php echo $i ?>">
            <input type="submit" name="eventssearched" style="display:none"
                value="<?php echo $pag ?>"></input>
        </form>
        <!--style='font-size:1.2rem;font-weight:bold;color:blue;'-->

        <?php
    } //End function createFormTempEvents



    /**
     * documented function summary
     * 12_ esta funcion recibe el form con los botones de
     * paginacion que createFormTempEvents da 
     * con el resultado de la query original
     * documented function long description
     *
     * @param Type $var array de eventos
     * @return type void
     * @throws conditon
     **/
     public static function showTempEvents($allEventsToShow)//17
    {
            //echo var_dump($allEventsToShow);
            if (isset($allEventsToShow) and !empty($allEventsToShow)) {
                ?>


        <table class="table">

            <h2> EVENTOS</h2>

            <thead>
                <tr>
                    <!-- <th><span class="notranslate">Id</span></th> -->
                    <th>Sensor</td>
<th>Estado</th>
<th>Valor</th>
<th>Hora</th>
<!-- <th> &nbsp;</th>
            <th> &nbsp;</th> -->
</tr>
</thead>
<colgroup>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
</colgroup>
<tbody>
    <?php


                foreach ($allEventsToShow as $event) {
                    echo
                    '<tr>
            <td>' . $event->getSensorName($event->getSensor_id()) . ' </td>' .
                        '<td>' . $event->getStatus() . ' </td>' .
                        '<td>' . $event->getValue() . ' </td>' .
                        '<td>' . $event->getDate() . ' </td>';

                } //end foreach $allEvents
              echo  '</tbody>
                </table>';
            } //End if Isset $allEvents
      
    } //End function showTemp>Events

} //End class HistoryEvents


        ?>