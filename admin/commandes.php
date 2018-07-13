<?php

/* 
Lister les commandes dans un tableau HTML : 
 * id de la commande
 * nom prénom de l'utilisateur qui a passé la commande
 * montant formaté
 * date de la commande
 * statut
 * date du statut
Passer le statut en liste déroulante avec un bouton Modifier
 * pour changer le satut de la commande en bdd (nécessité
 * d'un champ caché pour l'id de la commande
 */

require_once __DIR__ . '/../include/init.php';
adminSecurity(); 

require __DIR__ . '/../layout/top.php';
?>
        <h1>Vos commandes</h1>
        
<?php 

if (isset($_POST['modifierStatut'])) {
    dump($_POST['statut']);
    $query = <<<SQL
UPDATE commande SET 
    statut = :statut,
    date_statut = now()
WHERE id = :id 
SQL;
    
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':statut'   => $_POST['statut'],
            ':id'       => $_POST['commandeId']
        ]);
        setFlashMessage('Le statut de la commande est modifié');
}

$query = <<<SQL
     SELECT c.*, concat_ws(' ', u.prenom, u.nom) AS utilisateur
     FROM commande c 
     JOIN utilisateur u 
     ON c.utilisateur_id = u.id 
SQL;

$stmt = $pdo->query($query);
$commandes = $stmt -> fetchAll();

$statuts = [
    'en cours', 'envoyé', 'livré', 'annulé'
]
        
?>
        
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Utilisateur</th>
      <th scope="col">Montant</th>
      <th scope="col">Date de la commande</th>
      <th scope="col">Statut</th>
      <th scope="col">Date du Statut</th>
    </tr>
  </thead>
  <tbody>
   <?php
   foreach ($commandes as $commande) :
   ?>
    <tr>
      <td><?= $commande['id']?></td>
      <td><?= $commande['utilisateur']?></td>
      <td><?= prixFR( $commande['montant_total'])?></td>
      <td><?= datetimeFR($commande['date_commande'])?></td>
      <td><form method="post" class="form-inline">
          <select name="statut" class="form-control">
              <?php
              foreach ($statuts as $statut) :
                  $selected=($statut == $commande['statut'])
                      ? 'selected'
                      :''
                   ;
              ?>
              <option value="<?= $statut; ?>" <?= $selected; ?>><?= $statut ?></option>
              <?php
               endforeach;
              ?>
          </select>
              <input type="hidden" name="commandeId" value="<?= $commande['id']; ?>">
              <button type="submit"
                      name="modifierStatut"
                      class="btn btn-primary">
                  Modifier
              </button>
      
      <form></td>
      <td><?= datetimeFR($commande['date_statut'])?></td>
    </tr>
    <?php
    endforeach;
   ?>
  </tbody>
</table>
  
        
<?php
require __DIR__ . '/../layout/bottom.php';
?>


