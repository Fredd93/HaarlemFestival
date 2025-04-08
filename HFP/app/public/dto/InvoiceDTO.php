<?php
class InvoiceDTO {
    public int $invoice_id;
    public int $order_id;
    public string $due_date;
    public string $status;
    public string $email_sent;

    public function __construct(int $invoice_id, int $order_id, string $due_date, string $status, string $email_sent) {
        $this->invoice_id = $invoice_id;
        $this->order_id = $order_id;
        $this->due_date = $due_date;
        $this->status = $status;
        $this->email_sent = $email_sent;
    }
}
