<?php
// Adjust the path as needed:
require_once(__DIR__ . "/../../models/YummyEventModel.php");

// Create model instance & fetch all events
$yummyModel = new YummyEventModel();
$yummyEvents = $yummyModel->getAll();

// Helper function to generate session start times
function generateSessionSlots(string $startTime, float $sessionDuration, int $sessions): array {
    $slots = [];
    $dt = new DateTime($startTime);

    for ($i = 0; $i < $sessions; $i++) {
        // Add the current start time to slots
        $slots[] = $dt->format("H:i");
        // Move forward by sessionDuration (in hours)
        $minutesToAdd = (int)($sessionDuration * 60);
        $dt->modify("+{$minutesToAdd} minutes");
    }

    return $slots; // e.g. ["18:00", "19:30", "21:00"]
}
?>

<table class="yummy-table">
    <thead>
        <tr>
            <th>Restaurant</th>
            <th>Duration</th>
            <th>Time Slots</th>
            <th>Price (Adult/Child)</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($yummyEvents as $event): ?>
        <tr>
            <!-- Restaurant Name -->
            <td><?= htmlspecialchars($event->name) ?></td>

            <!-- Duration (e.g., "1.5 hours") -->
            <td><?= htmlspecialchars($event->sessionDuration) ?> hours</td>

            <!-- Time Slots (computed from startTime, sessionDuration, sessions) -->
            <td>
                <?php
                    $slots = generateSessionSlots($event->startTime, $event->sessionDuration, $event->sessions);
                    echo implode(", ", $slots);
                ?>
            </td>

            <!-- Price (Adult/Child) -->
            <td>
                €<?= htmlspecialchars($event->price) ?> (Adult)
                / €<?= htmlspecialchars($event->childPrice) ?> (Child)
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
