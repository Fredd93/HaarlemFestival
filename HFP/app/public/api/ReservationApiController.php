<?php
require_once(__DIR__ . '/../models/RestaurantReservationModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class ReservationApiController {
    private $reservationModel;
    
    public function __construct() {
        $this->reservationModel = new RestaurantReservationModel();
    }
    
    /**
     * Processes a booking request.
     */
    public function bookReservation() {
        // Read JSON from request body
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            ResponseHelper::sendError("Invalid input", 400);
            return;
        }
        
        // Retrieve fields from request
        $restaurant_id    = $data['restaurant_id']    ?? null;
        $client_name      = $data['client_name']      ?? null;
        $reservation_date = $data['reservation_date'] ?? null;
        $reservation_time = $data['reservation_time'] ?? null;
        $num_adults       = $data['num_adults']       ?? null;
        $num_children     = $data['num_children']     ?? null;
        $special_request  = $data['special_request']  ?? '';
        
        // Validate required fields (special_request is optional)
        if (!$restaurant_id || !$client_name || !$reservation_date || !$reservation_time || !$num_adults || !$num_children) {
            ResponseHelper::sendError("Missing required fields", 400);
            return;
        }
        
        // Insert the reservation into the database
        // Parameter order: restaurantId, clientName, date, time, numAdults, numChildren, specialRequest.
        $result = $this->reservationModel->insertReservation(
            $restaurant_id,
            $client_name,
            $reservation_date,
            $reservation_time,
            $num_adults,
            $num_children,
            $special_request
        );
        
        if ($result) {
            ResponseHelper::sendJson(["message" => "Reservation booked successfully"]);
        } else {
            ResponseHelper::sendError("Failed to book reservation", 500);
        }
    }
}
?>
