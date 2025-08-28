<?php
// ---------- PHP: compute home URL + load project ----------
$base    = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
$homeUrl = $base . 'index.php';

$projects  = json_decode(@file_get_contents('projects.json'), true) ?: [];
$projectId = $_GET['project'] ?? null;

if (!$projectId) { header('Location: ' . $homeUrl); exit(); }

$selectedProject = null;
foreach ($projects as $p) {
  if (($p['id'] ?? null) === $projectId) { $selectedProject = $p; break; }
}
if (!$selectedProject) { header('Location: ' . $homeUrl); exit(); }

// Safe helpers
$title = htmlspecialchars($selectedProject['title'] ?? 'Project');
$desc  = trim((string)($selectedProject['description'] ?? ''));
$short = htmlspecialchars($selectedProject['short_description'] ?? '');
$imgs  = array_values(array_filter($selectedProject['images'] ?? [], 'strlen'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<title><?php echo $title; ?> • Project</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
:root{
  --bg:#0b1220; --surface:#121826; --card:#0f172a;
  --text:#e5e7eb; --muted:#9ca3af;
  --primary:#60a5fa; --primary-2:#3b82f6; --accent:#8b5cf6; --teal:#22d3ee;
  --border:#203049; --shadow:0 10px 25px rgba(0,0,0,.45);
  --r:16px; --wrap:min(1200px,92vw); --headerH:70px;
}

html,body{background:var(--bg); color:var(--text); font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;}
*{box-sizing:border-box}
a{color:inherit; text-decoration:none;}
img{max-width:100%; display:block; height:auto;}
html{scroll-behavior:smooth; scroll-padding-top:calc(var(--headerH) + 10px);}

body{
  background:
    radial-gradient(900px 600px at 10% 10%, rgba(99,102,241,.14), transparent 60%),
    radial-gradient(900px 600px at 90% 85%, rgba(34,211,238,.10), transparent 55%),
    var(--bg);
  background-attachment: fixed;
}

.container{width:var(--wrap); margin:0 auto; padding:0 8px;}
.section__title{font-weight:900; font-size:clamp(1.6rem,3.2vw,2.3rem); margin:10px 0 6px;}
.section__subtitle{color:var(--muted); margin:0 0 16px;}

/* ===== Topbar (same style language as index) ===== */
.topbar{
  position:sticky; top:0; z-index:1000;
  background:rgba(10,14,22,.70); backdrop-filter:blur(10px);
  border-bottom:1px solid rgba(255,255,255,.08);
}
.topbar__inner{
  width:var(--wrap); margin:0 auto; padding:10px 8px;
  display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.brand{font-weight:900; letter-spacing:.2px;}

.nav{margin:0 auto;}
.nav__list{
  display:flex; gap:12px; list-style:none; margin:0; padding:8px 10px;
  border-radius:999px; background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.12); box-shadow:0 10px 30px rgba(0,0,0,.35);
}
.nav__link{
  font-weight:800; color:var(--text); line-height:1; white-space:nowrap;
  padding:9px 14px; border-radius:999px; transition:.18s;
}
.nav__link:hover, .nav__link.is-active{ color:#061018; background:linear-gradient(90deg,var(--accent),var(--primary)); }

.actions{display:flex; align-items:center; gap:10px;}
.btn-cta{
  display:inline-flex; align-items:center; gap:8px; font-weight:900;
  padding:10px 14px; border-radius:999px; color:#061018;
  background:linear-gradient(90deg,#10b981,var(--teal));
  border:1px solid rgba(255,255,255,.14); box-shadow:0 8px 22px rgba(34,211,238,.25);
}

/* Mobile menu */
.nav-toggle{
  display:none; width:44px; height:44px; border-radius:12px;
  border:1px solid rgba(255,255,255,.14);
  background:rgba(255,255,255,.06);
}
.hamburger,.hamburger::before,.hamburger::after{
  content:""; display:block; width:20px; height:2px; background:var(--text);
  margin:0 auto; position:relative; border-radius:2px;
}
.hamburger::before{position:absolute; top:-6px;}
.hamburger::after{position:absolute; top:6px;}

@media (max-width:860px){
  .nav-toggle{display:block;}
  .actions .btn-cta{display:none;}
  .nav{ position:fixed; left:0; right:0; top:calc(var(--headerH)); display:none; padding:10px 12px; }
  .nav__list{ justify-content:center; overflow-x:auto; -webkit-overflow-scrolling:touch; scrollbar-width:none; }
  .nav__list::-webkit-scrollbar{ display:none; }
  body.nav-open .nav{ display:block; background:rgba(7,12,22,.98); }
}

/* ===== Layout ===== */
main{ padding:22px 0 56px; }
.header-row{ margin-bottom:12px; }

/* ===== Carousel ===== */
.carousel{
  position:relative;
  width:min(1100px, 92vw);
  height:min(60vh, 620px);
  margin:12px auto 18px;
  border-radius:16px;
  background:#0a0f1c;
  border:1px solid var(--border);
  box-shadow:var(--shadow);
  overflow:hidden;
}
.track{ display:flex; height:100%; transition: transform .4s ease; }
.slide{ flex:0 0 100%; height:100%; display:grid; place-items:center; }
.slide img{
  max-width:100%; max-height:100%; object-fit:contain;
  cursor:zoom-in;
}

/* Arrows */
.cbtn{
  position:absolute; top:50%; transform:translateY(-50%);
  z-index:3; width:56px; height:56px; border-radius:50%;
  display:grid; place-items:center; color:#fff;
  background:rgba(8,12,20,.65);
  border:1px solid rgba(255,255,255,.35);
  box-shadow:0 8px 24px rgba(0,0,0,.55), 0 0 0 2px rgba(255,255,255,.15) inset;
  cursor:pointer; user-select:none;
}
.cbtn:hover{ background:rgba(8,12,20,.82); }
.prev{ left:12px; } .next{ right:12px; }
.cbtn i{ font-size:20px; }

/* Edge fades */
.edge{
  position:absolute; top:0; bottom:0; width:90px;
  z-index:2; pointer-events:none;
}
.edge.left{  left:0;  background:linear-gradient(90deg, rgba(11,18,32,.9), rgba(11,18,32,0)); }
.edge.right{ right:0; background:linear-gradient(270deg, rgba(11,18,32,.9), rgba(11,18,32,0)); }

/* Dots */
.dots{ position:absolute; left:0; right:0; bottom:10px; display:flex; gap:8px; justify-content:center; z-index:3; }
.dot{ width:8px; height:8px; border-radius:50%; background:rgba(255,255,255,.28); border:1px solid rgba(255,255,255,.35); cursor:pointer; }
.dot.active{ background:#fff; }

/* Description card */
.project-details{
  width:min(1100px, 92vw); margin:0 auto;
  background:var(--card); border:1px solid var(--border); border-radius:14px; box-shadow:var(--shadow);
  padding:18px; line-height:1.7;
}
.project-sub{ color:var(--muted); margin:0 0 14px; }

/* Lightbox */
.lightbox{
  position:fixed; inset:0; z-index:2000; display:none;
  align-items:center; justify-content:center;
  background:rgba(6,10,18,.92);
  -webkit-backdrop-filter: blur(2px); backdrop-filter: blur(2px);
}
.lightbox.open{ display:flex; }
.lightbox__img{
  max-width:92vw; max-height:90vh; object-fit:contain;
  cursor:zoom-out; border-radius:10px;
  border:1px solid rgba(255,255,255,.12); box-shadow:0 20px 60px rgba(0,0,0,.6);
}
.lightbox .cbtn{ width:60px; height:60px; }
.lightbox .prev{ left:20px; } .lightbox .next{ right:20px; }
.lightbox__close{
  position:absolute; top:16px; right:18px; width:46px; height:46px;
  display:grid; place-items:center; border-radius:10px; color:#fff;
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); cursor:pointer;
}
.lightbox__close:hover{ background:rgba(255,255,255,.18); }

/* Footer */
.footer{ border-top:1px solid var(--border); background:var(--surface); padding:22px 0; margin-top:42px; }
.footer__inner{ width:var(--wrap); margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
.footer__link{ color:var(--primary); font-weight:800; }

/* Mobile tweaks */
@media (max-width:520px){
  .cbtn{ width:48px; height:48px; }
  .edge{ width:72px; }
  .dots{ bottom:8px; }
}
</style>
<style>
  /* Center Software & Codes sections */
  .badge-section{ margin-top:36px; text-align:center; }
  .badge-title{ margin:0 0 14px; font-size:1.15rem; color:var(--muted); font-weight:800; text-align:center; }
  .badge-grid{
    display:flex; flex-wrap:wrap; gap:12px;
    list-style:none; margin:0; padding:0;
    justify-content:center;            /* <-- centers the badges */
    overflow-x:visible;
  }
</style>
<style>
  /* Center "Software" and "Codes & Standards" badges on all screens */
  .badge-section { text-align: center !important; }

  .badge-title {
    text-align: center !important;
    margin: 0 0 14px !important;
    font-weight: 800 !important;
  }

  /* Bulletproof centering of the badge grid */
  .badge-grid{
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 12px !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
  }

  /* Make each badge compact and consistent */
  .badge-grid .badge{
    display: inline-flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 10px 14px !important;
    border-radius: 12px !important;
    border: 1px solid var(--border) !important;
    background: linear-gradient(90deg, rgba(99,102,241,.15), rgba(34,211,238,.12)) !important;
    box-shadow: var(--shadow) !important;
    white-space: nowrap !important; /* keeps each badge tidy */
  }
</style>
<style>
  /* Center the two badge blocks inside the Skills section */
  #skills .badge-section{
    display:flex !important;
    flex-direction:column !important;
    align-items:center !important;   /* centers everything horizontally */
    text-align:center !important;
  }

  #skills .badge-title{
    text-align:center !important;
    margin: 20px 0 12px !important;
    font-weight:800 !important;
    width:100%;
  }

  #skills .badge-grid{
    display:flex !important;
    flex-wrap:wrap !important;
    justify-content:center !important;   /* the chips line up centered */
    align-items:center !important;
    gap:12px !important;
    list-style:none !important;
    padding:0 !important;                /* kill UL left padding */
    margin:0 auto !important;
    max-width: 1100px;                    /* keeps a nice line length */
  }

  #skills .badge-grid .badge{
    display:inline-flex !important;
    align-items:center !important;
    gap:10px !important;
    padding:10px 14px !important;
    border-radius:12px !important;
    border:1px solid var(--border) !important;
    background:linear-gradient(90deg, rgba(99,102,241,.15), rgba(34,211,238,.12)) !important;
    box-shadow:var(--shadow) !important;
    white-space:nowrap !important;
  }

  /* Fallback centering if your HTML lost the classes:
     any UL in #skills that contains .badge items will be centered */
  #skills ul:has(.badge){
    display:flex !important;
    flex-wrap:wrap !important;
    justify-content:center !important;
    gap:12px !important;
    padding:0 !important;
    margin:0 auto !important;
    list-style:none !important;
  }
  /* and center an h3 immediately before such a UL */
  #skills h3:has(+ ul .badge){ text-align:center !important; }
</style>

</head>
<body>

<header class="topbar" id="site-header">
  <div class="topbar__inner">
    <div class="brand">Mostafa</div>

    <button class="nav-toggle" aria-label="Open menu"><span class="hamburger"></span></button>

    <nav class="nav" aria-label="Primary">
      <ul class="nav__list">
        <!-- Always link back to index anchors -->
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#home">Home</a></li>
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#education">Education</a></li>
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#skills">Skills</a></li>
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#about">About</a></li>
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#work">Projects</a></li>
        <li><a class="nav__link" href="<?php echo $homeUrl; ?>#resume">Resume</a></li>
      </ul>
    </nav>

    <div class="actions">
      <a class="btn-cta" href="mailto:eng.mostafanajjar@outlook.com">Get in Touch <span aria-hidden="true">→</span></a>
    </div>
  </div>
</header>

<main>
  <div class="container header-row">
    <h1 class="section__title"><?php echo $title; ?></h1>
    <?php if ($short): ?><p class="section__subtitle project-sub"><?php echo $short; ?></p><?php endif; ?>
  </div>

  <!-- ===== Carousel ===== -->
  <div class="carousel" id="carousel" aria-label="Project images">
    <div class="track" id="track">
      <?php foreach ($imgs as $src): ?>
        <div class="slide"><img src="<?php echo htmlspecialchars($src); ?>" alt="<?php echo $title; ?>"></div>
      <?php endforeach; ?>
    </div>

    <div class="edge left"></div>
    <div class="edge right"></div>

    <button class="cbtn prev" id="prev" aria-label="Previous"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
    <button class="cbtn next" id="next" aria-label="Next"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>

    <div class="dots" id="dots">
      <?php for ($i=0; $i<count($imgs); $i++): ?>
        <span class="dot<?php echo $i===0?' active':''; ?>" data-i="<?php echo $i; ?>"></span>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ===== Description ===== -->
  <?php if ($desc): ?>
  <article class="project-details">
    <?php echo nl2br(htmlspecialchars($desc)); ?>
  </article>
  <?php endif; ?>
</main>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" aria-modal="true" role="dialog">
  <img class="lightbox__img" id="lightboxImg" alt="">
  <button class="lightbox__close" id="lbClose" aria-label="Close"><i class="fas fa-times"></i></button>
  <button class="cbtn prev" id="lbPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
  <button class="cbtn next" id="lbNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
</div>

<footer class="footer">
  <div class="footer__inner">
    <a href="mailto:eng.mostafanajjar@outlook.com" class="footer__link">eng.mostafanajjar@outlook.com</a>
    <a class="footer__link" href="https://linkedin.com/in/mostafa-najjar" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i> LinkedIn</a>
  </div>
</footer>

<script>
// Mobile menu
(() => {
  const btn = document.querySelector('.nav-toggle');
  btn?.addEventListener('click', () => document.body.classList.toggle('nav-open'));
  document.querySelectorAll('.nav__link').forEach(a => a.addEventListener('click', () => {
    document.body.classList.remove('nav-open');
  }));
})();

// Keep --headerH accurate (for scroll-padding on small screens)
(() => {
  const header = document.getElementById('site-header');
  const setH = () => document.documentElement.style.setProperty('--headerH', header.offsetHeight + 'px');
  setH(); addEventListener('resize', setH);
})();

// Highlight "Projects" in this page's nav
(() => {
  document.querySelectorAll('.nav__link').forEach(a => {
    const href = (a.getAttribute('href') || '').toLowerCase();
    a.classList.toggle('is-active', href.endsWith('#work'));
  });
})();

// Carousel + Lightbox (mobile friendly)
(() => {
  const track  = document.getElementById('track');
  const slides = Array.from(track?.children || []);
  const prev   = document.getElementById('prev');
  const next   = document.getElementById('next');
  const dotsW  = document.getElementById('dots');
  const dots   = Array.from(dotsW?.children || []);
  const lb     = document.getElementById('lightbox');
  const lbImg  = document.getElementById('lightboxImg');
  const lbClose= document.getElementById('lbClose');
  const lbPrev = document.getElementById('lbPrev');
  const lbNext = document.getElementById('lbNext');

  if (!track || !slides.length) return;

  let i = 0;
  const go = (idx) => {
    i = (idx + slides.length) % slides.length;
    track.style.transform = `translateX(${-i * 100}%)`;
    dots.forEach((d,k)=>d.classList.toggle('active', k===i));
  };

  prev?.addEventListener('click', ()=>go(i-1));
  next?.addEventListener('click', ()=>go(i+1));
  dots.forEach(d=>d.addEventListener('click', ()=>go(+d.dataset.i)));

  // Keyboard (no conflict with lightbox)
  window.addEventListener('keydown', e=>{
    if (lb.classList.contains('open')) return;
    if (e.key === 'ArrowLeft')  go(i-1);
    if (e.key === 'ArrowRight') go(i+1);
  });

  // Touch swipe
  let x0=null;
  track.addEventListener('touchstart', e=>{ x0 = e.touches[0].clientX; }, {passive:true});
  track.addEventListener('touchmove', e=>{
    if(x0===null) return;
    const dx = e.touches[0].clientX - x0;
    if (Math.abs(dx) > 60){ go(i + (dx<0 ? 1 : -1)); x0=null; }
  }, {passive:true});
  track.addEventListener('touchend', ()=>{ x0=null; });

  // Lightbox open on image click
  slides.forEach((s,idx) => {
    const img = s.querySelector('img');
    img?.addEventListener('click', ()=> openLB(idx));
  });

  function openLB(idx){
    i = (idx + slides.length) % slides.length;
    const img = slides[i].querySelector('img');
    lbImg.src = img?.getAttribute('src') || '';
    lbImg.alt = img?.getAttribute('alt') || '';
    lb.classList.add('open');
  }
  function closeLB(){ lb.classList.remove('open'); }
  function lbGo(di){ openLB(i + di); }

  lbClose?.addEventListener('click', closeLB);
  lb?.addEventListener('click', (e)=>{ if (e.target === lb) closeLB(); });
  lbPrev?.addEventListener('click', ()=> lbGo(-1));
  lbNext?.addEventListener('click', ()=> lbGo( 1));

  window.addEventListener('keydown', (e)=>{
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape') closeLB();
    if (e.key === 'ArrowLeft')  lbGo(-1);
    if (e.key === 'ArrowRight') lbGo( 1);
  });
})();
</script>
</body>
</html>
