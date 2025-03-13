// script.js
function displayField() {
    // Get the selected field value from the dropdown
    var selectedField = document.getElementById("fieldSelect").value;
    
    // Get the div where the input fields will be displayed
    var fieldInputDiv = document.getElementById("fieldInput");

    // Clear any existing content in the fieldInput div
    fieldInputDiv.innerHTML = "";

    // Create the corresponding input field based on the selected option
    if (selectedField === "Position Applied") {
        fieldInputDiv.innerHTML = `
            <label for="position_applied">Position Applied:</label><br>
            <input type="text" name="position_applied" id="position_applied" required>
        `;
    } else if (selectedField === "Email") {
        fieldInputDiv.innerHTML = `
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required>
        `;
    } else if (selectedField === "Phone") {
        fieldInputDiv.innerHTML = `
            <label for="phone">Phone:</label><br>
            <input type="tel" name="phone" id="phone" required>
        `;
    } else if (selectedField === "Address") {
        fieldInputDiv.innerHTML = `
            <label for="address">Address:</label><br>
            <input type="text" name="address" id="address" required>
        `;
    }
}
