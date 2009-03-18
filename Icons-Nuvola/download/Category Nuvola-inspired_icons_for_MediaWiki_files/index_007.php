/* generated javascript */
var skin = 'monobook';
var stylepath = '/skins-1.5';

/* MediaWiki:Common.js */
//<source lang="javascript">

/** JSconfig (old version, to be replaced soon) ************
 * Global configuration options to enable and disable specific
 * script features from [[MediaWiki:Common.js]]
 * Override these default settings in your [[Special:Mypage/monobook.js]]
 * for Example: JSconfig.loadAutoInformationTemplate = false;
 *
 *  Maintainer: [[User:Dschwen]]
 */

var JSconfig_old =
{
 loadAutoInformationTemplate : true,
 specialSearchEnhanced : true,
 subPagesLink : true,
 attributeSelf : true,
 userUploadsLink : true
}


/** JSconfig ************
 * Global configuration options to enable/disable and configure
 * specific script features from [[MediaWiki:Common.js]] and
 * [[MediaWiki:Monobook.js]]
 * This framework adds config options (saved as cookies) to [[Special:Preferences]]
 * For a more permanent change you can override the default settings in your 
 * [[Special:Mypage/monobook.js]]
 * for Example: JSconfig.keys[loadAutoInformationTemplate] = false;
 *
 *  Maintainer: [[User:Dschwen]]
 */

var JSconfig =
{
 prefix : 'jsconfig_',
 keys : {},
 meta : {},

 //
 // Register a new configuration item
 //  * name          : String, internal name
 //  * default_value : String or Boolean (type determines configuration widget)
 //  * description   : String, text appearing next to the widget in the preferences
 //  * prefpage      : Integer (optional), section in the preferences to insert the widget:
 //                     0 : User profile
 //                     1 : Skin
 //                     2 : Math
 //                     3 : Files
 //                     4 : Date and time
 //                     5 : Editing
 //                     6 : Recent changes
 //                     7 : Watchlist
 //                     8 : Search
 //                     9 : Misc
 //
 // Access keys through JSconfig.keys[name]
 //
 registerKey : function( name, default_value, description, prefpage )
 {
  if( typeof(JSconfig.keys[name]) == 'undefined' ) 
   JSconfig.keys[name] = default_value;
  else {

   // all cookies are read as strings, 
   // convert to the type of the default value
   switch( typeof(default_value) )
   {
    case 'boolean' : JSconfig.keys[name] = ( JSconfig.keys[name] == 'true' ); break;
    case 'number'  : JSconfig.keys[name] = JSconfig.keys[name]/1; break;
   }

  }

  JSconfig.meta[name] = { 'description' : description, 'page' : prefpage || 0, 'default_value' : default_value };
 },

 readCookies : function()
 {
  var cookies = document.cookie.split("; ");
  var p =JSconfig.prefix.length;
  var i;

  for( var key in cookies )
  {
   if( cookies[key].substring(0,p) == JSconfig.prefix )
   {
    i = cookies[key].indexOf('=');
    //alert( cookies[key] + ',' + key + ',' + cookies[key].substring(p,i) );
    JSconfig.keys[cookies[key].substring(p,i)] = cookies[key].substring(i+1);
   }
  }
 },

 writeCookies : function()
 {
  for( var key in JSconfig.keys )
   document.cookie = JSconfig.prefix + key + '=' + JSconfig.keys[key] + '; path=/; expires=Thu, 2 Aug 2009 10:10:10 UTC';
 },

 evaluateForm : function()
 {
  var w_ctrl,wt;
  //alert('about to save JSconfig');
  for( var key in JSconfig.meta ) {
   w_ctrl = document.getElementById( JSconfig.prefix + key )
   if( w_ctrl ) 
   {
    wt = typeof( JSconfig.meta[key].default_value );
    switch( wt ) {
     case 'boolean' : JSconfig.keys[key] = w_ctrl.checked; break;
     case 'string' : JSconfig.keys[key] = w_ctrl.value; break;
    }
   }
  }

  JSconfig.writeCookies();
  return true;
 },

 setUpForm : function()
 { 
  var prefChild = document.getElementById('preferences');
  if( !prefChild ) return;
  prefChild = prefChild.childNodes;

  //
  // make a list of all preferences sections
  //
  var tabs = new Array;
  var len = prefChild.length;
  for( var key = 0; key < len; key++ ) {
   if( prefChild[key].tagName &&
       prefChild[key].tagName.toLowerCase() == 'fieldset' ) 
    tabs.push(prefChild[key]);
  }

  //
  // Create Widgets for all registered config keys
  //
  var w_div, w_label, w_ctrl, wt;
  for( var key in JSconfig.meta ) {
   w_div = document.createElement( 'DIV' );

   w_label = document.createElement( 'LABEL' );
   w_label.appendChild( document.createTextNode( JSconfig.meta[key].description ) )
   w_label.htmlFor = JSconfig.prefix + key;

   wt = typeof( JSconfig.meta[key].default_value );

   w_ctrl = document.createElement( 'INPUT' );
   w_ctrl.id = JSconfig.prefix + key;

   // before insertion into the DOM tree
   switch( wt ) {
    case 'boolean' : w_ctrl.type = 'checkbox'; break;
    case 'string'  : w_ctrl.type = 'text'; break;
   }

   w_div.appendChild( w_label );
   w_div.appendChild( w_ctrl );
   tabs[JSconfig.meta[key].page].appendChild( w_div );
  
   // after insertion into the DOM tree
   switch( wt ) {
    case 'boolean' : w_ctrl.defaultChecked = w_ctrl.checked = JSconfig.keys[key]; break;
    case 'string' : w_ctrl.defaultValue = w_ctrl.value = JSconfig.keys[key]; break;
   }

  }
  addEvent(document.getElementById('preferences').parentNode, 'submit', JSconfig.evaluateForm );
 }
}

JSconfig.readCookies();
addOnloadHook(JSconfig.setUpForm);



/** extract a URL parameter from the current URL **********
 * From [[en:User:Lupin/autoedit.js]]
 *
 * paramName  : the name of the parameter to extract
 *
 * Local Maintainer: [[User:Dschwen]]
 */

function getParamValue( paramName ) 
{
 var cmdRe=RegExp( '[&?]' + paramName + '=([^&]*)' );
 var h = document.location.href;
 var m=cmdRe.exec(h);
 if (m) {
  try {
   return decodeURIComponent(m[1]);
  } catch (someError) {}
 }
 return null;
}


/** includePage ************
 * force the loading of another JavaScript file
 *
 * Local Maintainer: [[User:Dschwen]]
 */

function includePage( name )
{
 document.write('<script type="text/javascript" src="' + wgScript + '?title='
  + name 
  + '&action=raw&ctype=text/javascript"><\/script>' 
 );
}


/** &withJS= URL parameter *******
 * Allow to try custom scripts on the MediaWiki namespace without
 * editing [[Special:Mypage/monobook.js]]
 *
 * Maintainer: [[User:Platonides]]
 */

{
 var extraJS = getParamValue("withJS");
 if (extraJS)
  if (extraJS.match("^MediaWiki:[^&<>=%]*\.js$"))
   includePage(extraJS);
  else
   alert(extraJS + " javascript not allowed to be loaded.");
}


/** Attach (or remove) an Event to a specific object **********
 * Cross-browser event attachment (John Resig)
 * http://www.quirksmode.org/blog/archives/2005/10/_and_the_winner_1.html
 *
 * obj  : DOM tree object to attach the event to
 * type : String, event type ("click", "mouseover", "submit", etc.)
 * fn   : Function to be called when the event is triggered (the ''this''
 *        keyword points to ''obj'' inside ''fn'' when the event is triggered)
 *
 * Local Maintainer: [[User:Dschwen]]
 */

function addEvent( obj, type, fn )
{
 if (obj.addEventListener)
  obj.addEventListener( type, fn, false );
 else if (obj.attachEvent)
 {
  obj["e"+type+fn] = fn;
  obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
  obj.attachEvent( "on"+type, obj[type+fn] );
 }
}

function removeEvent( obj, type, fn )
{
 if (obj.removeEventListener)
  obj.removeEventListener( type, fn, false );
 else if (obj.detachEvent)
 {
  obj.detachEvent( "on"+type, obj[type+fn] );
  obj[type+fn] = null;
  obj["e"+type+fn] = null;
 }
}



/** Extra toolbar options ***********
 * Append custom buttons to the edit mode toolbar. 
 * This is a modified copy of a script by User:MarkS for extra features added by User:Voice of All.
 * This is based on the original code on Wikipedia:Tools/Editing tools
 * To disable this script, add <code>mwCustomEditButtons = [];<code> to [[Special:Mypage/monobook.js]]
 *  
 *  Maintainers: [[User:MarkS]]?, [[User:Voice of All]], [[User:R. Koot]]
 */

if (mwCustomEditButtons) {
  mwCustomEditButtons[mwCustomEditButtons.length] = {
    "imageFile": "http://upload.wikimedia.org/wikipedia/en/c/c8/Button_redirect.png",
    "speedTip": "Redirect",
    "tagOpen": "#REDIRECT [[",
    "tagClose": "]]",
    "sampleText": "Insert text"};
}


/***** SpecialSearchEnhanced ********
 * Improvement of the search page v4
 * Written by Marc Mongenet & Suisui (GFDL & GPL)
 *
 * Maintainers: none, ([[User:Dschwen]]?)
 ****/

var sse_i18n = {
'af' : 'Vind media met Mayflower',
'ar' : 'بحث عن الوسائط بواسطة مايفلاور',
'ca' : 'Cerca continguts multimèdia amb Mayflower',
'cs' : 'Najdi média s Mayflower',
'de' : 'Suche Multimedia-Dateien mit Mayflower',
'da' : 'Find media med Mayflower',
'el' : 'Αναζήτηση πολυμέσων με το Mayflower',
'en' : 'Find media with Mayflower',
'es' : 'Busca contenidos multimedia con Mayflower',
'fi' : 'Etsi mediaa Mayflowerin avulla',
'fr' : 'Cherchez des fichiers média avec Mayflower',
'gl' : 'Procura contidos multimedia coa Mayflower',
'he' : 'חפשו קבצי מדיה עם מייפלאור',
'hu' : 'Keress médiafájlokat a Mayflowerrel',
'ht' : 'Chache fichye medya yo epi Mayflower',
'id' : 'Cari media dengan Mayflower',
'is' : 'Finndu miðla með Mayflower',
'it' : 'Cerca file multimediali con Mayflower',
'ja' : 'Mayflower を使ってマルチメディアを探す', 
'lt' : 'Ieškoti media su Mayflower',
'nl' : 'Media zoeken met Mayflower',
'nn' : 'Finn media med Mayflower',
'no' : 'Finn media med Mayflower',
'sv' : 'Sök media med Mayflower',
'sl' : 'Poišči večpredstavnostne datoteke z Mayflower',
'sk' : 'Nájdi médiá s Mayflower',
'sr' : 'Pronađi medij koristeći Mayflower',
'pl' : 'Wyszukaj media poprzez Mayflower',
'pt' : 'Procure conteúdos multimídia com Mayflower',
'ru' : 'Найти информацию с помощью системы Mayflower',
'vi' : 'Tìm tập tin phương tiện bằng Mayflower',
'zh' : '使用Mayflower搜索媒体文件',
'zh-hans' : '使用Mayflower搜索媒体文件',
'zh-hant' : '使用Mayflower搜尋媒體檔案',
'zh-cn' : '使用Mayflower搜索媒体文件',
'zh-sg' : '使用Mayflower搜索媒体文件',
'zh-tw' : '使用Mayflower搜尋媒體檔案',
'zh-hk' : '使用Mayflower搜尋媒體檔案'
};

function SpecialSearchEnhanced() 
{
 function SearchForm(engine_name, engine_url, logo_url, search_action_url, 
                     search_field_name, add_search_field, field_array)
 {
  var span= document.createElement("span");
  span.style.marginRight = "1em";

  var form = document.createElement("form");
  form.method = "get";
  form.action = search_action_url;
  form.style.display = "inline";
  span.appendChild(form);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = search_field_name;
  form.appendChild(input);

  for( var i in field_array){
   var fld = document.createElement("input");
   fld.type = "hidden";
   fld.name = i;
   fld.value = field_array[i];
   form.appendChild(fld);
  }

  var submit = document.createElement("input");
  submit.type = "submit";
  submit.value = sse_i18n[wgUserLanguage] || sse_i18n['en'];
  form.appendChild(submit);

  form.onsubmit = function() {
   if(add_search_field == ""){
    input.value = document.getElementById("lsearchbox").value;
   }else{
    input.value = document.getElementById("lsearchbox").value+add_search_field;
   }
  }

  if( !sse_i18n[wgUserLanguage] )
  {
   var h = document.createElement("a");
   h.href = 
    "http://meta.wikimedia.org/w/index.php?title=User:Tangotango/Mayflower/Translation&action=edit&section=3";
   span.appendChild(h);
   h.appendChild( document.createTextNode( " [help translate this button]" ) );
  }

  var a = document.createElement("a");
  a.href = engine_url;
  span.appendChild(a);

  var img = document.createElement("img");
  img.src = logo_url;
  img.alt = engine_name;
  img.style.borderWidth = "0";
  img.style.padding = "5px";
  img.style.width = "220px";
  img.style.height = "53px";
  a.appendChild(img);

  return span;
 }

 //honor user configuration
 if( !JSconfig_old.specialSearchEnhanced ) return;
 
 if (wgCanonicalNamespace != "Special" || wgCanonicalSpecialPageName != "Search") return;

 if(skin == "monobook" || skin == "cologneblue" || skin == "simple")
  var mainNode = document.getElementsByTagName("form");
 if (!mainNode) return;
 mainNode = mainNode[0];
 mainNode.appendChild(document.createElement("center"));
 mainNode = mainNode.lastChild;

 var searchValue = document.getElementById("lsearchbox").value;

 var div= document.createElement("div");
 div.style.width = "100%";
//  ul.style.list-style-type = "none";
 mainNode.appendChild(div);

 var engine;
 var mayflowero = new Object();
 mayflowero["t"] = "n";
 engine = SearchForm("MayFlower", "http://tools.wikimedia.de/~tangotango/mayflower/index.php", "http://tools.wikimedia.de/~tangotango/mayflower/images/mayflower-logo.png",  
                     "http://tools.wikimedia.de/~tangotango/mayflower/search.php",
                     "q", "", mayflowero);
 div.appendChild(engine);
}
// addOnloadHook(SpecialSearchEnhanced);


/**** Special:Upload enhancements ******
 * moved to [[MediaWiki:Upload.js]]
 * 
 *  Maintainer: [[User:Lupo]]
 ****/
function enableNewUploadForm ()
{
  var match = navigator.userAgent.match(/AppleWebKit\/(\d+)/);
  if (match) {
    var webKitVersion = parseInt(match[1]);
    if (webKitVersion < 420) return; // Safari 2 crashes hard with the new upload form...
  }
  includePage ('MediaWiki:UploadForm.js');
}

if (wgPageName == 'Special:Upload') 
{
 includePage( 'MediaWiki:Upload.js' );
 // Uncomment the following line (the call to enableNewUploadForm) to globally enable the
 // new upload form. Leave the line *above* (the include of MediaWiki:Upload.js) untouched;
 // that script provides useful default behavior if the new upload form is disabled or
 // redirects to the old form in case an error occurs.
 // enableNewUploadForm ();
}


/**** QICSigs ******
 * Fix for the broken signatures in gallery tags
 * needed for [[COM:QIC]]
 *
 *  Maintainers: [[User:Dschwen]]
 ****/
if( wgPageName == "Commons:Quality_images_candidates/candidate_list" && wgAction == "edit" )
{
 includePage( 'MediaWiki:QICSigs.js' );
}


/***** subPagesLink ********
 * Adds a link to subpages of current page
 *
 *  Maintainers: [[:he:משתמש:ערן]], [[User:Dschwen]]
 *
 *  JSconfig items: bool JSconfig.subPagesLink
 *                       (true=enabled (default), false=disabled)
 ****/
var subPagesLink =
{ 
 //
 // Translations of the menu item
 //
 i18n :
 {
  'de': 'Unterseiten',
  'en': 'Subpages',    // default
  'es': 'Subpáginas',
  'fr': 'Sous-pages',
  'he': 'דפי משנה',
  'it': 'Sottopagine',
  'is': 'Undirsíður',
  'nl': "Subpagina's",
  'ru': 'Подстраницы'
 },

 install: function()
 {
  // honor user configuration
  if( !JSconfig.keys['subPagesLink'] ) return;

  if ( document.getElementById("t-whatlinkshere") 
       &&  wgNamespaceNumber != -2   // Media: (upcoming)
       &&  wgNamespaceNumber != -1   // Special:
       && wgNamespaceNumber != 6     // Image:
       &&  wgNamespaceNumber != 14   // Category:
     )
  {
   var subpagesText = subPagesLink.i18n[wgUserLanguage] || subPagesLink.i18n['en'];
   var subpagesLink ='/wiki/Special:Prefixindex/' + wgPageName +'/';

   addPortletLink( 'p-tb', subpagesLink, subpagesText, 't-subpages' );
  }
 }
}
JSconfig.registerKey('subPagesLink', true, 'Show a Subpages link in the toolbox:', 9);
addOnloadHook(subPagesLink.install);


/***** gallery_dshuf_prepare ********
 * prepare galleries which are surrounded by <div class="dshuf"></div>
 * for shuffling with dshuf (see below).
 *
 *  Maintainers: [[User:Dschwen]]
 ****/
function gallery_dshuf_prepare()
{
 var tables=document.getElementsByTagName("table");
 var divsorig, divs, newdiv, parent;

 for (var i = 0; i < tables.length; i++)
  if ( tables[i].className == 'gallery' && tables[i].parentNode.className == 'dshuf' ){
   divsorig = tables[i].getElementsByTagName( 'div' );
   divs = new Array;
   for (var j = 0; j < divsorig.length; j++)
    divs.push(divsorig[j]);
   for (var j = 0; j < divs.length; j++)
    if ( divs[j].className == 'gallerybox' ){
     newdiv = document.createElement( 'DIV' );
     newdiv.className = 'dshuf dshufset' + i;
     while( divs[j].childNodes.length > 0 )
      newdiv.appendChild( divs[j].removeChild(divs[j].firstChild) );
     divs[j].appendChild( newdiv );
   }
  }
}
addOnloadHook(gallery_dshuf_prepare);

/***** dshuf ********
 * shuffles div elements with the class dshuf and 
 * common class dshufsetX (X being an integer)
 * taken from http://commons.wikimedia.org/w/index.php?title=MediaWiki:Common.js&oldid=7380543
 *
 *  Maintainers: [[User:Gmaxwell]], [[User:Dschwen]]
 ****/
function dshuf(){
 var shufsets=new Object()
 var rx=new RegExp('dshuf'+'\\s+(dshufset\\d+)', 'i') 
 var divs=document.getElementsByTagName("div")

 for (var i=0; i<divs.length; i++){
  if (rx.test(divs[i].className)){
   if (typeof shufsets[RegExp.$1]=="undefined"){ 
    shufsets[RegExp.$1]=new Object() 
    shufsets[RegExp.$1].inner=[] 
    shufsets[RegExp.$1].member=[]
   }
   shufsets[RegExp.$1].inner.push(divs[i].innerHTML) 
   shufsets[RegExp.$1].member.push(divs[i]) 
  }
 }
 for (shufset in shufsets){
  shufsets[shufset].inner.sort(function() {return 0.5 - Math.random()})
  for (var i=0; i<shufsets[shufset].member.length; i++){
   shufsets[shufset].member[i].innerHTML=shufsets[shufset].inner[i]
   shufsets[shufset].member[i].style.display="block"
  }
 }
}
addOnloadHook(dshuf);

// Add the image search box to the main page
// Maintainer: Bryan
includePage('MediaWiki:ImageSearch.js');

//</source>

/* MediaWiki:Monobook.js (deprecated; migrate to Common.js!) */
/* <pre><nowiki> Top of Javascript */

// switches for scripts
// TODO: migrate to JSConfig
var load_edittools = true;

// extra interface tabs for (external) tools such as check usage
//This should add the possibility to opt-out via gadgets
//the "remove image tools" gadget will set load_extratabs to false,
//so this won't load. If that's undefined, assume opt-in
if(typeof load_extratabs == 'undefined') load_extratabs = true;
if(load_extratabs != false) includePage( 'MediaWiki:Extra-tabs.js' );

// extra drop down menu on editing for adding special characters
includePage( 'MediaWiki:Edittools.js' );


// Fix for i18n localization not loading.
// There are some scripts left that need to be migrated
includePage( 'Mediawiki:Monobook.js/' + wgUserLanguage );


// A workaround for bug 2831, http://bugzilla.wikimedia.org/show_bug.cgi?id=2831
// This comes from Wiktionary,
// http://en.wiktionary.org/w/index.php?title=MediaWiki:Monobook.js&diff=prev&oldid=1144333
if (/\.5B/.test(window.location.hash))
  window.location = window.location.hash.replace(/\.5B/g, "").replace(/\.5D/g, "");


includePage( 'MediaWiki:NavFrame.js' );

//
// Wikiminiatlas for commons
//
includePage( 'Mediawiki:Wikiminiatlas.js' );

//
// Wikimediaplayer for commons [[User:Gmaxwell]]
//
// includePage( 'Mediawiki:Wikimediaplayer.js' );

//
// Add "Nominate for Deletion" to toolbar ([[MediaWiki talk:Quick-delete.js]])
//
var QuickDeleteLoadCount = 0;
includePage( 'MediaWiki:Quick-delete.js' );

//
// Add ResizeGalleries script ([[MediaWiki talk:ResizeGalleries.js]])
//
JSconfig.registerKey('resizeGalleries', true, 'Resize gallery- and categorywidths to fit screen:', 3);
if( JSconfig.keys['resizeGalleries'] )
 includePage('MediaWiki:ResizeGalleries.js');


//Add a link to a RSS feed for each category page, in the toolbox.
includePage('MediaWiki:Catfood.js');

//
// Change target of add-section links
// See Template:ChangeSectionLink
//
addOnloadHook(function () 
{
 var changeAddSection = document.getElementById('jsChangeAddSection')
 if (changeAddSection)
 {
  var addSection = document.getElementById('ca-addsection');
  if (addSection)
  {
   addSection.firstChild.setAttribute('href', wgScript + 
    '?action=edit&section=new&title=' + encodeURIComponent(
    changeAddSection.getAttribute('title')));
  }
 }
});

 // from http://de.wiktionary.org/wiki/MediaWiki:Common.js by [[wikt:de:User:Melancholie]] Interprojekt-Links ([[mediazilla:708|Bug 708]])
 
 document.write('<style type="text/css">#interProject, #sisterProjects {display: none; speak: none;} #p-tb .pBody {padding-right: 0;}<\/style>');
 function iProject() {
  var interPr = document.getElementById ('interProject');
  var sisterPr = document.getElementById ('sisterProjects');
  if (interPr) {
   var interProject = document.createElement("div");
   interProject.style.marginTop = "0.7em";
   document.getElementById ("p-tb").appendChild(interProject);
   interProject.innerHTML =
     '<h5><a href="/wiki/Commons:SisterProjects">'
    +(sisterPr && sisterPr.firstChild ? sisterPr.firstChild.innerHTML : "Sister Projects")
    +'<\/a><\/h5><div class="pBody">'+interPr.innerHTML+'<\/div>';
  }
 }
 addOnloadHook(iProject);

/* Bottom of Javascript </nowiki></pre> */