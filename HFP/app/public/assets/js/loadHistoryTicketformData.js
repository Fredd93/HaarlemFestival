let fullSchedule = null;
//Initialise variables for later use
let chosenDay = "Thursday";
let chosenTime = "10:00";
let chosenLanguage = "Dutch";
let initialized = false;

function setDay(day) {
    chosenDay = day;
    updateTicketDay();
}
function setTime(time) {
    chosenTime = time;
    updateTicketTime();
}
async function FetchTicketingSchedule(){
    fetch('/api/history/schedule')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch schedule');
            }
            return response.json();
        })
        .then(fetchedSchedule => {
            console.log("Schedule fetched:", fetchedSchedule);
            CreateFullSchedule(fetchedSchedule);
            FillForm();
        })
        .catch(error => {
            console.error("Error fetching schedule:", error);
        });
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
function FillForm() {
    FillDayField();

    //The first option gets selected as the default
    FillTimeField(fullSchedule[0].cards);

    //The first option gets selected as the default
    FillLanguageField(fullSchedule[0].cards[0]);

    // Initialize event listeners
    setupEventListeners();

    //Disabled until values are filled in to prevent submitting "nothing"
    document.getElementById("historySubmit").disabled = false;
    initialized = true;

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
function FillDayField() {
    const dayField = document.getElementById("day");
    dayField.innerHTML = ''; //clear items so new ones can be added
    fullSchedule.forEach(daySchedule => {
        dayOption = document.createElement("option");
        dayOption.innerHTML = daySchedule.day;
        dayField.appendChild(dayOption);
        if(!initialized) dayField.value = chosenDay;
    })
    //Thursday is the first option and gets chosen as default
}
function FillTimeField(day) {
    const timeField = document.getElementById("time");
    timeField.innerHTML = ''; //clear items so new ones can be added
    day.forEach(tourItem => {
        time = tourItem.date.substring((tourItem.date.indexOf(":")-2), (tourItem.date.indexOf(":")+3));
        timeOption = document.createElement("option");
        timeOption.innerHTML = time;
        timeField.appendChild(timeOption);
        if(!initialized) timeField.value = chosenTime;
        else chosenTime = "10:00";
    })
}
function FillLanguageField(scheduleItem) {
    const languageField = document.getElementById("language");
    languageField.innerHTML = ''; //clear items so new ones can be added
    Object.entries(scheduleItem).forEach(tourItem => {
        if (tourItem[0].includes("Tours") && tourItem[1] > 0) {
            //make sure it is a language option, those all have [language]Tours as their name
            //And make sure it has at least 1 tour of that type
            parsedLanguage = tourItem[0].replace("Tours", "");
            //Make sure the 1st letter is capitalized
            parsedLanguage = parsedLanguage.charAt(0).toUpperCase() + parsedLanguage.slice(1);
            languageOption = document.createElement("option");
            languageOption.innerHTML = parsedLanguage;
            languageField.appendChild(languageOption);
            if(!initialized) languageField.value = chosenLanguage;
            else chosenLanguage = "Dutch";

        }
    })
}
async function createHistoryTicket() {
    let chosenType = null;
    if (document.getElementById("familyTicket").checked) {
        chosenType = "Family Ticket";
    }
    else {
        chosenType = "Single Ticket";
    }
    const chosenCount = document.getElementById("count").value;
    const price = parseFloat(document.getElementById("historyTicketPrice").textContent.replace("€", ""));
    console.log(price);
    console.log(document.getElementById("historyTicketPrice").textContent.replace("€", ""));
    console.log(document.getElementById("historyTicketPrice"));
    //Didn't know a better way to do this at first
    const weekday = {"Sunday":10,"Monday":4,"Tuesday":5,"Wednesday":6,"Thursday":7,"Friday":8,"Saturday":9};
    let time = "2025-8-" + weekday[chosenDay] + " " + chosenTime;
    const payload = {
        location: "St.Bavo church",
        time: time,
        language: chosenLanguage,
        ticket_type: chosenType,
        ticket_count: chosenCount,
        price: price,
    };
    fetch('/api/history/book', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(result => {
        if(result.error) {
            infoLabel = document.getElementById("InfoLabel");
            infoLabel.textContent = result.error;
            infoLabel.classList.add("negative");
            infoLabel.classList.remove("positive");
        }
        else {
            infoLabel = document.getElementById("InfoLabel");
            infoLabel.textContent = "Booking successful";
            infoLabel.classList.remove("negative");
            infoLabel.classList.add("positive");
        }
        // Optionally refresh table or disable button
    })
    .catch(err => {
        console.error("Booking error:", err);
        alert("❌ Failed to book ticket.");
    });
}
function updateTicketPrice() {
    const priceLabel = document.getElementById("historyTicketPrice");
    const familyTicket = document.getElementById("familyTicket");
    const ticketCount = document.getElementById("count");
    let price = 0;
    if (familyTicket.checked) {
        price = Math.ceil(ticketCount.value/4) * 60;
    }
    else {
        price = ticketCount.value * 17.5;
    }
    priceLabel.innerHTML = "€" + price.toFixed(2);
}
function updateTicketDay() {
    const dayLabel = document.getElementById("historyTicketDay");
    dayLabel.innerHTML = `<strong>Day:</strong> ${chosenDay}`
}
function updateTicketLanguage() {
    const languageLabel = document.getElementById("historyTicketLanguage");
    languageLabel.innerHTML = `<strong>Language:</strong> ${chosenLanguage}`
}
function updateTicketTime() {
    const timeLabel = document.getElementById("historyTicketTime");
    timeLabel.innerHTML = `<strong>Time:</strong> ${chosenTime}`
}
function updateFields() {
    updateTicketDay();
    updateTicketLanguage();
    updateTicketPrice();
    updateTicketTime();
    console.log("updating ALL fields");
    console.log(chosenDay);
    console.log(chosenTime);
    console.log(chosenLanguage);
}

function setupDatetimeChange() {
    const timeField = document.getElementById("time");
    const dayField = document.getElementById("day");
    dayField.addEventListener("change", function () {
        chosenDay = dayField.value;
        FillTimeField(fullSchedule[dayField.selectedIndex].cards);
        FillLanguageField(fullSchedule[dayField.selectedIndex].cards[timeField.selectedIndex]);
        updateFields();
    });
    timeField.addEventListener("change", function () {
        chosenTime = timeField.value;
        FillLanguageField(fullSchedule[dayField.selectedIndex].cards[timeField.selectedIndex]);
        updateFields();
    });
}

function setupLanguageChange() {
    const languageField = document.getElementById("language");
    languageField.addEventListener("change", function () {
        chosenLanguage = languageField.value;
        updateFields();
    });
}

function setupPriceChange() {
    const familyTicket = document.getElementById("familyTicket");
    const ticketCount = document.getElementById("count");

    familyTicket.addEventListener("change", updateTicketPrice);
    ticketCount.addEventListener("change", updateTicketPrice);
}
function setupTicketSubmit() {
    const form = document.getElementById("form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        createHistoryTicket();
    });
}

// Call all setup functions
function setupEventListeners() {
    setupDatetimeChange();
    setupLanguageChange();
    setupPriceChange();
    setupTicketSubmit();
}


