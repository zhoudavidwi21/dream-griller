<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form id="productForm">
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
                            <input type="number" class="form-control" id="productRating" name="productRating" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Product Categories -->
                <div class="mb-3">
                    <label for="productCategories" class="form-label fw-bold">Kategorie</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gas-griller" id="categoryGasGriller" name="productCategories">
                            <label class="form-check-label" for="categoryGasGriller">Gas Griller</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="charcoal-griller" id="categoryCharcoalGriller" name="productCategories">
                            <label class="form-check-label" for="categoryCharcoalGriller">Kohle Griller</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="portable" id="categoryPortable" name="productCategories">
                            <label class="form-check-label" for="categoryPelletGriller">Pellet Griller</label>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="productImage" class="form-label fw-bold">Bild</label>
                    <input type="file" class="form-control" id="productImage" name="productImage">
                </div>

                <button id="addProductButton" type="submit" class="btn btn-registrieren">Produkt hinzufügen</button>
            </form>
        </div>
    </div>
</div>
<script src="../js/addProduct.js"></script>
