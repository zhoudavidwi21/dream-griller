<?php include "./res/templates/sessions.php"; ?>

<?php
//Only logged in person can administrate profiles
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>
<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Produkt bearbeiten</h1>
<!--
  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
-->

<!--
  <h2 class="mt-5">Hallo
    <?php //echo $_SESSION["username"]; ?>! <br>
    <h4>Hier können Sie Ihre Daten ändern ...</h4>
  </h2>
-->

</div>

<div class="custom-container mt-5">
    <form id="productChangeForm" method="POST">
    <div class="row">
        <div class="col-md-6 mb-3">
          <label for="form_productId" class="form-label">Produkt-ID (nicht änderbar)</label>
          <input type="text" class="form-control" id="form_productId" name="form_productId" value="<?php echo $_GET['id']?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label for="form_productName" class="form-label">Name</label>
          <input type="text" class="form-control" id="form_productName"  name="form_productName" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="form_productPrice" class="form-label">Preis</label>
          <input type="number" class="form-control" id="form_productPrice" step="0.01" name="form_productPrice" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="form_productRating" class="form-label">Bewertung</label>
          <input type="number" class="form-control" id="form_productRating" step="0.1" name="form_productRating" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="form_imagePath" class="form-label">Bildpfad</label>
          <input type="text" class="form-control" id="form_imagePath" name="form_imagePath" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="form_description" class="form-label">Beschreibung</label>
          <textarea class="form-control" id="form_description" rows="3" name="form_description"></textarea>
        </div>
      </div>

    <div class="mb-3">
        <label for="productCategories" class="form-label fw-bold">Kategorie</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="gas" id="form_productCategoriesGas"
                        name="form_productCategoriesGas">
                <label class="form-check-label" for="categoryGas">Gas Griller</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="charcoal" id="form_productCategoriesCharcoal"
                        name="form_productCategoriesCharcoal">
                <label class="form-check-label" for="categoryCharcoal">Kohle Griller</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="pellet" id="form_productCategoriesPellet"
                        name="form_productCategoriesPellet">
                <label class="form-check-label" for="categoryPellet">Pellet Griller</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="sale" id="form_productCategoriesSale"
                        name="form_productCategoriesSale">
                <label class="form-check-label" for="categorySale">Verkauf</label>
            </div>
        </div>
    </div>

      <div class="row" id="productChangeSuccess" style="display: none">
        <div class="col-md-6 mb-3">
          <div class="alert alert-success">
          Änderungen erfolgreich gespeichert!
          </div>
        </div>
      </div>
      <div class="row" id="productChangeFail" style="display: none">
        <div class="col-md-6 mb-3">
          <div class="alert alert-danger">
          Änderungen fehlgeschlagen!
          </div>
        </div>
      </div>
      
      <button id="changeProductButton" type="submit" class="btn btn-registrieren">Änderungen speichern</button>
    </form>
  </div>