<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can add products
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Produkt hinzufügen</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form id="productForm" action="" method="POST" enctype="multipart/form-data">
                <!-- Product Name -->
                <div class="mb-3">
                    <label for="productName" class="form-label fw-bold">Produkt Name</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="Griller Name">
                </div>

                <!-- Product Description -->
                <div class="mb-3">
                    <label for="productDescription" class="form-label fw-bold">Produkt Beschreibung</label>
                    <textarea class="form-control" id="productDescription" rows="3" name="productDescription" placeholder="Hier kommt die Beschreibung des Grillers hin."></textarea>
                </div>

                <!-- Product Price and Product Stock -->
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="productPrice" class="form-label fw-bold">Preis</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" class="form-control" id="productPrice" step="0.01" name="productPrice" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="productRating" class="form-label fw-bold">Bewertung</label>
                            <input type="number" class="form-control" id="productRating" step="0.1" name="productRating" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Product Categories -->
                <div class="mb-3">
                    <label for="productCategories" class="form-label fw-bold">Kategorie</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gas" id="categoryGas" name="productCategoriesGas">
                            <label class="form-check-label" for="categoryGas">Gas Griller</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="charcoal" id="categoryCharcoal" name="productCategoriesCharcoal">
                            <label class="form-check-label" for="categoryCharcoal">Kohle Griller</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="pellet" id="categoryPellet" name="productCategoriesPellet">
                            <label class="form-check-label" for="categoryPellet">Pellet Griller</label>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="productImage" class="form-label fw-bold">Bild</label>
                    <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                </div>

                <button id="addProductButton" type="submit" class="btn btn-registrieren">Produkt hinzufügen</button>
            </form>
        </div>
    </div>
</div>
