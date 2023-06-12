<?php

class Coupon {
    public int $id;
    public string $code;
    public float $amount;
    public string $date;
    public bool $expired;

    /**
     * @param int $id
     * @param string $code
     * @param float $amount
     * @param string $date
     */
    public function __construct(int $id, string $code, float $amount, string $date, bool $expired)
    {
        $this->id = $id;
        $this->code = $code;
        $this->amount = $amount;
        $this->date = $date;
        $this->expired = $expired;
    }


}
