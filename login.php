<?php
require_once 'global-library/database.php';
require_once 'include/functions.php';

// ── State ────────────────────────────────────────────────────────────────────
$loginResult    = ["schoolId" => null,  "message" => null];
$registerResult = ["success"  => null,  "message" => null, "field" => null];
$activeTab      = "login"; // which panel to show on load
$oldReg         = ["txtSchoolId" => "", "txtSchoolName" => ""];

// ── Handle Login ─────────────────────────────────────────────────────────────
if (isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
    $result = doLogin();
    if (!empty($result) && is_array($result)) {
        $loginResult = $result;
        $activeTab   = "login";
    }
}

// ── Handle Register ───────────────────────────────────────────────────────────
if (isset($_POST['form_type']) && $_POST['form_type'] === 'register') {
    $registerResult = doRegister();
    $activeTab      = "register";
    if ($registerResult['success'] !== true) {
        $oldReg['txtSchoolId']   = htmlspecialchars(trim($_POST['txtSchoolId']   ?? ''));
        $oldReg['txtSchoolName'] = htmlspecialchars(trim($_POST['txtSchoolName'] ?? ''));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-css.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <title>School Portal</title>

<style>
/* ── Tokens ─────────────────────────────────────────────────────────────── */
:root {
    --navy:         #0f2744;
    --navy-mid:     #1a4a70;
    --forest:       #1e6e3e;
    --green:        #2e8b57;
    --green-lt:     #3aac6e;
    --green-glow:   rgba(46,139,87,.18);
    --surface:      #ffffff;
    --surface-soft: #f4f8fb;
    --border:       #d4e2ee;
    --text:         #192b3c;
    --muted:        #6b7d90;
    --err:          #c0392b;
    --err-bg:       #fef2f2;
    --ok:           #1e7a46;
    --ok-bg:        #edfaf3;
    --r-card:       22px;
    --r-inp:        11px;
    --shadow:       0 24px 64px rgba(15,39,68,.18), 0 4px 18px rgba(15,39,68,.10);
}

/* ── Reset / Base ────────────────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100dvh;
    background:
        radial-gradient(ellipse 60% 50% at 80% 10%,  rgba(46,139,87,.22) 0%, transparent 65%),
        radial-gradient(ellipse 50% 60% at 10% 90%,  rgba(26,74,112,.30) 0%, transparent 65%),
        linear-gradient(160deg, #091c35 0%, #0f2f55 50%, #0b2a1a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

/* subtle grid texture */
body::before {
    content: '';
    position: fixed; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}

/* ── Card shell ──────────────────────────────────────────────────────────── */
.auth-card {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 440px;
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    overflow: hidden;
    animation: rise .5s cubic-bezier(.22,.68,0,1.15) both;
}
@keyframes rise {
    from { opacity: 0; transform: translateY(32px) scale(.96); }
    to   { opacity: 1; transform: none; }
}

/* ── Banner ──────────────────────────────────────────────────────────────── */
.card-banner {
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
    padding: 2rem 2.5rem 0;
    text-align: center;
    position: relative;
}

.logo-ring {
    width: 74px; height: 74px;
    background: rgba(255,255,255,.08);
    border: 1.5px solid rgba(255,255,255,.2);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: .9rem;
    backdrop-filter: blur(6px);
}
.logo-ring img        { width: 46px; object-fit: contain; }
.logo-ring .logo-icon { font-size: 1.9rem; color: #fff; }

.banner-title {
    font-family: 'Sora', sans-serif;
    font-size: 1.25rem; font-weight: 700;
    color: #fff; letter-spacing: -.3px;
    margin-bottom: .2rem;
}
.banner-sub {
    font-size: .72rem; font-weight: 300;
    color: rgba(255,255,255,.55);
    letter-spacing: .6px; text-transform: uppercase;
    margin-bottom: 1.4rem;
}

/* ── Tab strip ───────────────────────────────────────────────────────────── */
.tab-strip {
    display: flex;
    border-radius: 10px 10px 0 0;
    overflow: hidden;
    background: rgba(0,0,0,.18);
    margin: 0 2rem;
    border: 1px solid rgba(255,255,255,.1);
    border-bottom: none;
}
.tab-btn {
    flex: 1;
    padding: .7rem .5rem;
    background: none; border: none;
    font-family: 'Sora', sans-serif;
    font-size: .78rem; font-weight: 600;
    color: rgba(255,255,255,.5);
    letter-spacing: .4px; text-transform: uppercase;
    cursor: pointer;
    transition: color .2s, background .2s;
    position: relative;
}
.tab-btn.active {
    color: #fff;
    background: rgba(255,255,255,.1);
}
.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0; left: 15%; right: 15%;
    height: 2.5px;
    background: var(--green-lt);
    border-radius: 2px 2px 0 0;
}
.tab-btn:hover:not(.active) { color: rgba(255,255,255,.8); }

/* ── Panels ──────────────────────────────────────────────────────────────── */
.panels-wrap {
    /* clip the sliding panels */
    overflow: hidden;
}
.panels-track {
    display: flex;
    width: 200%;
    transition: transform .38s cubic-bezier(.4,0,.2,1);
}
.panels-track.show-register { transform: translateX(-50%); }

.panel {
    width: 50%;
    flex-shrink: 0;
    padding: 1.7rem 2.5rem 2rem;
}

/* ── Alerts ──────────────────────────────────────────────────────────────── */
.msg-box {
    border-radius: 10px;
    font-size: .82rem;
    padding: .65rem 1rem;
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: 1rem;
}
.msg-box.err { background: var(--err-bg); color: var(--err); }
.msg-box.ok  { background: var(--ok-bg);  color: var(--ok);  }

/* ── Fields ──────────────────────────────────────────────────────────────── */
.field {
    margin-bottom: .95rem;
}
.field label {
    display: block;
    font-size: .73rem; font-weight: 500;
    color: var(--muted);
    margin-bottom: .32rem;
    padding-left: .15rem;
    letter-spacing: .15px;
}
.field label span { color: var(--err); }

.inp-shell { position: relative; }
.inp-icon {
    position: absolute; left: 13px; top: 50%;
    transform: translateY(-50%);
    color: var(--green); font-size: .95rem;
    pointer-events: none; z-index: 2;
}
.inp-shell input {
    width: 100%;
    padding: .82rem 2.8rem .82rem 2.45rem;
    border: 1.5px solid var(--border);
    border-radius: var(--r-inp);
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; color: var(--text);
    background: var(--surface-soft);
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
}
.inp-shell input:focus {
    border-color: var(--green);
    background: var(--surface);
    box-shadow: 0 0 0 3px var(--green-glow);
}
.inp-shell input.is-err  { border-color: var(--err); }
.inp-shell input.is-ok   { border-color: var(--green); }
.inp-shell input::placeholder { color: #b0c0d0; }

.pw-toggle {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: var(--muted); cursor: pointer; font-size: .95rem;
    padding: 0; z-index: 2;
    transition: color .15s;
}
.pw-toggle:hover { color: var(--green); }

.field-hint {
    font-size: .71rem; color: var(--muted);
    margin-top: .28rem; padding-left: .15rem;
}
.field-hint.err { color: var(--err); }
.field-hint.ok  { color: var(--ok); }

/* strength bar */
.str-wrap   { margin-top: .38rem; padding-left: .15rem; display: none; }
.str-track  { height: 4px; background: var(--border); border-radius: 4px; overflow: hidden; margin-bottom: .22rem; }
.str-fill   { height: 100%; width: 0; border-radius: 4px; transition: width .3s, background .3s; }
.str-label  { font-size: .7rem; color: var(--muted); }

/* divider */
.divider {
    border: none; border-top: 1px solid var(--border);
    margin: 1.1rem 0;
}
.divider-label {
    font-size: .68rem; font-weight: 600;
    color: var(--muted); text-transform: uppercase;
    letter-spacing: .9px; text-align: center;
    margin: 1rem 0 .9rem;
    display: flex; align-items: center; gap: .5rem;
}
.divider-label::before, .divider-label::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}

/* ── Submit button ───────────────────────────────────────────────────────── */
.btn-auth {
    width: 100%;
    padding: .88rem;
    border: none; border-radius: var(--r-inp);
    background: linear-gradient(135deg, var(--green) 0%, var(--forest) 100%);
    color: #fff;
    font-family: 'Sora', sans-serif;
    font-size: .92rem; font-weight: 600; letter-spacing: .15px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    box-shadow: 0 4px 18px rgba(46,139,87,.35);
    transition: transform .15s, box-shadow .15s, filter .15s;
    margin-top: .3rem;
}
.btn-auth:hover   { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(46,139,87,.4); }
.btn-auth:active  { transform: none; }
.btn-auth .spinner-border { display: none; }
.btn-auth.loading .btn-text  { display: none; }
.btn-auth.loading .spinner-border { display: inline-block; }

/* success state */
.success-block {
    text-align: center; padding: .5rem 0 .3rem;
}
.success-block .check-ring {
    width: 62px; height: 62px;
    background: var(--ok-bg);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: var(--ok);
    margin-bottom: .9rem;
}
.success-block p { font-size: .88rem; color: var(--muted); margin-bottom: 1.1rem; }

/* ── Footer ──────────────────────────────────────────────────────────────── */
.auth-footer {
    text-align: center;
    font-size: .72rem; color: var(--muted);
    margin-top: .6rem;
}

/* ── Responsive ──────────────────────────────────────────────────────────── */
@media (max-width: 480px) {
    .card-banner { padding: 1.7rem 1.5rem 0; }
    .tab-strip   { margin: 0 1.5rem; }
    .panel       { padding: 1.4rem 1.5rem 1.7rem; }
    .banner-title { font-size: 1.1rem; }
}
</style>
</head>
<body>

<div class="auth-card">

    <!-- ── Banner ─────────────────────────────────────────────────────────── -->
    <div class="card-banner">
        <div class="logo-ring">
            <?php
            $logoPath = $_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/assets/images/skate-horizontal.png';
            if (file_exists($logoPath)): ?>
                <img src="<?php echo WEB_ROOT; ?>assets/images/skate-horizontal.png" alt="Logo">
            <?php else: ?>
                <i class="bi bi-building logo-icon"></i>
            <?php endif; ?>
        </div>
        <div class="banner-title">School Portal</div>
        <div class="banner-sub">Inventory Management System</div>

        <!-- Tab strip sits at the bottom of the banner -->
        <div class="tab-strip">
            <button class="tab-btn <?php echo $activeTab === 'login'    ? 'active' : ''; ?>" id="tabLogin"    type="button">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </button>
            <button class="tab-btn <?php echo $activeTab === 'register' ? 'active' : ''; ?>" id="tabRegister" type="button">
                <i class="bi bi-person-plus me-1"></i> Register
            </button>
        </div>
    </div>

    <!-- ── Sliding panels ────────────────────────────────────────────────── -->
    <div class="panels-wrap">
        <div class="panels-track <?php echo $activeTab === 'register' ? 'show-register' : ''; ?>" id="panelsTrack">

            <!-- ══ LOGIN PANEL ══════════════════════════════════════════════ -->
            <div class="panel" id="panelLogin">

                <?php if (!empty($loginResult['message'])): ?>
                <div class="msg-box err">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php echo htmlspecialchars($loginResult['message']); ?>
                </div>
                <?php endif; ?>

                <form method="post" id="frmLogin">
                    <input type="hidden" name="form_type" value="login">

                    <div class="field">
                        <label for="li_schoolId">School ID</label>
                        <div class="inp-shell">
                            <i class="bi bi-person-badge inp-icon"></i>
                            <input type="text" name="txtSchoolId" id="li_schoolId"
                                placeholder="Enter your School ID"
                                value="<?php echo htmlspecialchars($loginResult['schoolId'] ?? ''); ?>"
                                autocomplete="username" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="li_password">Password</label>
                        <div class="inp-shell">
                            <i class="bi bi-lock inp-icon"></i>
                            <input type="password" name="txtPassword" id="li_password"
                                placeholder="Enter your password"
                                autocomplete="current-password" required>
                            <button type="button" class="pw-toggle" data-tgt="li_password" data-eye="li_eye">
                                <i class="bi bi-eye" id="li_eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth" id="btnLogin">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="btn-text"><i class="bi bi-box-arrow-in-right"></i> Sign In</span>
                    </button>
                </form>

                <div class="auth-footer mt-3">
                    &copy; <?php echo date('Y'); ?> School Inventory System &mdash; Authorized personnel only
                </div>
            </div><!-- /panelLogin -->

            <!-- ══ REGISTER PANEL ════════════════════════════════════════════ -->
            <div class="panel" id="panelRegister">

                <?php if ($registerResult['success'] === true): ?>
                <!-- Success state -->
                <div class="msg-box ok">
                    <i class="bi bi-check-circle-fill"></i>
                    <?php echo htmlspecialchars($registerResult['message']); ?>
                </div>
                <div class="success-block">
                    <div class="check-ring"><i class="bi bi-check-lg"></i></div>
                    <p>Your school account has been created.<br>You can now sign in.</p>
                    <button type="button" class="btn-auth" id="goLoginBtn">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span class="btn-text">Go to Sign In</span>
                    </button>
                </div>

                <?php else: ?>
                <!-- Registration form -->
                <?php if (!empty($registerResult['message']) && $registerResult['success'] === false): ?>
                <div class="msg-box err">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php echo htmlspecialchars($registerResult['message']); ?>
                </div>
                <?php endif; ?>

                <form method="post" id="frmRegister">
                    <input type="hidden" name="form_type" value="register">

                    <div class="divider-label">School Information</div>

                    <div class="field">
                        <label for="rg_schoolId">School ID <span>*</span></label>
                        <div class="inp-shell">
                            <i class="bi bi-person-badge inp-icon"></i>
                            <input type="text" name="txtSchoolId" id="rg_schoolId"
                                placeholder="e.g. SCH-001"
                                value="<?php echo $oldReg['txtSchoolId']; ?>"
                                class="<?php echo $registerResult['field'] === 'txtSchoolId' ? 'is-err' : ''; ?>"
                                autocomplete="off" required>
                        </div>
                        <div class="field-hint">Unique identifier for your school</div>
                    </div>

                    <div class="field">
                        <label for="rg_schoolName">School Name <span>*</span></label>
                        <div class="inp-shell">
                            <i class="bi bi-building inp-icon"></i>
                            <input type="text" name="txtSchoolName" id="rg_schoolName"
                                placeholder="e.g. Quezon City High School"
                                value="<?php echo $oldReg['txtSchoolName']; ?>"
                                class="<?php echo $registerResult['field'] === 'txtSchoolName' ? 'is-err' : ''; ?>"
                                autocomplete="organization" required>
                        </div>
                    </div>

                    <div class="divider-label">Set Password</div>

                    <div class="field">
                        <label for="rg_password">Password <span>*</span></label>
                        <div class="inp-shell">
                            <i class="bi bi-lock inp-icon"></i>
                            <input type="password" name="txtPassword" id="rg_password"
                                placeholder="Minimum 8 characters"
                                class="<?php echo $registerResult['field'] === 'txtPassword' ? 'is-err' : ''; ?>"
                                autocomplete="new-password" required>
                            <button type="button" class="pw-toggle" data-tgt="rg_password" data-eye="rg_eye1">
                                <i class="bi bi-eye" id="rg_eye1"></i>
                            </button>
                        </div>
                        <div class="str-wrap" id="strWrap">
                            <div class="str-track"><div class="str-fill" id="strFill"></div></div>
                            <span class="str-label" id="strLabel"></span>
                        </div>
                    </div>

                    <div class="field">
                        <label for="rg_confirm">Confirm Password <span>*</span></label>
                        <div class="inp-shell">
                            <i class="bi bi-lock-fill inp-icon"></i>
                            <input type="password" name="txtConfirmPassword" id="rg_confirm"
                                placeholder="Re-enter password"
                                class="<?php echo $registerResult['field'] === 'txtConfirmPassword' ? 'is-err' : ''; ?>"
                                autocomplete="new-password" required>
                            <button type="button" class="pw-toggle" data-tgt="rg_confirm" data-eye="rg_eye2">
                                <i class="bi bi-eye" id="rg_eye2"></i>
                            </button>
                        </div>
                        <div class="field-hint" id="matchHint"></div>
                    </div>

                    <button type="submit" class="btn-auth" id="btnRegister">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="btn-text"><i class="bi bi-person-plus-fill"></i> Create Account</span>
                    </button>
                </form>
                <?php endif; ?>

                <div class="auth-footer mt-3">
                    &copy; <?php echo date('Y'); ?> School Inventory System
                </div>
            </div><!-- /panelRegister -->

        </div><!-- /panels-track -->
    </div><!-- /panels-wrap -->

</div><!-- /auth-card -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Tab switching ─────────────────────────────────────────────────────── */
const tabLogin    = document.getElementById('tabLogin');
const tabRegister = document.getElementById('tabRegister');
const track       = document.getElementById('panelsTrack');

function switchTab(to) {
    if (to === 'register') {
        track.classList.add('show-register');
        tabRegister.classList.add('active');
        tabLogin.classList.remove('active');
    } else {
        track.classList.remove('show-register');
        tabLogin.classList.add('active');
        tabRegister.classList.remove('active');
    }
}

tabLogin.addEventListener('click',    () => switchTab('login'));
tabRegister.addEventListener('click', () => switchTab('register'));

// "Go to Sign In" after successful registration
const goLoginBtn = document.getElementById('goLoginBtn');
if (goLoginBtn) goLoginBtn.addEventListener('click', () => switchTab('login'));

/* ── Password visibility toggles ──────────────────────────────────────── */
document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const inp  = document.getElementById(btn.dataset.tgt);
        const icon = document.getElementById(btn.dataset.eye);
        const show = inp.type === 'text';
        inp.type       = show ? 'password' : 'text';
        icon.className = show ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
});

/* ── Password strength ────────────────────────────────────────────────── */
const pwInp   = document.getElementById('rg_password');
const strWrap = document.getElementById('strWrap');
const strFill = document.getElementById('strFill');
const strLbl  = document.getElementById('strLabel');

const LEVELS = [
    { score: 1, pct: '15%',  color: '#e74c3c', label: 'Too weak'   },
    { score: 2, pct: '35%',  color: '#e67e22', label: 'Weak'        },
    { score: 3, pct: '60%',  color: '#f1c40f', label: 'Fair'        },
    { score: 4, pct: '82%',  color: '#2ecc71', label: 'Strong'      },
    { score: 5, pct: '100%', color: '#27ae60', label: 'Very strong' },
];

function scorePass(v) {
    let s = 0;
    if (v.length >= 8)          s++;
    if (v.length >= 12)         s++;
    if (/[A-Z]/.test(v))        s++;
    if (/[0-9]/.test(v))        s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    return s;
}

if (pwInp) {
    pwInp.addEventListener('input', () => {
        const v = pwInp.value;
        if (!v) { strWrap.style.display = 'none'; return; }
        strWrap.style.display = 'block';
        const sc  = scorePass(v);
        const lvl = LEVELS.find(l => sc <= l.score) || LEVELS[4];
        strFill.style.width      = lvl.pct;
        strFill.style.background = lvl.color;
        strLbl.textContent       = lvl.label;
        strLbl.style.color       = lvl.color;
    });
}

/* ── Confirm match hint ───────────────────────────────────────────────── */
const cfmInp   = document.getElementById('rg_confirm');
const matchHint = document.getElementById('matchHint');

if (cfmInp) {
    cfmInp.addEventListener('input', () => {
        if (!cfmInp.value) { matchHint.textContent = ''; matchHint.className = 'field-hint'; return; }
        const match = cfmInp.value === pwInp.value;
        matchHint.textContent = match ? '✓ Passwords match' : '✗ Passwords do not match';
        matchHint.className   = 'field-hint ' + (match ? 'ok' : 'err');
        cfmInp.classList.toggle('is-ok',  match);
        cfmInp.classList.toggle('is-err', !match);
    });
}

/* ── Loading states ───────────────────────────────────────────────────── */
document.getElementById('frmLogin')?.addEventListener('submit', () => {
    document.getElementById('btnLogin').classList.add('loading');
});
document.getElementById('frmRegister')?.addEventListener('submit', () => {
    document.getElementById('btnRegister')?.classList.add('loading');
});
</script>

<?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-js.php'); ?>
</html>