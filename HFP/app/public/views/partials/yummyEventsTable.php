<?php
// Adjust the path as needed:
require_once(__DIR__ . "/../../models/YummyEventModel.php");

// Create model instance & fetch all events
$yummyModel = new YummyEventModel();
$yummyEvents = $yummyModel->getAll();
?>

<table border="1">
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
            <td>
                <?= htmlspecialchars($event->name) ?>
            </td>

            <!-- Duration (e.g., "1.5 hours") -->
            <td>
                <?= htmlspecialchars($event->sessionDuration) ?> hours
            </td>

            <!-- Time Slots (hourly from start_time to end_time) -->
            <td>
                <?php
                    // Convert start_time / end_time to DateTime objects
                    $start = new DateTime($event->startTime);
                    $end = new DateTime($event->endTime);

                    // We'll create an hourly interval
                    $interval = new DateInterval("PT1H"); // 1 hour

                    // Use DatePeriod to list each hour
                    $timeSlots = [];
                    $period = new DatePeriod($start, $interval, $end);

                    // Add each hour in the period
                    foreach ($period as $dt) {
                        $timeSlots[] = $dt->format("H:i");
                    }

                    // Optionally include the end time as a slot
                    // (If you want the user to see the final hour as well)
                    $lastSlot = $end->format("H:i");
                    if (!in_array($lastSlot, $timeSlots)) {
                        $timeSlots[] = $lastSlot;
                    }

                    // Display as comma-separated or any format you prefer
                    echo implode(", ", $timeSlots);
                ?>
            </td>

            <!-- Price (Adult/Child) -->
            <td>
                <?php
                    // If you only have one price in DB, you can either:
                    // (A) show it as "€XX.XX / ???" (placeholder),
                    // (B) or do some logic to derive child price (e.g. 70%).
                    // We'll do a placeholder here:
                ?>
                €<?= htmlspecialchars($event->price) ?> (Adult) / €?? (Child)
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
