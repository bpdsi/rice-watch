/*!CK:1313004879!*//*1387162045,178191153*/

if (self.CavalryLogger) { CavalryLogger.start_js(["sh2NU"]); }

__d("ContainerDimensionsUtils",["Event","Style","Vector","EagleEye","DOM"],function(a,b,c,d,e,f){var g=b('Event'),h=b('Style'),i=b('Vector'),j=b('EagleEye'),k=b('DOM');f.onDimensionsReady=function(l,m){var n=k.scry(l,'img.img'),o=n.length;if(o){var p=function(){--o;if(!o)setTimeout(m,0);};n.forEach(function(q){if(q.complete){p();}else g.listen(q,{load:p,error:p,abort:p});});}else setTimeout(m,0);};f.log=function(l,m,n,o){var p=l.parentNode;if(p)f.onDimensionsReady(p,function(){var q=i.getElementDimensions(p),r=i.getElementPosition(p),s=parseInt(h.get(p,'marginBottom'),10);j.log(m,[o,q.x,q.y+s,r.x,r.y,n]);});};});
__d("legacy:ua",["UserAgent"],function(a,b,c,d){a.ua=b('UserAgent');},3);