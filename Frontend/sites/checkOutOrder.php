<?php include "./res/templates/sessions.php"; ?>

<?php
//Only logged in person can view orders
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Bestellübersicht</h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>

</div>

<div class="row container-fluid justify-content-center mt-4">
    <table class="table table-checkout">
      <thead>
        <tr>
          <th>Produkt</th>
          <th>Menge</th>
          <th>Preis</th>
          <th>Gesamt</th>
        </tr>
      </thead>
      <tbody id="checkOutTable">
        
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><strong>Gesamt</strong></td>
          <td id="totalSumOrder"></td>
        </tr>
      </tfoot>
      
    </table>
</div>

<div class="row container-fluid justify-content-center mt-4">
  <div class="col-auto">
    <button id="submitOrder" class="btn btn-registrieren">Jetzt bestellen</button>
  </div>
</div>

<div id="checkOutSuccess" class="row container-fluid justify-content-center mt-4" style="display: none">
  <div class="col-auto">
    <div class="alert alert-success">
      Ihre Bestellung war erfolgreich!
    </div>
  </div>
</div>