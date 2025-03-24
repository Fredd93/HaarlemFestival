document.addEventListener("DOMContentLoaded", function () {
    fetchSchedule();
});

function fetchSchedule() {
    fetch('/api/history/schedule')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch schedule');
            }
            return response.json();
        })
        .then(schedule => {
            console.log("Schedule fetched:", schedule);
            DisplaySchedule(schedule);
        })
        .catch(error => {
            console.error("Error fetching schedule:", error);
        });
}
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
function DisplaySchedule(schedule) {
    const container = document.getElementById("schedule-cards-container");
    container.innerHTML = ""; // Clear previous content
    combinedSchedule = [];

    schedule.forEach(scheduleItem => {
        success = false;
        for (let i = 0; i < combinedSchedule.length; i++) {
            combinedScheduleItem = combinedSchedule[i];
            if (scheduleItem.date == combinedScheduleItem.date) {
                if (scheduleItem.language == "dutch") {
                    combinedScheduleItem.dutchTours++;
                }
                else if (scheduleItem.language == "english") {
                    combinedScheduleItem.englishTours++;
                }
                else if (scheduleItem.language == "chinese") {
                    combinedScheduleItem.chineseTours++;
                }
                combinedSchedule[i] = combinedScheduleItem;
                success = true;
                break;
            }
        }
        if (!success) {
            newCard = new HistoryScheduleCard(scheduleItem.date) ;
            if (scheduleItem.language == "dutch") {
                newCard.dutchTours++;
            }
            else if (scheduleItem.language == "english") {
                newCard.englishTours++;
            }
            else if (scheduleItem.language == "chinese") {
                newCard.chineseTours++;
            }
            combinedSchedule.push(newCard);
        }
    });
    console.log(combinedSchedule);
    fullSchedule = [];
    const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    combinedSchedule.forEach(scheduleItem => {
        success = false;
        for (let i = 0; i < fullSchedule.length; i++) {
            const d = new Date(scheduleItem.date);
            let day = d.getDay();
            day = weekday[day];
            if (fullSchedule[i].day == day) {
                fullSchedule[i].cards.push(scheduleItem);
                success = true;
            }
        }
        if (!success) {
            const d = new Date(scheduleItem.date);
            let day = d.getDay();
            day = weekday[day];
            scheduleDay = new HistoryScheduleDay(day);
            scheduleDay.cards.push(scheduleItem);
            fullSchedule.push(scheduleDay);
        }
    });
    fullSchedule.forEach(daySchedule => {
        const container = document.getElementById("schedule-cards-container");
        dayContainer = document.createElement("div");
        dayContainer.innerHTML = `<h2>${daySchedule.day}</h2><div class="schedule-item-collection" id="${daySchedule.day}"</div>`;
        container.appendChild(dayContainer);
        cardContainer = document.getElementById(daySchedule.day);
        daySchedule.cards.forEach(scheduleItem => {
            const card = CreateScheduleCard(scheduleItem);
            cardContainer.appendChild(card);
        })
    })
}
function CreateScheduleCard(scheduleItem) {
    console.log(scheduleItem);
    time = scheduleItem.date.substring((scheduleItem.date.indexOf(":")-2), (scheduleItem.date.indexOf(":")+3));
    dutchTours = scheduleItem.dutchTours;
    englishTours = scheduleItem.englishTours;
    chineseTours = scheduleItem.chineseTours;
    const card = document.createElement("div");
    card.innerHTML = 
    `<div class="schedule-item">
        <div class="top"><h2>${time}</h2></div>
            <div class="bottom" id="bottom"> 
            ${checkTours(dutchTours, "dutch")}
            ${checkTours(englishTours, "english")}
            ${checkTours(chineseTours, "chinese")}
            <div class="ticketButton">Buy tickets</div>
        </div>
    </div>`;
    return card;
}
function checkPlural(tourCount) {
    if (tourCount > 1) {
        return "s";
    }
    else return "";
}
function checkTours(tourCount, language) {
    if (tourCount > 0){ 
        if (language == "dutch") {
            return `<p>${tourCount} Dutch tour${checkPlural(tourCount)} <img src="assets/images/history/dutchFlag.png" alt="Dutch flag" width="20" height="15"></p>`;
        }
        else if (language == "english") {
            return `<p>${tourCount} English tour${checkPlural(tourCount)} <img src="assets/images/history/englishFlag.png" alt="English flag" width="20" height="15"></p>`;
        }
        else if (language == "chinese") {
            return `<p>${tourCount} Chinese tour${checkPlural(tourCount)} <img src="assets/images/history/chineseFlag.png" alt="Chinese flag" width="20" height="15"></p>`;
        }
        else {
            return "";
        }
    }
    else return "";
}
