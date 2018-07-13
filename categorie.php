<?php

// - afficher le nom de la catégorie dont on a reçu 
//   l'id dans l'URL en titre de la page
// - lister les produits appartenant à la catégorie 
//   avec leur photo s'ils en ont une
require_once __DIR__ . '/include/init.php';

require __DIR__ . '/layout/top.php';

 $query = 'SELECT * FROM categorie WHERE id = ' . (int)$_GET['id'];
    $stmt = $pdo->query($query);
    $categorie = $stmt->fetch();
    
 $query = 'SELECT * FROM produit WHERE categorie_id =' . (int)$_GET['id'];
 $stmt = $pdo->query($query);
 $produits = $stmt->fetchAll();
?>

    <h1><?= $categorie['nom']; ?></h1>
    
    <div class="card-deck">
        
        <?php
        foreach ($produits as $produit) :
            $src = (!empty($produit['photo']))
                ? PHOTO_WEB . $produit['photo']
                : PHOTO_DEFAULT
            ;
        ?>
            <div class="card">
                <img class="card-img-top" src="<?= $src ?>">
            
                <div class="card-body">
                    <h5 class="card-title text-center"><?= $produit['nom']; ?> </h5>
                    <p clas=""card-text text-center">
                <?= prixFR($produit['prix']); ?>
                </p>
                </div>
                <div class="card-footer">
                    <p clas=""card-text text-center">
                       <a class="btn btn-primary" href="produit.php?id=<?= $produit['id']; ?>">
                           Voir
                        </a>
                    </p>
                </div>
            </div>
        
        <?php
        endforeach;
        ?>
        
    <div>
    
<?php



?>

        
<?php
require __DIR__ . '/layout/bottom.php';
?>

    