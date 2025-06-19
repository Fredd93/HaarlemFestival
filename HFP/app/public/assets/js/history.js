let isTicketingPage = false;
function FetchHistorySchedule() {
    fetch('/api/history/schedule')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch schedule');
            }
            return response.json();
        })
        .then(schedule => {
            fullSchedule = CreateFullSchedule(schedule);
            DisplaySchedule(fullSchedule);
        })
        .catch(error => {
            console.error("Error fetching schedule:", error);
        });
}
function setTicketingPage(isPage) {
    isTicketingPage = isPage;
}
function CombineSchedule(schedule) {
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
    return combinedSchedule;
}
function CreateFullSchedule(schedule) {
    combinedSchedule = CombineSchedule(schedule);
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
    return fullSchedule;
}
function DisplaySchedule(fullSchedule) {
    const container = document.getElementById("schedule-cards-container");
    container.innerHTML = ""; // Clear previous content
    fullSchedule.forEach(daySchedule => {
        const container = document.getElementById("schedule-cards-container");
        dayContainer = document.createElement("div");
        dayContainer.innerHTML = `<h2>${daySchedule.day}</h2><div class="schedule-item-collection" id="${daySchedule.day}"</div>`;
        container.appendChild(dayContainer);
        cardContainer = document.getElementById(daySchedule.day);
        daySchedule.cards.forEach(scheduleItem => {
            let card = null;
            if (isTicketingPage) {
                card = CreateTicketingScheduleCard(scheduleItem, daySchedule.day);
            }
            else {
                card = CreateScheduleCard(scheduleItem, daySchedule.day);
            }
            cardContainer.appendChild(card);
        })
    })
}
function CreateScheduleCard(scheduleItem, day) {
    time = scheduleItem.date.substring((scheduleItem.date.indexOf(":")-2), (scheduleItem.date.indexOf(":")+3));
    dutchTours = scheduleItem.dutchTours;
    englishTours = scheduleItem.englishTours;
    chineseTours = scheduleItem.chineseTours;
    const card = document.createElement("div");
    card.innerHTML = 
    `<div class="schedule-item">
        <div class="top"><h2>${time}</h2></div>
            <div class="bottom" id="bottom"> 
            ${CheckTours(dutchTours, "dutch")}
            ${CheckTours(englishTours, "english")}
            ${CheckTours(chineseTours, "chinese")}
            <div class="ticketButton" onclick="window.location.href='/history/tickets?day=${day}&time=${time}'">Buy tickets</div>
        </div>
    </div>`;
    return card;
}
function CreateTicketingScheduleCard(scheduleItem, day) {
    time = scheduleItem.date.substring((scheduleItem.date.indexOf(":")-2), (scheduleItem.date.indexOf(":")+3));
    dutchTours = scheduleItem.dutchTours;
    englishTours = scheduleItem.englishTours;
    chineseTours = scheduleItem.chineseTours;
    const card = document.createElement("div");
    card.innerHTML = 
    `<div class="schedule-item">
        <div class="top"><h2>${time}</h2></div>
            <div class="bottom" id="bottom"> 
            ${CheckTours(dutchTours, "dutch")}
            ${CheckTours(englishTours, "english")}
            ${CheckTours(chineseTours, "chinese")}
            <div class="ticketButton" onclick="openTicketing('${day}', '${time}')">Buy tickets</div>
        </div>
    </div>`;
    return card;
}
function openTicketing(day, time) {
    ticketForm = document.getElementById("HistoryTicketing");
    ticketForm.classList.remove("hidden");
    schedule = document.getElementById("schedule-cards-container");
    schedule.classList.add("hidden");
    setDay(day);
    setTime(time);
    FillForm();
    console.log(day);
    console.log(time);
}
function CheckPlural(tourCount) {
    if (tourCount > 1) {
        return "s";
    }
    else return "";
}
function CheckTours(tourCount, language) {
    if (tourCount > 0){ 
        if (language == "dutch") {
            return `<p>${tourCount} Dutch tour${CheckPlural(tourCount)} <img src="assets/images/history/dutchFlag.png" alt="Dutch flag" width="20" height="15"></p>`;
        }
        else if (language == "english") {
            return `<p>${tourCount} English tour${CheckPlural(tourCount)} <img src="assets/images/history/englishFlag.png" alt="English flag" width="20" height="15"></p>`;
        }
        else if (language == "chinese") {
            return `<p>${tourCount} Chinese tour${CheckPlural(tourCount)} <img src="assets/images/history/chineseFlag.png" alt="Chinese flag" width="20" height="15"></p>`;
        }
        else {
            return "";
        }
    }
    else return "";
}
function FetchLocations() {
    fetch('/api/history/locations')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch locations');
            }
            return response.json();
        })
        .then(locations => {
            console.log("Locations fetched:", locations);
            DisplayLocations(locations);
        })
        .catch(error => {
            console.error("Error fetching locations:", error);
        });
}
function DisplayLocations(locations) {
    const container = document.getElementById("locationContainer");
    counter = 0;
    locations.forEach(location => {
        locationCard = document.createElement("div");
        locationCard.classList.add("locationCard");
        if (counter % 2 == 0) {
            locationCard.classList.add("left");
        }
        else {
            locationCard.classList.add("right");
        }
        counter++;
        linkResult = location.name.replaceAll(" ", "_");
        locationCard.innerHTML = `<a href="history/${linkResult}">
        <img src=assets/images/history/${location.image_name} width="200" height="150" alt="${location.name} Image">
        </a>
        <a class="locationButton" href="history/${linkResult}">Learn more</a>
        <p class="locationCardText"><strong>${location.name}</strong> <br>${location.description}</p>`;
        container.appendChild(locationCard);
    })
}
