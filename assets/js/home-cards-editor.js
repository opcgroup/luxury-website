(function(){'use strict';
  function elt(tag,cls,text){var e=document.createElement(tag);if(cls)e.className=cls;if(text!=null)e.textContent=text;return e;}
  function btn(label,cls){var b=elt('button','button '+cls,label);b.type='button';return b;}
  function makeRow(card){
    var wrap=elt('div','lw-home-card-editor-row');
    var head=elt('div','lw-home-card-editor-head');var title=elt('strong','lw-home-card-index');var actions=elt('div','lw-home-card-actions');
    actions.appendChild(btn('↑','lw-card-up'));actions.appendChild(btn('↓','lw-card-down'));actions.appendChild(btn('Remove','lw-card-remove'));
    head.appendChild(title);head.appendChild(actions);wrap.appendChild(head);
    [['title','Card Title','text'],['description','Description (optional)','textarea'],['image','Card Image URL','url'],['url','Card Link URL','url']].forEach(function(field){
      var label=elt('label','lw-home-card-field');label.appendChild(elt('span',null,field[1]));
      var input=elt(field[2]==='textarea'?'textarea':'input','lw-home-card-'+field[0]);
      if(field[2]!=='textarea')input.type=field[2];if(field[0]==='title')input.maxLength=160;if(field[0]==='description')input.maxLength=600;
      input.value=card[field[0]]||'';if(field[0]==='url')input.placeholder='https://... or /projects/';
      if(field[0]==='image'){
        var row=elt('div','lw-home-card-media');row.appendChild(input);var media=btn('Choose Image','lw-card-media');row.appendChild(media);label.appendChild(row);
      }else label.appendChild(input);wrap.appendChild(label);
    });
    return wrap;
  }
  function setup(root){if(root.dataset.ready==='1')return;
    var input=root.querySelector('.lw-home-card-json'),list=root.querySelector('.lw-home-card-list'),add=root.querySelector('.lw-home-card-add');
    if(!input||!list||!add)return;root.dataset.ready='1';
    var cards=[];try{cards=JSON.parse(input.value);if(!Array.isArray(cards))cards=[]}catch(e){cards=[]}
    cards.forEach(function(card){list.appendChild(makeRow(card));});
    function renumber(){Array.from(list.children).forEach(function(row,i){row.querySelector('.lw-home-card-index').textContent='Card '+(i+1);row.querySelector('.lw-card-up').disabled=!i;row.querySelector('.lw-card-down').disabled=i===list.children.length-1;});}
    function sync(){var data=Array.from(list.children).map(function(row){var obj={};['title','description','image','url'].forEach(function(field){obj[field]=row.querySelector('.lw-home-card-'+field).value;});return obj;});
      input.value=JSON.stringify(data);input.dispatchEvent(new Event('change',{bubbles:true}));
      if(root.dataset.context==='customizer'&&window.wp&&wp.customize){var key='lw_options['+root.dataset.kind+'_cards]';wp.customize(key,function(setting){setting.set(input.value);});}
      renumber();
    }
    var typing;
    list.addEventListener('input',function(e){if(!e.target.matches('input,textarea'))return;clearTimeout(typing);typing=setTimeout(sync,700)});
    list.addEventListener('change',function(e){if(!e.target.matches('input,textarea'))return;clearTimeout(typing);sync();});
    list.addEventListener('click',function(e){var button=e.target.closest('button');if(!button)return;var row=button.closest('.lw-home-card-editor-row');if(!row)return;
      if(button.classList.contains('lw-card-media')){
        if(!(window.wp&&wp.media))return;
        var dialog=wp.media({title:'Choose card image',button:{text:'Use image'},multiple:false,library:{type:'image'}});
        dialog.on('select',function(){row.querySelector('.lw-home-card-image').value=dialog.state().get('selection').first().toJSON().url;sync();});dialog.open();return;
      }
      if(button.classList.contains('lw-card-remove'))row.remove();
      if(button.classList.contains('lw-card-up')&&row.previousElementSibling)list.insertBefore(row,row.previousElementSibling);
      if(button.classList.contains('lw-card-down')&&row.nextElementSibling)list.insertBefore(row.nextElementSibling,row);
      sync();
    });
    add.addEventListener('click',function(){if(list.children.length>=30){alert('Maximum 30 cards.');return;}var row=makeRow({});list.appendChild(row);sync();row.querySelector('.lw-home-card-title').focus();});
    renumber();
  }
  function init(){document.querySelectorAll('.lw-home-card-editor').forEach(setup);}
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
  if(window.wp&&wp.customize&&wp.customize.control)wp.customize.control.bind('add',function(){setTimeout(init,0);});
})();
