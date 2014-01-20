/*!CK:4150802804!*//*1387161326,178186541*/

if (self.CavalryLogger) { CavalryLogger.start_js(["kvpBa"]); }

__d("CommunityNotificationFilter",[],function(a,b,c,d,e,f){e.exports={ALL:0,COMMUNITY:1,NON_COMMUNITY:2};});
__d("NotificationConstants",[],function(a,b,c,d,e,f){e.exports={PayloadSourceType:{UNKNOWN:0,USER_ACTION:1,LIVE_SEND:2,ENDPOINT:3,INITIAL_LOAD:4,OTHER_APPLICATION:5}};});
__d("NotificationTokens",["CurrentUser"],function(a,b,c,d,e,f){var g=b('CurrentUser'),h={tokenizeIDs:function(i){return i.map(function(j){return g.getID()+':'+j;});},untokenizeIDs:function(i){return i.map(function(j){return j.split(':')[1];});}};e.exports=h;});
__d("NotificationUpdates",["Arbiter","ChannelConstants","JSLogger","NotificationConstants","NotificationTokens","LiveTimer","copyProperties","createObjectFrom"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('ChannelConstants'),i=b('JSLogger'),j=b('NotificationConstants'),k=b('NotificationTokens'),l=b('LiveTimer'),m=b('copyProperties'),n=b('createObjectFrom'),o={},p={},q={},r={},s=[],t=0,u=i.create('notification_updates');function v(){if(t)return;var z=o,aa=p,ba=q,ca=r;o={};p={};q={};r={};x('notifications-updated',z);if(Object.keys(aa).length)x('seen-state-updated',aa);if(Object.keys(ba).length)x('read-state-updated',ba);if(Object.keys(ca).length)x('hidden-state-updated',ca);s.pop();}function w(){if(s.length)return s[s.length-1];return j.PayloadSourceType.UNKNOWN;}function x(event,z){y.inform(event,{updates:z,source:w()});}g.subscribe(h.getArbiterType('notification_json'),function(z,aa){var ba=Date.now(),ca=aa.obj.nodes;if(ca){ca.forEach(function(da){da.receivedTime=ba;});u.debug('notifications_received',ca);y.handleUpdate(j.PayloadSourceType.LIVE_SEND,aa.obj);}});g.subscribe(h.getArbiterType('notifications_seen'),function(z,aa){var ba=k.tokenizeIDs(aa.obj.alert_ids);y.handleUpdate(j.PayloadSourceType.LIVE_SEND,{seenState:n(ba)});});g.subscribe(h.getArbiterType('notifications_read'),function(z,aa){var ba=k.tokenizeIDs(aa.obj.alert_ids);y.handleUpdate(j.PayloadSourceType.LIVE_SEND,{readState:n(ba)});});var y=m(new g(),{handleUpdate:function(z,aa){if(aa.servertime)l.restart(aa.servertime);if(Object.keys(aa).length)this.synchronizeInforms(function(){s.push(z);var ba=m({payloadsource:w()},aa);this.inform('update-notifications',ba);this.inform('update-seen',ba);this.inform('update-read',ba);this.inform('update-hidden',ba);}.bind(this));},didUpdateNotifications:function(z){m(o,n(z));v();},didUpdateSeenState:function(z){m(p,n(z));v();},didUpdateReadState:function(z){m(q,n(z));v();},didUpdateHiddenState:function(z){m(r,n(z));v();},synchronizeInforms:function(z){t++;try{z();}catch(aa){throw aa;}finally{t--;v();}}});e.exports=y;});
__d("NotificationSeenState",["NotificationConstants","NotificationUpdates","copyProperties","createObjectFrom","mergeObjects"],function(a,b,c,d,e,f){var g=b('NotificationConstants'),h=b('NotificationUpdates'),i=b('copyProperties'),j=b('createObjectFrom'),k=b('mergeObjects'),l={},m=1,n=2,o=0,p=m,q=m|n,r={UNSEEN_AND_UNREAD:o,SEEN_BUT_UNREAD:p,SEEN_AND_READ:q};function s(u){var v=[],w=[];Object.keys(u).forEach(function(x){var y=u[x],z=l[x];l[x]=y;if(z===undefined){v.push(x);w.push(x);return;}var aa=z^y;if(aa&m)v.push(x);if(aa&n)w.push(x);});v.length&&h.didUpdateSeenState(v);w.length&&h.didUpdateReadState(w);}h.subscribe('update-notifications',function(u,v){var w=v.nodes;if(!w||!w.length)return;var x=v.payloadsource,y=g.PayloadSourceType,z=x==y.ENDPOINT,aa={};v.nodes.forEach(function(ba){var ca=ba.alert_id;if(!z||l[ca]===undefined)aa[ca]=r[ba.seen_state];});s(aa);});h.subscribe('update-seen',function(u,v){if(!v.seenState)return;var w=[],x={};Object.keys(v.seenState).forEach(function(z){if(!v.seenState[z]){w.push(z);return;}var aa=l[z];if(aa!==undefined)x[z]=aa|m;});var y=k(j(w,o),x);s(y);});h.subscribe('update-read',function(u,v){if(!v.readState)return;var w=[],x={};Object.keys(v.readState).forEach(function(z){if(v.readState[z]){w.push(z);return;}var aa=l[z];if(aa!==undefined)x[z]=aa^n;});var y=k(j(w,q),x);s(y);});var t={isRead:function(u){var v=l[u];return v==q;},isUnseen:function(u){var v=l[u];return v==o;},getUnseenCount:function(){return t.getUnseenIDs().length;},getUnseenIDs:function(){return Object.keys(l).filter(function(u){return l[u]==o;});},getUnreadIDs:function(){return Object.keys(l).filter(function(u){return l[u]!=q;});}};e.exports=t;});
__d("NotificationStore",["CommunityNotificationFilter","KeyedCallbackManager","NotificationConstants","NotificationSeenState","NotificationUpdates","RangedCallbackManager","MercuryServerDispatcher","merge"],function(a,b,c,d,e,f){var g=b('CommunityNotificationFilter'),h=b('KeyedCallbackManager'),i=b('NotificationConstants'),j=b('NotificationSeenState'),k=b('NotificationUpdates'),l=b('RangedCallbackManager'),m=b('MercuryServerDispatcher'),n=b('merge'),o=new h(),p=new l(function(v){var w=o.getResource(v);return w;},function(v,w){if(!t)return w.creation_time-v.creation_time;var x=j.isUnseen(v.alert_id),y=j.isUnseen(w.alert_id),z=!j.isRead(v.alert_id),aa=!j.isRead(w.alert_id),ba=v.alert_id in r,ca=w.alert_id in r,da=w.creation_time>=v.creation_time,ea=!da;return ((Number(y)*8)+(Number(aa)*4)+(Number(ca)*2)+Number(da)-(Number(x)*8)-(Number(z)*4)-(Number(ba)*2)-Number(ea));}),q={},r={},s=null,t=false;k.subscribe('update-notifications',function(v,w){if(w.ranked_notifs)r=n(r,w.ranked_notifs);if(w.page_info)q[w.filter]=w.page_info;if(w.nodes===undefined)return;var x,y=[],z={},aa=w.nodes||[],ba;aa.forEach(function(ca){x=ca.alert_id;ba=o.getResource(x);if(!ba||ba.creation_time<ca.creation_time){y.push(x);z[x]=ca;}});o.addResourcesAndExecute(z);p.addResources(y);k.didUpdateNotifications(y);});m.registerEndpoints({'/ajax/notifications/client/get.php':{mode:m.IMMEDIATE,handler:function(v){k.handleUpdate(i.PayloadSourceType.ENDPOINT,v);}}});var u={setShouldRankNotifs:function(v){t=v;},getNotifications:function(v,w,x){var y=false,z=null;if(w!==g.ALL){var aa=w===g.COMMUNITY;y=true;z=function(ia){var ja=o.getResource(ia);return ja.isCommunity===aa;};}var ba=p.executeOrEnqueue(0,v,function(ia){var ja=o.executeOrEnqueue(ia,function(ka){x(ka);});},y,z),ca=p.getUnavailableResources(ba);if(ca.length){p.unsubscribe(ba);if(!u.canFetchMore(w)){o.executeOrEnqueue(p.getAllResources(),x);return;}var da=q[w],ea=(da&&da.end_cursor)||null,fa;if(ea){var ga=Math.max.apply(null,ca),ha=p.getCurrentArraySize({strict:y,skipOnStrictHandler:z});fa=ga-ha+1;}else fa=v;m.trySend('/ajax/notifications/client/get.php',{businessID:s,cursor:ea,length:fa,filter:w});}},filterNotification:function(v,w){if(!v){return false;}else if(w===g.COMMUNITY){return !!v.isCommunity;}else if(w===g.NON_COMMUNITY)return !v.isCommunity;return true;},getFilteredIDs:function(v,w){return v.filter(function(x){return w(o.getResource(x));});},getAll:function(v){u.getNotifications(u.getCount(null),g.ALL,v);},getCount:function(v){return p.getAllResources().filter(function(w){return !v||v(o.getResource(w));}).length;},canFetchMore:function(v){var w=q[v];return (!w||!w.hasOwnProperty('has_next_page')||w.has_next_page);},resortNotifs:function(){p.resortResources();},setBusinessID:function(v){s=v;}};e.exports=u;});
__d("NotificationInitialLoadController",["NotificationSeenState","NotificationStore","Arbiter","NotificationConstants","NotificationUpdates"],function(a,b,c,d,e,f){b('NotificationSeenState');b('NotificationStore');var g=b('Arbiter'),h=b('NotificationConstants'),i=b('NotificationUpdates');function j(k){i.handleUpdate(h.PayloadSourceType.INITIAL_LOAD,k);g.inform('jewel/count-updated',{jewel:k.isCommunity?'community-notifications':'notifications',count:k.nodes.length});}e.exports=j;});
__d("NotificationPhotoThumbnail",[],function(a,b,c,d,e,f){function g(i){if(!i.media||!i.style_list||!i.style_list.length)return null;switch(i.style_list[0]){case 'album':case 'application':case 'photo':case 'video':case 'video_autoplay':case 'video_inline':return i.media.image;default:return null;}}var h={getThumbnail:function(i,j,k){var l;if(i&&i.length){l=g(i[0]);if(l)return l;}if(k){var m=k.relevant_comments;if(m&&m.length){var n=m[0].attachments;if(n&&n.length){l=g(n[0]);if(l)return l;}}}if(j){var o=j.attachments;if(o&&o.length)return g(o[0]);}return null;}};e.exports=h;});
__d("NotificationURI",["URI"],function(a,b,c,d,e,f){var g=b('URI'),h={localize:function(i){i=g(i);if(!i.isFacebookURI())return i.toString();var j=i.getSubdomain();return i.getUnqualifiedURI().getQualifiedURI().setSubdomain(j).toString();},snowliftable:function(i){if(!i)return false;i=g(i);return i.isFacebookURI()&&i.getQueryData().hasOwnProperty('fbid');},isVaultSetURI:function(i){if(!i)return false;i=g(i);return i.isFacebookURI()&&i.getPath()=='/ajax/vault/sharer_preview.php';}};e.exports=h;});
__d("NotificationUserActions",["AsyncRequest","AsyncSignal","NotificationConstants","NotificationStore","NotificationTokens","NotificationUpdates","URI","createObjectFrom","emptyFunction","mergeInto"],function(a,b,c,d,e,f){var g=b('AsyncRequest'),h=b('AsyncSignal'),i=b('NotificationConstants'),j=b('NotificationStore'),k=b('NotificationTokens'),l=b('NotificationUpdates'),m=b('URI'),n=b('createObjectFrom'),o=b('emptyFunction'),p=b('mergeInto'),q=i.PayloadSourceType.USER_ACTION,r='mark_spam',s='turn_off',t='undo',u='original_subscription_level',v='first_receipt_yes',w='first_receipt_no';function x(ca){var da=m('/ajax/notifications/mark_read.php').getQualifiedURI().toString();new h(da,ca).send();}function y(ca){var da={};ca.forEach(function(ea,fa){da['alert_ids['+fa+']']=ea;});return da;}function z(ca,da,ea,fa,ga){var ha=k.untokenizeIDs([ca])[0],ia={notification_id:ha,client_rendered:true,request_type:da};p(ia,ea);new g('/ajax/notifications/negative_req.php').setData(ia).setHandler(fa||o).setErrorHandler(ga||o).send();}function aa(ca,da,ea,fa,ga){var ha=ga?t:s;j.getAll(function(ia){var ja=Object.keys(ia).filter(function(ka){var la=ia[ka];return !!(la.application&&la.application.id&&la.application.id==da);});z(ca,ha,null,function(ka){ea(ka);l.handleUpdate(q,{hiddenState:n(ja,!ga)});},fa);});}var ba={markNotificationsAsSeen:function(ca){l.handleUpdate(q,{seenState:n(ca)});var da=k.untokenizeIDs(ca),ea=y(da);ea.seen=true;x(ea);if(a.presenceNotifications)a.presenceNotifications.alertList.markSeen(da);},markNotificationsAsRead:function(ca){l.handleUpdate(q,{readState:n(ca)});var da=k.untokenizeIDs(ca);x(y(da));if(a.presenceNotifications)a.presenceNotifications.markRead(false,da);},markNotificationAsHidden:function(ca,da,ea){l.handleUpdate(q,{hiddenState:n([ca])});z(ca,s,null,da,ea);},markNotificationAsVisible:function(ca,da,ea,fa){l.handleUpdate(q,{hiddenState:n([ca],false)});var ga=null;if(da!==null){ga={};ga[u]=da;}z(ca,t,ga,ea,fa);},markNotificationAsSpam:function(ca,da,ea){l.handleUpdate(q,{hiddenState:n([ca],false)});z(ca,r,null,da,ea);},markAppAsHidden:function(ca,da,ea,fa){var ga=false;aa(ca,da,ea,fa,ga);},markAppAsVisible:function(ca,da,ea,fa){var ga=true;aa(ca,da,ea,fa,ga);},markFirstReceiptYes:function(ca,da,ea){z(ca,v,null,da,ea);},markFirstReceiptNo:function(ca,da,ea){z(ca,w,null,da,ea);}};e.exports=ba;});
__d("FriendsCenterStickyController",["StickyController"],function(a,b,c,d,e,f){var g=b('StickyController');for(var h in g)if(g.hasOwnProperty(h))j[h]=g[h];var i=g===null?null:g.prototype;j.prototype=Object.create(i);j.prototype.constructor=j;j.__superConstructor__=g;function j(k,l,m,n){"use strict";g.call(this,k,l,m,n);this.$FriendsCenterStickyController0=l;this.$FriendsCenterStickyController1=n||k.parentNode;var o=k.getBoundingClientRect();this.$FriendsCenterStickyController2=o.bottom-o.top;this.$FriendsCenterStickyController3=true;}j.prototype.unstick=function(){"use strict";this.$FriendsCenterStickyController3=false;this.handleScroll();};j.prototype.restick=function(){"use strict";this.$FriendsCenterStickyController3=true;this.handleScroll();};j.prototype.shouldFix=function(){"use strict";if(!this.$FriendsCenterStickyController3)return false;var k=this.$FriendsCenterStickyController1.getBoundingClientRect();return this.$FriendsCenterStickyController0>=k.top&&this.$FriendsCenterStickyController0+this.$FriendsCenterStickyController2<k.bottom;};e.exports=j;});
__d("FriendsCenterStickyHeader",["CSS","DOM","FriendsCenterStickyController","Style","Vector","ge","cx"],function(a,b,c,d,e,f){var g=b('CSS'),h=b('DOM'),i=b('FriendsCenterStickyController'),j=b('Style'),k=b('Vector'),l=b('ge'),m=b('cx'),n=[];function o(p){"use strict";var q=l('blueBar');if(!q)return;var r=j.isFixed(q)?k.getElementDimensions(q).y:0,s=this.getPlaceholder(p.getBoundingClientRect());h.insertAfter(p,s);g.addClass(p,"_5m65");var t=new i(p,r,function(u){g.conditionShow(s,u);g.conditionClass(p,'stuck',u);}.bind(this));t.start();n[p.id]=t;}o.prototype.getPlaceholder=function(p){"use strict";var q=h.create('div');g.hide(q);j.set(q,'height',(p.bottom-p.top)+'px');j.set(q,'width',(p.right-p.left)+'px');return q;};o.stopSticky=function(p){"use strict";p&&(p.id in n)&&n[p.id].unstick();};o.startSticky=function(p){"use strict";p&&(p.id in n)&&n[p.id].restick();};e.exports=o;});
__d("FriendBrowserCheckboxController",["AsyncRequest","CSS","DOM","Event","Form","FriendsCenterStickyHeader","OnVisible","$","bind","copyProperties","csx","ge"],function(a,b,c,d,e,f){var g=b('AsyncRequest'),h=b('CSS'),i=b('DOM'),j=b('Event'),k=b('Form'),l=b('FriendsCenterStickyHeader'),m=b('OnVisible'),n=b('$'),o=b('bind'),p=b('copyProperties'),q=b('csx'),r=b('ge');function s(){}p(s,{instances:{},getInstance:function(t){return this.instances[t];}});p(s.prototype,{init:function(t,u,v,w){s.instances[t]=this;this._id=t;this._simplified=v;this._infiniteScroll=w;this._form=u;this._contentGrid=i.find(u,'.friendBrowserCheckboxContentGrid');this._loadingIndicator=i.find(u,'.friendBrowsingCheckboxContentLoadingIndicator');this._checkboxResults=i.find(u,'.friendBrowserCheckboxResults');this._contentPager=i.find(u,'.friendBrowserCheckboxContentPager');this._standaloneFilters=null;this._searchStarted=false;this._stickyHeader=null;this.numGetNewRequests=0;this.queuedRequests={};j.listen(this._form,'submit',this.onFormSubmit.bind(this));},addTypeahead:function(t,u){t.subscribe('select',this.onHubSelect.bind(this,t,u));if(this._simplified)t.subscribe('unselect',this.onHubSelect.bind(this,t,u));},setStandaloneFilters:function(t){if(t){this._standaloneFilters=i.scry(document.body,'.friendBrowserCheckboxFilters')[0];this._stickyHeader=i.scry(n('fbSearchResultsBox'),"._5m65")[0];var u=n('doneSearchButton');u.onclick=function(){this._searchStarted=false;i.scry(document.body,"._5n-u").forEach(function(v){h.show(v);});h.hide(u);h.removeClass(n('searchFilterBox'),'fixed_elem');window.scrollTo(0,0);l.startSticky(this._stickyHeader);}.bind(this);}return this;},onFormSubmit:function(){this.getNew(true);return false;},addSelector:function(t){t.subscribe('change',this.getNew.bind(this,false));},onHubSelect:function(t,u,event,v){if(this._simplified){this.getNew(true);return;}if(!((event=='select')&&v.selected))return;var w=this.buildNewCheckbox(u,v.selected.text,v.selected.uid),x=i.find(this._standaloneFilters||this._form,'.checkboxes_'+u);i.appendContent(x.firstChild,w);var y=i.scry(t.getElement(),'input[type="button"]');if(y&&y[0])y[0].click();this.getNew(true);},buildNewCheckbox:function(t,u,v){var w=t+'_ids_'+v,x=t+'_ids[]',y=i.create('input',{id:w,type:'checkbox',value:v,name:x,checked:true});j.listen(y,'click',o(this,'getNew',false));var z=i.create('td',null,y);h.addClass(z,'vTop');h.addClass(z,'hLeft');var aa=i.create('label',null,u),ba=i.create('td',null,aa);h.addClass(ba,'vMid');h.addClass(ba,'hLeft');var ca=i.create('tr');ca.appendChild(z);ca.appendChild(ba);return ca;},showMore:function(){var t=i.scry(this._contentPager,'.friendBrowserMorePager')[0];if(!t)return false;if(h.hasClass(t,'async_saving'))return false;var u=this.numGetNewRequests,v=this.getFormData();v.show_more=true;var w=new g().setURI('/ajax/growth/friend_browser/checkbox.php').setData(v).setHandler(o(this,function(x){this.showMoreHandler(x,u);})).setStatusElement(t).send();},showMoreHandler:function(t,u){if(u==this.numGetNewRequests){var v=t.payload;i.appendContent(this._contentGrid,v.results);this.updatePagerAndExtraData(v.pager,v.extra_data);}},getFormData:function(){var t=k.serialize(this._form);if(this._standaloneFilters){var u=k.serialize(this._standaloneFilters);for(var v in u)t[v]=u[v];}return t;},getNew:function(t){this.numGetNewRequests++;var u=this.numGetNewRequests;h.addClass(this._checkboxResults,'friendBrowserCheckboxContentOnload');if(r('friendBrowserCI'))h.addClass(n('friendBrowserCI'),'friendBrowserCheckboxContentOnload');this.startStandaloneSearch();h.show(this._loadingIndicator);var v=this.getFormData();v.used_typeahead=t;new g().setURI('/ajax/growth/friend_browser/checkbox.php').setData(v).setHandler(o(this,function(w){this.getNewHandler(w,u);})).send();},getNewHandler:function(t,u){if(u==this.numGetNewRequests){var v=t.payload;i.setContent(this._contentGrid,v.results);h.removeClass(this._checkboxResults,'friendBrowserCheckboxContentOnload');if(r('friendBrowserCI'))h.hide(n('friendBrowserCI'));h.hide(this._loadingIndicator);this.updatePagerAndExtraData(v.pager,v.extra_data);}},startStandaloneSearch:function(){if(!this._standaloneFilters)return;window.scrollTo(0,0);if(this._searchStarted)return;this._searchStarted=true;h.show(n('fbSearchResultsBox'));i.scry(document.body,"._5n-u").forEach(function(t){h.hide(t);});h.show(n('doneSearchButton'));h.addClass(n('searchFilterBox'),'fixed_elem');l.stopSticky(this._stickyHeader);},updatePagerAndExtraData:function(t,u){i.setContent(this._contentPager,t);if(this._infiniteScroll)this.setupOnVisible();i.replace(this._form.elements.extra_data,u);},setupOnVisible:function(){var t=i.scry(this._contentPager,'.friendBrowserMorePager')[0];if(t&&this._id!='jewel'){this._onVisible&&this._onVisible.remove();this._onVisible=new m(t,o(this,'showMore'),false,1000);}}});e.exports=s;});
__d("legacy:friend-browser-checkbox-js",["FriendBrowserCheckboxController"],function(a,b,c,d){a.FriendBrowserCheckboxController=b('FriendBrowserCheckboxController');},3);
__d("ModalMask",["DOM"],function(a,b,c,d,e,f){var g=b('DOM'),h=null,i=0,j={show:function(){i++;if(!h){h=g.create('div',{id:'modalMaskOverlay'});g.appendContent(document.body,h);}},hide:function(){if(i){i--;if(!i&&h){g.remove(h);h=null;}}}};e.exports=j;});
__d("MessagingEvents",["Arbiter","ChannelConstants","arrayContains","copyProperties","isEmpty"],function(a,b,c,d,e,f){var g=b('Arbiter'),h=b('ChannelConstants'),i=b('arrayContains'),j=b('copyProperties'),k=b('isEmpty'),l={},m=new g();function n(o){if(!k(l))return;for(var p in o)m.inform('count/'+p,o[p]);}m.subscribe('mark-as-read',function(o,p){(p.tids||p.chat_ids||[]).forEach(function(q){q=''+q;if(!(q in l)){l[q]=true;var r=function(){m.unsubscribe(s);clearTimeout(t);delete l[q];},s=m.subscribe('read',function(u,v){if(i((v.tids||[]),q)||i((v.chat_ids||[]),q))r();}),t=setTimeout(r,60000);}});});g.subscribe(h.getArbiterType('messaging'),function(o,p){var q=j({},p.obj),event=q.event||'';delete q.type;delete q.event;m.inform(event,q);if('unread_counts' in q){var r=q.unread_counts;n({unread:r.inbox,other_unseen:r.other});}});g.subscribe(h.getArbiterType('inbox'),function(o,p){var q=j(p.obj);delete q.type;n(q);});a.MessagingEvents=e.exports=m;},3);
__d("AccessibleMenu",["Event","CSS","DOM","Keys","TabbableElements","Toggler"],function(a,b,c,d,e,f){var g=b('Event'),h=b('CSS'),i=b('DOM'),j=b('Keys'),k=b('TabbableElements'),l=b('Toggler'),m,n,o;function p(){var x=i.scry(m,'a[rel="toggle"]')[0];x&&x.focus();l.getInstance(m).hide();}function q(x){if(!x)return false;h.removeClass(x,'selected');x.setAttribute('aria-selected','false');}function r(x){if(!x)return false;h.addClass(x,'selected');x.setAttribute('aria-selected','true');var y=k.find(x);if(y[0])y[0].focus();}function s(x){var y=i.scry(m,'.selected')[0],z=n.indexOf(y)+x,aa=n[z];if(!aa)return false;q(y);r(aa);}function t(x){if(!l.isShown()||l.getActive()!==m)return true;var y=g.getKeyCode(x);switch(y){case j.TAB:s(x.shiftKey?-1:1);g.prevent(x);break;case j.ESC:p();g.prevent(x);break;case j.UP:case j.DOWN:s(y===j.UP?-1:1);g.prevent(x);break;}}function u(x,y){m=y.getActive();n=i.scry(m,'[role="menuitem"]');if(!o)o=g.listen(document.documentElement,'keydown',t);}function v(){if(l.getActive()==m)q(i.scry(m,'.selected')[0]);}var w={init:function(x){l.listen('show',x,u);l.listen('hide',x,v);}};e.exports=w;});
__d("MusicButtonStore",[],function(a,b,c,d,e,f){var g={},h={addButton:function(i,j){g[i]=j;return j;},getButton:function(i){return g[i];},getButtons:function(){return g;},removeButton:function(i){g[i]&&g[i].resetLoadingTimers();delete g[i];}};e.exports=h;});
__d("MusicConstants",["URI"],function(a,b,c,d,e,f){var g=b('URI'),h={DEBUG:false,CONFIG:{PARTNER_TIMEOUT:8000},LIVE_LISTEN_MIN_SPOTIFY_VERSION:'spotify-0.6.6.0.g5a9eaca5',enableDebug:function(){this.DEBUG=true;},sameURLs:function(i,j){var k=/\/$/;if(i&&j){i=g(i);j=g(j);return i.getDomain()==j.getDomain()&&i.getPath()==j.getPath();}return false;},greaterOrEqualToMinimumVersion:function(i,j){var k=/(?:\d+\.)+/,l=i.match(k)[0].split('.').slice(0,-1),m=j.match(k)[0].split('.').slice(0,-1);if(l.length!==m.length)return false;for(var n=0;n<m.length;n++)if(+l[n]<+m[n]){return false;}else if(+l[n]>+m[n])return true;return true;},sanitizeForProviders:function(i){var j={};for(var k in i)if(this.ALLOWED_EXTERNAL_CONTEXT_PARAMS[k])j[k]=i[k];return j;},OP:{RESUME:'RESUME',PAUSE:'PAUSE',PLAY:'PLAY',VERSION:'VERSION'},STATUS_CHANGE_OP:{STATUS:'STATUS',LOGIN:'LOGIN',REINFORM:'REINFORM'},STATUS_CHANGE_EVENT:{playing:'PLAY_STATE_CHANGED',track:'TRACK_CHANGED'},DIAGNOSTIC_EVENT:{ALL_PAUSED:'ALL_PAUSED',ALL_OFFLINE:'ALL_OFFLINE',OFFLINE:'OFFLINE',ONLINE:'ONLINE',SEARCHING:'SEARCHING',HIT:'HIT',MISS:'MISS',RESIGN:'RESIGN',IFRAME_POLLING:'IFRAME_POLLING',RELAUNCH:'RELAUNCH',STATE_CHANGE:'STATE_CHANGE',WRONG_VERSION:'WRONG_VERSION',SERVICE_ERROR:'SERVICE_ERROR',INCORRECT_ONLINE_STATE:'INCORRECT_ONLINE_STATE',LOG_SEND_OP:'LOG_SEND_OP',REQUEUE_OP:'REQUEUE_OP'},ALLOWED_STATUS_PARAMS:{playing:'playing',track:'track',context:'context',client_version:'client_version',start_time:'start_time',expires_in:'expires_in',open_graph_state:'open_graph_state'},ALLOWED_EXTERNAL_CONTEXT_PARAMS:{uri:true,song:true,radio_station:true,album:true,playlist:true,musician:true,song_list:true,offset:true,title:true,request_id:true,listen_with_friends:true,needs_tos:true},LIVE_LISTEN_OP:{NOW_LEADING:'NOW_LEADING',NOW_LISTENING:'NOW_LISTENING',END_SESSION:'END_SESSION',SONG_PLAYING:'SONG_PLAYING',LISTENER_UPDATE:'LISTENER_UPDATE',QUEUE_SESSION:'QUEUE_SESSION',PLAY_ERROR:'PLAY_ERROR',SESSION_UPDATED:'SESSION_UPDATED',QUEUING_SESSION:'QUEUING_SESSION'},MUSIC_BUTTON:{ACTIVATE:'ACTIVATE'},ERROR:{1:'SERVICE_UNAVAILABLE_WITHOUT_PREMIUM',2:'SERVICE_UNAVAILABLE_WITHOUT_PREMIUM_OR_WAIT',3:'SERVICE_UNAVAILABLE_BILLING_ISSUE',4:'SERVICE_UNAVAILABLE_TECHNICAL_ISSUE',5:'AUDIO_AD_PLAYING',99:'SERVICE_TEMPORARILY_UNAVAILABLE',101:'SONG_UNAVAILABLE_WITHOUT_PURCHASE',102:'SONG_UNAVAILABLE_WITHOUT_PREMIUM',103:'SONG_UNAVAILABLE_INDEFINITELY'}};e.exports=a.MusicConstants||h;});
__d("MusicEvents",["Arbiter"],function(a,b,c,d,e,f){var g=b('Arbiter');e.exports=a.MusicEvents=new g();});
__d("MusicButton",["BanzaiODS","Bootloader","copyProperties","CSS","DOM","MusicButtonStore","MusicConstants","MusicEvents","Parent","ScubaSample","Tooltip","cx","setTimeoutAcrossTransitions"],function(a,b,c,d,e,f){var g=b('BanzaiODS'),h=b('Bootloader'),i=b('copyProperties'),j=b('CSS'),k=b('DOM'),l=b('MusicButtonStore'),m=b('MusicConstants'),n=b('MusicEvents'),o=b('Parent'),p=b('ScubaSample'),q=b('Tooltip'),r=b('cx'),s=b('setTimeoutAcrossTransitions'),t=function(u,v,w,x,y,z){this.provider=u;this.buttonElem=v;this.url=w;this.context=x||{};this.mediaType=y;this.setState(this.STATES.OFFLINE);this.tooltip=z||'';n.subscribe(m.MUSIC_BUTTON.ACTIVATE,this.processClick.bind(this));};i(t,{tracksetableTypes:[]});i(t.prototype,{SHOW_LOADING_TIMEOUT:500,HIDE_LOADING_TIMEOUT:m.CONFIG.PARTNER_TIMEOUT,RECENTLY_ONLINE_TIMEOUT:6000,STATES:{PLAYING:'music_playing',PAUSED:'music_paused',LOADING:'music_loading',DISABLED:'music_disabled',OFFLINE:'music_offline'},setState:function(u){if(u!==this.STATES.LOADING){this.resetLoadingTimers();this.previousState=this.state||u;}if(u===this.STATES.PLAYING){q.set(this.buttonElem,this.tooltip);}else q.set(this.buttonElem,'');var v=this.buttonElem.parentNode;this.state&&j.removeClass(v,this.state);this.state=u;j.addClass(v,this.state);},isTracksetable:function(u){return t.tracksetableTypes.indexOf(this.mediaType)!==-1;},handleIncomingEvent:function(u,v){clearTimeout(this._showLoadingTimer);if(v&&v.provider&&v.provider!=this.provider)return;switch(u){case m.DIAGNOSTIC_EVENT.ONLINE:case m.STATUS_CHANGE_EVENT.track:case m.STATUS_CHANGE_EVENT.playing:var w=v&&v.track&&v.track.uri,x=v&&v.context&&v.context.uri;if(v&&v.playing&&(m.sameURLs(w,this.url)||m.sameURLs(x,this.url))){this.setState(this.STATES.PLAYING);}else if(this.state===this.STATES.LOADING&&(this.previousState===this.STATES.PAUSED||this.previousState===this.STATES.OFFLINE)){clearTimeout(this._attemptingPlayTimer);this._attemptingPlayTimer=s(this.setState.bind(this,this.STATES.PAUSED),this.RECENTLY_ONLINE_TIMEOUT);}else if(!this._attemptingPlayTimer)this.setState(this.STATES.PAUSED);break;case m.DIAGNOSTIC_EVENT.OFFLINE:this.setState(this.STATES.OFFLINE);break;case m.DIAGNOSTIC_EVENT.ALL_OFFLINE:this.setState(this.STATES.OFFLINE);break;}},processClick:function(u,v){if(v!=this.buttonElem){if(this.state===this.STATES.LOADING)this.previousState&&this.setState(this.previousState);return;}var w=new p('music_play_button_click',null,{addBrowserFields:true,addGeoFields:true,addUser:true});w.addNormal('uses_bridge','1');w.addNormal('state',this.state);w.addNormal('provider',this.provider);w.addNormal('class','MusicButton');w.addNormal('insights_source',this.context.appear_source_log_str);w.addDenorm('url',this.url);w.flush();if(this.state!=this.STATES.PLAYING){g.bumpEntityKey('music_play_button','music_play_button_click');g.bumpEntityKey('music_play_button','music_play_button_click.'+this.provider);var x=o.byClass(this.buttonElem,"_4--s");if(x){j.addClass(x,"_4--t");setTimeout(j.removeClass.bind(null,x,"_4--t"),3000);}}var y=this.isTracksetable()&&o.byClass(this.buttonElem,'music_trackset_container'),z=[];if(y){var aa=y.getAttribute('data-trackset-title'),ba=this.provider,ca=k.scry(y,'.music_button');for(var da=0;da<ca.length;da++){var ea=l.getButton([ca[da].id]);if(ea&&ea.provider==ba&&ea.isTracksetable())z.push(ea.url);}}if(!a.Music)this.showLoading(true);h.loadModules(['Music'],function(fa){var ga=(y&&z.length>1)?fa.playPauseSongList(this.provider,this.url,z,aa,this.context):fa.playPauseSong(this.provider,this.url,this.context);this.showLoading(!ga);}.bind(this));},showLoading:function(u){this.resetLoadingTimers();this._hideLoadingTimer=s(this._timeout.bind(this,u),this.HIDE_LOADING_TIMEOUT);this._showLoadingTimer=s(this.setState.bind(this,this.STATES.LOADING),this.SHOW_LOADING_TIMEOUT);},resetLoadingTimers:function(){clearTimeout(this._hideLoadingTimer);clearTimeout(this._showLoadingTimer);clearTimeout(this._attemptingPlayTimer);this._attemptingPlayTimer=null;},destroy:function(){this.resetLoadingTimers();this.buttonElem=null;},_timeout:function(u){a.Music&&a.Music.reInform([this.provider]);if(!u&&this.state===this.STATES.LOADING)this.setState(this.STATES.PAUSED);}});e.exports=t;});
__d("MusicButtonManager",["Event","DOM","KeyedCallbackManager","Layer","MusicButton","MusicButtonStore","MusicConstants","MusicEvents","Parent","$","copyProperties","ge"],function(a,b,c,d,e,f){var g=b('Event'),h=b('DOM'),i=b('KeyedCallbackManager'),j=b('Layer'),k=b('MusicButton'),l=b('MusicButtonStore'),m=b('MusicConstants'),n=b('MusicEvents'),o=b('Parent'),p=b('$'),q=b('copyProperties'),r=b('ge'),s=new i(),t=null,u={},v=0;function w(da){var ea=da.getTarget(),fa=o.byClass(ea,'music_button');fa=fa||(!(da.getModifiers&&da.getModifiers().any)&&x(ea));if(!fa)return;return y(fa,da);}function x(da){var ea=o.byClass(da,'music_button_trigger')&&o.byClass(da,'music_button_trigger_group');if(ea){var fa=h.scry(ea,'.music_button');if(fa.length)return fa[0];}return null;}function y(da,event){event&&event.stop();n.inform(m.MUSIC_BUTTON.ACTIVATE,da);return false;}function z(da){a.Music&&a.Music.reInform(da);}function aa(da,ea){var fa=l.getButtons();for(var ga in fa)if(fa[ga].noGC||r(ga)){fa[ga].handleIncomingEvent(da,ea);}else l.removeButton(ga);}var ba={init:function(da){if(t)return;t=true;k.tracksetableTypes=da||[];g.listen(document.body,'click',w);n.subscribe([m.STATUS_CHANGE_EVENT.playing,m.STATUS_CHANGE_EVENT.track,m.DIAGNOSTIC_EVENT.OFFLINE,m.DIAGNOSTIC_EVENT.ALL_OFFLINE,m.DIAGNOSTIC_EVENT.ONLINE],aa);},add:function(da,ea,fa,ga,ha,ia){t||ba.init();var ja=ea.id,ka=l.getButton(ja);if(ka)return ka;ka=l.addButton(ja,new k(da,ea,fa,q({button_id:ja},ga),ha,ia));var la=o.byClass(ea,'uiOverlay');if(la){ka.noGC=true;var ma=j.subscribe('destroy',function(na,oa){if(h.contains(oa.getRoot(),ea)){l.removeButton(ja);j.unsubscribe(ma);}});}if(da&&!u[da])u[da]=setTimeout(function(){var na=Object.keys(u);na.length&&z(na);u={};},0);return ka;},addButton:function(da,ea,fa,ga,ha,ia){if(!r(ea))return;var ja=p(ea);return ba.add(da,ja,fa,ga,ha,ia);},asyncAddMusicButton:function(da,ea){da.setAttribute('id','music_button_'+v++);ca(da,ea);},tryAddButtonInDOM:function(da,ea){var fa=r(da);fa&&ca(fa,ea);},addMusicData:function(da,ea,fa,ga,ha,ia){s.setResource(da,{provider:ea,uri:fa,context:ga,media_type:ha,tooltip:ia});}};function ca(da,ea){var fa=h.find(da,'a.button_anchor').getAttribute('href');s.executeOrEnqueue(fa,function(ga){return ba.add(ga.provider,da,ga.uri,ga.context,ga.media_type,ea?ga.tooltip:'');});}e.exports=a.MusicButtonManager||ba;});
__d("legacy:onvisible",["OnVisible"],function(a,b,c,d){a.OnVisible=b('OnVisible');},3);
__d("PagesVoiceBar",["$","Arbiter","AsyncRequest","CSS","ChannelConstants","DOM","PageTransitions"],function(a,b,c,d,e,f){var g=b('$'),h=b('Arbiter'),i=b('AsyncRequest'),j=b('CSS'),k=b('ChannelConstants'),l=b('DOM'),m=b('PageTransitions'),n='PagesVoiceBar/initialized',o='PagesVoiceBar/switchVoice',p='page_transition',q='pages_voice_bar_sync',r=null,s=null,t=false;function u(aa,ba){new i('/ajax/pages/switch_voice.php').setData(ba).setHandler(function(ca){y();}).send();}function v(){r=null;}function w(aa,ba){if(ba.obj.profile_id&&ba.obj.profile_id==r)y();}function x(aa){h.subscribe(n,aa);}function y(){m.getNextURI().go();}var z={initVoiceBar:function(){if(t)return;s=g('pagesVoiceBarContent');h.subscribe(o,u);h.subscribe(p,v);h.subscribe(k.getArbiterType(q),w);t=true;h.inform(n,null,h.BEHAVIOR_STATE);},update:function(aa,ba){x(function(){r=ba;l.setContent(s,aa);});}};e.exports=z;});
__d("ViewasChromeBar",["Event","Arbiter","AsyncRequest","CSS","DOM","Focus","ModalMask","PageTransitions","Parent","cx","csx"],function(a,b,c,d,e,f){var g=b('Event'),h=b('Arbiter'),i=b('AsyncRequest'),j=b('CSS'),k=b('DOM'),l=b('Focus'),m=b('ModalMask'),n=b('PageTransitions'),o=b('Parent'),p=b('cx'),q=b('csx'),r='ViewasChromeBar/initialized',s=null,t=false;function u(x){h.subscribe(r,x);}function v(x){j.addClass(x,"_7g7");var y=k.find(x,"._7g0");l.set(k.find(y,'.textInput'));}var w={initChromeBar:function(x){if(t)return;s=x;t=true;h.inform(r,null,h.BEHAVIOR_STATE);},update:function(x,y){u(function(){k.setContent(s,x);if(y)new i('/ajax/privacy/glasgow/viewas_bar_flyout_open').send();});},registerSpecificModeOnClick:function(x){g.listen(x,'click',v.bind(null,o.byClass(x,"_7f-")));},registerFlyoutModalMask:function(){m.show();n.registerHandler(m.hide,10);}};e.exports=w;});
__d("TypeaheadRegulateMemorializedUsers",["TokenizeUtil","copyProperties"],function(a,b,c,d,e,f){var g=b('TokenizeUtil'),h=b('copyProperties');function i(j){"use strict";this._typeahead=j;}i.prototype._filter=function(j,k){"use strict";if(j.type!=='user'||!j.memorialized)return true;var l=g.parse(j.text).tokens;if(l.length===1&&g.isExactMatch(k,j.text))return true;var m=this._typeahead.getData().getTextToIndex(j),n=g.parse(k).tokens;return (n.length>1&&g.isQueryMatch(k,m));};i.prototype.enable=function(){"use strict";this._filterRegistry=this._typeahead.getData().addFilter(this._filter.bind(this));};i.prototype.disable=function(){"use strict";this._filterRegistry.remove();this._filterRegistry=null;};h(i.prototype,{_filterRegistry:null});e.exports=i;});
__d("legacy:RegulateMemorializedUsersTypeaheadBehavior",["TypeaheadRegulateMemorializedUsers"],function(a,b,c,d){var e=b('TypeaheadRegulateMemorializedUsers');if(!a.TypeaheadBehaviors)a.TypeaheadBehaviors={};a.TypeaheadBehaviors.regulateMemorializedUsers=function(f){f.enableBehavior(e);};},3);