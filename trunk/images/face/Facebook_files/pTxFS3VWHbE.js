/*!CK:2940157709!*//*1387161007,178186557*/

if (self.CavalryLogger) { CavalryLogger.start_js(["WVkgu"]); }

__d("SwapButtonDEPRECATED",["Event","Arbiter","copyProperties","CSS","Focus"],function(a,b,c,d,e,f){var g=b('Event'),h=b('Arbiter'),i=b('copyProperties'),j=b('CSS'),k=b('Focus');function l(m,n,o){this._swapperButton=m;this._swappeeButton=n;g.listen(m,'click',this.swap.bind(this));if(o)g.listen(n,'click',this.unswap.bind(this));h.subscribe('SwapButtonDEPRECATED/focusOnJoinButton',this.setFocusOnSwapper.bind(this),h.SUBSCRIBE_ALL);}i(l.prototype,{_swapperButton:null,_swappeeButton:null,swap:function(m){j.hide(this._swapperButton);j.show(this._swappeeButton);m!==false&&k.setWithoutOutline(this._swappeeButton);},unswap:function(m){j.show(this._swapperButton);j.hide(this._swappeeButton);m!==false&&k.setWithoutOutline(this._swapperButton);},toggle:function(){j.toggle(this._swapperButton);j.toggle(this._swappeeButton);},setFocusOnSwapper:function(){this._swapperButton.focus();}});e.exports=l;});
__d("legacy:dom-html",["HTML"],function(a,b,c,d){a.HTML=b('HTML');},3);
__d("DoublyLinkedListMap",[],function(a,b,c,d,e,f){function g(){"use strict";this._head=null;this._tail=null;this._nodes={};this._nodeCount=0;}g.prototype.get=function(h){"use strict";return this._nodes[h]?this._nodes[h].data:null;};g.prototype.getIndex=function(h){"use strict";for(var i=this._head,j=0;i;i=i.next,j++)if(i.key===h)return j;return null;};g.prototype._insert=function(h,i,j,k){"use strict";j&&!this._nodes[j]&&(j=null);var l=(j&&this._nodes[j])||(k?this._head:this._tail),m={data:i,key:h,next:null,prev:null};if(l){this.remove(h);if(k){m.prev=l.prev;l.prev&&(l.prev.next=m);l.prev=m;m.next=l;}else{m.next=l.next;l.next&&(l.next.prev=m);l.next=m;m.prev=l;}}m.prev===null&&(this._head=m);m.next===null&&(this._tail=m);this._nodes[h]=m;this._nodeCount++;return this;};g.prototype.insertBefore=function(h,i,j){"use strict";return this._insert(h,i,j,true);};g.prototype.insertAfter=function(h,i,j){"use strict";return this._insert(h,i,j,false);};g.prototype.prepend=function(h,i){"use strict";return this.insertBefore(h,i,this._head&&this._head.key);};g.prototype.append=function(h,i){"use strict";return this.insertAfter(h,i,this._tail&&this._tail.key);};g.prototype.remove=function(h){"use strict";var i=this._nodes[h];if(i){var j=i.next,k=i.prev;j&&(j.prev=k);k&&(k.next=j);this._head===i&&(this._head=j);this._tail===i&&(this._tail=k);delete this._nodes[h];this._nodeCount--;}return this;};g.prototype.find=function(h){"use strict";for(var i=this._head;i;i=i.next)if(h(i.data))return i.key;return null;};g.prototype.reduce=function(h,i){"use strict";for(var j=this._head;j;j=j.next)i=h(j.data,i);return i;};g.prototype.exists=function(h){"use strict";return !!this._nodes[h];};g.prototype.isEmpty=function(){"use strict";return !this._head;};g.prototype.reset=function(){"use strict";this._head=null;this._tail=null;this._nodes={};this._nodeCount=0;};g.prototype.map=function(h){"use strict";for(var i=this._head;i;i=i.next)h(i.data);};g.prototype.getCount=function(){"use strict";return this._nodeCount;};g.prototype.getHead=function(){"use strict";return this._head&&this._head.data;};g.prototype.getTail=function(){"use strict";return this._tail&&this._tail.data;};g.prototype.getNext=function(h){"use strict";var i=this._nodes[h];if(i&&i.next)return i.next.data;return null;};g.prototype.getPrev=function(h){"use strict";var i=this._nodes[h];if(i&&i.prev)return i.prev.data;return null;};e.exports=g;});
__d("PopoverAsyncMenu",["AsyncRequest","Event","PopoverMenu","copyProperties"],function(a,b,c,d,e,f){var g=b('AsyncRequest'),h=b('Event'),i=b('PopoverMenu'),j=b('copyProperties'),k={},l=0;for(var m in i)if(i.hasOwnProperty(m))o[m]=i[m];var n=i===null?null:i.prototype;o.prototype=Object.create(n);o.prototype.constructor=o;o.__superConstructor__=i;function o(p,q,r,s,t){"use strict";this._endpoint=s;this._loadingMenu=r;this._instanceId=l++;k[this._instanceId]=this;this._mouseoverListener=h.listen(q,'mouseover',this._fetchMenu.bind(this));i.call(this,p,q,null,t);}o.prototype._onLayerInit=function(){"use strict";if(!this._menu)this.setMenu(this._loadingMenu);this._fetchMenu();this._popover.getLayer().subscribe('key',this._handleKeyEvent.bind(this));};o.prototype._fetchMenu=function(){"use strict";if(this._fetched)return;new g().setURI(this._endpoint).setData({pmid:this._instanceId}).send();this._fetched=true;if(this._mouseoverListener){this._mouseoverListener.remove();this._mouseoverListener=null;}};o.setMenu=function(p,q){"use strict";k[p].setMenu(q);};o.getInstance=function(p){"use strict";return k[p];};j(o.prototype,{_fetched:false,_mouseoverListener:null});e.exports=o;});
__d("PopoverMenuShowOnHover",["Event"],function(a,b,c,d,e,f){var g=b('Event'),h=250;function i(j){"use strict";this._popoverMenu=j;this._listeners=[];}i.prototype.enable=function(){"use strict";this._attachMouseListeners(this._popoverMenu.getTriggerElem());this._setMenuSubscription=this._popoverMenu.subscribe('setMenu',this._onSetMenu.bind(this));};i.prototype.disable=function(){"use strict";while(this._listeners.length)this._listeners.pop().remove();if(this._setMenuSubscription){this._setMenuSubscription.unsubscribe();this._setMenuSubscription=null;}};i.prototype._onSetMenu=function(){"use strict";this._attachMouseListeners(this._popoverMenu.getMenu().getRoot());};i.prototype._attachMouseListeners=function(j){"use strict";var k=this._popoverMenu.getPopover(),l=null;this._listeners.push(g.listen(j,'mouseleave',k.hideLayer.bind(k)),g.listen(j,'mouseenter',function(){l=Date.now();k.showLayer();}),g.listen(j,'click',function(m){if(Date.now()<l+h)m.stop();}));};e.exports=i;});
__d("ScrollingPager",["Arbiter","CSS","DOM","OnVisible","UIPagelet","$","copyProperties","ge"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('CSS'),i=b('DOM'),j=b('OnVisible'),k=b('UIPagelet'),l=b('$'),m=b('copyProperties'),n=b('ge'),o={};function p(q,r,s,t){"use strict";this.scroll_loader_id=q;this.pagelet_src=r;this.data=s;this.options=t||{};if(this.options.target_id){this.target_id=this.options.target_id;this.options.append=true;}else this.target_id=q;this.scroll_area_id=this.options.scroll_area_id;this.handler=null;}p.prototype.setBuffer=function(q){"use strict";this.options.buffer=q;this.onvisible&&this.onvisible.setBuffer(q);};p.prototype.getBuffer=function(){"use strict";return this.options.buffer;};p.prototype.register=function(){"use strict";this.onvisible=new j(l(this.scroll_loader_id),this.getHandler(),false,this.options.buffer,false,n(this.scroll_area_id));o[this.scroll_loader_id]=this;g.inform(p.REGISTERED,{id:this.scroll_loader_id});};p.prototype.getInstance=function(q){"use strict";return o[q];};p.prototype.getHandler=function(){"use strict";if(this.handler)return this.handler;function q(r){var s=n(this.scroll_loader_id);if(!s){this.onvisible.remove();return;}h.addClass(s.firstChild,'async_saving');var t=this.options.handler,u=this.options.force_remove_pager&&(this.scroll_loader_id!==this.target_id);this.options.handler=function(){g.inform('ScrollingPager/loadingComplete');t&&t.apply(null,arguments);if(u)i.remove(s);};if(r)this.data.pager_fired_on_init=true;k.loadFromEndpoint(this.pagelet_src,this.target_id,this.data,this.options);}return q.bind(this);};p.prototype.setHandler=function(q){"use strict";this.handler=q;};p.prototype.removeOnVisible=function(){"use strict";this.onvisible.remove();};p.prototype.checkBuffer=function(){"use strict";this.onvisible&&this.onvisible.checkBuffer();};p.getInstance=function(q){"use strict";return o[q];};m(p,{REGISTERED:'ScrollingPager/registered'});e.exports=p;});
__d("TimelineConstants",[],function(a,b,c,d,e,f){var g={DS_HEIGHT:'timeline-unit-height',DS_LOADED:'timeline-capsule-loaded',DS_SIDEORG:'timeline-unit-sideorg',DS_TAILBALANCE:'timeline-capsule-tailbalance',DS_COLUMN_HEIGHT_DIFFERENTIAL:'timeline-column-diff-height',FIXED_SIDE_LEFT:'left',FIXED_SIDE_RIGHT:'right',FIXED_SIDE_BOTH:'both',FIXED_SIDE_NONE:'none',SCROLL_TO_OFFSET:30,SUBSECTION_SCROLL_TO_OFFSET:90,SCRUBBER_DEFAULT_OFFSET:38,SECTION_LOADING:'TimelineConstants/sectionLoading',SECTION_LOADED:'TimelineConstants/sectionLoaded',SECTION_FULLY_LOADED:'TimelineConstants/sectionFullyLoaded',SECTION_REGISTERED:'TimelineConstants/sectionRegistered'};e.exports=g;});
__d("TimelineLegacySections",[],function(a,b,c,d,e,f){var g={},h={get:function(i){return g[i];},getAll:function(){return g;},remove:function(i){delete g[i];},removeAll:function(){g={};},set:function(i,j){g[i]=j;}};e.exports=h;});
__d("TimelineURI",["URI"],function(a,b,c,d,e,f){var g=b('URI'),h={TIMELINE_KEY:'timeline',WALL_KEY:'wall',parseURI:function(i){i=g(i);var j=i.getQueryData(),k=i.getPath(),l=k.split('/').slice(1);if(l[0]=='people'||l[0]=='pages')l=l.slice(2);var m=j.sk||l[1]||h.TIMELINE_KEY;if(m==h.WALL_KEY)m=h.TIMELINE_KEY;var n=null,o=null;if(m==h.TIMELINE_KEY){o=parseInt(l[2],10)||null;n=parseInt(l[3],10)||null;}return {path:k,id:j.id||l[0],key:m,viewas:j.viewas?j.viewas:0,filter:j.filter?j.filter:null,year:o,month:n,friendship:!!j.and};}};e.exports=h;});
__d("TimelineController",["Event","Arbiter","CSS","DataStore","DOMQuery","Run","ScrollingPager","TidyArbiter","TimelineConstants","TimelineLegacySections","TimelineURI","Vector","ViewportBounds","$","copyProperties","ge","tidyEvent","queryThenMutateDOM"],function(a,b,c,d,e,f){var g=b('Event'),h=b('Arbiter'),i=b('CSS'),j=b('DataStore'),k=b('DOMQuery'),l=b('Run'),m=b('ScrollingPager'),n=b('TidyArbiter'),o=b('TimelineConstants'),p=b('TimelineLegacySections'),q=b('TimelineURI'),r=b('Vector'),s=b('ViewportBounds'),t=b('$'),u=b('copyProperties'),v=b('ge'),w=b('tidyEvent'),x=b('queryThenMutateDOM'),y=358,z=48,aa=740,ba=1285,ca=null,da=false,ea,fa,ga,ha={},ia={},ja=[],ka=null,la=null,ma=false,na=false,oa=0,pa=false,qa=false,ra=false,sa={},ta=false;function ua(){ka&&ka.remove();ka=null;}function va(hb,ib,jb){jb=jb||[];if(ha[hb])return ha[hb][ib].apply(ha[hb],jb);ia[hb]=ia[hb]||{};ia[hb][ib]=jb;return false;}function wa(){if(!(pa||ra||qa)){ua();return;}var hb=r.getScrollPosition();pa=pa&&ab(v('rightCol'),hb,'paddingTop',true);qa=qa&&ab(t('pagelet_above_header_timeline'),hb,'top');ra=ra&&ab(t('blueBar'),hb,'paddingTop');}var xa=0;function ya(){xa=r.getScrollPosition();}function za(){x(ya,function(){var hb=oa===0||xa.y>=oa;va(gb.STICKY_HEADER,'toggle',[hb]);va(gb.CONTENT,'checkCurrentSectionChange');},'TimelineController/scrollListener');}function ab(hb,ib,jb,kb){if(!hb){ua();return;}if(ib.y<=0){bb(hb,jb);return false;}else{var lb=kb&&gb.getCurrentScrubber();if(lb&&i.hasClass(lb.getRoot(),'fixed_elem')){bb(hb,jb);return false;}else{var mb=parseInt(hb.style[jb],10)||0;if(ib.y<mb){i.addClass(hb,'timeline_fixed');hb.style[jb]=ib.y+'px';}else i.removeClass(hb,'timeline_fixed');}}return true;}function bb(hb,ib){hb.style[ib]='0px';i.removeClass(hb,'timeline_fixed');}function cb(){x(gb.shouldShowWideAds,function(){va(gb.ADS,'adjustAdsType',[ma]);va(gb.ADS,'adjustAdsToFit');va(gb.CONTENT,'adjustContentPadding');va(gb.STICKY_HEADER_NAV,'adjustMenuHeights');},'TimelineController/resize');}function db(hb,ib){if(hb=='sidebar/initialized')ta=true;va(gb.ADS,'adjustAdsType',[gb.shouldShowWideAds()]);}function eb(hb,ib){var jb=v('rightCol');if(jb){jb.style.paddingTop=ib+'px';pa=true;}var kb=t('pagelet_above_header_timeline');if(kb.firstChild){t('above_header_timeline_placeholder').style.height=kb.offsetHeight+'px';kb.style.top=ib+'px';qa=true;}var lb=document.documentElement;ra=lb.clientHeight<400||lb.clientWidth<lb.scrollWidth;if(ra)t('blueBar').style.paddingTop=ib+'px';ka=g.listen(window,'scroll',wa);h.inform('reflow');}function fb(){while(ja.length)ja.pop().remove();for(var hb in ha)ha[hb].reset&&ha[hb].reset();ua();ga.unsubscribe();ga=null;ca=null;ea=null;ha={};ia={};la=null;na=false;oa=0;qa=false;if(pa){var ib=v('rightCol');if(ib){ib.style.paddingTop='';i.removeClass(ib,'timeline_fixed');}}pa=false;if(ra){t('blueBar').style.paddingTop='';i.removeClass(t('blueBar'),'timeline_fixed');}ra=false;ta=false;da=false;j.purge(o.DS_HEIGHT);j.purge(o.DS_LOADED);j.purge(o.DS_SIDEORG);j.purge(o.DS_TAILBALANCE);j.purge(o.DS_COLUMN_HEIGHT_DIFFERENTIAL);}var gb={NAV:'nav',STICKY_HEADER:'sticky_header',STICKY_HEADER_NAV:'sticky_header_nav',SCRUBBER:'scrubber',CONTENT:'content',ADS:'ads',LOGGING:'logging',init:function(hb,ib,jb){if(da)return;if(ib==q.WALL_KEY)ib=q.TIMELINE_KEY;da=true;ea=hb;fa=jb.has_fixed_ads;na=jb.one_column_minimal;sa={allactivity:true,approve:true};if(!na)u(sa,{games:true,map:true,music:true,video:true});sa[q.TIMELINE_KEY]=true;va(gb.CONTENT,'adjustContentPadding');ja.push(g.listen(window,'scroll',za),g.listen(window,'resize',cb));ga=h.subscribe(['sidebar/initialized','sidebar/show','sidebar/hide'],db);w(n.subscribe('TimelineCover/coverCollapsed',eb));l.onLeave(fb);gb.registerCurrentKey(ib);},setAdsTracking:function(hb){va(gb.ADS,'start',[hb]);},pageHasScrubber:function(hb){return !hb||(!na&&hb.match(/^(og_)?app_/))||(hb in sa);},fixedAds:function(){return fa;},registerCurrentKey:function(hb){ca=hb;la=hb!=='map'&&r.getViewportDimensions().y<aa&&gb.pageHasScrubber(hb);la=la||t('blueBar').offsetTop;va(gb.ADS,'setShortMode',[la]);va(gb.ADS,'updateCurrentKey',[hb]);oa=hb==q.TIMELINE_KEY?y-z:0;},getCurrentKey:function(){return ca;},getCurrentScrubber:function(){return ha[gb.SCRUBBER];},getCurrentStickyHeaderNav:function(){return ha[gb.STICKY_HEADER_NAV];},scrubberHasLoaded:function(hb){i.conditionClass(hb.getRoot(),'fixed_elem',!la);va(gb.ADS,'registerScrubber',[hb]);},scrubberHasChangedState:function(){va(gb.ADS,'adjustAdsToFit');},scrubberWasClicked:function(hb){va(gb.LOGGING,'logScrubberClick',[hb]);},stickyHeaderNavWasClicked:function(hb){va(gb.LOGGING,'logStickyHeaderNavClick',[hb]);},sectionHasChanged:function(hb,ib){va(gb.STICKY_HEADER_NAV,'updateSection',[hb,ib]);va(gb.SCRUBBER,'updateSection',[hb,ib]);va(gb.ADS,'loadAdsIfEnoughTimePassed');va(gb.LOGGING,'logSectionChange',[hb,ib]);},navigateToSection:function(hb){va(gb.CONTENT,'navigateToSection',[hb]);},shouldShowWideAds:function(){if(!ta){ma=false;}else{var hb=ba+s.getRight()+s.getLeft();ma=r.getViewportDimensions().x>=hb;}return ma;},sidebarInitialized:function(){return ta;},adjustStickyHeaderWidth:function(){va(gb.STICKY_HEADER,'adjustWidth');},isOneColumnMinimal:function(){return na;},hideStickyHeaderNavSectionMenu:function(){va(gb.STICKY_HEADER_NAV,'hideSectionMenu');},register:function(hb,ib){ha[hb]=ib;if(ia[hb]){for(var jb in ia[hb])va(hb,jb,ia[hb][jb]);delete ia[hb];}},adjustScrollingPagerBuffer:function(hb,ib){var jb=j.get(o.DS_COLUMN_HEIGHT_DIFFERENTIAL,ib);if(!jb)return;var kb=m.getInstance(hb);kb&&kb.setBuffer(kb.getBuffer()+Math.abs(jb));},runOnceWhenSectionFullyLoaded:function(hb,ib,jb){var kb=p.get(ib);if(kb){var lb=false;k.scry(kb.node,'.fbTimelineCapsule').forEach(function(nb){if(!lb&&parseInt(j.get(o.DS_LOADED,nb.id),10)>=parseInt(jb,10)){hb();lb=true;}});if(lb)return;}var mb=h.subscribe(o.SECTION_FULLY_LOADED,function(nb,ob){if(ob.scrubberKey===ib&&ob.pageIndex===jb){hb();mb.unsubscribe();}});}};e.exports=gb;});
__d("TimelineDrag",["ArbiterMixin","Event","Locale","Style","Vector","mixin"],function(a,b,c,d,e,f){var g=b('ArbiterMixin'),h=b('Event'),i=b('Locale'),j=b('Style'),k=b('Vector'),l=b('mixin'),m=l(g);for(var n in m)if(m.hasOwnProperty(n))p[n]=m[n];var o=m===null?null:m.prototype;p.prototype=Object.create(o);p.prototype.constructor=p;p.__superConstructor__=m;function p(q,r,s){"use strict";s=s||{};this._listenOn=s.listenOn;this._offsetInput=r;this._defaultOffset=s.default_offset;this._killClicks=s.killClicks;this._vertical=true;this._RTLXSwitch=false;this.setPicture(q,s);}p.prototype.setPicture=function(q,r){"use strict";if(!q)return false;r=r||{};this._picture=q;this._defaultOffset=r.default_offset;if(r.offsetInput)this._offsetInput=r.offsetInput;if(r.vertical!==undefined)this._vertical=r.vertical;if(r.height)this._containerHeight=r.height;if(r.width)this._containerWidth=r.width;if(this._vertical){this._offsetType='top';this._eventCoord='y';}else{this._RTLXSwitch=i.isRTL();this._offsetType='left';this._eventCoord='x';}if(this._picture.complete){this._initialLoad();}else this._loadListener=h.listen(this._picture,'load',function(){this._loadListener.remove();this._loadListener=null;this._initialLoad();}.bind(this));};p.prototype.destroy=function(){"use strict";this._stopDrag();this._saveOffset();this._mousedown&&this._mousedown.remove();this._mousedown=null;this._onclick&&this._onclick.remove();this._onclick=null;this._loadListener&&this._loadListener.remove();this._loadListener=null;};p.prototype._initialLoad=function(){"use strict";var q=this._listenOn?this._listenOn:this._picture;this._mousedown&&this._mousedown.remove();this._mousedown=h.listen(q,'mousedown',this._onMouseDown.bind(this));if(this._vertical){this._maxOffset=this._containerHeight-this._picture.offsetHeight;}else this._maxOffset=this._containerWidth-this._picture.offsetWidth;if(this._defaultOffset!==undefined)this._setOffset(this._defaultOffset);this._onclick&&this._onclick.remove();this._onclick=null;if(this._killClicks)this._onclick=h.listen(q,'click',this._onClick.bind(this));this._saveOffset();};p.prototype._onClick=function(event){"use strict";event.kill();};p.prototype._onMouseDown=function(event){"use strict";var q=parseInt(j.get(this._picture,this._offsetType),10)||0;this._pictureStartDragOffset=q-k.getEventPosition(event)[this._eventCoord];this._startDrag();event.kill();};p.prototype._startDrag=function(){"use strict";if(!this._dragStarted){this.inform('startdrag',this);this._dragTokens=[h.listen(document.documentElement,'mouseup',this._onMouseUp.bind(this)),h.listen(document.documentElement,'mousemove',this._onMouseMove.bind(this))];this._dragStarted=true;}};p.prototype._saveOffset=function(){"use strict";var q=parseInt(j.get(this._picture,this._offsetType),10);if(this._RTLXSwitch){this._offsetInput.value=q+this._containerWidth-this._picture.offsetWidth;}else this._offsetInput.value=q;};p.prototype._stopDrag=function(){"use strict";if(this._dragStarted){this.inform('stopdrag',this);this._dragStarted=false;this._dragTokens.forEach(function(q){q.remove();});this._saveOffset();}};p.prototype._onMouseUp=function(event){"use strict";this._stopDrag();event.kill();};p.prototype._setOffset=function(q){"use strict";if(this._RTLXSwitch){q=Math.max(0,Math.min(q,-this._maxOffset));}else q=Math.min(0,Math.max(q,this._maxOffset));j.set(this._picture,this._offsetType,q+'px');};p.prototype._onMouseMove=function(event){"use strict";this._setOffset(this._pictureStartDragOffset+k.getEventPosition(event)[this._eventCoord]);event.kill();};e.exports=p;});
__d("TimelineCover",["Arbiter","Button","CSS","DOM","DOMScroll","HTML","Parent","Style","TimelineController","TimelineDrag","Vector","$","cx","ge"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('Button'),i=b('CSS'),j=b('DOM'),k=b('DOMScroll'),l=b('HTML'),m=b('Parent'),n=b('Style'),o=b('TimelineController'),p=b('TimelineDrag'),q=b('Vector'),r=b('$'),s=b('cx'),t=b('ge');function u(v,w,x){"use strict";this.root=r('fbProfileCover');if(typeof w==='object'){this._coverHeight=w.cover_height;this._coverWidth=w.cover_width;this.previewing=w.previewing;this._isLegacy=false;}else{this._isLegacy=true;this._coverHeight=w;this.previewing=x;}this._parentSection=m.byClass(this.root,'fbTimelineSection');this.cover=j.find(this.root,'.cover');u.instance=this;this.editing=false;if(!this._parentSection)this._parentSection=m.byClass(this.root,'fbEventHeader');if(this.previewing){this.editMode();this.updateCoverImage(this.previewing);}}u.prototype.showLoadingIndicator=function(){"use strict";var v=t('fbCoverImageContainer');if(v)i.addClass(v,'opaquedLoading');};u.prototype.hideLoadingIndicator=function(){"use strict";var v=t('fbCoverImageContainer');if(v)i.removeClass(v,'opaquedLoading');};u.prototype.isCoverImageVerticalFlow=function(v){"use strict";return !(v.style.height);};u.prototype.editMode=function(){"use strict";h.setEnabled(j.find(this.root,'button.cancelButton'),true);h.setEnabled(j.find(this.root,'button.saveButton'),true);this.hideLoadingIndicator();this._coverImage=j.scry(this.root,'.coverImage')[0];var v=j.scry(this._coverImage,'.coverWrap')[0];if(v){var w=j.find(v,'.coverPhotoImg');this._originalIsVertical=this.isCoverImageVerticalFlow(w);this._originalOffset=n.get(w,this._originalIsVertical?'top':'left');}i.addClass(this._parentSection,'fbEditCover');k.scrollTo(this.root);if(this.previewing){j.remove(this._coverImage);i.show(this._coverImage);}var x=j.scry(this._coverImage,'.coverPhotoImg')[0];if(x)this._createDragger();this.editing=true;g.inform('CoverPhotoEdit',{sender:this,state:"open"});};u.prototype._exitEditMode=function(){"use strict";if(this._timelineDrag){this._timelineDrag.destroy();this._timelineDrag=null;}j.find(this.root,'input.hiddenPhotoID').value=null;j.find(this.root,'input.hiddenVideoID').value=null;h.setEnabled(j.find(this.root,'button.cancelButton'),false);h.setEnabled(j.find(this.root,'button.saveButton'),false);i.removeClass(this._parentSection,'fbEditCover');this.hideLoadingIndicator();this.previewing=false;g.inform('CoverPhotoEdit',{sender:this,state:"closed"});};u.prototype._createDragger=function(v){"use strict";var w;if(this._isLegacy){w=j.find(this.root,'input.photoOffsetInput');this._originalIsVertical=true;}else{var x=v===undefined?this._originalIsVertical:v;w=x?j.find(this.root,'input.photoOffsetYInput'):j.find(this.root,'input.photoOffsetXInput');}this._timelineDrag=new p(j.find(this.root,'.coverImage .coverPhotoImg'),w,{height:this._coverHeight,width:this._coverWidth,listenOn:this.cover,vertical:x,killClicks:true});};u.prototype.updateCoverImage=function(v,w,x){"use strict";this.videoID=x;if(w)this.editMode();j.find(this.root,'input.hiddenPhotoID').value=v;j.find(this.root,'input.hiddenVideoID').value=x||null;h.setEnabled(j.find(this.root,'button.saveButton'),true);if(w)j.replace(j.find(this.root,'.coverImage'),l(w));var y=j.find(j.find(this.root,'.coverImage'),'.coverPhotoImg'),z=this.isCoverImageVerticalFlow(y),aa;if(this._isLegacy){aa=j.find(this.root,'input.photoOffsetInput');}else aa=z?j.find(this.root,'input.photoOffsetYInput'):j.find(this.root,'input.photoOffsetXInput');if(this._timelineDrag){this._timelineDrag.setPicture(y,{offsetInput:aa,vertical:z});}else this._createDragger(z);};u.prototype.cancelUpdate=function(){"use strict";j.remove(j.scry(this.root,'.coverImage')[0]);j.prependContent(this.cover,this._coverImage);if(this._originalOffset!==undefined)n.set(j.find(this._coverImage,'.coverPhotoImg'),this._originalIsVertical?'top':'left',this._originalOffset);this._exitEditMode();};u.prototype.saveComplete=function(){"use strict";this._coverImage=j.scry(this.root,'.coverImage')[0];var v=m.byClass(this.root,'fbTimelineTopSectionBase');v&&i.removeClass(v,"_6_5");this._exitEditMode();};u.prototype.isInEditMode=function(){"use strict";return this.editing;};u.getInstance=function(){"use strict";return u.instance;};u.instance=null;e.exports=u;});
__d("TimelineCoverDisclaimer",["Dialog"],function(a,b,c,d,e,f){var g=b('Dialog');function h(i,j,k){if(h.displayed===undefined){h.displayed=true;}else return;new g().setModal(true).setTitle(i).setBody(j).setButtonsMessage(k).setButtons(g.OK).show();}e.exports=h;});
__d("legacy:TimelineCoverDisclaimer",["TimelineCoverDisclaimer"],function(a,b,c,d){a.TimelineCoverDisclaimer=b('TimelineCoverDisclaimer');},3);
__d("TimelineSection",["Arbiter","DOMScroll","DoublyLinkedListMap","Run","TidyArbiterMixin","copyProperties","ge"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('DOMScroll'),i=b('DoublyLinkedListMap'),j=b('Run'),k=b('TidyArbiterMixin'),l=b('copyProperties'),m=b('ge'),n=null;function o(){n=null;}function p(q,r,s){"use strict";this.id=q;this.label=s;this.nodeID=r;this._parentSection=null;this.childSections=new i();this._isLoaded=false;setTimeout(p.inform.bind(p,'sectionInitialized/'+q,{section:this},g.BEHAVIOR_STATE),0);}p.prototype.appendSection=function(q){"use strict";this.childSections.append(q.id,q);q._parentSection=this;};p.prototype.freeze=function(){"use strict";this.freezeChildren();};p.prototype.freezeChildren=function(){"use strict";var q=this.childSections.getHead();while(q){!q.isActive()&&q.freeze();q=q.getNext();}};p.prototype.getNext=function(){"use strict";return this._parentSection&&this._parentSection.childSections.getNext(this.id);};p.prototype.getPrev=function(){"use strict";return this._parentSection&&this._parentSection.childSections.getPrev(this.id);};p.prototype.isActive=function(){"use strict";var q=this;while(q){if(q.id===n)return true;q=q._parentSection;}return false;};p.prototype.isLoaded=function(){"use strict";return this._isLoaded;};p.prototype.setIsLoaded=function(q){"use strict";this._isLoaded=q;return this;};p.prototype.scrollTo=function(){"use strict";if(!m(this.nodeID))return;h.scrollTo(this.getNode(),true,false,false,h.scrollTo.bind(this).bind(null,this.getNode(),0));};p.prototype.thaw=function(){"use strict";this.thawChildren();};p.prototype.thawChildren=function(){"use strict";var q=this.childSections.getHead();while(q){q.thaw();q=q.getNext();}};p.prototype.getNode=function(){"use strict";throw new Error('This function needs to be implemented in children.');};p.callWithSection=function(q,r){"use strict";this.subscribe('sectionInitialized/'+q,function(s,t){r(t.section);});};p.setActiveSectionID=function(q){"use strict";!n&&j.onLeave(o);n=q;};l(p,k);e.exports=p;});
__d("TimelineNavLight",["CSS","DOM","DOMQuery","Parent","TimelineSection","csx","cx"],function(a,b,c,d,e,f){var g=b('CSS'),h=b('DOM'),i=b('DOMQuery'),j=b('Parent'),k=b('TimelineSection'),l=b('csx'),m=b('cx');function n(o){var p=i.scry(o,"._6-7")[0],q=i.scry(o,"._6-6"),r=j.byClass(o,"_70k").offsetWidth,s=q[q.length-1];if(s.offsetLeft+s.offsetWidth>r)g.addClass(o,"_5215");for(var t=q.length-1;t>1;t--)if(q[t].offsetLeft+q[t].offsetWidth>r){h.remove(q[t]);}else break;var u="_529n";g.removeClass(j.byClass(o,u),u);k.subscribe('Medley/transitionToSection',function(v,w){if(p&&w===p.getAttribute('data-medley-id'))return;p&&g.removeClass(p,"_6-7");for(var x=0;x<q.length;++x)if(q[x].getAttribute('data-medley-id')===w){g.addClass(q[x],"_6-7");p=q[x];return;}});}e.exports=n;});
__d("TimelineSmartInsert",["Run","UserAgent","Vector"],function(a,b,c,d,e,f){var g=b('Run'),h=b('UserAgent'),i=b('Vector'),j=100;function k(q){if(q==='viewport')return i.getViewportDimensions().y;return q;}var l=false,m=false;function n(){if(m)return;g.onLeave(o);m=true;}function o(){l=false;m=false;}var p={run:function(q,r,s){n();if(!l||h.ie()<=8){r();return;}var t=q.offsetHeight;r();var u=q.offsetHeight,v=i.getScrollPosition().y,w=i.getElementPosition(q).y;if(u!==t&&w<v&&w+t<v+k(s||j))window.scrollBy(0,u-t);},enable:function(){l=true;}};e.exports=p;});
__d("legacy:TimelineCover",["TimelineCover"],function(a,b,c,d){a.TimelineCover=b('TimelineCover');},3);
__d("legacy:ui-scrolling-pager-js",["ScrollingPager"],function(a,b,c,d){a.ScrollingPager=b('ScrollingPager');},3);
__d("PopoverLoadingMenu",["DOM","PopoverMenuInterface","copyProperties","cx","joinClasses"],function(a,b,c,d,e,f){var g=b('DOM'),h=b('PopoverMenuInterface'),i=b('copyProperties'),j=b('cx'),k=b('joinClasses');for(var l in h)if(h.hasOwnProperty(l))n[l]=h[l];var m=h===null?null:h.prototype;n.prototype=Object.create(m);n.prototype.constructor=n;n.__superConstructor__=h;function n(o){"use strict";h.call(this);this._config=o||{};this._theme=o.theme||{};}n.prototype.getRoot=function(){"use strict";if(!this._root)this._root=g.create('div',{className:k("_54nq",this._config.className,this._theme.className)},g.create('div',{className:"_54ng"},g.create('div',{className:"_54nf _54af"},g.create('span',{className:"_54ag"}))));return this._root;};i(n.prototype,{_root:null});e.exports=n;});
__d("ContextualLayerAsyncRelative",["Event","Parent","copyProperties"],function(a,b,c,d,e,f){var g=b('Event'),h=b('Parent'),i=b('copyProperties');function j(k){"use strict";this._layer=k;}j.prototype.enable=function(){"use strict";this._layerSubscription=this._layer.subscribe('show',this._attachListener.bind(this));if(this._layer.isShown())this._attachListener();};j.prototype.disable=function(){"use strict";this._layerSubscription.unsubscribe();this._layerSubscription=null;if(this._listener){this._listener.remove();this._listener=null;}};j.prototype._attachListener=function(){"use strict";this._listener=g.listen(this._layer.getRoot(),'click',this._onclick.bind(this));};j.prototype._onclick=function(k){"use strict";var l=h.byTag(k.getTarget(),'A');if(!l)return;var m=l.getAttribute('ajaxify'),n=l.href,o=m||n;if(l.rel==='async'||l.rel==='async-post'){d(['AsyncRequest'],function(p){p.bootstrap(o,this._layer.getContext(),l.rel==='async-post');}.bind(this));return false;}};i(j.prototype,{_layerSubscription:null,_listener:null});e.exports=j;});
__d("ButtonGroup",["CSS","DataStore","Parent","copyProperties","createArrayFrom"],function(a,b,c,d,e,f){var g=b('CSS'),h=b('DataStore'),i=b('Parent'),j=b('copyProperties'),k=b('createArrayFrom'),l='firstItem',m='lastItem';function n(s,t){var u=i.byClass(s,t);if(!u)throw new Error('invalid use case');return u;}function o(s){return g.shown(s)&&k(s.childNodes).some(g.shown);}function p(s){var t,u,v;k(s.childNodes).forEach(function(w){v=o(w);g.removeClass(w,l);g.removeClass(w,m);g.conditionShow(w,v);if(v){t=t||w;u=w;}});t&&g.addClass(t,l);u&&g.addClass(u,m);g.conditionShow(s,t);}function q(s,t){var u=n(t,'uiButtonGroupItem');s(u);p(u.parentNode);}function r(s){"use strict";this._root=n(s,'uiButtonGroup');h.set(this._root,'ButtonGroup',this);p(this._root);}r.getInstance=function(s){"use strict";var t=n(s,'uiButtonGroup'),u=h.get(t,'ButtonGroup');return u||new r(t);};j(r.prototype,{hideItem:q.bind(null,g.hide),showItem:q.bind(null,g.show),toggleItem:q.bind(null,g.toggle)});e.exports=r;});
__d("ButtonGroupMonitor",["ContextualDialog","ContextualLayer","CSS","Layer","Parent","SelectorDeprecated"],function(a,b,c,d,e,f){var g=b('ContextualDialog'),h=b('ContextualLayer'),i=b('CSS'),j=b('Layer'),k=b('Parent'),l=b('SelectorDeprecated');function m(n){var o=k.byClass(n,'bg_stat_elem')||k.byClass(n,'uiButtonGroup');o&&i.toggleClass(o,'uiButtonGroupActive');}j.subscribe(['hide','show'],function(n,o){if(o instanceof h||o instanceof g)m(o.getCausalElement());});l.subscribe(['close','open'],function(n,o){m(o.selector);});});
__d("SubMenu",["Arbiter","CSS","Event","copyProperties"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('CSS'),i=b('Event'),j=b('copyProperties');function k(){"use strict";}k.prototype.init=function(l,m,n,o){"use strict";this._subMenu=l;this._mainMenu=m;this._forward=n;this._backward=o;g.subscribe('SubMenu/Reset',this._goToMainMenu.bind(this));i.listen(n,'click',this._goToSubMenu.bind(this));i.listen(o,'click',this._goToMainMenu.bind(this));};k.prototype.initAsyncChildMenu=function(l){"use strict";i.listen(this._forward,'click',function(){this._goToSubMenu();l.load();}.bind(this));};k.prototype._goToMainMenu=function(){"use strict";h.hide(this._subMenu);h.show(this._mainMenu);};k.prototype._goToSubMenu=function(){"use strict";h.hide(this._mainMenu);h.show(this._subMenu);};j(k.prototype,{_subMenu:null,_mainMenu:null,_forward:null,_backward:null});e.exports=k;});
__d("legacy:ui-submenu",["SubMenu"],function(a,b,c,d){a.SubMenu=b('SubMenu');},3);
__d("AsyncMenu",["AsyncRequest","copyProperties","emptyFunction"],function(a,b,c,d,e,f){var g=b('AsyncRequest'),h=b('copyProperties'),i=b('emptyFunction');function j(k,l){"use strict";this._uri=k;this._elem=l;}j.prototype.load=function(){"use strict";this.load=i;g.bootstrap(this._uri,this._elem);};h(j.prototype,{_uri:null,_elem:null});e.exports=j;});