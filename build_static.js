// build_static.js - Generates static HTML site in public/ for Firebase Hosting
const fs = require('fs');
const path = require('path');
const http = require('http');

const publicDir = path.join(__dirname, 'public');

// Ensure public directory exists
if (!fs.existsSync(publicDir)) {
  fs.mkdirSync(publicDir, { recursive: true });
}

// Copy assets
function copyFolderSync(from, to) {
  if (!fs.existsSync(to)) fs.mkdirSync(to, { recursive: true });
  fs.readdirSync(from).forEach(element => {
    const stat = fs.lstatSync(path.join(from, element));
    if (stat.isFile()) {
      fs.copyFileSync(path.join(from, element), path.join(to, element));
    } else if (stat.isDirectory()) {
      copyFolderSync(path.join(from, element), path.join(to, element));
    }
  });
}

copyFolderSync(path.join(__dirname, 'assets'), path.join(publicDir, 'assets'));
copyFolderSync(path.join(__dirname, 'data'), path.join(publicDir, 'data'));
if (fs.existsSync(path.join(__dirname, 'logo.jpg'))) {
  fs.copyFileSync(path.join(__dirname, 'logo.jpg'), path.join(publicDir, 'logo.jpg'));
}

function fetchUrl(urlPath) {
  return new Promise((resolve, reject) => {
    http.get(`http://localhost:8080${urlPath}`, res => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => resolve(data));
    }).on('error', reject);
  });
}

function processHtml(html) {
  // Convert .php links to .html or query parameters
  return html
    .replace(/href="([^"]*?)\.php\?cat=([^"]+)"/g, 'href="$1-cat-$2.html"')
    .replace(/href="([^"]*?)\.php\?id=([^"]+)"/g, 'href="article-$2.html"')
    .replace(/href="([^"]*?)\.php"/g, 'href="$1.html"')
    .replace(/action="([^"]*?)\.php"/g, 'action="$1.html"');
}

async function build() {
  console.log('Building static site for Firebase Hosting...');

  const pages = [
    { url: '/', file: 'index.html' },
    { url: '/expat-guide.php', file: 'expat-guide.html' },
    { url: '/currency.php', file: 'currency.html' },
    { url: '/prayer-times.php', file: 'prayer-times.html' },
    { url: '/directory.php', file: 'directory.html' },
    { url: '/search.php', file: 'search.html' }
  ];

  // Fetch categories
  const categories = JSON.parse(fs.readFileSync(path.join(__dirname, 'data/categories.json'), 'utf8'));
  categories.forEach(cat => {
    pages.push({ url: `/category.php?cat=${cat.id}`, file: `category-cat-${cat.id}.html` });
  });

  // Fetch articles
  const articles = JSON.parse(fs.readFileSync(path.join(__dirname, 'data/articles.json'), 'utf8'));
  articles.forEach(art => {
    pages.push({ url: `/article.php?id=${encodeURIComponent(art.id)}`, file: `article-${art.id}.html` });
  });

  for (const page of pages) {
    try {
      const rawHtml = await fetchUrl(page.url);
      const cleanHtml = processHtml(rawHtml);
      const outPath = path.join(publicDir, page.file);
      fs.writeFileSync(outPath, cleanHtml, 'utf8');
      console.log(`[GENERATED] ${page.file}`);
    } catch (e) {
      console.error(`[ERROR] ${page.url}: ${e.message}`);
    }
  }

  // Also create a fallback 404.html
  const notFoundHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Page Not Found | NEWS @ DOHA</title>
  <link rel="icon" type="image/jpeg" href="assets/img/logo.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light text-center py-5">
  <div class="container py-5">
    <img src="assets/img/logo.jpg" width="80" height="80" class="rounded mb-3">
    <h2 class="fw-bold text-maroon">NEWS @ DOHA</h2>
    <p class="text-muted">The requested page could not be found.</p>
    <a href="index.html" class="btn btn-maroon px-4">Back to Home</a>
  </div>
</body>
</html>`;
  fs.writeFileSync(path.join(publicDir, '404.html'), notFoundHtml, 'utf8');

  console.log('\nStatic site build completed in public/');
}

build();
