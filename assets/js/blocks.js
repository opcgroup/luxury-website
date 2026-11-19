(function(wp){
 'use strict';
 if(!wp || !wp.blocks || !wp.blockEditor || !wp.components) return;
 var el=wp.element.createElement, registerBlockType=wp.blocks.registerBlockType;
 var I=wp.blockEditor.InspectorControls, R=wp.blockEditor.RichText, M=wp.blockEditor.MediaUpload,
     Inner=wp.blockEditor.InnerBlocks, BlockControls=wp.blockEditor.BlockControls;
 var Panel=wp.components.PanelBody, Select=wp.components.SelectControl, Range=wp.components.RangeControl,
     Text=wp.components.TextControl, Toggle=wp.components.ToggleControl, Button=wp.components.Button, ColorPalette=wp.components.ColorPalette;
 function field(prop,label,props){return el(Text,Object.assign({label:label,value:props.attributes[prop]||'',onChange:function(v){var x={};x[prop]=v;props.setAttributes(x);}},{}));}
 function picker(prop,props){return el('div',{className:'lw-block-media'},
   el(M,{onSelect:function(media){var x={};x[prop]=media.url||'';props.setAttributes(x);},allowedTypes:['image'],render:function(obj){return el(Button,{variant:'secondary',onClick:obj.open},props.attributes[prop]?'Change image':'Choose image');}}),
   props.attributes[prop]?el('div',{},el('img',{src:props.attributes[prop],alt:'',style:{maxWidth:'100%',maxHeight:130,objectFit:'cover'}}),el(Button,{isDestructive:true,onClick:function(){var x={};x[prop]='';props.setAttributes(x);}},'Remove')):null);
 }
 function headingEdit(props,attr,label,placeholder,tag){return el(R,{tagName:tag||'h2',value:props.attributes[attr],onChange:function(v){var x={};x[attr]=v;props.setAttributes(x);},placeholder:placeholder||label,allowedFormats:['core/bold','core/italic']});}
 function textEdit(props,attr,placeholder){return el(R,{tagName:'p',value:props.attributes[attr],onChange:function(v){var x={};x[attr]=v;props.setAttributes(x);},placeholder:placeholder,allowedFormats:['core/bold','core/italic','core/link']});}
 function pAttrs(extra){return Object.assign({className:{type:'string',default:''}},extra);}

 registerBlockType('luxury/section',{
   apiVersion:2,title:'Luxury Section',icon:'align-wide',category:'design',description:'Drag and drop any blocks into a luxury section.',
   attributes:pAttrs({width:{type:'string',default:'contained'},padding:{type:'string',default:'large'},bg:{type:'string',default:''},image:{type:'string',default:''},radius:{type:'number',default:0}}),
   supports:{align:['full','wide'],html:false,customClassName:true},
   edit:function(props){var a=props.attributes;return el('section',{className:'lw-builder-section lw-builder-'+a.width+' lw-pad-'+a.padding+' '+(props.className||''),style:{backgroundColor:a.bg||undefined,backgroundImage:a.image?'url('+a.image+')':undefined,borderRadius:a.radius||undefined}},
      el(I,{},el(Panel,{title:'Section Layout',initialOpen:true},
         el(Select,{label:'Content width',value:a.width,options:[{label:'Contained',value:'contained'},{label:'Wide',value:'wide'},{label:'Full Width',value:'full'}],onChange:function(v){props.setAttributes({width:v});}}),
         el(Select,{label:'Vertical padding',value:a.padding,options:[{label:'None',value:'none'},{label:'Small',value:'small'},{label:'Medium',value:'medium'},{label:'Large',value:'large'},{label:'Extra Large',value:'xl'}],onChange:function(v){props.setAttributes({padding:v});}}),
         el(Range,{label:'Corner radius',value:a.radius,min:0,max:60,onChange:function(v){props.setAttributes({radius:v});}}),
         el('p',{},'Background colour'),el(ColorPalette,{value:a.bg,onChange:function(v){props.setAttributes({bg:v||''});}}),el('p',{},'Background image'),picker('image',props))),
      el('div',{className:'lw-builder-section-inner'},el(Inner,{renderAppender:Inner.ButtonBlockAppender})));
   },
   save:function(props){var a=props.attributes;return el('section',{className:'lw-builder-section lw-builder-'+a.width+' lw-pad-'+a.padding+(a.className?' '+a.className:''),
        style:{backgroundColor:a.bg||undefined,backgroundImage:a.image?'url('+a.image+')':undefined,borderRadius:a.radius||undefined}},
        el('div',{className:'lw-builder-section-inner'},el(Inner.Content)));
   }
 });

 registerBlockType('luxury/hero',{
   apiVersion:2,title:'Luxury Hero',icon:'cover-image',category:'design',description:'Large hero banner with editable headline and CTAs.',
   attributes:pAttrs({kicker:{type:'string',default:'NEW ADDRESS. NEW POSSIBILITIES.'},headline:{type:'string',default:'A more extraordinary place to live.'},text:{type:'string',default:'Explore crafted luxury living.'},
     image:{type:'string',default:''},button:{type:'string',default:'Explore Projects'},url:{type:'string',default:'#projects'},height:{type:'number',default:560},overlay:{type:'number',default:65}}),
   supports:{html:false,customClassName:true},
   edit:function(props){var a=props.attributes;return el('section',{className:'lw-block-hero '+(props.className||''),style:{minHeight:a.height,backgroundImage:'linear-gradient(90deg,rgba(8,17,20,'+(a.overlay/100)+'),rgba(8,17,20,.25))'+(a.image?',url('+a.image+')':'')}},
      el(I,{},el(Panel,{title:'Hero Design',initialOpen:true},picker('image',props),
         el(Range,{label:'Height',value:a.height,min:300,max:900,onChange:function(v){props.setAttributes({height:v});}}),
         el(Range,{label:'Dark overlay (%)',value:a.overlay,min:0,max:95,onChange:function(v){props.setAttributes({overlay:v});}}),field('button','Button text',props),field('url','Button URL',props))),
      el('div',{className:'lw-block-hero-inner'},headingEdit(props,'kicker','Eyebrow','Eyebrow','span'),headingEdit(props,'headline','Hero headline','Headline','h1'),textEdit(props,'text','Short introduction'),el('span',{className:'lw-button'},a.button||'Button ↗')));
   },
   save:function(props){var a=props.attributes;return el('section',{className:'lw-block-hero'+(a.className?' '+a.className:''),style:{minHeight:a.height,backgroundImage:'linear-gradient(90deg,rgba(8,17,20,'+(a.overlay/100)+'),rgba(8,17,20,.25))'+(a.image?',url('+a.image+')':'')}},
      el('div',{className:'lw-block-hero-inner'},el(R.Content,{tagName:'span',className:'lw-block-hero-kicker',value:a.kicker}),el(R.Content,{tagName:'h1',value:a.headline}),el(R.Content,{tagName:'p',value:a.text}),
      el('a',{href:a.url||'#contact',className:'lw-button'},a.button||'Explore Projects')));
   }
 });

 registerBlockType('luxury/card',{
   apiVersion:2,title:'Luxury Feature Card',icon:'index-card',category:'design',description:'Feature, service or benefit card.',
   attributes:pAttrs({title:{type:'string',default:'Premium Living'},body:{type:'string',default:'Create an elegant feature description.'},icon:{type:'string',default:'✦'},image:{type:'string',default:''},link:{type:'string',default:''},button:{type:'string',default:'Learn more'}}),
   supports:{html:false,customClassName:true},
   edit:function(props){var a=props.attributes;return el('article',{className:'lw-block-card '+(props.className||'')},
     el(I,{},el(Panel,{title:'Feature Card Settings',initialOpen:true},field('icon','Icon (emoji or symbol)',props),picker('image',props),field('link','Button link URL',props),field('button','Button label',props))),
     a.image?el('img',{className:'lw-block-card-image',src:a.image,alt:''}):el('span',{className:'lw-block-card-icon'},a.icon),
     headingEdit(props,'title','Card Title','Card title','h3'),textEdit(props,'body','Describe the feature'),a.link?el('span',{className:'lw-text-link'},a.button+' ↗'):null);
   },
   save:function(props){var a=props.attributes;return el('article',{className:'lw-block-card'+(a.className?' '+a.className:'')},
     a.image?el('img',{className:'lw-block-card-image',src:a.image,alt:'',loading:'lazy'}):el('span',{className:'lw-block-card-icon'},a.icon),
     el(R.Content,{tagName:'h3',value:a.title}),el(R.Content,{tagName:'p',value:a.body}),a.link?el('a',{className:'lw-text-link',href:a.link},a.button+' ↗'):null);
   }
 });

 registerBlockType('luxury/stat',{
   apiVersion:2,title:'Luxury Statistic',icon:'chart-bar',category:'widgets',
   attributes:pAttrs({number:{type:'string',default:'100+'},label:{type:'string',default:'Happy Customers'}}),supports:{html:false},
   edit:function(props){return el('div',{className:'lw-block-stat '+(props.className||'')},headingEdit(props,'number','','100+','strong'),textEdit(props,'label','Statistic label'));},
   save:function(props){var a=props.attributes;return el('div',{className:'lw-block-stat'+(a.className?' '+a.className:'')},el(R.Content,{tagName:'strong',value:a.number}),el(R.Content,{tagName:'p',value:a.label}));}
 });
 registerBlockType('luxury/testimonial',{
   apiVersion:2,title:'Luxury Testimonial',icon:'format-quote',category:'widgets',
   attributes:pAttrs({quote:{type:'string',default:'A very professional experience from start to finish.'},name:{type:'string',default:'Customer name'},role:{type:'string',default:'Verified client'}}),supports:{html:false},
   edit:function(props){return el('blockquote',{className:'lw-block-testimonial '+(props.className||'')},textEdit(props,'quote','Client feedback'),headingEdit(props,'name','','Customer name','strong'),textEdit(props,'role','Role / Source'));},
   save:function(props){var a=props.attributes;return el('blockquote',{className:'lw-block-testimonial'+(a.className?' '+a.className:'')},el(R.Content,{tagName:'p',value:a.quote}),el(R.Content,{tagName:'strong',value:a.name}),el(R.Content,{tagName:'small',value:a.role}));}
 });
 registerBlockType('luxury/cta',{
   apiVersion:2,title:'Luxury Call to Action',icon:'megaphone',category:'design',
   attributes:pAttrs({headline:{type:'string',default:'Your new home awaits.'},text:{type:'string',default:'Speak with our property team.'},button:{type:'string',default:'Book a Site Visit'},url:{type:'string',default:'#contact'}}),supports:{html:false},
   edit:function(props){var a=props.attributes;return el('div',{className:'lw-block-cta '+(props.className||'')},el(I,{},el(Panel,{title:'CTA Button',initialOpen:true},field('button','Button text',props),field('url','Button URL',props))),
      headingEdit(props,'headline','','Your message','h2'),textEdit(props,'text','Short description'),el('span',{className:'lw-button lw-button-outline'},a.button));},
   save:function(props){var a=props.attributes;return el('div',{className:'lw-block-cta'+(a.className?' '+a.className:'')},el(R.Content,{tagName:'h2',value:a.headline}),el(R.Content,{tagName:'p',value:a.text}),el('a',{className:'lw-button lw-button-outline',href:a.url||'#contact'},a.button));}
 });
 registerBlockType('luxury/faq',{
   apiVersion:2,title:'Luxury FAQ',icon:'editor-help',category:'widgets',
   attributes:pAttrs({question:{type:'string',default:'Frequently asked question'},answer:{type:'string',default:'Your answer goes here.'}}),supports:{html:false},
   edit:function(props){return el('div',{className:'lw-block-faq '+(props.className||'')},headingEdit(props,'question','','Question','strong'),textEdit(props,'answer','Answer'));},
   save:function(props){var a=props.attributes;return el('details',{className:'lw-block-faq'+(a.className?' '+a.className:'')},el('summary',{},a.question),el(R.Content,{tagName:'p',value:a.answer}));}
 });
 registerBlockType('luxury/property-grid',{
   apiVersion:2,title:'Luxury Property Grid',icon:'building',category:'widgets',description:'Dynamic property cards with optional filters, updated automatically.',
   attributes:pAttrs({count:{type:'number',default:6},type:{type:'string',default:''},filters:{type:'boolean',default:true}}),supports:{html:false,customClassName:true},
   edit:function(props){var a=props.attributes;return el('div',{className:'lw-block-placeholder '+(props.className||'')},
     el(I,{},el(Panel,{title:'Property Grid Settings',initialOpen:true},el(Range,{label:'Number of cards',min:1,max:24,value:a.count,onChange:function(v){props.setAttributes({count:v});}}),field('type','Project type slug (optional)',props),el(Toggle,{label:'Show category filters',checked:a.filters,onChange:function(v){props.setAttributes({filters:v});}}))),
     el('div',{className:'lw-block-placeholder-icon'},'▦'),el('h3',{},'Luxury Property Grid'),el('p',{},a.count+' property cards will load automatically on the published page.'));
   },save:function(){return null;}
 });

 // No-code visual motion controls for all compatible Gutenberg blocks.
 var motionOptions=[['none','None'],['fade-up','Fade Up'],['fade-down','Fade Down'],['fade-left','Fade Left'],['fade-right','Fade Right'],
   ['zoom-in','Zoom In'],['zoom-out','Zoom Out'],['flip-x','Flip Horizontally'],['flip-y','Flip Vertically'],['rotate','Rotate In'],['blur','Blur In'],['slide-up','Slide Up'],['bounce','Bounce In']];
 var hoverOptions=[['none','None'],['raise','Lift'],['scale','Scale'],['tilt','Tilt'],['glow','Glow'],['shadow','Deep Shadow'],['zoom','Image Zoom']];
 function stripKnown(s){return (s||'').split(/\s+/).filter(function(v){return v && !/^(lw-motion-|lw-hover-|lw-delay-|lw-time-|lw-loop-|lw-mobile-motion-|lw-motion-replay)/.test(v);});}
 function current(cls,prefix,def){var x=(cls||'').split(/\s+/).find(function(v){return v.indexOf(prefix)===0 && v!=='lw-motion-replay';});return x?x.slice(prefix.length):(def||'none');}
 function updateClass(props,prefix,value){var parts=(props.attributes.className||'').split(/\s+/).filter(function(v){return v && v.indexOf(prefix)!==0;});if(value!=='none'&&value!=='')parts.push(prefix+value);props.setAttributes({className:parts.join(' ')});}
 function filterBlockSettings(settings,name){
   if(settings.supports && settings.supports.customClassName===false)return settings;
   settings.attributes=Object.assign({},settings.attributes,{className:Object.assign({type:'string',default:''},settings.attributes&&settings.attributes.className||{})});
   return settings;
 }
 wp.hooks.addFilter('blocks.registerBlockType','luxury/motion-support',filterBlockSettings);
 var withMotion=wp.compose.createHigherOrderComponent(function(BlockEdit){return function(props){
   if(!props.isSelected || (props.name.indexOf('core/')!==0 && props.name.indexOf('luxury/')!==0 && props.attributes.className===undefined)) return el(BlockEdit,props);
   var cls=props.attributes.className||'';
   if(props.name==='core/freeform'||props.name==='core/html')return el(BlockEdit,props);
   return el(wp.element.Fragment,{},el(BlockEdit,props),
     el(I,{},el(Panel,{title:'Luxury Animation & Hover',initialOpen:false},
       el(Select,{label:'Entrance animation',value:current(cls,'lw-motion-'),options:motionOptions.map(function(m){return {value:m[0],label:m[1]};}),onChange:function(v){updateClass(props,'lw-motion-',v);}}),
       el(Select,{label:'Delay',value:current(cls,'lw-delay-','0'),options:[0,100,200,300,400,500,700,1000,1500,2000].map(function(x){return {value:String(x),label:x+' ms'};}),onChange:function(v){updateClass(props,'lw-delay-',v);}}),
       el(Select,{label:'Duration',value:current(cls,'lw-time-','700'),options:[300,500,700,900,1200,1500,2000].map(function(x){return {value:String(x),label:x+' ms'};}),onChange:function(v){updateClass(props,'lw-time-',v);}}),
       el(Select,{label:'Hover animation',value:current(cls,'lw-hover-'),options:hoverOptions.map(function(x){return {value:x[0],label:x[1]};}),onChange:function(v){updateClass(props,'lw-hover-',v);}}),
       el(Select,{label:'Continuous animation',value:current(cls,'lw-loop-'),options:[{value:'none',label:'None'},{value:'float',label:'Float'},{value:'pulse',label:'Pulse'},{value:'glow',label:'Glow'},{value:'spin',label:'Slow Spin'}],onChange:function(v){updateClass(props,'lw-loop-',v);}}),
       el(Toggle,{label:'Repeat on scroll',checked:cls.split(/\s+/).includes('lw-motion-replay'),onChange:function(v){var parts=cls.split(/\s+/).filter(function(x){return x&&x!=='lw-motion-replay';});if(v)parts.push('lw-motion-replay');props.setAttributes({className:parts.join(' ')});}}),
       el(Toggle,{label:'Disable animation on mobile',checked:cls.indexOf('lw-mobile-motion-off')!==-1,onChange:function(v){var parts=cls.split(/\s+/).filter(function(x){return x&&x!=='lw-mobile-motion-off';});if(v)parts.push('lw-mobile-motion-off');props.setAttributes({className:parts.join(' ')});}}),
       el('p',{},'Preview animations on the published page. Reduced-motion settings are respected.'))));
 };},'withLuxuryMotionControls');
 wp.hooks.addFilter('editor.BlockEdit','luxury/motion-controls',withMotion);

 // Ready-made no-code compositions in the editor's Patterns panel.
 if(wp.blocks.registerBlockPattern) {
   wp.blocks.registerBlockPattern('luxury/landing',{
     title:'Luxury Landing Page',categories:['featured'],description:'Hero, features, properties and enquiry CTA.',
     content:wp.blocks.serialize([wp.blocks.createBlock('luxury/hero'),wp.blocks.createBlock('luxury/section',{},[wp.blocks.createBlock('core/heading',{content:'Explore Our Residences'}),wp.blocks.createBlock('core/paragraph',{content:'Discover the difference a great address makes.'}),wp.blocks.createBlock('luxury/property-grid')]),wp.blocks.createBlock('luxury/cta')])
   });
 }
})(window.wp);
