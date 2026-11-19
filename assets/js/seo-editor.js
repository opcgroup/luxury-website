(function(wp){
 'use strict';
 if(!wp || !wp.plugins || !wp.editPost || !wp.data) return;
 var el=wp.element.createElement, useSelect=wp.data.useSelect, useDispatch=wp.data.useDispatch;
 var TextControl=wp.components.TextControl, TextareaControl=wp.components.TextareaControl,
     ToggleControl=wp.components.ToggleControl, PanelBody=wp.components.PanelBody,
     Button=wp.components.Button, Notice=wp.components.Notice, PluginSidebar=wp.editPost.PluginSidebar;
 var MediaUpload=wp.blockEditor.MediaUpload;
 function SEOEditor(){
   var data=useSelect(function(select){
      var ed=select('core/editor');
      return {meta:ed.getEditedPostAttribute('meta')||{},title:ed.getEditedPostAttribute('title')||'',excerpt:ed.getEditedPostAttribute('excerpt')||''};
   },[]);
   var editPost=useDispatch('core/editor').editPost;
   function update(k,v){var next=Object.assign({},data.meta);next[k]=v;editPost({meta:next});}
   function val(key){return data.meta['_lw_seo_'+key]||'';}
   function control(key,label,desc,textarea){return el('div',{className:'lw-seo-field',key:key},
      textarea?el(TextareaControl,{label:label,value:val(key),onChange:function(v){update('_lw_seo_'+key,v);},help:desc}):
      el(TextControl,{label:label,value:val(key),onChange:function(v){update('_lw_seo_'+key,v);},help:desc}));}
   var title=val('title')||data.title;
   var description=val('description')||data.excerpt;
   var focus=val('focus').trim().toLowerCase();
   var checks=[];
   if(focus){
      checks.push({ok:title.toLowerCase().indexOf(focus)>=0,label:'Focus keyword in SEO title'});
      checks.push({ok:description.toLowerCase().indexOf(focus)>=0,label:'Focus keyword in description'});
   }
   checks.push({ok:!!title && title.length<=65,label:'Descriptive title (roughly ≤65 characters)'});
   checks.push({ok:!!description && description.length>=80 && description.length<=170,label:'Useful meta description (roughly 80–170 characters)'});
   return el('div',{className:'lw-seo-panel'},
      window.LWSEO && window.LWSEO.pluginActive?el(Notice,{status:'warning',isDismissible:false},'An SEO plugin is active. Luxury SEO front-end output is disabled to prevent duplicate tags.'):null,
      el(PanelBody,{title:'Search Appearance',initialOpen:true},
        el('div',{className:'lw-serp-preview'},el('div',{className:'lw-serp-url'},'Your domain / page-url'),
           el('div',{className:'lw-serp-title'},title||'SEO page title'),
           el('div',{className:'lw-serp-desc'},description||'Page description preview appears here.')),
        control('title','SEO Title','Different from the visible page heading, if needed.'),
        el('p',{className:'lw-seo-count'},String(val('title').length)+' characters'),
        control('description','Meta Description','Short, accurate search snippet. Google may rewrite snippets.',true),
        el('p',{className:'lw-seo-count'},String(val('description').length)+' characters'),
        control('focus','Focus Keyword','Used only for your on-page checklist.'),
        control('keywords','Related Keywords','Separate phrases with commas; stored for your editorial reference.')
      ),
      el(PanelBody,{title:'Indexing & Canonical',initialOpen:false},
        control('canonical','Canonical URL','Leave empty to use the standard WordPress canonical URL.'),
        el(ToggleControl,{label:'Noindex this page',checked:!!val('noindex'),onChange:function(v){update('_lw_seo_noindex',v);},help:'Ask search engines not to show this page.'}),
        el(ToggleControl,{label:'Nofollow links on this page',checked:!!val('nofollow'),onChange:function(v){update('_lw_seo_nofollow',v);}})
      ),
      el(PanelBody,{title:'Social Sharing Image',initialOpen:false},
        control('og_image','Social Image URL','Best around 1200 × 630 pixels; featured image is the fallback.'),
        MediaUpload ? el(MediaUpload,{onSelect:function(media){update('_lw_seo_og_image',media.url||'');},
            allowedTypes:['image'],render:function(obj){return el(Button,{variant:'secondary',onClick:obj.open},'Choose image from Media Library');}}):null,
        val('og_image')?el('img',{alt:'Social image preview',src:val('og_image'),className:'lw-seo-image'}):null
      ),
      el(PanelBody,{title:'SEO Checklist',initialOpen:false},
        el('p',{},'Suggestions only—not a Google ranking score.'),
        el('ul',{className:'lw-seo-checks'},checks.map(function(c,i){return el('li',{key:i},c.ok?'✓ ':'○ ',c.label);})),
        el('p',{},'Also use a clean URL, clear headings, descriptive alt text, internal links, and verified content.')
      )
   );
 }
 wp.plugins.registerPlugin('luxury-website-seo',{render:function(){return el(PluginSidebar,{name:'luxury-website-seo',title:'Luxury SEO',icon:'search'},el(SEOEditor));}});
})(window.wp);
