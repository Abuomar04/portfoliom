<?php
// ---------- PHP: data ----------
$projects = json_decode(file_get_contents('projects.json'), true) ?? [];

$cvPath = 'Documentation/Mostafa El Badawi El Najjar- CV 2025.pdf';
$cvVer  = file_exists($cvPath) ? filemtime($cvPath) : time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<title>Mostafa Najjar • MEP Engineer</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* ====== Design tokens ====== */
:root{
  --bg: #0b1220;
  --surface: #121826;
  --card: #0f172a;
  --text: #e5e7eb;
  --muted:#9ca3af;
  --primary:#60a5fa;
  --primary-2:#3b82f6;
  --accent:#8b5cf6;
  --teal:#22d3ee;
  --border:#203049;
  --shadow:0 10px 25px rgba(0,0,0,.45);
  --radius:16px;
  --maxw:1200px;
}

/* ====== Base ====== */
html,body{background:var(--bg); color:var(--text); font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;}
img{max-width:100%; height:auto; display:block;}
a{color:inherit; text-decoration:none;}

body{
  background:
    radial-gradient(900px 600px at 10% 10%, rgba(99,102,241,.14), transparent 60%),
    radial-gradient(900px 600px at 90% 85%, rgba(34,211,238,.10), transparent 55%),
    var(--bg);
  background-attachment: fixed;
}

.container{max-width:var(--maxw); margin:0 auto; padding:0 16px;}
section{padding:84px 0;}
.section__title{font-weight:900; font-size:clamp(1.6rem, 3.5vw, 2.4rem); text-align:center; margin:0 0 10px;}
.section__subtitle{color:var(--muted); text-align:center; margin:0 0 32px;}

/* ====== Top bar ====== */
.topbar{
  position:sticky; top:0; z-index:1000;
  background:rgba(10,14,22,.70); backdrop-filter:blur(10px);
  border-bottom:1px solid rgba(255,255,255,.08);
  padding-top: env(safe-area-inset-top);
}
.topbar__inner{max-width:var(--maxw); margin:0 auto; padding:10px 16px; display:flex; align-items:center; gap:12px;}
/* Brand gradient like active pill */
.brand{
  font-weight:900;
  background: linear-gradient(90deg, var(--accent), var(--primary));
  -webkit-background-clip: text; background-clip: text; color: transparent;
  text-shadow: 0 0 22px rgba(96,165,250,.22);
}

/* nav pills */
.nav{margin-left:auto; margin-right:auto;}
.nav__list{
  display:flex; align-items:center; gap:12px;
  list-style:none; padding:8px 10px; margin:0;
  border-radius:999px;
  background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.12);
  box-shadow:0 10px 30px rgba(0,0,0,.35);
}
.nav__link{
  font-weight:700; line-height:1;
  padding:9px 14px; border-radius:999px; white-space:nowrap;
  transition:.18s; color:var(--text);
}
.nav__link:hover,
.nav__link.is-active{color:#061018; background:linear-gradient(90deg, var(--accent), var(--primary));}

/* actions */
.actions{display:flex; align-items:center; gap:10px;}
.btn-cta{
  display:inline-flex; align-items:center; gap:8px;
  padding:10px 14px; border-radius:999px; font-weight:900;
  color:#061018; background:linear-gradient(90deg,#10b981,var(--teal));
  border:1px solid rgba(255,255,255,.14); box-shadow:0 8px 22px rgba(34,211,238,.25);
}

/* mobile nav: SECOND ROW inside topbar (no overlay) */
@media (max-width: 860px){
  .topbar__inner{ flex-wrap:wrap; row-gap:8px; }
  .nav{ position:static; width:100%; }
  .nav__list{
    width:100%;
    justify-content:flex-start;
    overflow-x:auto; -webkit-overflow-scrolling:touch;
    scrollbar-width:none; gap:10px;
  }
  .nav__list::-webkit-scrollbar{ display:none; }
  .actions .btn-cta{ display:none; } /* keep only icons if tight */
}

/* ====== HERO ====== */
.intro-grid{ display:grid; gap:24px; align-items:center; }
@media (min-width:980px){
  .intro-grid{ grid-template-columns:minmax(260px,360px) 1fr; }
}
.intro__img{
  border-radius:22px; border:3px solid transparent;
  border-image: linear-gradient(135deg, var(--accent), var(--primary), var(--teal)) 1;
  box-shadow:0 16px 38px rgba(0,0,0,.5), 0 0 40px rgba(34,211,238,.15);
  transition:.25s;
}
.intro__img:hover{transform:translateY(-2px); box-shadow:0 22px 54px rgba(0,0,0,.55), 0 0 44px rgba(96,165,250,.22);}

/* Hero title: proper spacing */
.hero-title{ margin:0; }
.hero-title .hello{
  display:block;
  font-size: clamp(.95rem, 2.6vw, 1rem);
  letter-spacing:.02em;
  color: var(--muted);
  margin-bottom: .45rem; /* breathing room */
}
.hero-title .name{
  display:block;
  font-weight: 900;
  font-size: clamp(2.0rem, 4.6vw, 2.8rem);
  line-height: 1.12;
}
.section__subtitle--intro{
  display:inline-block; margin-top: 12px;
  padding:8px 12px; border-radius:12px;
  background:linear-gradient(90deg, var(--accent), var(--primary));
  color:#061018; font-weight:900;
}
.hero-pills{display:flex; flex-wrap:wrap; gap:10px; margin:14px 0 0; padding:0; list-style:none;}
.hero-pills li{display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px;
  background:rgba(255,255,255,.06); border:1px solid var(--border); box-shadow:var(--shadow); font-weight:700;}

/* ====== Education ====== */
.education{background:var(--surface);}
.edu{
  display:grid; gap:22px; align-items:center;
  grid-template-columns:120px 1fr;
  max-width:900px; margin:0 auto; padding:18px; border-radius:var(--radius);
  background:var(--card); border:1px solid var(--border); box-shadow:var(--shadow);
}
.edu img{width:100%; height:100px; object-fit:cover; border-radius:12px; border:1px solid var(--border);}
.edu h3{margin:0 0 6px; font-weight:900;}
.edu .degree{margin:0 0 12px; color:var(--muted); font-weight:700;}
.edu .chips{display:flex; flex-wrap:wrap; gap:8px; list-style:none; padding:0; margin:0;}
.edu .chip{padding:6px 10px; border-radius:999px; font-size:.85rem; color:#d9f7ff; background:rgba(34,211,238,.12); border:1px solid rgba(34,211,238,.22);}
@media (max-width:640px){ .edu{grid-template-columns:1fr;} .edu img{height:140px;} }

/* ====== Skills ====== */
.skills-grid{display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:18px;}
.skill{
  background:var(--card); border:1px solid var(--border); border-radius:var(--radius);
  box-shadow:var(--shadow); padding:20px; transition:.2s;
}
.skill:hover{transform:translateY(-4px); border-color:rgba(34,211,238,.35); box-shadow:0 18px 36px rgba(0,0,0,.5);}
.skill .icon{font-size:28px; color:var(--primary); margin-bottom:8px;}
.skill h3{margin:6px 0 8px;}
.skill p{color:var(--muted);}

/* — Centered Software & Codes rows — */
.badge-section{ margin-top: 36px; display:flex; flex-direction:column; align-items:center; text-align:center; }
.badge-title{ margin: 0 0 14px; font-size: 1.15rem; color: var(--muted); font-weight: 800; text-align:center; width:100%; }
.badge-grid{
  display: flex; flex-wrap: wrap; justify-content:center; align-items:center;
  gap: 12px; list-style: none; margin: 0 auto; padding: 0;
  max-width: 1100px;
  overflow-x: auto; -webkit-overflow-scrolling: touch;
}
.badge-grid::-webkit-scrollbar{ display:none; }
.badge{
  display: inline-flex; align-items: center; gap: 10px;
  padding: 10px 14px; border-radius: 12px;
  background: linear-gradient(90deg, rgba(99,102,241,.14), rgba(34,211,238,.12));
  border: 1px solid var(--border); box-shadow: var(--shadow);
  transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease;
  white-space:nowrap;
}
.badge:hover{ transform: translateY(-2px) scale(1.02); border-color: rgba(34,211,238,.35); background: linear-gradient(90deg, rgba(99,102,241,.20), rgba(34,211,238,.18)); }
.badge__logo{ width:22px; height:22px; object-fit:contain; }
.badge span{ font-weight: 700; color: var(--text); }

/* ====== About ====== */
.about{background:var(--surface);}
.about .grid{display:grid; gap:36px; align-items:start;}
@media (min-width:1000px){ .about .grid{grid-template-columns:1.15fr .85fr;} }
.about .lead{line-height:1.8; color:var(--text); margin:8px 0 18px;}
.tags{display:flex; flex-wrap:wrap; gap:10px; list-style:none; padding:0; margin:0 0 18px;}
.tags li{padding:8px 12px; border-radius:12px; background:rgba(99,102,241,.14); border:1px solid rgba(255,255,255,.12); font-weight:700; transition:.15s;}
.tags li:hover{transform:translateY(-2px); box-shadow:0 12px 24px rgba(0,0,0,.35); border-color:rgba(34,211,238,.35);}
.stats{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px;}
@media (max-width:560px){ .stats{grid-template-columns:repeat(2,1fr);} }
.stat{background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 12px; text-align:center; transition:.15s;}
.stat:hover{transform:translateY(-2px); border-color:rgba(34,211,238,.35);}
.stat .num{font-weight:900; font-size:1.6rem; background:linear-gradient(90deg,var(--primary),var(--teal)); -webkit-background-clip:text; background-clip:text; color:transparent;}
.stat .label{color:var(--muted); font-weight:700; font-size:.92rem;}
.photo{
  position:relative; border-radius:18px; overflow:hidden;
  background:
    linear-gradient(var(--card),var(--card)) padding-box,
    linear-gradient(120deg,rgba(139,92,246,.6),rgba(96,165,250,.6)) border-box;
  border:1px solid transparent; box-shadow:0 20px 60px rgba(0,0,0,.45); transition:.2s;
}
.photo:hover{transform:translateY(-4px) scale(1.01); box-shadow:0 28px 70px rgba(0,0,0,.55);}

/* ====== Projects ====== */
.projects-grid{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px;}
@media (max-width:1100px){ .projects-grid{grid-template-columns:repeat(2,1fr);} }
@media (max-width:700px){ .projects-grid{grid-template-columns:1fr;} }
.card{
  background:rgba(15,22,35,.92); border:1px solid rgba(255,255,255,.08); border-radius:18px;
  overflow:hidden; box-shadow:0 12px 30px rgba(0,0,0,.45); display:flex; flex-direction:column; transition:.2s; position:relative;
}
.card:hover{transform:translateY(-4px); border-color:rgba(34,211,238,.35);}
.card__media{display:block; aspect-ratio:16/10; background:#0b1220;}
.card__media img{width:100%; height:100%; object-fit:cover;}
.card__body{padding:14px 16px; display:flex; flex-direction:column; gap:8px; flex:1;}
.chips{display:flex; flex-wrap:wrap; gap:8px;}
.chip{padding:4px 8px; border-radius:999px; font-size:.75rem; color:#d9f7ff; background:rgba(34,211,238,.12); border:1px solid rgba(34,211,238,.22);}
.card__cta{
  align-self:flex-start; margin-top:auto; font-weight:900; color:#061018;
  background:linear-gradient(90deg,var(--accent),var(--primary));
  padding:10px 14px; border-radius:12px; border:1px solid rgba(255,255,255,.1);
}

/* ====== Resume ====== */
.resume .box{
  max-width:780px; margin:0 auto; padding:18px; display:flex; flex-wrap:wrap; gap:14px; justify-content:space-between; align-items:center;
  background:var(--card); border:1px solid var(--border); border-radius:14px; box-shadow:var(--shadow);
}
.btn{display:inline-block; padding:10px 14px; border-radius:12px; font-weight:900;
     color:#061018; background:linear-gradient(90deg,var(--primary),var(--primary-2)); border:1px solid rgba(255,255,255,.12);}
.btn:hover{filter:saturate(1.05);}

/* ====== Footer ====== */
.footer{border-top:1px solid var(--border); background:var(--surface); padding:22px 0;}
.social{display:flex; gap:12px; list-style:none; padding:0; margin:8px 0 0;}
.social a{display:inline-grid; place-items:center; width:40px; height:40px; border-radius:12px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12);}
.social a:hover{transform:translateY(-2px);}

/* Mobile polish + edge cases */
html { -webkit-text-size-adjust: 100%; }
* { min-width: 0; }
:where(h1,h2,h3,p,li,span,a){ overflow-wrap:anywhere; }
.icon-btn, .btn-cta, .nav__link { min-height: 44px; }
section { scroll-margin-top: 76px; } /* header offset */
@media (prefers-reduced-motion: reduce) { html:focus-within { scroll-behavior: auto; } * { animation: none !important; transition: none !important; } }
:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
* { -webkit-tap-highlight-color: rgba(255,255,255,0.08); }
</style>
</head>
<body>

<header class="topbar">
  <div class="topbar__inner">
    <div class="brand">Mostafa</div>

    <!-- Center nav -->
    <nav class="nav" aria-label="Primary">
      <ul class="nav__list">
        <li><a class="nav__link" href="#home">Home</a></li>
        <li><a class="nav__link" href="#education">Education</a></li>
        <li><a class="nav__link" href="#skills">Skills</a></li>
        <li><a class="nav__link" href="#about">About</a></li>
        <li><a class="nav__link" href="#work">Projects</a></li>
        <li><a class="nav__link" href="#resume">Resume</a></li>
      </ul>
    </nav>

    <!-- Right actions -->
    <div class="actions">
      <a class="btn-cta" href="mailto:eng.mostafanajjar@outlook.com">Get in Touch <span aria-hidden="true">→</span></a>
      <a class="social-btn" href="https://linkedin.com/in/mostafa-najjar" target="_blank" rel="noopener" title="LinkedIn"
         style="display:grid;place-items:center;width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
  </div>
</header>

<!-- ===== HERO ===== -->
<section id="home" class="intro">
  <div class="container intro-grid">
    <img class="intro__img" src="img/Pfp-mos.jpg" alt="Mostafa Najjar">
    <div class="intro__text">
      <h1 class="hero-title">
        <span class="hello">Hello, I am</span>
        <span class="name">Mostafa Najjar !</span>
      </h1>
      <p class="section__subtitle section__subtitle--intro">MEP Designer &amp; BIM Modeler</p>

      <ul class="hero-pills">
        <li>🛠️ MEP Design</li>
        <li>🧩 BIM / Revit</li>
        <li>🌱 Sustainable HVAC</li>
      </ul>
    </div>
  </div>
</section>

<!-- ===== EDUCATION ===== -->
<section id="education" class="education">
  <div class="container">
    <h2 class="section__title">Education</h2>
    <p class="section__subtitle">B.E. in Mechanical Engineering</p>

    <div class="edu">
      <img src="img/lau.jpg" alt="Lebanese American University" onerror="this.style.display='none'">
      <div>
        <h3>Lebanese American University (LAU)</h3>
        <p class="degree">Bachelor of Engineering • Mechanical Engineering (2022–2026)</p>
        <ul class="chips">
          <li class="chip">HVAC</li>
          <li class="chip">Thermodynamics</li>
          <li class="chip">Fluid Mechanics</li>
          <li class="chip">Heat Transfer</li>
          <li class="chip">Mechanical Design</li>
          <li class="chip">Thermal Systems</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ===== SKILLS ===== -->
<section id="skills">
  <div class="container">
    <h2 class="section__title">My Skills</h2>
    <p class="section__subtitle">What I work with</p>

    <div class="skills-grid">
      <div class="skill">
        <div class="icon"><i class="fas fa-cogs"></i></div>
        <h3>Systems Design &amp; Standards</h3>
        <p>Designing & integrating MEP systems for residential, commercial & institutional projects; codes like ASHRAE & IPC; accurate load calculations & optimization.</p>
      </div>

      <div class="skill">
        <div class="icon"><i class="fas fa-drafting-compass"></i></div>
        <h3>BIM &amp; Digital Engineering</h3>
        <p>Building Information Modeling with Revit—precise, coordinated, construction-ready models for efficient multidisciplinary collaboration.</p>
      </div>

      <div class="skill">
        <div class="icon"><i class="fas fa-users"></i></div>
        <h3>Leadership &amp; Collaboration</h3>
        <p>Club president, scout leader, and startup co-founder—driving delivery, communication, and teamwork.</p>
      </div>
    </div>

    <!-- Centered Software & Tools -->
    <div class="badge-section" id="software">
      <h3 class="badge-title">Software &amp; Tools</h3>
      <ul class="badge-grid">
        <li class="badge"><img src="img/revit.jpg" alt="Revit" class="badge__logo" onerror="this.style.display='none'"><span>Revit</span></li>
        <li class="badge"><img src="img/Autocad.jpg" alt="AutoCAD" class="badge__logo" onerror="this.style.display='none'"><span>AutoCAD</span></li>
        <li class="badge"><img src="img/HAP.jpg" alt="HAP" class="badge__logo" onerror="this.style.display='none'"><span>HAP</span></li>
        <li class="badge"><img src="img/LATS.png" alt="LATS" class="badge__logo" onerror="this.style.display='none'"><span>LATS</span></li>
        <li class="badge"><img src="img/ductsizer.png" alt="Ductsizer" class="badge__logo" onerror="this.style.display='none'"><span>Ductsizer</span></li>
        <li class="badge"><img src="img/Solidworks.png" alt="SolidWorks" class="badge__logo" onerror="this.style.display='none'"><span>SolidWorks</span></li>
        <li class="badge"><img src="img/MS office.png" alt="MS Office" class="badge__logo" onerror="this.style.display='none'"><span>MS Office</span></li>
        <li class="badge"><img src="img/navisworks.jpg" alt="Navisworks" class="badge__logo" onerror="this.style.display='none'"><span>Navisworks</span></li>
        <li class="badge"><img src="img/caps.jpg" alt="CAPS" class="badge__logo" onerror="this.style.display='none'"><span>CAPS</span></li>
      </ul>
    </div>

    <!-- Centered Codes & Standards -->
    <div class="badge-section" id="codes">
      <h3 class="badge-title">Codes &amp; Standards</h3>
      <ul class="badge-grid">
        <li class="badge"><img src="img/ASHRAE.jpg" alt="ASHRAE" class="badge__logo" onerror="this.style.display='none'"><span>ASHRAE</span></li>
        <li class="badge"><img src="img/ipc.jpg" alt="IPC" class="badge__logo" onerror="this.style.display='none'"><span>IPC</span></li>
        <li class="badge"><img src="img/smacna.jpg" alt="SMACNA" class="badge__logo" onerror="this.style.display='none'"><span>SMACNA</span></li>
        <li class="badge"><img src="img/logos/npc.svg" alt="UPC" class="badge__logo" onerror="this.style.display='none'"><span>UPC</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ===== ABOUT ===== -->
<section id="about" class="about">
  <div class="container">
    <div class="grid">
      <div>
        <h2 class="section__title" style="text-align:left">Who’s Mostafa?</h2>
        <span class="section__subtitle" style="display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border-radius:12px;background:linear-gradient(90deg,var(--accent),var(--primary));color:#061018;font-weight:900;">MEP Engineer • BIM Modeler • Team Leader</span>

        <p class="lead">I’m Mostafa El Badawi El Najjar, a Senior Mechanical Engineering student at the Lebanese American University. I focus on sustainable MEP design and modern digital tools to deliver efficient, coordinated systems.</p>
        <p class="lead">Outside academics I’ve led student clubs and scout teams and co-founded LawMate, an AI startup—experiences that sharpened my leadership and delivery.</p>

        <ul class="tags">
          <li title="Cooling/heating loads, ducting, piping">🧮 Load Calc</li>
          <li title="3D coordination, families, schedules">🧩 Revit</li>
          <li title="Energy-aware systems & selections">🌱 Sustainable HVAC</li>
        </ul>

        <div class="stats">
          <div class="stat"><div class="num">10+</div><div class="label">Projects</div></div>
          <div class="stat"><div class="num">4+</div><div class="label">Leadership Roles</div></div>
          <div class="stat"><div class="num">2</div><div class="label">Years in BIM</div></div>
        </div>
      </div>

      <figure class="photo">
        <img src="img/imagemos.jpg" alt="Mostafa Najjar speaking">
      </figure>
    </div>
  </div>
</section>

<!-- ===== PROJECTS ===== -->
<section id="work">
  <div class="container">
    <h2 class="section__title">My Projects</h2>
    <p class="section__subtitle">A selection of my top work</p>

    <div class="projects-grid">
      <?php foreach ($projects as $p): ?>
        <article class="card">
          <a class="card__media" href="project.php?project=<?php echo htmlspecialchars($p['id']); ?>">
            <img src="<?php echo htmlspecialchars($p['images'][0] ?? ''); ?>" alt="<?php echo htmlspecialchars($p['title'] ?? 'Project'); ?>" onerror="this.style.display='none'">
          </a>
          <div class="card__body">
            <?php if (!empty($p['tags']) && is_array($p['tags'])): ?>
              <div class="chips">
                <?php foreach ($p['tags'] as $t): ?>
                  <span class="chip"><?php echo htmlspecialchars($t); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <h3 style="margin:.2rem 0;"><?php echo htmlspecialchars($p['title'] ?? 'Untitled'); ?></h3>
            <?php if (!empty($p['short_description'])): ?>
              <p style="color:var(--muted); margin:0 0 8px;"><?php echo htmlspecialchars($p['short_description']); ?></p>
            <?php endif; ?>

            <a class="card__cta" href="project.php?project=<?php echo htmlspecialchars($p['id']); ?>">View details →</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== RESUME ===== -->
<section id="resume" class="resume">
  <div class="container">
    <h2 class="section__title">My Resume</h2>
    <p class="section__subtitle">PDF download & online view</p>

    <div class="box">
      <div style="display:flex;align-items:center;gap:10px;color:var(--muted);font-weight:700;">
        <i class="far fa-file-pdf"></i> Resume (PDF)
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a class="btn" href="<?php echo $cvPath . '?v=' . $cvVer; ?>" target="_blank" rel="noopener">View</a>
        <a class="btn" href="<?php echo $cvPath; ?>" download>Download</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
    <a class="footer__link" href="mailto:eng.mostafanajjar@outlook.com" style="color:var(--primary); font-weight:800;">
      eng.mostafanajjar@outlook.com
    </a>
    <ul class="social">
      <li><a href="https://linkedin.com/in/mostafa-najjar" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i></a></li>
      <li><a href="tel:+96176493457" title="Call"><i class="fas fa-phone fa-flip-horizontal"></i></a></li>
    </ul>
  </div>
</footer>

<!-- ===== SCRIPTS ===== -->
<script>
/* Single, robust active-pill + smooth-scroll */
(function () {
  const links = Array.from(document.querySelectorAll('.nav__link'));
  if (!links.length) return;

  const ids = [...new Set(
    links.map(a => (a.hash || '').slice(1).toLowerCase()).filter(Boolean)
  )];
  const sections = ids.map(id => document.getElementById(id)).filter(Boolean);
  const header  = document.querySelector('.topbar');
  const headerH = () => (header?.offsetHeight || 64);

  const setActive = (id) => {
    links.forEach(a => a.classList.toggle('is-active', (a.hash || '').toLowerCase() === '#'+id));
  };

  const scrollToId = (id, smooth=true) => {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - headerH() - 8;
    window.scrollTo({ top: y, behavior: smooth ? 'smooth' : 'auto' });
  };

  // click: smooth scroll + immediate highlight
  links.forEach(a => {
    a.addEventListener('click', (e) => {
      const id = (a.hash || '').slice(1).toLowerCase();
      if (!id) return;
      e.preventDefault();
      scrollToId(id, true);
      history.replaceState(null, '', '#'+id);
      setActive(id);
    });
  });

  // scroll: choose section whose top is nearest to header
  let ticking = false;
  const updateActive = () => {
    const y = window.scrollY + headerH() + 24;
    let best = null, bestDist = Infinity;
    for (const sec of sections) {
      const top = sec.offsetTop;
      const d   = Math.abs(top - y);
      if (d < bestDist) { best = sec; bestDist = d; }
    }
    if (best) setActive(best.id.toLowerCase());
  };
  window.addEventListener('scroll', () => {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(() => { updateActive(); ticking = false; });
    }
  }, { passive:true });
  window.addEventListener('resize', updateActive);

  // initial (honor hash and compensate for sticky header)
  window.addEventListener('load', () => {
    const initial = (location.hash || '#home').slice(1).toLowerCase();
    if (document.getElementById(initial)) {
      scrollToId(initial, false);
      setActive(initial);
    } else {
      setActive('home');
    }
    updateActive();
  });
})();
</script>

</body>
</html>
