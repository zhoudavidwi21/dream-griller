<?php

class Order {
    public int $id;
    public float $total;
    public string $date;
    public int $fk_customerId;
    public ?int $fk_couponId;

    /**
     * @param int $id
     * @param float $total
     * @param string $date
     * @param int $fk_customerId
     * @param int|null $fk_couponId
     */
    public function __construct(int $id, float $total, string $date, int $fk_customerId, ?int $fk_couponId)
    {
        $this->id = $id;
        $this->total = $total;
        $this->date = $date;
        $this->fk_customerId = $fk_customerId;
        $this->fk_couponId = $fk_couponId;
    }


}
