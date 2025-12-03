function showPage(page) {
  // Remove active class from all links
  const links = document.querySelectorAll(".sidebar-menu a");
  links.forEach((link) => link.classList.remove("active"));

  // Add active class to clicked link
  event.target.closest("a").classList.add("active");

  // Here you can add logic to show different content based on page
  console.log("Navigating to:", page);
}

// Add some interactivity
document.addEventListener("DOMContentLoaded", function () {
  // Animate stat cards on load
  const statCards = document.querySelectorAll(".stat-card");
  statCards.forEach((card, index) => {
    setTimeout(() => {
      card.style.opacity = "0";
      card.style.transform = "translateY(20px)";
      card.style.transition = "all 0.5s ease";
      setTimeout(() => {
        card.style.opacity = "1";
        card.style.transform = "translateY(0)";
      }, 50);
    }, index * 100);
  });
});
