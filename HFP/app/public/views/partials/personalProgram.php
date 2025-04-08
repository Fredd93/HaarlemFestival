<!-- Personal Program Overlay -->
<div id="personal-program-overlay" class="overlay">
    <div class="overlay-content">
        <button class="close-btn" onclick="closePersonalProgram()">✖</button>
        <h2 class="overlay-title">Personal program</h2>

        <div id="program-items" class="program-items">
            <!-- Items will be dynamically rendered here -->
            <p>Loading your program...</p>
        </div>

        <button class="purchase-btn">Purchase item(s)</button>
        <button class="paylater-btn">Pay later</button>
    </div>
</div>

<!-- Button in the nav -->
<div class="personal-program-container">
    <button class="personal-program-btn" onclick="openPersonalProgram()">
        <img src="/assets/images/global/Shopping Cart.png" alt="Personal Program" class="personal-program-icon">
        <span id="personal-program-count" class="program-count">0</span>
    </button>
</div>
