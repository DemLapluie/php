<?php

/* 
 * Faire le formulaire d'édition de produit
 * - nom : champ text - obligatoire
 * - description:champ textarea - obligatoire
 * - référence : champ text - obligatoire
 * - prix champ text - obligatoire
 * - catégorie : liste déroulante - obligatoire
 * 
 * Si le formulaire est correctement rempli: INSERT en bdd
 * et la redirection vers la page de liste avec message de confirmation
 * sinon message d'erreurs
 * 
 * Adapter la page pour la modification
 * - Si on reçoit un id dans l'URL sans retour de POST, 
 * pré-remplissage du formulaire de la bdd
 * - enregistrement avec UPDATE au lieu d'INSERT
 * - adapter le contrôle de l'unicité de la référence pour exclure
 * la référence du produit que l'on modifie de la requête
 */

require_once __DIR__ . '/../include/init.php';
adminSecurity();

$errors = [];
$produits = $prix = $nom = $description = $reference = $categorie  = '';

$query = <<<SQL
        SELECT nom
        FROM categorie
SQL;

$stmt = $pdo->query($query);
$categorie = $stmt -> fetchAll();

if (!empty($_POST)) { 
   sanitizePost();
   extract($_POST);
   if(empty($_POST['nom'])) {
       $errors[] = 'Le nom est obligatoire';    
   }
   if(empty($_POST['description'])) {
       $errors[] = 'La description est obligatoire';    
   }

   if(empty($_POST['reference'])) {
       $errors[] = 'Le champ de référence est obligatoire';    
   } elseif (strlen($_POST['reference'])> 50) {
       $errors[] = 'La reference ne doit pas faire plus de 50 caractères';
   }else{
        $query = 'SELECT count(*) FROM produits WHERE reference = :reference'; 
        $stmt = $pdo->prepare($query);
        $stmt->execute([':reference' => $_POST['reference']]);
        $nb = $stmt-> fetchColumn();
        
        if($nb != 0) {
            
            $errors[] = 'La reference doit être unique';
            }
    }
   
   if(empty($_POST['prix'])) {
       $errors[] = 'Le prix est obligatoire';    
   } 
   
   
   // si le formulaire est correctement rempli
   if(empty($errors)){
       $query ='INSERT INTO produits(nom,description,reference, prix, categorie_id) VALUES (:nom, :description, :reference, :prix, :categorie_id)';
       $stmt = $pdo->prepare($query);
       $stmt->execute([
           ':nom' => $nom,
           ':description' => $description,
           ':reference' => $reference,
           ':prix' => $prix,
           ':categories' => $categorie,
            ]);
       
            setFlashMessage('Le produit est enregistré');
            header('Location: produits.php');
            die;
       } else{
           $query = 'SELECT * FROM produit WHERE id = '. (int)$_GET['id'];
           $stmt = $pdo->prepare($query);
           $stmt-> execute([
               ':nom' => $nom,
               ':id' => $_GET['id']
               
               ]);
        }
   } /*
}elseif(isset($_GET['id'])){
    // en modification, si on n'a pas de retour de formulaire
    // on va chercher la catégorie en BDD pour affichage
    $stmt= $pdo->query('SELECT * FROM categorie WHERE id='.(int)$_GET['id']);
    $stmt = $pdo->query($query);
    $categorie = $stmt->fetch();
    $nom = $categorie['nom'];    */
}

require __DIR__ . '/../layout/top.php';

if (!empty($errors)) : 
    
    

    
    
?>
<div class="alert alert-danger">
   <h5 class="alert-heading">Le formulaire contient des erreurs</h5>
   <?= implode('<br>', $errors); // transforme un tableau en chaine de caracteres
?>
</div>
<?php
endif;
?>
<h1>Edition catégorie</h1>


<form method="post">
   <div class="form-group">
       <label>Nom</label>
       <input type="text" name="nom" class="form-control" value="<?= $nom ; ?>">
   </div>
    <div class="form-group">
       <label>Description</label>
       <textarea type="text" name="description" class="form-control" ><?= $description; ?> </textarea>
   </div>
    <div class="form-group">
       <label>Référence</label>
       <input type="text" name="reference" class="form-control" value="<?= $reference; ?>">
   </div>
    <div class="form-group">
       <label>Prix</label>
       <input type="text" name="prix" class="form-control" value="<?= $prix; ?>">
   </div>
    <div class="form-group">
       <label>Catégorie</label>
       <select name="categorie" class="form-control">
            <option value=""></option>
            <option value="Pull" <?php if ($categorie == 'Pull') {echo 'selected';} ?>>Pull</option>
            <option value="Manteau." <?php if ($categorie == 'Manteau') {echo 'selected';} ?>>Manteau</option>
            <option value="Jean." <?php if ($categorie == 'Jean') {echo 'selected';} ?>>Jean</option>
        </select>
   </div>
   <div class="form-btn-group text-right">
       <button type="submit" class="btn btn-primary">
           Enregistrer
       </button>
       <a class="btn btn-secondary" href="categories.php">
           Retour
       </a>
   </div>
</form>
<?php
require __DIR__ . '/../layout/bottom.php';
?>