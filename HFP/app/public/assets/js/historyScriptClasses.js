class HistoryScheduleCard {
    dutchTours = 0;
    englishTours = 0;
    chineseTours = 0;
    constructor(date) {
        this.date = date;
    }
}
class HistoryScheduleDay {
    constructor(day) {
        this.day = day;
    }
    cards = [];
}