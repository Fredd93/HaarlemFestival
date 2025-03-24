<?php
require_once(__DIR__ . "/header.php");
require_once(__DIR__ . "/../../models/EventModel.php");

$eventModel = new EventModel();
$events = $eventModel->getAllEvents();
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Events</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#eventModal">Add Event</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= $event->event_id ?></td>
                <td><?= htmlspecialchars($event->event_name) ?></td>
                <td><?= htmlspecialchars($event->event_description) ?></td>
                <td><img src="/<?= htmlspecialchars($event->image) ?>" alt="Event Image" width="80"></td>
                <td>
                    <button class="btn btn-primary btn-sm edit-btn" 
                        data-id="<?= $event->event_id ?>" 
                        data-name="<?= htmlspecialchars($event->event_name) ?>" 
                        data-description="<?= htmlspecialchars($event->event_description) ?>" 
                        data-image="<?= htmlspecialchars($event->image) ?>"
                        data-bs-toggle="modal" data-bs-target="#eventModal">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $event->event_id ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding/Editing Events -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="event_id">
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="event_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="event_description" class="form-label">Description</label>
                        <textarea class="form-control tinymce-editor" id="event_description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="event_image" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="event_image">
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/jzaxsgdy1peu0fk6h4zk1hp8a4zpnu7zvckpgzdp2urvvq3w/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="editor.js"></script>
<script src="api.js"></script>
