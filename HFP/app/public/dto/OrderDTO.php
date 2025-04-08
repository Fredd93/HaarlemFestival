<?php
class OrderDTO {
    public int $order_id;
    public int $user_id;
    public int $total_price;
    public string $payment_method;
    public string $created_at;

    public function __construct(int $order_id, int $user_id, int $total_price, string $payment_method, string $created_at) {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->payment_method = $payment_method;
        $this->created_at = $created_at;
    }
}
