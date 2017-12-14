<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($estudiantes);
      print_r($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $No_control = $request->getParam('No_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $apellido_p_estudiante = $request->getParam('apellido_p_estudiante');
    $apellido_m_estudiante = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = 	"INSERT INTO estudiante (No_control, nombre_estudiante, apellido_p_estudiante, apellido_m_estudiante, semestre, carrera_clave) VALUES (:No_control, :nombre_estudiante, :apellido_p_estudiante, :apellido_m_estudiante, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',                  $No_control);
        $stmt->bindParam(':nombre_estudiante',           $nombre_estudiante);
        $stmt->bindParam(':apellido_p_estudiante',       $apellido_p_estudiante);
        $stmt->bindParam(':apellido_m_estudiante',       $apellido_m_estudiante);
        $stmt->bindParam(':semestre',                    $semestre);
        $stmt->bindParam(':carrera_clave',               $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $No_control = $request->getParam('No_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $apellido_p_estudiante = $request->getParam('apellido_p_estudiante');
    $apellido_m_estudiante = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                No_control              = :No_control,
                nombre_estudiante       = :nombre_estudiante,
                apellido_p_estudiante   = :apellido_p_estudiante,
                apellido_m_estudiante   = :apellido_m_estudiante,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE No_control = $No_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',      $No_control);
        $stmt->bindParam(':nombre_estudiante',         $nombre_estudiante);
        $stmt->bindParam(':apellido_p_estudiante',      $apellido_p_estudiante);
        $stmt->bindParam(':apellido_m_estudiante',      $apellido_m_estudiante);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//carreras

// Obtener todas las carreras

$app->get('/api/carrera', function(Request $request, Response $response){
	//echo "materias";
	$sql = "select * from carrera";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($carrera);
      print_r($carrera);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//buscar carrera por clave

$app->get('/api/carrera/{clave_carrera}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_carrera');

    $sql = "SELECT * FROM carrera WHERE clave_carrera = '$clave_instituto'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clave_instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //echo  json_encode($clave_instituto);
        print_r($clave_instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave_carrera = $request->getParam('clave_carrera');
    $nombre_carrera = $request->getParam('nombre_carrera');


    $sql = "INSERT INTO carrera (clave_carrera, nombre_carrera) VALUES (:clave_carrera, :nombre_carrera)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_carrera', $clave_carrera);
        $stmt->bindParam(':nombre_carrera',$nombre_carrera);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/carrera/update/{clave_carrera}', function(Request $request, Response $response){
    $clave = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_carrera');


    $sql = "UPDATE carrera SET
                clave_carrera        = :clave_carrera,
                nombre_carrera       = :nombre_carrera

            WHERE clave_carrera = '$clave'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_carrera',   $clave);
        $stmt->bindParam(':nombre_carrera',  $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Borrar carrera
$app->delete('/api/carrera/delete/{clave_carrera}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave_carrera');

    $sql = "DELETE FROM carrera WHERE clave_carrera = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//DEPARTAMENTO

//Obtener todos los departamentos

$app->get('/api/departamento', function(Request $request, Response $response){
    //echo "Departamento";
    $sql = "select * from departamento";

    try{
        //Get DB Object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);
        //print_r($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
// Obtener un departamento por rfc_departamento
$app->get('/api/departamento/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getAttribute('rfc_departamento');

    $sql = "SELECT * FROM departamento WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $rfc_departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rfc_departamento);
        //print_r($rfc_departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
    $trabajador_rfc = $request->getParam('trabajador_rfc');

    $sql = "INSERT INTO departamento (rfc_departamento, nombre_departamento, trabajador_rfc) VALUES (:rfc_departamento, :nombre_departamento, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',      $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',         $nombre_departamento);
        $stmt->bindParam(':trabajador_rfc',      $trabajador_rfc);

        $stmt->execute();

        echo '{"notice": {"text": "Departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar departamento
$app->put('/api/departamento/update/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
    $trabajador_rfc = $request->getParam('trabajador_rfc');

    $sql = "UPDATE departamento SET
                rfc_departamento               = :rfc_departamento,
                nombre_departamento       = :nombre_departamento,
                trabajador_rfc   = :trabajador_rfc

            WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',      $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',         $nombre_departamento);
        $stmt->bindParam(':trabajador_rfc',      $trabajador_rfc);

        $stmt->execute();

        echo '{"notice": {"text": "Departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar departamentos
$app->delete('/api/departamento/delete/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getAttribute('rfc_departamento');

    $sql = "DELETE FROM departamento WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





//instituto

$app->get('/api/institu', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institu = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($institu);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instituto por no de clave
$app->get('/api/institu/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "SELECT * FROM instituto WHERE clave_instituto = '$clave_instituto'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clave_instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //echo  json_encode($clave_instituto);
       print_r($clave_instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Agregar un instituto
$app->post('/api/institu/add', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');


    $sql = 	"INSERT INTO instituto (clave_instituto, nombre_instituto) VALUES (:clave_instituto, :nombre_instituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',      $clave_instituto);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);


        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Actualizar instituto
$app->put('/api/institu/update/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');



    $sql = "UPDATE instituto SET
                clave_instituto        = :clave_instituto,
                nombre_instituto       = :nombre_instituto
								

            WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',   $clave_instituto);
        $stmt->bindParam(':nombre_instituto',  $nombre_instituto);



        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instituto
$app->delete('/api/institu/delete/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "DELETE FROM instituto WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





//trabajador

//todos los trabajadores
$app->get('/api/trabajador', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($trabajador);
        print_r($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un trabajador por rfc
$app->get('/api/trabajador/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "SELECT * FROM trabajador WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un trabajador
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');


    $sql = 	"INSERT INTO trabajador (rfc_trabajador, nombre_trabajador,apellido_p,apellido_m,clave_presupuestal) VALUES (:rfc_trabajador,:nombre_trabajador,:apellido_p,:apellido_m,:clave_presupuestal)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',          $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',       $nombre_trabajador);
        $stmt->bindParam(':apellido_p',              $apellido_p);
        $stmt->bindParam(':apellido_m',              $apellido_m);
        $stmt->bindParam(':clave_presupuestal',      $clave_presupuestal);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar trabajador
$app->put('/api/trabajador/update/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');



    $sql = "UPDATE trabajador SET
           rfc_trabajador            = :rfc_trabajador,
           nombre_trabajador         = :nombre_trabajador,
           apellido_p                = :apellido_p,
           apellido_m                = :apellido_m,
           clave_presupuestal        = :clave_presupuestal
								

            WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',   $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',  $nombre_trabajador);
        $stmt->bindParam(':apellido_p',   $apellido_p);
        $stmt->bindParam(':apellido_m',   $apellido_m);
        $stmt->bindParam(':clave_presupuestal',   $clave_presupuestal);



        $stmt->execute();

        echo '{"notice": {"text": "trabajor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajador/delete/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "DELETE FROM trabajador WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



