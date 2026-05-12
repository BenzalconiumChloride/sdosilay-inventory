  <!-- Topbar -->
  <header class="topbar">
    <button class="hamburger" id="hamburger" onclick="openSidebar()" style="display:none;">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
        <rect x="1" y="4" width="14" height="1.5" rx="1" fill="#1a1a2e" />
        <rect x="1" y="7.25" width="14" height="1.5" rx="1" fill="#1a1a2e" />
        <rect x="1" y="10.5" width="14" height="1.5" rx="1" fill="#1a1a2e" />
      </svg>
    </button>

    <div class="topbar-right">
      <div class="icon-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <circle cx="8" cy="8" r="2.5" stroke="#8b8fa8" stroke-width="1.5" />
          <path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.22 3.22l1.41 1.41M11.37 11.37l1.41 1.41M11.37 4.63l1.41-1.41M3.22 12.78l1.41-1.41" stroke="#8b8fa8" stroke-width="1.2" stroke-linecap="round" />
        </svg>
      </div>

      <!-- Avatar Dropdown -->
      <div class="dropdown">
        <img
          src="<?php echo WEB_ROOT; ?>assets/images/favicon.png"
          alt="Avatar"
          class="rounded-circle dropdown-toggle"
          id="avatarDropdown"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          style="width:40px; height:40px; object-fit:cover; cursor:pointer;">

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="avatarDropdown">
          <li>
            <a class="dropdown-item text-danger" href="?logout">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </header>