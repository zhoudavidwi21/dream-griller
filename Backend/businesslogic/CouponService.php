<?php

include "./models/Coupon.php";
class CouponService {

    private Database $database;

    public function __construct(){
        require_once "./config/Database.php";
        $this->database = new Database();
    }

    public function getAllCoupons(): ?array {
        $query = "SELECT * FROM coupons";
        $res = $this->database->executeQuery($query);

        $coupons = [];

        foreach ($res as $row) {
            $coupon = new Coupon(
                $row['id'],
                $row['code'],
                $row['amount'],
                $row['expirydate'],
                boolval($row['expired'])
            );
            $coupons[] = $coupon;
        }
        return $coupons;
    }

    /**
     * @throws Exception
     */
    public function saveCoupon($requestData): ?Coupon {
        $code = $requestData['couponCode'] ?? '';
        $amount = $requestData['couponValue'] ?? '';
        $expirydate = $requestData['couponExpiration'] ?? '';


        // Insert extracted Data
        $query = "INSERT INTO coupons (code, amount, expirydate) 
              VALUES (:code, :amount, :expirydate)";

        $params = array(
            ':code' => $code,
            ':amount' => $amount,
            ':expirydate' => $expirydate,
        );

        $this->database->executeQuery($query, $params);

        // Get CouponId
        $couponId = $this->database->getLastInsertedId();

        if ($couponId) {
            return $this->getCouponById($couponId);
        }

        return null;
    }

    private function getCouponById(int $couponId): ?Coupon {
        $query = "SELECT * FROM coupons WHERE id = :id";
        $params = array(':id' => $couponId);
        $couponData = $this->database->executeQuery($query, $params);

        if (!empty($couponData)) {
            $row = $couponData[0];
            $coupon = new Coupon(
                $row['id'],
                $row['code'],
                $row['amount'],
                $row['expirydate'],
                boolval($row['expired'])
            );
            return $coupon;
        }

        return null;
    }

}