<!-- Personal Program Overlay -->
<div id="personal-program-overlay" class="overlay">
    <div class="overlay-content">
        <button class="close-btn" onclick="closePersonalProgram()">✖</button>
        <h2 class="programOVerlayText">Personal program</h2>
        <div id="program-items" class="program-items">
            <!-- Items will be dynamically added here -->
        </div>
        <button class="purchase-btn">Purchase item(s)</button>
    </div>
</div>

<div class="personal-program-container">
    <button class="personal-program-btn" onclick="openPersonalProgram()">
        <img src="../../assets/images/global/Shopping Cart.png" alt="Personal Program" class="personal-program-icon">
        
        <span id="personal-program-count" class="program-count">0</span>
    </button>
</div>
