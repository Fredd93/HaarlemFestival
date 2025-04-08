<?php

class PersonalProgramDTO{
    public int $programId;
    public int $userId;
    public int $eventId;
    public string $status;

    public function __construct(int $programId, int $userId, int $eventId, string $status) {
        $this->programId = $programId;
        $this->userId = $userId;
        $this->eventId = $eventId;
        $this->status = $status;
    }
}
?>