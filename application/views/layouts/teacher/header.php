  <!-- Toast Message Box -->
  <?php if ($this->session->flashdata('toast_message')): ?>
    <div class="toast toast-<?= $this->session->flashdata('toast_type'); ?>">
      <?= $this->session->flashdata('toast_message'); ?>
    </div>
  <?php endif; ?>

  <!-- Nav Bar -->
  <div class="navbar">
    <div class="title">Teacher Panel</div>
    <div class="profile-section" onclick="toggleCard()">
      <img src="<?= base_url('assets/images/teacher.png') ?>" class="profile-img" alt="Profile">
      <div id="profileDropdown" class="dropdown-card">
        <h4><?= $this->session->userdata('teacher_name') ?></h4>
        <p><?= $this->session->userdata('teacher_email') ?></p>
        <a href="<?= base_url('index.php/teacher/edit_profile_details') ?>" class="btn">Edit Profile</a>
        <a href="<?= base_url('index.php/auth/logout') ?>" class="btn">Logout</a>
      </div>
    </div>
  </div>

  <script>
    function toggleCard() {
      const dropdown = document.getElementById('profileDropdown');
      dropdown.classList.toggle('show');
    }
    // Close the dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const profileSection = document.querySelector('.profile-section');
      const dropdown = document.getElementById('profileDropdown');
      if (!profileSection.contains(event.target)) {
        dropdown.classList.remove('show');
      }
    });
  </script>
  <div class="layout">