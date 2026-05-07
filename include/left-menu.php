<!-- ════════════ SIDEBAR ════════════ -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo" style="padding: 16px 8px 20px; display: flex; align-items: center; gap: 12px;">
      <div class="logo-icon" style="background: linear-gradient(135deg, #10b981, #059669); flex-shrink: 0; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-box-seam" style="color: white; font-size: 14px;"></i>
      </div>
      <span style="font-size: 14px; line-height: 1.2; font-weight: 700; color: #1e293b;">Inventory<br>Tracking System</span>
      <button class="collapse-btn" onclick="closeSidebar()" style="margin-left: auto;">
        <i class="bi bi-list"></i>
      </button>
    </div>

    <nav style="display: flex; flex-direction: column; flex-grow: 1;">
      <div>
          <a href="<?php echo WEB_ROOT; ?>" class="nav-item <?php echo ($currentPage == 'Home') ? 'active' : ''; ?>" style="text-decoration: none; color: inherit; padding: 12px 10px;">
            <i class="bi bi-graph-up" style="width: 20px; text-align: center; font-size: 16px;"></i>
            Overview
          </a>
          <a href="<?php echo WEB_ROOT; ?>school-item/" class="nav-item <?php echo ($currentPage == 'school-item') ? 'active' : ''; ?>" style="text-decoration: none; color: inherit; padding: 12px 10px;">
            <i class="bi bi-boxes" style="width: 20px; text-align: center; font-size: 16px;"></i>
            School Items
          </a>
          <a href="<?php echo WEB_ROOT; ?>records/" class="nav-item <?php echo ($currentPage == 'records') ? 'active' : ''; ?>" style="text-decoration: none; color: inherit; padding: 12px 10px;">
            <i class="bi bi-clipboard2-data" style="width: 20px; text-align: center; font-size: 16px;"></i>
            Records
          </a>
      </div>
      
      <div style="margin-top: auto; padding-top: 15px; border-top: 1px solid var(--border);">
          <a href="<?php echo WEB_ROOT; ?>?logout" class="nav-item" style="text-decoration: none; color: #ef4444; padding: 12px 10px; font-weight: 600;">
            <i class="bi bi-box-arrow-right" style="width: 20px; text-align: center; font-size: 16px;"></i>
            Log Out
          </a>
      </div>
    </nav>
  </aside>