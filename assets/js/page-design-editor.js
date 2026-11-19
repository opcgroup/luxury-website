(function(wp){
'use strict';
if(!wp || !wp.plugins || !wp.editPost || !wp.components || !wp.data)return;
var el=wp.element.createElement, panel=wp.editPost.PluginDocumentSettingPanel,
    select=wp.components.SelectControl, text=wp.components.TextareaControl,
    useSelect=wp.data.useSelect,useDispatch=wp.data.useDispatch;
wp.plugins.registerPlugin('luxury-inner-page-design',{
  render:function(){
    var meta=useSelect(function(s){return (s('core/editor').getEditedPostAttribute('meta')||{});},[]);
    var editPost=useDispatch('core/editor').editPost;
    function change(k,v){var m=Object.assign({},meta);m[k]=v;editPost({meta:m});}
    function control(k,label,choices,fallback){return el(select,{label:label,value:meta[k]||fallback,options:choices.map(function(o){return {value:o[0],label:o[1]};}),onChange:function(v){change(k,v);}});}
    return el(panel,{name:'luxury-inner-page-design',title:'Luxury Page Design',className:'lw-page-options'},
       el('p',{},'These settings affect only this page. The homepage design is not changed.'),
       control('_lw_page_layout','Page width',[['auto','Automatic'],['narrow','Narrow — articles'],['contained','Standard content'],['wide','Wide — 1440 px'],['full','Full Width — sections edge to edge']],'auto'),
       control('_lw_page_hero','Top title banner',[['auto','Automatic'],['show','Show title banner'],['hide','Hide — design your own hero']],'auto'),
       control('_lw_page_hero_style','Title banner style',[['solid','Solid colour'],['gradient','Luxury gradient'],['photo','Featured image background']],'solid'),
       el(text,{label:'Banner subtitle',value:meta._lw_page_subtitle||'',onChange:function(v){change('_lw_page_subtitle',v);}}),
       el('p',{},'Ready-made inner pages: click + → Patterns → Luxury Inner Pages, then edit the text, sections and images. Use List View to reorder blocks.'),
       el('p',{},'Design options for Groups, Images and Buttons are in each block’s Styles sidebar. Select any block for Luxury Animation & Hover.'));
  }
});
})(window.wp);
