// build_static.js - Generates full static HTML site for Firebase Hosting
const fs = require('fs');
const path = require('path');
const http = require('http');

const publicDir = path.join(__dirname, 'public');

if (!fs.existsSync(publicDir)) {
  fs.mkdirSync(publicDir, { recursive: true });
}

// Copy assets & data folders
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

function cleanStaticHtml(html, isMalayalam = false) {
  let out = html;

  // 1. Convert absolute localhost URLs to relative URLs
  out = out.replace(/https?:\/\/localhost:8080\//g, './');
  out = out.replace(/https?:\/\/localhost:8080/g, './');

  // 2. Convert .php links to .html files
  out = out.replace(/href="(\.\/)?category\.php\?cat=([^"&]+)"/g, 'href="category-cat-$2.html"');
  out = out.replace(/href="(\.\/)?article\.php\?id=([^"&]+)"/g, 'href="article-$2.html"');
  out = out.replace(/href="(\.\/)?expat-guide\.php(#.*?)?"/g, 'href="expat-guide.html$2"');
  out = out.replace(/href="(\.\/)?currency\.php"/g, 'href="currency.html"');
  out = out.replace(/href="(\.\/)?prayer-times\.php"/g, 'href="prayer-times.html"');
  out = out.replace(/href="(\.\/)?directory\.php"/g, 'href="directory.html"');
  out = out.replace(/href="(\.\/)?search\.php"/g, 'href="search.html"');
  out = out.replace(/action="(\.\/)?search\.php"/g, 'action="search.html"');
  out = out.replace(/href="(\.\/)?admin\/index\.php"/g, 'href="admin/index.html"');
  out = out.replace(/href="(\.\/)?admin\/login\.php"/g, 'href="admin/index.html"');
  out = out.replace(/href="\.\/"/g, isMalayalam ? 'href="index-ml.html"' : 'href="index.html"');

  // 3. Language switcher link handling
  if (isMalayalam) {
    // When on a Malayalam page, the switcher should point to English
    out = out.replace(/href="\?lang=en"/g, 'href="index.html"');
    out = out.replace(/href="\?lang=ml"/g, 'href="index-ml.html"');
  } else {
    // When on an English page, the switcher should point to Malayalam
    out = out.replace(/href="\?lang=ml"/g, 'href="index-ml.html"');
    out = out.replace(/href="\?lang=en"/g, 'href="index.html"');
  }

  return out;
}

async function build() {
  console.log('Building 100% relative static site for Firebase Hosting...');

  const pages = [
    { url: '/', file: 'index.html', isMl: false },
    { url: '/?lang=ml', file: 'index-ml.html', isMl: true },
    { url: '/expat-guide.php', file: 'expat-guide.html', isMl: false },
    { url: '/currency.php', file: 'currency.html', isMl: false },
    { url: '/prayer-times.php', file: 'prayer-times.html', isMl: false },
    { url: '/directory.php', file: 'directory.html', isMl: false },
    { url: '/search.php', file: 'search.html', isMl: false }
  ];

  // Categories
  const categories = JSON.parse(fs.readFileSync(path.join(__dirname, 'data/categories.json'), 'utf8'));
  categories.forEach(cat => {
    pages.push({ url: `/category.php?cat=${cat.id}`, file: `category-cat-${cat.id}.html`, isMl: false });
  });

  // Articles
  const articles = JSON.parse(fs.readFileSync(path.join(__dirname, 'data/articles.json'), 'utf8'));
  articles.forEach(art => {
    pages.push({ url: `/article.php?id=${encodeURIComponent(art.id)}`, file: `article-${art.id}.html`, isMl: false });
  });

  for (const page of pages) {
    try {
      const rawHtml = await fetchUrl(page.url);
      const cleanHtml = cleanStaticHtml(rawHtml, page.isMl);
      const outPath = path.join(publicDir, page.file);
      fs.writeFileSync(outPath, cleanHtml, 'utf8');
      console.log(`[GENERATED] ${page.file}`);
    } catch (e) {
      console.error(`[ERROR] ${page.url}: ${e.message}`);
    }
  }

  // Generate public/admin/index.html (Client-side CMS dashboard for static hosting)
  const adminDir = path.join(publicDir, 'admin');
  if (!fs.existsSync(adminDir)) fs.mkdirSync(adminDir, { recursive: true });

  const adminHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editorial Management | NEWS @ DOHA</title>
  <link rel="icon" type="image/jpeg" href="../assets/img/logo.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
  <div class="navbar bg-maroon text-white py-2 px-3 shadow-sm">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <img src="../assets/img/logo.jpg" width="38" height="38" class="rounded me-2 bg-white p-1">
        <span class="fw-bold fs-5 text-white">NEWS @ DOHA Editorial Panel</span>
      </div>
      <div>
        <a href="../index.html" class="btn btn-sm btn-outline-light"><i class="fas fa-external-link-alt me-1"></i> View Live Site</a>
      </div>
    </div>
  </div>

  <div class="container my-4">
    <div class="card border-0 shadow-sm p-4 mb-4">
      <h4 class="fw-bold text-maroon mb-2"><i class="fas fa-tachometer-alt me-2"></i>Editorial CMS Status</h4>
      <p class="text-muted">You are viewing the static edition hosted on Firebase. Full dynamic PHP editing is active in your local XAMPP environment at <code>http://localhost/NEWSATDOHA/admin/</code>.</p>
      <div class="row g-3 text-center">
        <div class="col-md-4">
          <div class="p-3 border rounded bg-white">
            <h3 class="fw-bold text-maroon">${articles.length}</h3>
            <span class="text-muted small">Published Stories</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 border rounded bg-white">
            <h3 class="fw-bold text-success">${categories.length}</h3>
            <span class="text-muted small">Active Categories</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 border rounded bg-white">
            <h3 class="fw-bold text-primary">12,213+</h3>
            <span class="text-muted small">Facebook Followers</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
      <h5 class="fw-bold mb-3"><i class="fas fa-list me-2 text-maroon"></i>Published Articles</h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Headline</th>
              <th>Category</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            ${articles.map(a => `
              <tr>
                <td><img src="${a.image}" width="50" height="35" class="rounded object-fit-cover"></td>
                <td class="fw-bold">${a.title_en}</td>
                <td><span class="badge bg-secondary">${a.category}</span></td>
                <td class="small text-muted">${a.date}</td>
                <td><a href="../article-${a.id}.html" target="_blank" class="btn btn-sm btn-outline-maroon"><i class="fas fa-eye"></i> View</a></td>
              </tr>
            `).join('')}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>`;
  fs.writeFileSync(path.join(adminDir, 'index.html'), adminHtml, 'utf8');
  console.log('[GENERATED] admin/index.html');

  // Fallback 404
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
    <img src="assets/img/logo.jpg" width="80" height="80" class="rounded mb-3 border">
    <h2 class="fw-bold text-maroon">NEWS @ DOHA</h2>
    <p class="text-muted">The requested page could not be found.</p>
    <a href="index.html" class="btn btn-maroon px-4">Back to Home</a>
  </div>
</body>
</html>`;
  fs.writeFileSync(path.join(publicDir, '404.html'), notFoundHtml, 'utf8');

  console.log('\nStatic site build completed in public/ with all relative links!');
}

build();
