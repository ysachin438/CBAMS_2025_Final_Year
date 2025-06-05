// Toggle sidebar on small screens
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('open');
}

// Optional: highlight current menu link
document.addEventListener('DOMContentLoaded', function () {
  const links = document.querySelectorAll('.sidebar ul li a');
  const currentURL = window.location.href;

  links.forEach(link => {
    if (currentURL.includes(link.getAttribute('href'))) {
      link.classList.add('active');
    }
  });
});
