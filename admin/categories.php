
<?php
require_once __DIR__ . '/../include/init.php';
adminSecurity(); 

// lister les catégories dans un tableau HTML

// la requête ici

$stmt = $pdo->query ('SELECT * FROM categorie');
$categories = $stmt -> fetchAll();
/*echo '<pre>';
var_dump($categories);
echo '</pre>';
 */


require __DIR__ . '/../layout/top.php';
?>
<h1>Gestion catégories</h1>

<p><a href="categorie-edit.php">Ajouter une catégorie</a></p>

<!--  Le tableau HTML ici -->
    
<?php 
/*
echo '<table border="1">';

    echo '<tr>'
    . '<th>Id</th>'
    . '<th>Nom</th>'
    . '<th width="250px"></th>'
    . '<tr>';
   
    foreach ($categories as $key => $value){
        echo '<tr>'
        . '<td>' .$value['id'] .'</td>'
        . '<td>' .$value['nom'] .'</td>'
        . '</tr>' ;
        }
echo'</table>';*/

?>

<table class="table">
   <tr>
       <th>ID</th>
       <th>NOM</th>
   </tr>
   <?php
   foreach ($categories as $categorie) :
   ?>
   <tr>
       <td><?= $categorie['id']; ?></td>
       <td><?= $categorie['nom']; ?></td>
       <td>
           <a class="btn btn-primary" href="categorie-edit.php?id=<?=$categorie['id']; ?>">
           Modifier</a>
           <a class="btn btn-danger" href="categorie-delete.php?id=<?=$categorie['id']; ?>">
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
