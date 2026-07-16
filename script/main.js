function toggleStatus(button) {
  const statusContainer = button.previousElementSibling;
  const statusSpan = statusContainer.querySelector('.status');
  if (statusSpan.classList.contains('available')) {
    statusSpan.classList.remove('available');
    statusSpan.classList.add('in-use');
    statusSpan.textContent = 'In Use';
  } else {
    statusSpan.classList.remove('in-use');
    statusSpan.classList.add('available');
    statusSpan.textContent = 'Available';
  }
}

const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");

menuToggle.addEventListener("click", () => {
  navMenu.classList.toggle("active");
});


// === REGISTRATION FUNCTIONALITY ===
function setupRegistrationButtons() {
  const registerButtons = document.querySelectorAll('.register-btn');
  
  registerButtons.forEach(button => {
    button.addEventListener('click', function() {
      const eventTitle = this.closest('.event').querySelector('.title').textContent;
      alert(`Successfully registered for: ${eventTitle}`);
      
      // Optional: Change button text and disable it
      this.textContent = 'Registered ✓';
      this.disabled = true;
      this.style.backgroundColor = '#28a745'; // Green color
      this.style.cursor = 'not-allowed';
    });
  });
}

// === INITIALIZE WHEN PAGE LOADS ===
document.addEventListener('DOMContentLoaded', function() {
  setupRegistrationButtons();
});