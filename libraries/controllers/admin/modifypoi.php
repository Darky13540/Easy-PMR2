<?php

require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

if (isset($_SESSION)) {

    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

if (isset($_POST['delete'])) {
    deletePoi($pdo, $_GET['id']);
    addFlash('success', 'La suppression a bien été faite');
    header('Location: poiadmin');
    exit();
}
    if(isset(
    $_POST['name']) 
    && isset($_POST['longitude']) 
    && isset($_POST['latitude']) 
    && isset($_POST['genre']) 
    && isset($_POST['type']) 
    && isset($_POST['adresse']) 
    && isset($_POST['cp']) 
    && isset($_POST['commune']) 
    && isset($_POST['opening']) 
    && isset($_POST['phone']) 
    && isset($_POST['website'])){
   
        editPoi($pdo, $_POST['name'], 
                    $_POST['latitude'], 
                    $_POST['longitude'], 
                    $_POST['genre'], 
                    $_POST['type'], 
                    $_POST['adresse'], 
                    $_POST['cp'], 
                    $_POST['commune'], 
                    $_POST['opening'],
                    $_POST['phone'], 
                    $_POST['website'],
                    $_GET['id']);


            /* if(isset($_FILES['picture'])){ */
                if ($_FILES['picture']['name'] !== ""){
                    
                    //Seules les images .png et .jpeg sont autorisées
                    $allowedFiletypes = ['image/png', 'image/jpeg'];
                    //le type est bien dans le array il faut le renommer
                    
                    //On teste le type
                    if (in_array(mime_content_type($_FILES['picture']['tmp_name']), $allowedFiletypes)){
                        /* var_dump(in_array(mime_content_type($_FILES['picture']['tmp_name']), $allowedFiletypes));
                        die; */
                        
                        switch(mime_content_type($_FILES['picture']['tmp_name'])){

                            case 'image/png':
                                $fileName = $_GET['id'].'.png';
                                break;
                            case 'image/jpeg':
                                $fileName = $_GET['id'].'.jpg';
                                break;


                        }
                                
                        // on déplace le fichier dans le dossier d'upload
                        $resultMoveFile = move_uploaded_file($_FILES['picture']['tmp_name'], "upload/".$fileName);

                        //Test pour savoir si le fichier a bien été déplacé dans le dossier upload
                        if ($resultMoveFile){
                            $queryFile = ', Photo = ?';
                        }

                        //upload du lien dans la BDD
                        updatePoiImage($pdo, intval($_GET['id']), htmlspecialchars($fileName));
                    }
            
            
            
                /* } */
            }




        addFlash('success', 'La modification est prise en compte');
        header('Location: poiadmin');
        exit();
        
    }
    

    $shop = getPoiById($pdo, $_GET['id']);
    $types = getTypes($pdo);
    $genres = getGenre($pdo);

$template = 'editpoi.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');