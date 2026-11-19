(function(){'use strict';
 document.documentElement.classList.add('js-lw');
 var header=document.getElementById('lw-site-header');
 var toggle=document.querySelector('.lw-menu-toggle');
 var nav=document.getElementById('lw-mobile-nav');
 if(toggle&&nav){toggle.addEventListener('click',function(){var open=toggle.getAttribute('aria-expanded')==='true';toggle.setAttribute('aria-expanded',String(!open));nav.hidden=open;});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&!nav.hidden){nav.hidden=true;toggle.setAttribute('aria-expanded','false');toggle.focus();}});
  nav.addEventListener('click',function(e){if(e.target.closest('a')){nav.hidden=true;toggle.setAttribute('aria-expanded','false');}});
 }
 function scrolled(){if(header) header.classList.toggle('lw-scrolled',window.scrollY>30);var top=document.querySelector('.lw-scroll-top');if(top)top.classList.toggle('is-visible',window.scrollY>480);}
 window.addEventListener('scroll',scrolled,{passive:true});scrolled();
 var topBtn=document.querySelector('.lw-scroll-top');if(topBtn)topBtn.addEventListener('click',function(){window.scrollTo({top:0,behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'instant':'smooth'});});
 var filters=document.querySelectorAll('.lw-filter-bar button');filters.forEach(function(b){b.addEventListener('click',function(){var term=b.dataset.filter||'all';var bar=b.closest('.lw-filter-bar');if(!bar)return;bar.querySelectorAll('button').forEach(function(btn){var active=btn===b;btn.classList.toggle('is-active',active);btn.setAttribute('aria-pressed',String(active));});var grid=bar.nextElementSibling;if(!grid)return;grid.querySelectorAll('.lw-property-card').forEach(function(card){card.hidden=term!=='all'&&!card.dataset.type.split(' ').includes(term);});});});
 var revealEls=document.querySelectorAll('.lw-reveal');
 if('IntersectionObserver' in window&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
  var io=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){entry.target.classList.add('is-visible');io.unobserve(entry.target);}});},{rootMargin:'0px 0px -35px 0px',threshold:.07});revealEls.forEach(function(el){io.observe(el);});
 }else revealEls.forEach(function(el){el.classList.add('is-visible');});
})();
