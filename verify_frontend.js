const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  // Set viewport for better screenshots
  await page.setViewportSize({ width: 1280, height: 720 });

  // 1. Homepage
  await page.goto('http://localhost:8080');
  await page.screenshot({ path: 'homepage.png', fullPage: true });
  console.log('Homepage screenshot captured.');

  // 2. Video Player Page
  await page.goto('http://localhost:8080/courses/1');
  await page.screenshot({ path: 'course_player.png', fullPage: true });
  console.log('Course Player screenshot captured.');

  await browser.close();
})();
