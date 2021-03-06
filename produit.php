<?php
require_once __DIR__ . '/include/init.php';

require __DIR__ . '/layout/top.php';

$query = 'SELECT * FROM produit WHERE id = ' . (int)$_GET['id'];
    $stmt = $pdo->query($query);
    $produit = $stmt->fetch();

$src = (!empty($produit['photo']))
     ? PHOTO_WEB . $produit['photo']
     : PHOTO_DEFAULT
;

if(!empty($_POST)) {
    ajoutPanier($produit,$_POST['quantite']);
    // dump($_SESSION['panier']);
    setFlashMessage('Le produit est ajouté au panier');
    header('Location: produit.php?id=' . $_GET['id']);
    die;
}

?>
        <h1> <?= $produit['nom']; ?></h1>
        
        <div class="row">
            <div class="col-md-4 text-center">
                <img height="200px" src="<?= $src; ?>">
                <p><?= prixFR($produit['prix']); ?></p>
                <form method="post" class=form-inline">
                    <label>Qté</label>
                    <select name="quantite" class="form-control">
                        <?php
                        for($i = 1; $i <= 10; $i++) :
                        ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php
                        endfor;
                        ?>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary"> 
                        Ajouter au panier
                    </button>
                </form>
            </div>
            <div class="col-md-8">
                <?= nl2br($produit['description']); ?>               
            </div>
        </div>
        
        
        
<?php
require __DIR__ . '/layout/bottom.php';
?>
