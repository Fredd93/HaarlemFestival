<?php

/**
 * Require the user to be logged in.
 */
function requireApiLogin(): void {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["message" => "Unauthorized"]);
        exit;
    }
}

/**
 * Require the user to have one of the allowed roles.
 *
 * @param array 
 */
function requireApiRole(array $allowedRoles): void {
    requireApiLogin(); // First make sure the user is logged in

    if (!in_array($_SESSION['user_role'], $allowedRoles)) {
        http_response_code(403);
        echo json_encode(["message" => "Forbidden"]);
        exit;
    }
}
