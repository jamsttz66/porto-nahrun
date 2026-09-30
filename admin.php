<?php
session_start();
require_once __DIR__ . '/content.php';

// Ganti kredensial ini sebelum upload. Password hanya disimpan sebagai hash.
const ADMIN_USER = 'admin';
const ADMIN_PASSWORD_HASH = '$2y$10$2b2eL1O7hQ7l.5JcL5Jq7u4x2E9hN9QyJvQYy1j6aJkWjYfG8gZyK';

function admin_logged_in(): bool { return !empty($_SESSION['portfolio_admin']); }
function admin_redirect(): never { header('Location: admin.php'); exit; }
function csrf_token(): string { if (empty($_SESSION['portfolio_csrf'])) $_SESSION['portfolio_csrf'] = bin2hex(random_bytes(24)); return $_SESSION['portfolio_csrf']; }
function csrf_valid(): bool { return isset($_POST['csrf']) && hash_equals($_SESSION['portfolio_csrf'] ?? '', $_POST['csrf']); }

if (isset($_GET['logout'])) { $_SESSION = []; session_destroy(); header('Location: admin.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    if (hash_equals(ADMIN_USER, (string) ($_POST['username'] ?? '')) && password_verify((string) ($_POST['password'] ?? ''), ADMIN_PASSWORD_HASH)) {
        session_regenerate_id(true); $_SESSION['portfolio_admin'] = true; admin_redirect();
    }
    $error = 'Username atau password salah.';
}

if (!admin_logged_in()) {
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin — Portofolio</title><link rel="stylesheet" href="css/style.css"><style>body{min-height:100vh;display:grid;place-items:center}.admin-box{width:min(92%,440px);padding:2rem;border:1px solid var(--line-strong);background:var(--surface);box-shadow:12px 12px 0 var(--accent-soft)}h1{font:400 2.7rem Georgia,serif;margin:.5rem 0 1.5rem}.field{display:grid;gap:.4rem;margin:1rem 0}label{color:var(--muted);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em}input,textarea{width:100%;padding:.75rem;border:1px solid var(--line-strong);background:var(--bg);color:var(--ink);font:inherit}textarea{min-height:90px;resize:vertical}.error{padding:.7rem;border:1px solid var(--signal);color:var(--signal);font-size:.85rem}.admin-box .button{width:100%;cursor:pointer}</style></head><body><main class="admin-box"><p class="mono-label">PORTFOLIO / ADMIN</p><h1>Masuk editor.</h1><?php if ($error): ?><p class="error"><?= portfolio_e($error) ?></p><?php endif; ?><form method="post"><input type="hidden" name="action" value="login"><div class="field"><label for="username">Username</label><input id="username" name="username" autocomplete="username" required></div><div class="field"><label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required></div><button class="button primary" type="submit">Masuk ke dashboard</button></form></main></body></html><?php exit; }

$content = portfolio_load();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save') {
    if (!csrf_valid()) { http_response_code(400); exit('Token tidak valid. Muat ulang halaman.'); }
    $fields = ['tagline','location','focus','status','email','about_statement','about_one','about_two'];
    foreach ($fields as $field) $content[$field] = trim((string) ($_POST[$field] ?? ''));
    foreach (['first','middle','last'] as $field) $content['name'][$field] = trim((string) ($_POST['name'][$field] ?? ''));
    foreach (['facts','skills','experience','targets'] as $group) {
        if (isset($_POST[$group]) && is_array($_POST[$group])) $content[$group] = array_values(array_map(static fn($row) => is_array($row) ? array_map(static fn($v) => trim((string)$v), $row) : [], $_POST[$group]));
    }
    if (portfolio_save($content)) $_SESSION['portfolio_notice'] = 'Perubahan tersimpan.'; else $_SESSION['portfolio_notice'] = 'Gagal menyimpan. Pastikan folder storage writable.';
    admin_redirect();
}
$notice = $_SESSION['portfolio_notice'] ?? ''; unset($_SESSION['portfolio_notice']);
function field(string $name, string $value): string { return '<input name="'.portfolio_e($name).'" value="'.portfolio_e($value).'">'; }
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard — Portofolio</title><link rel="stylesheet" href="css/style.css"><style>
.admin-shell{max-width:1100px;margin:auto;padding:2rem 1rem 5rem}.admin-top{display:flex;justify-content:space-between;gap:1rem;align-items:center;margin-bottom:2rem;border-bottom:1px solid var(--line);padding-bottom:1.2rem}.admin-top h1{margin:0;font:400 clamp(2rem,5vw,4rem) Georgia,serif}.admin-card{margin:1.2rem 0;padding:1.3rem;border:1px solid var(--line);background:var(--surface)}.admin-card h2{margin:0 0 1rem;font:400 1.5rem Georgia,serif}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}.field{display:grid;gap:.35rem}.field.full{grid-column:1/-1}label{font-size:.68rem;color:var(--faint);text-transform:uppercase;letter-spacing:.08em}input,textarea{width:100%;padding:.7rem;border:1px solid var(--line-strong);background:var(--bg);color:var(--ink);font:inherit}textarea{min-height:100px;resize:vertical}.repeat-row{display:grid;grid-template-columns:1fr 2fr;gap:.75rem;padding:.8rem 0;border-bottom:1px solid var(--line)}.repeat-row.three{grid-template-columns:1fr 1fr 2fr}.repeat-row:last-child{border-bottom:0}.savebar{position:sticky;bottom:1rem;display:flex;justify-content:flex-end;gap:1rem;padding:1rem;border:1px solid var(--line-strong);background:color-mix(in srgb,var(--surface) 94%,transparent);backdrop-filter:blur(12px)}.notice{padding:.75rem;border:1px solid var(--accent);color:var(--accent-strong)}@media(max-width:680px){.form-grid,.repeat-row,.repeat-row.three{grid-template-columns:1fr}.admin-top{align-items:flex-start;flex-direction:column}}
</style></head><body><main class="admin-shell"><div class="admin-top"><div><p class="mono-label">PORTFOLIO / DASHBOARD</p><h1>Edit konten.</h1></div><div><a class="button secondary" href="index.php" target="_blank">Lihat porto</a> <a class="button" href="admin.php?logout=1">Keluar</a></div></div><?php if ($notice): ?><p class="notice"><?= portfolio_e($notice) ?></p><?php endif; ?><form method="post"><input type="hidden" name="action" value="save"><input type="hidden" name="csrf" value="<?= portfolio_e(csrf_token()) ?>">
<section class="admin-card"><h2>Identitas</h2><div class="form-grid"><div class="field"><label>Nama depan</label><?= field('name[first]', $content['name']['first']) ?></div><div class="field"><label>Nama tengah</label><?= field('name[middle]', $content['name']['middle']) ?></div><div class="field"><label>Nama belakang</label><?= field('name[last]', $content['name']['last']) ?></div><div class="field"><label>Email</label><?= field('email', $content['email']) ?></div><div class="field full"><label>Tagline</label><textarea name="tagline"><?= portfolio_e($content['tagline']) ?></textarea></div><div class="field"><label>Domisili</label><?= field('location', $content['location']) ?></div><div class="field"><label>Fokus</label><?= field('focus', $content['focus']) ?></div><div class="field"><label>Status</label><?= field('status', $content['status']) ?></div></div></section>
<section class="admin-card"><h2>Tentang saya</h2><div class="field"><label>Statement</label><textarea name="about_statement"><?= portfolio_e($content['about_statement']) ?></textarea></div><div class="field"><label>Paragraf 1</label><textarea name="about_one"><?= portfolio_e($content['about_one']) ?></textarea></div><div class="field"><label>Paragraf 2</label><textarea name="about_two"><?= portfolio_e($content['about_two']) ?></textarea></div></section>
<section class="admin-card"><h2>Ringkasan profil</h2><?php foreach ($content['facts'] as $i => $row): ?><div class="repeat-row"><input name="facts[<?= $i ?>][value]" value="<?= portfolio_e($row['value']) ?>"><input name="facts[<?= $i ?>][label]" value="<?= portfolio_e($row['label']) ?>"></div><?php endforeach; ?></section>
<section class="admin-card"><h2>Skill</h2><?php foreach ($content['skills'] as $i => $row): ?><div class="repeat-row"><input name="skills[<?= $i ?>][title]" value="<?= portfolio_e($row['title']) ?>"><textarea name="skills[<?= $i ?>][description]" placeholder="Deskripsi"><?= portfolio_e($row['description']) ?></textarea></div><?php endforeach; ?></section>
<section class="admin-card"><h2>Perjalanan</h2><?php foreach ($content['experience'] as $i => $row): ?><div class="repeat-row three"><input name="experience[<?= $i ?>][period]" value="<?= portfolio_e($row['period']) ?>"><input name="experience[<?= $i ?>][title]" value="<?= portfolio_e($row['title']) ?>"><textarea name="experience[<?= $i ?>][organization]" placeholder="Organisasi"><?= portfolio_e($row['organization']) ?></textarea><textarea name="experience[<?= $i ?>][description]" placeholder="Deskripsi"><?= portfolio_e($row['description']) ?></textarea></div><?php endforeach; ?></section>
<section class="admin-card"><h2>Target belajar</h2><?php foreach ($content['targets'] as $i => $row): ?><div class="repeat-row"><input name="targets[<?= $i ?>][code]" value="<?= portfolio_e($row['code']) ?>"><input name="targets[<?= $i ?>][title]" value="<?= portfolio_e($row['title']) ?>"><textarea name="targets[<?= $i ?>][description]" placeholder="Deskripsi"><?= portfolio_e($row['description']) ?></textarea></div><?php endforeach; ?></section>
<div class="savebar"><button class="button primary" type="submit">Simpan semua perubahan</button></div></form></main></body></html>
