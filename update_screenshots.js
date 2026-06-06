const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1280, height: 800 });

  // Homepage
  await page.goto('http://localhost:8080');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'img/homepage.png', fullPage: true });

  // Course Player (Custom)
  await page.goto('http://localhost:8080/courses/1');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'img/course_player.png', fullPage: true });

  // Admin Dashboard (Live Data)
  await page.goto('http://localhost:8080/admin');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'img/admin_dashboard.png', fullPage: true });

  await browser.close();
})();
