<?php include "./res/templates/sessions.php"; ?>

<?php
//Only logged in person can manage coupons
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Bestellungen ansehen</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
</div>

<div style="display: none">
  <input type="text" id="idForOrders" value="<?php echo $_GET['idForOrders']?>">
</div>

<div class="row container-fluid justify-content-center mt-4">
    <table class="table table-fit">
        <thead>
        <tr>
            <th>ID</th>
            <th>Gesamtwert</th>
            <th>Datum</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="adminOrderTable">

        </tbody>
    </table>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Bestellungsdetails</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Rechnungsnummer: <span id="orderID"></span></h6>
                        <p>Kundennummer: <span id="customerID"></span></p>
                        <p>Kundenname: <span id="customerName"></span></p>
                        <p>Bestellungsdatum: <span id="orderDate"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Lieferadresse:</h6>
                        <p><span id="addressLine"></span></p>
                        <p><span id="postCode"></span>, <span id="city"></span></p>
                    </div>
                </div>
                <h6>Bestellte Produkte:</h6>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Menge</th>
                        <th>Preis</th>
                        <th>Summe</th>
                    </tr>
                    </thead>
                    <tbody id="orderItems"></tbody>
                </table>
                <div class="row">
                    <p><strong>Gesamtsumme: <span id="totalSum"></span></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="printInvoiceButton">Rechnung drucken</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>