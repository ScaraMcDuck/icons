//Installing this (as described on the talk page) will give you links in the toolbox for all pages in the Image: namespace, that say 'Nominate for deletion', 'mark as no source' and 'mark as no license'. The first one will give you a pop-up that asks for a reason. It inserts this reason on [[COM:DEL]], marks the image for deletion and notifies the uploader. The second and third one mark the image as missing source/license (NSD/NLD) and notify the uploader. Note: don't abuse this. If you mark 10 images from one user as no source, don't use this because they will get 10 separate warnings on their talk page!! (Or if you do, at least clean it up afterwards.)

if (!QuickDeleteLoadCount) { // Load functions only once

//Yes, this needs super cleaning-up and there's duplicate code and it doesn't work for Konqueror. Nonetheless it works at least for Firefox. If there's one central copy it's much easier to keep up to date than everyone having their own copy.
//Also it has no i18n. I will leave that for the experts.

// Main code by [[:en:User:Jietse Niesen]], some adaption by [[user:pfctdayelise]], cleanup by [[User:Alphax]]

// Now available on en.wp! See [[w:User:Howcheng/quickimgdelete.js]].

// ==Automatic 'nominate for deletion', 'mark no license', 'mark no permission', 'mark no source' scripts==
// <pre>
// Configuration

// Should the edits be saved automatically?
if(window.nfd_autosave == false){}else if(window.nfd_autosave){}else{ nfd_autosave = true; }
if(window.mnx_autosave == false){}else if(window.mnx_autosave){}else{ mnx_autosave = true; }

// String constants
nfd_text = "Nominate for deletion";
nfd_tooltip = "Nominate this image for deletion";
nfd_prompt = "Why do you want to nominate this image for deletion?";
nfd_delReq = "Commons:Deletion_requests";
nfd_deleteTemplate = "delete";
nfd_idwTemplate = "idw";

if (wgUserLanguage != 'en')
{
 includePage( 'MediaWiki:Quick-delete2.js/' + wgUserLanguage );
}

mns_text = "No source";
mns_tooltip = "Mark this image as missing required source information";
mnl_text = "No license";
mnl_tooltip = "Mark this image as missing required licensing information";
mnp_text = "No permission";
mnp_tooltip = "Mark this image as missing required permission information";
mnx_lang = "lang?";
mnx_langquery = "In which language should the message be given? "+
"Example: en for English, de for German, es for Spanish, etc. " +
"If the language does not exist for the template, a red link will be inserted. ";


var now = new Date();
var timestamp = now.getUTCFullYear() + '/';
now.getUTCMonth() < 9 ? timestamp += '0' + (now.getUTCMonth() + 1) : timestamp += (now.getUTCMonth() + 1);
timestamp += '/';
now.getUTCDate() < 10 ? timestamp += '0' + now.getUTCDate() : timestamp += now.getUTCDate();
nfd_datePage = nfd_delReq + "/" + timestamp;
var monthsArray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var timestamp2 = monthsArray[now.getUTCMonth()] + " " + now.getUTCDate();

// From [[en:Wikipedia:WikiProject User scripts/Scripts/addLink]]
function addLink(where, url1, name1, id, title, key, after, url2, name2)
{
    //* where is the id of the toolbar where the button should be added;
    //   i.e. one of "p-cactions", "p-personal", "p-navigation", or "p-tb".
    //
    //* url1 is the URL which will be called when the button is clicked.
    //   javascript: urls can be used to do more complex things.
    //
    //* name1 is what will appear as the name of the button.
    //
    //* id is the id of the button; it's best to define one.  
    //   Use a prefix to make sure its unique. Optional.
    //
    //* title is the tooltip title that gives a longer description 
    //   of the button; if you define a accesskey, mention it here. Optional.
    //
    //* key is the char you want for the accesskey. Optional.
    //
    //* after is the id of the button you want to follow this one. Optional.
    //
    //* url2 is a second url to add. Optional
    //
    //*name2 is the name of the second url; defaults to name1. Optional
    var na = document.createElement('a');
    na.href = url1;
    na.appendChild(document.createTextNode(name1));
    var li = document.createElement('li');
    if(id) li.id = id;
    li.appendChild(na);

    if (url2) { //Another link, brother of the previous.
       var na = document.createElement('a');
       na.href = url2;       
       na.appendChild(document.createTextNode(name2 ? name2 : name1));
       li.appendChild(document.createTextNode(" · ")); //separate them a bit
       li.appendChild(na);
    }

    var tabs = document.getElementById(where).getElementsByTagName('ul')[0];
    if(after) {
        tabs.insertBefore(li,document.getElementById(after));
    } else {
        tabs.appendChild(li);
    }
    if(id) {
        if(key && title) { ta[id] = [key, title]; }
        else if(key) { ta[id] = [key, '']; }
        else if(title) { ta[id] = ['', title];} 
    }
    // re-render the title and accesskeys from existing code in wikibits.js
    akeytt();
    return li;
}

function openWindow(url) {
  var res = window.open(url, '_blank');
  if (!res) alert("openWindow: window.open() returned null");
}

function getUploader() {
  // Get uploader from first point in the list under "File history"
  // Uploader is stored in second A tag in UL tag under "File history"
  // Returns title of user page (without name space) in URL form
  var el = document.getElementById('filehistory')
  if (!el) {
    alert("getUploader: Cannot find filehistory ... exiting");
    return null;
  }
  while (el.nextSibling) {
    el = el.nextSibling;
    if (el.tagName && el.tagName.toLowerCase() == 'table') 
      break;
  }
  if (!el) {
    alert("getUploader: Cannot find table tag ... exiting");
    return null;
  }

  var as = el.getElementsByTagName('a');

  var re1 = new RegExp((wgServer + wgArticlePath.substr(0, wgArticlePath.length-2) ).replace(/\./g, '\\.') + 'User:(.*)$');
  var re2 = new RegExp((wgServer  + wgScript).replace(/\./g, '\\.') + '\\?title=User:([^&]*)');
  var m;
  for (var k=0; k<as.length; k++) {
     m = re1.exec(as[k].href);
     if (m) return m[1];
     m = re2.exec(as[k].href);
     if (m) return m[1];
  }
  alert("getUploader: Cannot find uploader ... exiting");
  return null;
}

function nfd_nomForDel() {
  var reason = prompt(nfd_prompt, '');
  if (!reason) return;
  var pagename = encodeURIComponent(wgPageName);
  var uploader = getUploader();
  if (!uploader) return;
  openWindow(wgScript + '?title=User_talk:' + uploader
     + '&action=edit&fakeaction=nfd_warn&target=' + pagename);
  openWindow(wgScript + '?title=' + nfd_delReq + '/' + pagename 
     + '&action=edit&fakeaction=nfd_add&target=' + pagename + '&reason='
     + encodeURIComponent(reason));
  openWindow(wgScript + '?title=' + nfd_datePage +
     '&action=edit&fakeaction=nfd_add2&target=' + pagename);
  var editlk = document.getElementById('ca-edit').getElementsByTagName('a')[0].href;
  document.location = editlk + '&fakeaction=nfd_delete&reason=' + encodeURIComponent(reason);
}

function nfd_addDeleteTemplate() {
  var reason = decodeURIComponent(getParamValue('reason'));
  var txt = '{{' + nfd_deleteTemplate + '|reason=' + reason + '}}';
  document.editform.wpTextbox1.value = txt + '\n' + document.editform.wpTextbox1.value;
  document.editform.wpSummary.value = 'Nominating image for deletion';
  if (nfd_autosave) document.editform.wpSave.click();
}

function nfd_addIdwTemplate(target) {
  var txt = '{{subst:' + nfd_idwTemplate + '|' + target + '}}';
  document.editform.wpTextbox1.value += 
    (document.editform.wpTextbox1.value.length > 0 ? '\n' : '') +
    txt + '~~' + '~~\n';
  document.editform.wpSummary.value = 'Image deletion warning: ' + target;
  if (nfd_autosave) document.editform.wpSave.click();
}

function nfd_updateDelReq(target, reason) {
  document.editform.wpTextbox1.value += 
    (document.editform.wpTextbox1.value.length > 0 ? '\n' : '') +
    '{{subst:delete2|image=' + target + '|reason=' + reason + ' ~~' + '~~}}';
  document.editform.wpSummary.value = 'Nominating [[' + target + ']]';
  if (nfd_autosave) document.editform.wpSave.click();
}

function nfd_updateDelReq2(target) {
  document.editform.wpTextbox1.value += 
    (document.editform.wpTextbox1.value.length > 0 ? '' : '==' + timestamp2 + '==\n') +
    '{{subst:delete3|pg=' + target + '}}';
  document.editform.wpSummary.value = 'Nominating [[' + target + ']]';
  if (nfd_autosave) document.editform.wpSave.click();
}

function nfd_onload() {
  if (wgNamespaceNumber == 6) { //NS_IMAGE
    addLink('p-tb', 'javascript:nfd_nomForDel()', nfd_text, 'nom-for-del', nfd_tooltip);
  }
  var fakeaction = getParamValue('fakeaction');
  if (fakeaction == 'nfd_delete')
    nfd_addDeleteTemplate();
  else if (fakeaction == 'nfd_warn')
    nfd_addIdwTemplate(decodeURIComponent(getParamValue('target')));
  else if (fakeaction == 'nfd_add')
    nfd_updateDelReq(decodeURIComponent(getParamValue('target')), decodeURIComponent(getParamValue('reason')));
  else if (fakeaction == 'nfd_add2')
    nfd_updateDelReq2(decodeURIComponent(getParamValue('target')));
}

// ??
function mnx_mark(imagepage_fakeaction, usertalk_fakeaction, message_lang) {
  if (!message_lang) return; //User pressed cancel

  var pagename = encodeURIComponent(wgPageName);
  var uploader = getUploader();
  
  if (!uploader) return;
  // Open new window for the user page
  openWindow(wgScript + '?title=User_talk:' + uploader
     + '&action=edit&fakeaction=' + usertalk_fakeaction + '&target=' + pagename + '&mnx_lang=' + message_lang + '&template_type=' + imagepage_fakeaction);
  var editlk = document.getElementById('ca-edit').getElementsByTagName('a')[0].href;
  document.location = editlk + '&fakeaction=' + imagepage_fakeaction + '&mnx_lang=' + message_lang;
}

// Add template to image description page
// sorl = "source", "permission" or "license"
function mnx_addTemplate(template, sorl) {		
  if (template == 'nsd') template='no source since';
  if (template == 'nld') template='no license';
  if (template == 'npd') template='no permission since';
  if (getParamValue('mnx_lang')) {
          template = template + '/' + getParamValue('mnx_lang');
          template = template + '|' + 'month={{subst:CURRENTMONTHNAME}}|day={{subst:CURRENTDAY}}|year={{subst:CURRENTYEAR}}';
  }

  //  the edit summary for when you mark the image. You can change it if you want.  
  var txt = '{{' + template + '}}';
  document.editform.wpTextbox1.value = txt + '\n' + document.editform.wpTextbox1.value;
  document.editform.wpSummary.value = 'marking image as missing essential ' + sorl + ' information. If this is not fixed this image might be deleted after 7 days.';
  if (mnx_autosave) document.editform.wpSave.click();
}

// Add warning template to uploader's talk page
function mnx_addUserWarningTemplate(imagetarget, template_type) {
  // If template to add is a not permission template, add {{image permission}}
  if (template_type == 'mnp_mnp')			
     var txt = '{{subst:image permission' + (getParamValue('mnx_lang') ? '/' + getParamValue('mnx_lang') : '' ) + '|' + imagetarget + '}}';
  // else, add the {{image source}} template
  else
     var txt = '{{subst:image source' + (getParamValue('mnx_lang') ? '/' + getParamValue('mnx_lang') : '' ) + '|' + imagetarget + '}}';

  // add in subst: if you want to subst these warnings
  document.editform.wpTextbox1.value += '\n' + txt + '~~' + '~~\n';
  document.editform.wpSummary.value = "Warning: image missing source or licensing information.";
  // this is the edit summary for when you leave the user warning on the talk page.
  // you can change it if you want.
  if (mnx_autosave) document.editform.wpSave.click();		// save page
}

function mnx_onload() {
  if (wgNamespaceNumber == 6) { //NS_IMAGE
    addLink('p-tb', 'javascript:mnx_mark(\'mns_mns\', \'mnx_warn\', \'en\')', mns_text, 'mark-no-source', mns_tooltip, null, null, 'javascript:mnx_mark(\'mns_mns\', \'mnx_warn\', prompt(\'' + mnx_langquery + '\', wgUserLanguage))', mnx_lang);
    addLink('p-tb', 'javascript:mnx_mark(\'mnp_mnp\', \'mnx_warn\', \'en\')', mnp_text, 'mark-no-permission', mnp_tooltip, null, null, 'javascript:mnx_mark(\'mnp_mnp\', \'mnx_warn\', prompt(\'' + mnx_langquery + '\', wgUserLanguage))', mnx_lang);
    addLink('p-tb', 'javascript:mnx_mark(\'mnl_mnl\', \'mnx_warn\', \'en\')', mnl_text, 'mark-no-license', mnl_tooltip, null, null, 'javascript:mnx_mark(\'mnl_mnl\', \'mnx_warn\', prompt(\'' + mnx_langquery + '\', wgUserLanguage))', mnx_lang);
  }
  var fakeaction = getParamValue('fakeaction');
  var template_type = getParamValue('template_type');	// Fetch what template to add

  if (fakeaction == 'mns_mns'){
    mnx_addTemplate('nsd','source');
  }
  if (fakeaction == 'mnp_mnp'){
    mnx_addTemplate('npd','permission');
  }
  if (fakeaction == 'mnl_mnl'){
    mnx_addTemplate('nld','license');
  }
  if (fakeaction == 'mnx_warn') {  // Add warning to uploader's talk page
    mnx_addUserWarningTemplate(decodeURIComponent(getParamValue('target')), template_type); }

 }
}

//QuickDeleteLoadCount black magic.
//We use this to provide different functions to different users.
QuickDeleteLoadCount++; //We keep track in QuickDeleteLoadCount how many times this file was loaded.

if (QuickDeleteLoadCount == 1) { 
  //First load is from [[Mediawiki:Common.js]]
  addOnloadHook(nfd_onload); //Provide nominate for deletion. Formerly [[MediaWiki:Quick-delete2.js]]
} else if (QuickDeleteLoadCount == 2) { 
  //The user has this file in it's /monobook.js. Provide extended functionality.
  addOnloadHook(mnx_onload); //No source, no permission, no license.
}
/*else if (QuickDeleteLoadCount > 2) alert("Why do you have MediaWiki:Quick-delete.js loaded several times on your monobook.js??") //Silently ignore this */

// </pre>