<?php
include_once('lib/auth.php');
include_once('lib/nonce.php');

header('Content-Type: application/json');

// input validation
if (empty($_REQUEST['action']) || !preg_match('/^\w+$/', $_REQUEST['action'])) {
	echo json_encode(array('failed'=>'undefined'));
	exit();
}

//
// The following calls the appropriate function based to the request parameter $_REQUEST['action'],
//   (e.g. When $_REQUEST['action'] is 'cat_insert', the function ierg4210_cat_insert() is called)
// the return values of the functions are then encoded in JSON format and used as output
try {
	if (($returnVal = call_user_func('ierg4210_' . $_REQUEST['action'])) === false) {
		if ($db && $db->errorCode()) 
			error_log(print_r($db->errorInfo(), true));
		echo json_encode(array('failed'=>'1'));
	}
	
    if (!ierg4210_auth()) {
	    header('Location: main.php', true, 302);
    } else {
        global $db;
        $db = ierg4210_DB();
        $q=$db->prepare('SELECT * FROM USER WHERE email = ?'); 
        $q->execute(array($_POST['email']));
        if ($r = $q->fetch()) {
            if ($r['flag'] == "1")
                header('Location: admin.php', true, 302);
	        if ($r['flag'] == "0")
                header('Location: main.php', true, 302);
        }
    }

	csrt_verifyNonce($_REQUEST['action'], $_POST['nonce']);
	echo 'while(1);' . json_encode(array('success' => $returnVal));
} catch(PDOException $e) {
	error_log($e->getMessage());
	echo json_encode(array('failed'=>'error-db'));
} catch(Exception $e) {
	echo 'while(1);' . json_encode(array('failed' => $e->getMessage()));
}

?>
