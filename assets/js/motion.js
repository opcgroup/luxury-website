(function(){'use strict';
 var all=document.querySelectorAll('[class*="lw-motion-"]');
 if(!all.length)return;
 var reduce=window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
 if(reduce || !('IntersectionObserver' in window)){
   all.forEach(function(el){el.classList.add('lw-in-view');});return;
 }
 var observer=new IntersectionObserver(function(entries){entries.forEach(function(entry){
   var item=entry.target;
   if(entry.isIntersecting){item.classList.add('lw-in-view');if(!item.classList.contains('lw-motion-replay')) observer.unobserve(item);}
   else if(item.classList.contains('lw-motion-replay'))item.classList.remove('lw-in-view');
 });},{rootMargin:'0px 0px -25px 0px',threshold:0.05});
 all.forEach(function(item){observer.observe(item);});
 document.documentElement.classList.add('lw-motion-ready');
})();
