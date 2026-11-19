(function(wp){
'use strict';
if(!wp || !wp.blocks || !wp.blocks.registerBlockPattern || !wp.blocks.createBlock)return;
var b=wp.blocks.createBlock, ser=wp.blocks.serialize;
function para(t,cls){return b('core/paragraph',{content:t,className:cls||''});}
function heading(t,l){return b('core/heading',{content:t,level:l||2});}
// Core Button stores label as rich-text rather than InnerBlocks.
function button(label,href){return b('core/buttons',{},[b('core/button',{text:label,url:href||'#contact'})]);}
function box(children,cls){return b('core/group',{className:cls||'lw-inner-card',layout:{type:'constrained'}},children);}
function column(children){return b('core/column',{},children);}
function cols(items,cls){return b('core/columns',{className:cls||''},items.map(function(c){return column(c);}));}
function section(children,cls){return b('core/group',{align:'full',className:'lw-inner-section '+(cls||''),layout:{type:'constrained'}},children);}
function hero(kicker,title,desc){return b('core/group',{align:'full',className:'lw-inner-section lw-inner-hero',layout:{type:'constrained'}},[
  para(kicker,'lw-inner-eyebrow'),heading(title,1),para(desc),button('Enquire Now','#contact')
]);}
function intro(kicker,title,desc){return [para(kicker,'lw-inner-eyebrow'),heading(title,2),para(desc)];}
function stat(number,label){return box([heading(number,3),para(label)],'lw-inner-card lw-inner-stat');}
function placeholder(t){return box([para(t)],'lw-inner-placeholder');}
function card(t,desc){return box([heading(t,3),para(desc)],'lw-inner-card');}
function cta(title,desc){return b('core/group',{align:'full',anchor:'contact',className:'lw-inner-section lw-inner-dark lw-inner-cta',layout:{type:'constrained'}},[heading(title,2),para(desc),button('Contact Us','#contact')]);}
function pattern(slug,title,description,blocks){
  wp.blocks.registerBlockPattern('luxury-inner/'+slug,{title:title,description:description,categories:['luxury-inner-pages'],content:ser(blocks)});
}
function register(){
  if(wp.blocks.registerBlockPatternCategory)wp.blocks.registerBlockPatternCategory('luxury-inner-pages',{label:'Luxury Inner Pages'});
  pattern('about','01 • About Us — Complete Page','Company story, credibility, values and consultation CTA',[
    hero('ABOUT THE COMPANY','Homes, relationships and trust.','Introduce your real estate company with a powerful headline and clear positioning.'),
    section(intro('WHO WE ARE','A deeper understanding of property.','Replace these words with your company history, team credentials and verified experience.').concat([
      cols([[heading('Our Story',3),para('Explain how your company started, your focus market and how you help buyers make informed decisions.')],
        [placeholder('Replace this panel with your office, team or project photograph using an Image or Cover block.')]])
    ])),
    section([heading('What matters to our clients',2),cols([[card('Transparency','Explain your process for confirming project information and sharing relevant documents.')],[card('Local Knowledge','Describe the locations and real estate categories you specialise in.')],[card('After-Sales Support','Explain your customer support and documentation process.')]])],'lw-inner-soft'),
    section([cols([[stat('00+','Projects represented — replace with verified count')],[stat('00+','Site visits — replace with verified count')],[stat('00+','Years of experience — replace with verified count')]])]),
    cta('Let us help you find the right property.','Tell us your budget, preferred location and property type.')
  ]);
  pattern('project','02 • Single Project Landing Page','Complete project page with overview, specs, amenities, plans and lead CTA',[
    hero('PROJECT OVERVIEW','Your Project Name','Introduce the project, developer and location. Replace all sample text with verified project information.'),
    section([cols([[stat('00','Total acres / area')],[stat('00','Homes / plots')],[stat('00','Configuration types')]])]),
    section(intro('DISCOVER THE PROJECT','A closer look at the community.','Describe the project concept, approved information, architecture and intended lifestyle.').concat([cols([
      [placeholder('Insert the approved project elevation or master plan here.')],
      [heading('Project Highlights',3),para('Location: Add verified address'),para('Developer: Add verified developer name'),para('RERA: Add registration number, where applicable'),para('Project status: Add verified details'),button('Get Project Details','#contact')]
    ])])),
    section([heading('Amenities & Facilities',2),cols([[card('Landscaped Spaces','Describe verified gardens and green spaces.')],[card('Security & Access','Describe verified entry and security features.')],[card('Recreation','Describe approved leisure and community facilities.')]])],'lw-inner-soft'),
    section([heading('Floor Plans & Configurations',2),cols([[placeholder('Upload approved floor plan image here.')],[heading('Available Configurations',3),para('Add verified carpet / built-up / super-area figures, BHK information and pricing terms.'),button('Request Floor Plan','#contact')]])]),
    section([heading('Location & Connectivity',2),para('Insert the official Google Maps location block and verified nearby landmarks here.'),placeholder('Replace with a map Embed or approved location map.')],'lw-inner-soft'),
    cta('Interested in this project?','Request availability, the current price sheet and site visit details.')
  ]);
  pattern('location','03 • Location & Connectivity','Location introduction, nearby places, maps and enquiry',[
    hero('LOCATION ADVANTAGE','Well connected. Thoughtfully located.','Explain the project location and accessibility without making unverified travel-time claims.'),
    section([heading('Explore the neighbourhood',2),cols([
      [heading('Road Connectivity',3),para('List the nearest major roads and access points with accurate, current information.')],
      [heading('Education & Healthcare',3),para('List relevant schools, hospitals and amenities after checking their names and distances.')],
      [heading('Daily Convenience',3),para('Describe shopping, public transport and nearby facilities.')]
    ])]),
    section([heading('Find us on the map',2),para('Add a Map embed from the editor’s block inserter, or replace the placeholder with an approved location graphic.'),placeholder('MAP / LOCATION PLAN PLACEHOLDER')],'lw-inner-soft'),
    cta('Book a local site visit.','Contact the team for the meeting point and visit arrangements.')
  ]);
  pattern('floorplans','04 • Floor Plans & Prices','Configuration cards, plan previews and transparent pricing notes',[
    hero('FLOOR PLANS','Spaces designed for your needs.','Compare layouts, usable space and verified availability.'),
    section([heading('Choose your configuration',2),cols([
      [card('2 BHK / Config A','Add approved area breakup, balconies, utility space and layout summary.')],
      [card('3 BHK / Config B','Add approved area breakup and layout summary.')],
      [card('4 BHK / Config C','Add approved area breakup and layout summary.')]
    ])]),
    section([heading('Detailed Floor Plans',2),cols([
      [placeholder('Replace this placeholder with Floor Plan A image.')],
      [placeholder('Replace this placeholder with Floor Plan B image.')]
    ])],'lw-inner-soft'),
    section([heading('Pricing & Payment Plan',2),para('Prices, sizes and payment schedules should be confirmed against the latest approved project documentation. Add taxes and other charges clearly.'),button('Request Latest Price List','#contact')]),
    cta('Need help choosing a floor plan?','Speak with the team to compare layouts and availability.')
  ]);
  pattern('amenities','05 • Amenities & Specifications','Designed feature cards, benefits and specifications',[
    hero('AMENITIES','Everyday living, thoughtfully planned.','Explain the approved facilities and construction specifications.'),
    section([heading('Community Features',2),cols([
      [card('Green Spaces','Add verified landscaping and outdoor areas.')],
      [card('Security','Add verified security features.')],
      [card('Fitness & Recreation','Add verified fitness and leisure facilities.')]
    ]),cols([
      [card('Parking','Describe the approved parking arrangement.')],
      [card('Power & Water','Add verified utility provisions.')],
      [card('Connectivity','Explain access and circulation within the community.')]
    ])]),
    section([heading('Specifications',2),cols([
      [heading('Structure & Finishes',3),para('Insert developer-approved construction specifications, materials and finishes.')],
      [heading('Kitchen & Bathrooms',3),para('Insert the approved fixtures, fittings and plumbing specifications.')]
    ])],'lw-inner-soft'),
    cta('Request complete project specifications.','Get the latest official brochure or plan a visit.')
  ]);
  pattern('gallery','06 • Photo Gallery & Lifestyle','Editorial image layouts with introduction and CTA',[
    hero('PROJECT GALLERY','See the spaces and the details.','Show approved renderings and original project photographs. Label renders clearly.'),
    section([heading('Project Gallery',2),cols([
      [placeholder('Insert a Gallery or Image block for exterior photographs.')],
      [placeholder('Insert a Gallery or Image block for interior photographs.')]
    ])]),
    section([heading('Community & Lifestyle',2),cols([
      [placeholder('Upload clubhouse / landscaping image here.')],
      [placeholder('Upload neighbourhood / amenity image here.')]
    ])],'lw-inner-soft'),
    section([para('All project renders should be labelled illustrative if the final built product may differ.')]),
    cta('Experience it in person.','Book a site visit for a closer look.')
  ]);
  pattern('contact','07 • Contact & Enquiry','Property enquiry form, address, site visit CTA and map space',[
    hero('CONTACT US','Start the conversation.','Ask about projects, availability, pricing or site visits.'),
    b('core/group',{align:'full',anchor:'contact',className:'lw-inner-section',layout:{type:'constrained'}},[cols([
      [heading('Send an Enquiry',2),b('core/shortcode',{text:'[luxury_contact_form]'})],
      [heading('Our Office',2),para('Add your office address and working hours.'),heading('Call or WhatsApp',3),para('Add your verified contact number.'),heading('Site Visits',3),para('Share appointment hours and meeting point.'),button('View Properties','/projects/')]
    ])]),
    section([heading('Visit our location',2),placeholder('Insert a Google Maps Embed block or map image here.')],'lw-inner-soft')
  ]);
  pattern('services','08 • Real Estate Services','Consulting services with buyer journey and CTA',[
    hero('OUR SERVICES','Property guidance from search to possession.','Explain the real estate services you offer, your process and your service area.'),
    section([heading('How we help',2),cols([
      [card('Residential Advisory','Property discovery, shortlist support and site-visit coordination.')],
      [card('Resale & Rental','Help with property availability and viewing arrangements.')],
      [card('Commercial Advisory','Support with location and property-format evaluation.')]
    ])]),
    section([heading('Your Property Journey',2),cols([
      [heading('Discover',3),para('Share preferences and budget.')],
      [heading('Compare',3),para('Review documents and shortlisted options.')],
      [heading('Visit',3),para('Arrange site visits and follow-ups.')]
    ],'lw-inner-steps')],'lw-inner-soft'),
    cta('Discuss your requirement.','Tell us the property type, location and budget you have in mind.')
  ]);
  pattern('faq','09 • FAQ & Buyer Information','Common buyer questions and useful document checklist',[
    hero('BUYER GUIDE','Questions worth asking.','Provide reliable, project-specific answers to frequently asked property questions.'),
    section([heading('Frequently Asked Questions',2),
      b('luxury/faq',{question:'Is this project registered under RERA?',answer:'Include the verified registration details and official source where applicable.'}),
      b('luxury/faq',{question:'What does the quoted price include?',answer:'List the price components, taxes and additional charges from the current price sheet.'}),
      b('luxury/faq',{question:'How do I arrange a site visit?',answer:'Explain your booking and site-visit coordination procedure.'}),
      b('luxury/faq',{question:'Where can I obtain approved floor plans?',answer:'Explain how buyers can obtain the latest approved layout and floor plan documents.'})
    ]),
    section([heading('Before You Decide',2),para('Check registration, approvals, carpet area, payment schedule, possession terms and the latest written project documentation.')],'lw-inner-soft'),
    cta('Still have questions?','Our property team can help you obtain project-specific information.')
  ]);
  pattern('section-feature','10 • Section — 3 Property Benefits','Drop-in cards section for any inner page',[
    section([para('WHY CHOOSE THIS LOCATION','lw-inner-eyebrow'),heading('Three reasons to explore this address.',2),cols([
      [card('Location','Replace with verified transport and locality information.')],
      [card('Planning','Add approved layout and community features.')],
      [card('Support','Explain your enquiry and visit support.')]
    ])],'lw-inner-soft')
  ]);
  pattern('section-cta','11 • Section — Enquiry Call to Action','Drop-in lead generation section',[
    cta('Ready to explore your options?','Speak with our property team for current availability, pricing and site visits.')
  ]);
}
if(wp.domReady)wp.domReady(register);else register();
})(window.wp);
