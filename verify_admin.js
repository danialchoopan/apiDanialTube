const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1280, height: 800 });

  // We might need to login. Voyager default is admin/password if seeded.
  // But let's see if we can just hit the dashboard.
  // The RealisticDataSeeder might not have created an admin user, but Voyager's own seeder might.

  await page.goto('http://localhost:8080/admin');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'img/admin_dashboard.png', fullPage: true });

  await browser.close();
})();
