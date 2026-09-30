(function () { var progress = document.querySelector('.progress'); function
updateProgress() { var max = document.documentElement.scrollHeight -
window.innerHeight; var ratio = max > 0 ? window.scrollY / max : 0;
progress.style.transform = 'scaleX(' + Math.min(1, Math.max(0, ratio)) + ')'; }
updateProgress(); window.addEventListener('scroll', updateProgress, { passive:
true }); window.addEventListener('resize', updateProgress); var navLinks =
document.querySelectorAll('.nav-links a[href^="#"]'); navLinks.forEach(function
(link) { link.addEventListener('click', function () { navLinks.forEach(function
(item) { item.removeAttribute('aria-current'); });
link.setAttribute('aria-current', 'location'); }); }); }());
