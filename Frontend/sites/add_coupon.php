<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
// Only logged-in person can add coupons
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
    header('Refresh:1; url=index.php?site=error');
    exit();
}
?>

<div class="text-center container-fluid">
    <h1 class="h1 mb-3 fw-normal">Neuen Coupon erstellen</h1>
    <div class="row justify-content-md-center">
        <div class="col-lg-2 col-md-3">
            <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png"
                 alt="Dreamgriller Logo" width="144" height="114">
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form id="couponForm" action="" method="POST">
                <!-- Coupon Code -->
                <div class="mb-3">
                    <label for="couponCode" class="form-label fw-bold">Coupon Code</label>
                    <input type="text" class="form-control" id="couponCode" name="couponCode"
                           placeholder="Coupon Code" required>
                </div>

                <!-- Coupon Value -->
                <div class="mb-3">
                    <label for="couponValue" class="form-label fw-bold">Coupon Value</label>
                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" class="form-control" id="couponValue" step="0.01" name="couponValue"
                               placeholder="0.00" required>
                    </div>
                </div>

                <!-- Coupon Expiration Date -->
                <div class="mb-3">
                    <label for="couponExpiration" class="form-label fw-bold">Coupon Expiration Date</label>
                    <input type="date" class="form-control" id="couponExpiration" name="couponExpiration" required>
                </div>

                <button id="addCouponButton" type="submit" class="btn btn-registrieren">Coupon hinzufügen</button>
            </form>
        </div>
    </div>
</div>
