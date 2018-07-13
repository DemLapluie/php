<?php
require_once __DIR__ . '/../include/init.php';
adminSecurity(); 


//faire la page qui liste les produits dans un tableau HTML
// tous les champs sauf la description
//bonus : 
//Afficher le nom de la catégorie au lieu de son id

$query = <<<SQL
        SELECT p.*, c.nom as cnom FROM produit p INNER JOIN categorie c ON p.categorie_id = c.id
SQL;

$stmt = $pdo->query($query);
$produits = $stmt -> fetchAll();
require __DIR__ . '/../layout/top.php';
?>

<h1>Gestion Produits</h1>
<p><a href="produits-edit.php">Ajouter un produit</a></p>

<table class="table">
   <tr>
       <th>ID</th>
       <th>NOM</th>
       <th>PRIX</th>
       <th>REFERENCE</th>
       <th>CATEGORIE</th>
   </tr>
   <?php
   foreach ($produits as $produit) :
   ?>
   <tr>
       <td><?= $produit['id']; ?></td>
       <td><?= $produit['nom']; ?></td>
       <td><?= prixFR( $produit['prix']); ?></td>
       <td><?= $produit['reference']; ?></td>
       <td><?= $produit['cnom']; ?></td>
       <td>
           <a class="btn btn-primary" href="produits-edit.php?id=<?=$produit['id']; ?>">
           Modifier</a>
           <a class="btn btn-danger" href="produits-delete.php?id=<?=$produit['id']; ?>">
           Supprimer</a>
           
       </td>

   </tr>
   <?php
   endforeach;;
   ?>
</table>
<?php
require __DIR__ . '/../layout/bottom.php';
?>