// @ts-check
import { test, expect } from '@playwright/test';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const screenshotDir = path.join(__dirname, 'screenshots');

// ============================================================
// FITUR 1: AUTENTIKASI LOGIN
// ============================================================

test('01 - Halaman Login Tampil dengan Benar', async ({ page }) => {
  await page.goto('/login');

  // Verifikasi elemen login
  await expect(page.locator('h1')).toContainText('Layanan Persuratan Digital');
  await expect(page.locator('input#login')).toBeVisible();
  await expect(page.locator('input#password')).toBeVisible();
  await expect(page.locator('button[type="submit"]')).toContainText('Masuk');

  await page.screenshot({ path: path.join(screenshotDir, '01-halaman-login.png'), fullPage: true });
});

test('02 - Login Gagal dengan Password Salah', async ({ page }) => {
  await page.goto('/login');

  await page.fill('input#login', 'fajar@example.com');
  await page.fill('input#password', 'passwordsalah');
  await page.click('button[type="submit"]');

  // Tunggu halaman selesai loading dan menampilkan error
  await page.waitForLoadState('networkidle');
  
  // Harus tetap di halaman login
  await expect(page).toHaveURL(/.*login.*/);

  await page.screenshot({ path: path.join(screenshotDir, '02-login-gagal.png'), fullPage: true });
});

test('03 - Login Berhasil sebagai Warga', async ({ page }) => {
  await page.goto('/login');

  await page.fill('input#login', 'fajar@example.com');
  await page.fill('input#password', '123');
  await page.click('button[type="submit"]');

  // Harus diarahkan ke dashboard warga
  await page.waitForURL('**/warga/dashboard', { timeout: 15000 });
  await expect(page.locator('text=Selamat datang')).toBeVisible();

  await page.screenshot({ path: path.join(screenshotDir, '03-dashboard-warga.png'), fullPage: true });

  // Logout untuk test berikutnya
  // Cari tombol/link logout - biasanya di navigasi
  const logoutForm = page.locator('form[action*="logout"]');
  if (await logoutForm.count() > 0) {
    await logoutForm.first().locator('button').click();
    await page.waitForURL('**/login', { timeout: 10000 });
  }
});

test('04 - Login Berhasil sebagai Admin', async ({ page }) => {
  await page.goto('/login');

  await page.fill('input#login', 'admin@desa-babakanmulya.id');
  await page.fill('input#password', 'admin123');
  await page.click('button[type="submit"]');

  // Harus diarahkan ke dashboard admin
  await page.waitForURL('**/admin/dashboard', { timeout: 15000 });
  await expect(page.locator('text=Selamat Datang')).toBeVisible();

  await page.screenshot({ path: path.join(screenshotDir, '04-dashboard-admin.png'), fullPage: true });
});

// ============================================================
// FITUR 2: PENGAJUAN SURAT OLEH WARGA
// ============================================================

test('05 - Warga Melihat Halaman Riwayat Pengajuan', async ({ page }) => {
  // Login sebagai warga
  await page.goto('/login');
  await page.fill('input#login', 'fajar@example.com');
  await page.fill('input#password', '123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/warga/dashboard', { timeout: 15000 });

  // Navigasi ke halaman pengajuan / riwayat
  await page.goto('/warga/pengajuan');
  await page.waitForLoadState('networkidle');

  await page.screenshot({ path: path.join(screenshotDir, '05-riwayat-pengajuan-warga.png'), fullPage: true });
});

test('06 - Warga Membuka Form Pengajuan Surat Baru', async ({ page }) => {
  // Login sebagai warga
  await page.goto('/login');
  await page.fill('input#login', 'fajar@example.com');
  await page.fill('input#password', '123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/warga/dashboard', { timeout: 15000 });

  // Navigasi ke form pengajuan
  await page.goto('/warga/pengajuan/create');
  await page.waitForLoadState('networkidle');

  // Verifikasi form elements
  await expect(page.locator('text=Ajukan Surat Baru')).toBeVisible();
  await expect(page.locator('#jenis_surat')).toBeVisible();
  await expect(page.locator('#keperluan')).toBeVisible();

  // Isi jenis surat untuk menampilkan persyaratan
  await page.selectOption('#jenis_surat', 'SKTM');

  await page.screenshot({ path: path.join(screenshotDir, '06-form-pengajuan-surat.png'), fullPage: true });
});

// ============================================================
// FITUR 3: KELOLA SURAT OLEH ADMIN
// ============================================================

test('07 - Admin Melihat Daftar Pengajuan Surat', async ({ page }) => {
  // Login sebagai admin
  await page.goto('/login');
  await page.fill('input#login', 'admin@desa-babakanmulya.id');
  await page.fill('input#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard', { timeout: 15000 });

  // Navigasi ke kelola surat
  await page.goto('/admin/kelola-surat');
  await page.waitForLoadState('networkidle');

  await expect(page.locator('text=Daftar Pengajuan Surat')).toBeVisible();

  await page.screenshot({ path: path.join(screenshotDir, '07-admin-kelola-surat.png'), fullPage: true });
});

test('08 - Admin Melihat Detail Pengajuan Surat', async ({ page }) => {
  // Login sebagai admin
  await page.goto('/login');
  await page.fill('input#login', 'admin@desa-babakanmulya.id');
  await page.fill('input#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard', { timeout: 15000 });

  // Navigasi ke kelola surat
  await page.goto('/admin/kelola-surat');
  await page.waitForLoadState('networkidle');

  // Klik tombol Detail pada pengajuan pertama (jika ada data)
  const detailBtn = page.locator('a:has-text("Detail")').first();
  if (await detailBtn.isVisible()) {
    await detailBtn.click();
    await page.waitForLoadState('networkidle');

    // Verifikasi halaman detail
    await expect(page.locator('text=Data Pemohon')).toBeVisible();
    await expect(page.locator('text=Status Surat')).toBeVisible();
    await expect(page.locator('#status')).toBeVisible();

    await page.screenshot({ path: path.join(screenshotDir, '08-admin-detail-surat.png'), fullPage: true });
  } else {
    // Jika tidak ada data, screenshot halaman kosong
    await page.screenshot({ path: path.join(screenshotDir, '08-admin-detail-surat-kosong.png'), fullPage: true });
  }
});

test('09 - Admin Filter Surat Berdasarkan Status', async ({ page }) => {
  // Login sebagai admin
  await page.goto('/login');
  await page.fill('input#login', 'admin@desa-babakanmulya.id');
  await page.fill('input#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard', { timeout: 15000 });

  // Navigasi ke kelola surat dengan filter "Menunggu"
  await page.goto('/admin/kelola-surat?status=Menunggu');
  await page.waitForLoadState('networkidle');

  await page.screenshot({ path: path.join(screenshotDir, '09-admin-filter-menunggu.png'), fullPage: true });
});

// ============================================================
// FITUR 4: LAPORAN ADMIN
// ============================================================

test('10 - Admin Melihat Halaman Laporan', async ({ page }) => {
  // Login sebagai admin
  await page.goto('/login');
  await page.fill('input#login', 'admin@desa-babakanmulya.id');
  await page.fill('input#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard', { timeout: 15000 });

  // Navigasi ke laporan
  await page.goto('/admin/laporan');
  await page.waitForLoadState('networkidle');

  await page.screenshot({ path: path.join(screenshotDir, '10-admin-laporan.png'), fullPage: true });
});
