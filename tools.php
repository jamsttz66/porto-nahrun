<?php
require_once __DIR__ . '/content.php';
$content = portfolio_load();
$name = $content['name'];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="Nahrun Tools — utilitas developer ringan yang berjalan langsung di browser.">
  <title>Nahrun Tools — Developer Utilities</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .tools-shell{max-width:1120px;margin:auto;padding:2rem 1rem 6rem}.tools-top{display:flex;justify-content:space-between;align-items:flex-start;gap:2rem;padding:3rem 0 4rem;border-bottom:1px solid var(--line)}.tools-top h1{max-width:8ch;margin:1rem 0 1rem;font:400 clamp(3.3rem,8vw,7rem)/.86 Georgia,serif;letter-spacing:-.07em}.tools-top h1 em{color:var(--accent);font-style:italic}.tools-intro{max-width:430px;margin-top:3rem;color:var(--muted);font-size:.95rem}.tools-note{padding:1rem;border:1px solid var(--line);color:var(--faint);font-size:.75rem}.tools-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;padding-top:3rem}.tool-card{min-height:330px;padding:1.25rem;border:1px solid var(--line-strong);background:var(--surface);display:flex;flex-direction:column;gap:1rem}.tool-card.wide{grid-column:1/-1}.tool-head{display:flex;justify-content:space-between;gap:1rem;align-items:baseline;border-bottom:1px solid var(--line);padding-bottom:.8rem}.tool-head h2{margin:0;font:400 1.5rem Georgia,serif}.tool-code{color:var(--accent);font:500 .65rem "JetBrains Mono",monospace}.tool-card label{color:var(--faint);font-size:.68rem;letter-spacing:.08em;text-transform:uppercase}.tool-card textarea,.tool-card input,.tool-card select{width:100%;padding:.75rem;border:1px solid var(--line-strong);background:var(--bg);color:var(--ink);font:inherit}.tool-card textarea{min-height:120px;resize:vertical}.tool-card textarea.output{color:var(--accent-strong)}.tool-actions{display:flex;flex-wrap:wrap;gap:.5rem}.tool-actions button,.copy-btn{padding:.65rem .8rem;border:1px solid var(--line-strong);background:transparent;color:var(--ink);font:600 .68rem Poppins,sans-serif;letter-spacing:.06em;text-transform:uppercase;cursor:pointer}.tool-actions button:hover,.copy-btn:hover{border-color:var(--accent);color:var(--accent-strong)}.tool-actions .active{background:var(--accent);border-color:var(--accent);color:#17130b}.tool-status{min-height:1.2em;color:var(--faint);font-size:.75rem}.tool-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}.tool-card small{color:var(--faint);font-size:.72rem}.back-link{color:var(--muted);font-size:.72rem;letter-spacing:.1em;text-decoration:none;text-transform:uppercase}.back-link:hover{color:var(--accent)}.json-layout{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}.json-layout textarea{min-height:220px}@media(max-width:760px){.tools-top{display:block}.tools-intro{margin-top:2rem}.tools-grid,.json-layout{grid-template-columns:1fr}.tool-card.wide{grid-column:auto}.tool-row{grid-template-columns:1fr}.tools-top h1{font-size:clamp(3.3rem,18vw,5rem)}}
  </style>
</head>
<body>
  <main class="tools-shell">
    <header class="tools-top">
      <div><a class="back-link" href="index.php">← Kembali ke portofolio</a><h1><em>Nahrun</em><br>Tools.</h1></div>
      <p class="tools-intro">Utilitas kecil untuk kerja web dan coding. Semua proses berjalan lokal di browser — input tidak dikirim ke server dan tidak memakai database.</p>
    </header>
    <div class="tools-note">Rekomendasi awal: HTML Escape, PHP String Escape, Base64, URL Encode, JSON Formatter, dan Timestamp Converter.</div>
    <section class="tools-grid" aria-label="Daftar Nahrun Tools">
      <article class="tool-card">
        <header class="tool-head"><h2>HTML Escape</h2><span class="tool-code">WEB-01</span></header>
        <label for="html-input">Input HTML / text</label><textarea id="html-input" placeholder="<script>alert('hello')</script>"></textarea>
        <div class="tool-actions"><button class="active" data-html-mode="escape">Escape</button><button data-html-mode="unescape">Unescape</button><button class="copy-btn" data-copy="html-output">Copy hasil</button></div>
        <textarea id="html-output" class="output" readonly aria-label="Hasil HTML"></textarea>
      </article>
      <article class="tool-card">
        <header class="tool-head"><h2>PHP String Escape</h2><span class="tool-code">PHP-02</span></header>
        <label for="php-input">String PHP</label><textarea id="php-input" placeholder="Teks dengan 'quote' dan baris baru"></textarea>
        <div class="tool-actions"><button class="active" data-php-mode="single">Single quote</button><button data-php-mode="double">Double quote</button><button data-php-mode="html">htmlspecialchars()</button><button class="copy-btn" data-copy="php-output">Copy hasil</button></div>
        <textarea id="php-output" class="output" readonly aria-label="Hasil PHP"></textarea>
      </article>
      <article class="tool-card">
        <header class="tool-head"><h2>Base64</h2><span class="tool-code">ENC-03</span></header>
        <label for="base-input">Input</label><textarea id="base-input" placeholder="Teks atau Base64"></textarea>
        <div class="tool-actions"><button class="active" data-base-mode="encode">Encode</button><button data-base-mode="decode">Decode</button><button class="copy-btn" data-copy="base-output">Copy hasil</button></div>
        <textarea id="base-output" class="output" readonly aria-label="Hasil Base64"></textarea><p id="base-status" class="tool-status"></p>
      </article>
      <article class="tool-card">
        <header class="tool-head"><h2>URL Encode</h2><span class="tool-code">WEB-04</span></header>
        <label for="url-input">URL atau query string</label><textarea id="url-input" placeholder="https://example.com/search?q=hello world"></textarea>
        <div class="tool-actions"><button class="active" data-url-mode="encode">Encode</button><button data-url-mode="decode">Decode</button><button class="copy-btn" data-copy="url-output">Copy hasil</button></div>
        <textarea id="url-output" class="output" readonly aria-label="Hasil URL"></textarea><p id="url-status" class="tool-status"></p>
      </article>
      <article class="tool-card wide">
        <header class="tool-head"><h2>JSON Formatter</h2><span class="tool-code">DATA-05</span></header>
        <div class="json-layout"><div><label for="json-input">JSON input</label><textarea id="json-input" placeholder='{"name":"Nahrun","tools":true}'></textarea></div><div><label for="json-output">Output</label><textarea id="json-output" class="output" readonly></textarea></div></div>
        <div class="tool-actions"><button class="active" id="json-pretty">Pretty print</button><button id="json-minify">Minify</button><button class="copy-btn" data-copy="json-output">Copy hasil</button></div><p id="json-status" class="tool-status"></p>
      </article>
      <article class="tool-card wide">
        <header class="tool-head"><h2>Timestamp Converter</h2><span class="tool-code">TIME-06</span></header>
        <div class="tool-row"><div><label for="timestamp-input">Unix timestamp</label><input id="timestamp-input" inputmode="numeric" placeholder="Contoh: 1710000000"></div><div><label for="date-input">Tanggal lokal</label><input id="date-input" type="datetime-local"></div></div>
        <div class="tool-actions"><button id="timestamp-to-date" class="active">Timestamp → tanggal</button><button id="date-to-timestamp">Tanggal → timestamp</button><button id="timestamp-now">Pakai waktu sekarang</button></div><p id="timestamp-output" class="tool-status"></p>
      </article>
    </section>
  </main>
<script>
(function(){
  const $=s=>document.querySelector(s), $$=s=>document.querySelectorAll(s);
  const copy=async id=>{const el=$('#'+id);if(!el.value)return;try{await navigator.clipboard.writeText(el.value);el.parentElement.querySelector('.tool-status')?.replaceChildren('Tersalin.');}catch(e){el.select();document.execCommand('copy');}};
  $$('[data-copy]').forEach(b=>b.addEventListener('click',()=>copy(b.dataset.copy)));
  const htmlInput=$('#html-input'),htmlOutput=$('#html-output');let htmlMode='escape';
  const htmlEscape=s=>s.replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c]));
  const htmlUnescape=s=>{const t=document.createElement('textarea');t.innerHTML=s;return t.value};
  function htmlRun(){htmlOutput.value=htmlMode==='escape'?htmlEscape(htmlInput.value):htmlUnescape(htmlInput.value)} htmlInput.addEventListener('input',htmlRun);$$('[data-html-mode]').forEach(b=>b.addEventListener('click',()=>{htmlMode=b.dataset.htmlMode;$$('[data-html-mode]').forEach(x=>x.classList.toggle('active',x===b));htmlRun()}));
  const phpInput=$('#php-input'),phpOutput=$('#php-output');let phpMode='single';
  function phpRun(){const s=phpInput.value;phpOutput.value=phpMode==='single'?"'"+s.replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/\r?\n/g,'\\n')+"'":phpMode==='double'?"\""+s.replace(/\\/g,'\\\\').replace(/"/g,'\\"').replace(/\r?\n/g,'\\n')+"\"":'htmlspecialchars('+JSON.stringify(s)+', ENT_QUOTES, \'UTF-8\')';} phpInput.addEventListener('input',phpRun);$$('[data-php-mode]').forEach(b=>b.addEventListener('click',()=>{phpMode=b.dataset.phpMode;$$('[data-php-mode]').forEach(x=>x.classList.toggle('active',x===b));phpRun()}));
  const baseInput=$('#base-input'),baseOutput=$('#base-output');let baseMode='encode';function baseRun(){try{if(baseMode==='encode'){baseOutput.value=btoa(unescape(encodeURIComponent(baseInput.value)));$('#base-status').textContent='';}else{baseOutput.value=decodeURIComponent(escape(atob(baseInput.value.trim())));$('#base-status').textContent='';}}catch(e){baseOutput.value='';$('#base-status').textContent='Input Base64 tidak valid.'}}baseInput.addEventListener('input',baseRun);$$('[data-base-mode]').forEach(b=>b.addEventListener('click',()=>{baseMode=b.dataset.baseMode;$$('[data-base-mode]').forEach(x=>x.classList.toggle('active',x===b));baseRun()}));
  const urlInput=$('#url-input'),urlOutput=$('#url-output');let urlMode='encode';function urlRun(){try{urlOutput.value=urlMode==='encode'?encodeURIComponent(urlInput.value):decodeURIComponent(urlInput.value);$('#url-status').textContent=''}catch(e){urlOutput.value='';$('#url-status').textContent='Input URL encoding tidak valid.'}}urlInput.addEventListener('input',urlRun);$$('[data-url-mode]').forEach(b=>b.addEventListener('click',()=>{urlMode=b.dataset.urlMode;$$('[data-url-mode]').forEach(x=>x.classList.toggle('active',x===b));urlRun()}));
  const jsonIn=$('#json-input'),jsonOut=$('#json-output');let jsonMode=2;function jsonRun(){try{const v=JSON.parse(jsonIn.value);jsonOut.value=jsonMode===2?JSON.stringify(v,null,2):JSON.stringify(v);$('#json-status').textContent='JSON valid.';$('#json-status').style.color='var(--accent-strong)'}catch(e){jsonOut.value='';$('#json-status').textContent='JSON tidak valid: '+e.message;$('#json-status').style.color='var(--signal)'}}jsonIn.addEventListener('input',jsonRun);$('#json-pretty').addEventListener('click',()=>{jsonMode=2;jsonRun()});$('#json-minify').addEventListener('click',()=>{jsonMode=0;jsonRun()});
  const ts=$('#timestamp-input'),date=$('#date-input'),tsOut=$('#timestamp-output');$('#timestamp-to-date').addEventListener('click',()=>{const n=Number(ts.value);if(!Number.isFinite(n)){tsOut.textContent='Timestamp tidak valid.';return}const d=new Date(n*(String(n).length<=10?1000:1));date.value=new Date(d.getTime()-d.getTimezoneOffset()*60000).toISOString().slice(0,16);tsOut.textContent=d.toString()});$('#date-to-timestamp').addEventListener('click',()=>{if(!date.value){tsOut.textContent='Pilih tanggal dulu.';return}const n=new Date(date.value);ts.value=Math.floor(n.getTime()/1000);tsOut.textContent=n.toString()});$('#timestamp-now').addEventListener('click',()=>{ts.value=Math.floor(Date.now()/1000);$('#timestamp-to-date').click()});
})();
</script>
</body>
</html>
