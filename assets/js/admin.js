(function(){'use strict';
 document.querySelectorAll('.lw-tabs button').forEach(function(tab){tab.addEventListener('click',function(){var name=tab.dataset.tab;document.querySelectorAll('.lw-tabs button').forEach(function(t){t.classList.toggle('is-active',t===tab);});document.querySelectorAll('.lw-panel').forEach(function(panel){panel.classList.toggle('is-active',panel.dataset.panel===name);});});});
 var dragged=null;
 function sync(zone){var wrapper=zone.closest('.lw-header-builder-zone');if(!wrapper)return;var input=wrapper.querySelector('input[type=hidden]');if(input)input.value=Array.from(zone.querySelectorAll('.lw-chip')).map(function(chip){return chip.dataset.name;}).join(',');}
 function chip(name){var n=document.createElement('div');n.className='lw-chip';n.draggable=true;n.dataset.name=name;n.appendChild(document.createTextNode(name.charAt(0).toUpperCase()+name.slice(1)));var b=document.createElement('button');b.type='button';b.className='lw-chip-remove';b.setAttribute('aria-label','Remove '+name);b.textContent='×';n.appendChild(b);return n;}
 document.querySelectorAll('.lw-dropzone').forEach(function(zone){
  zone.addEventListener('dragstart',function(e){var el=e.target.closest('.lw-chip');if(!el)return;dragged=el;el.classList.add('is-dragging');e.dataTransfer.effectAllowed='move';e.dataTransfer.setData('text/plain',el.dataset.name);});
  zone.addEventListener('dragend',function(){if(dragged)dragged.classList.remove('is-dragging');dragged=null;document.querySelectorAll('.lw-dropzone').forEach(function(z){z.classList.remove('is-over');sync(z);});});
  zone.addEventListener('dragover',function(e){if(!dragged)return;e.preventDefault();zone.classList.add('is-over');e.dataTransfer.dropEffect='move';});
  zone.addEventListener('dragleave',function(e){if(!zone.contains(e.relatedTarget))zone.classList.remove('is-over');});
  zone.addEventListener('drop',function(e){if(!dragged)return;e.preventDefault();zone.classList.remove('is-over');var after=e.target.closest('.lw-chip');if(after&&after!==dragged&&zone.contains(after))zone.insertBefore(dragged,after);else zone.appendChild(dragged);document.querySelectorAll('.lw-dropzone').forEach(sync);});
  zone.addEventListener('click',function(e){var remove=e.target.closest('.lw-chip-remove');if(!remove)return;remove.closest('.lw-chip').remove();sync(zone);});
 });
 document.querySelectorAll('.lw-add-item').forEach(function(sel){sel.addEventListener('change',function(){var zone=sel.closest('.lw-header-builder-zone').querySelector('.lw-dropzone');if(!sel.value)return;zone.appendChild(chip(sel.value));sync(zone);sel.value='';});});
 document.querySelectorAll('.lw-media-select').forEach(function(b){b.addEventListener('click',function(){if(!window.wp||!wp.media)return;var input=b.parentNode.querySelector('input');var dialog=wp.media({title:'Choose a Luxury Website image',button:{text:'Use this image'},multiple:false,library:{type:'image'}});dialog.on('select',function(){var file=dialog.state().get('selection').first().toJSON();input.value=file.url;});dialog.open();});});
})();
