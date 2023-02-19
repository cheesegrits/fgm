(()=>{"use strict";var t={63:t=>{t.exports=function t(e,r){if(e===r)return!0;if(e&&r&&"object"==typeof e&&"object"==typeof r){if(e.constructor!==r.constructor)return!1;var n,o,s;if(Array.isArray(e)){if((n=e.length)!=r.length)return!1;for(o=n;0!=o--;)if(!t(e[o],r[o]))return!1;return!0}if(e.constructor===RegExp)return e.source===r.source&&e.flags===r.flags;if(e.valueOf!==Object.prototype.valueOf)return e.valueOf()===r.valueOf();if(e.toString!==Object.prototype.toString)return e.toString()===r.toString();if((n=(s=Object.keys(e)).length)!==Object.keys(r).length)return!1;for(o=n;0!=o--;)if(!Object.prototype.hasOwnProperty.call(r,s[o]))return!1;for(o=n;0!=o--;){var i=s[o];if(!t(e[i],r[i]))return!1}return!0}return e!=e&&r!=r}}},e={};function r(n){var o=e[n];if(void 0!==o)return o.exports;var s=e[n]={exports:{}};return t[n](s,s.exports,r),s.exports}r.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return r.d(e,{a:e}),e},r.d=(t,e)=>{for(var n in e)r.o(e,n)&&!r.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},r.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{var t=r(63),e=r.n(t);function n(t,e,r,s,i,a){if(i-s<=r)return;const l=s+i>>1;o(t,e,l,s,i,a%2),n(t,e,r,s,l-1,a+1),n(t,e,r,l+1,i,a+1)}function o(t,e,r,n,i,a){for(;i>n;){if(i-n>600){const s=i-n+1,l=r-n+1,c=Math.log(s),u=.5*Math.exp(2*c/3),h=.5*Math.sqrt(c*u*(s-u)/s)*(l-s/2<0?-1:1);o(t,e,r,Math.max(n,Math.floor(r-l*u/s+h)),Math.min(i,Math.floor(r+(s-l)*u/s+h)),a)}const l=e[2*r+a];let c=n,u=i;for(s(t,e,n,r),e[2*i+a]>l&&s(t,e,n,i);c<u;){for(s(t,e,c,u),c++,u--;e[2*c+a]<l;)c++;for(;e[2*u+a]>l;)u--}e[2*n+a]===l?s(t,e,n,u):(u++,s(t,e,u,i)),u<=r&&(n=u+1),r<=u&&(i=u-1)}}function s(t,e,r,n){i(t,r,n),i(e,2*r,2*n),i(e,2*r+1,2*n+1)}function i(t,e,r){const n=t[e];t[e]=t[r],t[r]=n}function a(t,e,r,n){const o=t-r,s=e-n;return o*o+s*s}const l=t=>t[0],c=t=>t[1];class u{constructor(t,e=l,r=c,o=64,s=Float64Array){this.nodeSize=o,this.points=t;const i=t.length<65536?Uint16Array:Uint32Array,a=this.ids=new i(t.length),u=this.coords=new s(2*t.length);for(let n=0;n<t.length;n++)a[n]=n,u[2*n]=e(t[n]),u[2*n+1]=r(t[n]);n(a,u,o,0,a.length-1,0)}range(t,e,r,n){return function(t,e,r,n,o,s,i){const a=[0,t.length-1,0],l=[];let c,u;for(;a.length;){const h=a.pop(),p=a.pop(),m=a.pop();if(p-m<=i){for(let i=m;i<=p;i++)c=e[2*i],u=e[2*i+1],c>=r&&c<=o&&u>=n&&u<=s&&l.push(t[i]);continue}const f=Math.floor((m+p)/2);c=e[2*f],u=e[2*f+1],c>=r&&c<=o&&u>=n&&u<=s&&l.push(t[f]);const g=(h+1)%2;(0===h?r<=c:n<=u)&&(a.push(m),a.push(f-1),a.push(g)),(0===h?o>=c:s>=u)&&(a.push(f+1),a.push(p),a.push(g))}return l}(this.ids,this.coords,t,e,r,n,this.nodeSize)}within(t,e,r){return function(t,e,r,n,o,s){const i=[0,t.length-1,0],l=[],c=o*o;for(;i.length;){const u=i.pop(),h=i.pop(),p=i.pop();if(h-p<=s){for(let o=p;o<=h;o++)a(e[2*o],e[2*o+1],r,n)<=c&&l.push(t[o]);continue}const m=Math.floor((p+h)/2),f=e[2*m],g=e[2*m+1];a(f,g,r,n)<=c&&l.push(t[m]);const d=(u+1)%2;(0===u?r-o<=f:n-o<=g)&&(i.push(p),i.push(m-1),i.push(d)),(0===u?r+o>=f:n+o>=g)&&(i.push(m+1),i.push(h),i.push(d))}return l}(this.ids,this.coords,t,e,r,this.nodeSize)}}const h={minZoom:0,maxZoom:16,minPoints:2,radius:40,extent:512,nodeSize:64,log:!1,generateId:!1,reduce:null,map:t=>t},p=Math.fround||(m=new Float32Array(1),t=>(m[0]=+t,m[0]));var m;class f{constructor(t){this.options=b(Object.create(h),t),this.trees=new Array(this.options.maxZoom+1)}load(t){const{log:e,minZoom:r,maxZoom:n,nodeSize:o}=this.options;e&&console.time("total time");const s=`prepare ${t.length} points`;e&&console.time(s),this.points=t;let i=[];for(let e=0;e<t.length;e++)t[e].geometry&&i.push(d(t[e],e));this.trees[n+1]=new u(i,x,P,o,Float32Array),e&&console.timeEnd(s);for(let t=n;t>=r;t--){const r=+Date.now();i=this._cluster(i,t),this.trees[t]=new u(i,x,P,o,Float32Array),e&&console.log("z%d: %d clusters in %dms",t,i.length,+Date.now()-r)}return e&&console.timeEnd("total time"),this}getClusters(t,e){let r=((t[0]+180)%360+360)%360-180;const n=Math.max(-90,Math.min(90,t[1]));let o=180===t[2]?180:((t[2]+180)%360+360)%360-180;const s=Math.max(-90,Math.min(90,t[3]));if(t[2]-t[0]>=360)r=-180,o=180;else if(r>o){const t=this.getClusters([r,n,180,s],e),i=this.getClusters([-180,n,o,s],e);return t.concat(i)}const i=this.trees[this._limitZoom(e)],a=i.range(v(r),w(s),v(o),w(n)),l=[];for(const t of a){const e=i.points[t];l.push(e.numPoints?y(e):this.points[e.index])}return l}getChildren(t){const e=this._getOriginId(t),r=this._getOriginZoom(t),n="No cluster with the specified id.",o=this.trees[r];if(!o)throw new Error(n);const s=o.points[e];if(!s)throw new Error(n);const i=this.options.radius/(this.options.extent*Math.pow(2,r-1)),a=o.within(s.x,s.y,i),l=[];for(const e of a){const r=o.points[e];r.parentId===t&&l.push(r.numPoints?y(r):this.points[r.index])}if(0===l.length)throw new Error(n);return l}getLeaves(t,e,r){e=e||10,r=r||0;const n=[];return this._appendLeaves(n,t,e,r,0),n}getTile(t,e,r){const n=this.trees[this._limitZoom(t)],o=Math.pow(2,t),{extent:s,radius:i}=this.options,a=i/s,l=(r-a)/o,c=(r+1+a)/o,u={features:[]};return this._addTileFeatures(n.range((e-a)/o,l,(e+1+a)/o,c),n.points,e,r,o,u),0===e&&this._addTileFeatures(n.range(1-a/o,l,1,c),n.points,o,r,o,u),e===o-1&&this._addTileFeatures(n.range(0,l,a/o,c),n.points,-1,r,o,u),u.features.length?u:null}getClusterExpansionZoom(t){let e=this._getOriginZoom(t)-1;for(;e<=this.options.maxZoom;){const r=this.getChildren(t);if(e++,1!==r.length)break;t=r[0].properties.cluster_id}return e}_appendLeaves(t,e,r,n,o){const s=this.getChildren(e);for(const e of s){const s=e.properties;if(s&&s.cluster?o+s.point_count<=n?o+=s.point_count:o=this._appendLeaves(t,s.cluster_id,r,n,o):o<n?o++:t.push(e),t.length===r)break}return o}_addTileFeatures(t,e,r,n,o,s){for(const i of t){const t=e[i],a=t.numPoints;let l,c,u;if(a)l=k(t),c=t.x,u=t.y;else{const e=this.points[t.index];l=e.properties,c=v(e.geometry.coordinates[0]),u=w(e.geometry.coordinates[1])}const h={type:1,geometry:[[Math.round(this.options.extent*(c*o-r)),Math.round(this.options.extent*(u*o-n))]],tags:l};let p;a?p=t.id:this.options.generateId?p=t.index:this.points[t.index].id&&(p=this.points[t.index].id),void 0!==p&&(h.id=p),s.features.push(h)}}_limitZoom(t){return Math.max(this.options.minZoom,Math.min(Math.floor(+t),this.options.maxZoom+1))}_cluster(t,e){const r=[],{radius:n,extent:o,reduce:s,minPoints:i}=this.options,a=n/(o*Math.pow(2,e));for(let n=0;n<t.length;n++){const o=t[n];if(o.zoom<=e)continue;o.zoom=e;const l=this.trees[e+1],c=l.within(o.x,o.y,a),u=o.numPoints||1;let h=u;for(const t of c){const r=l.points[t];r.zoom>e&&(h+=r.numPoints||1)}if(h>u&&h>=i){let t=o.x*u,i=o.y*u,a=s&&u>1?this._map(o,!0):null;const p=(n<<5)+(e+1)+this.points.length;for(const r of c){const n=l.points[r];if(n.zoom<=e)continue;n.zoom=e;const c=n.numPoints||1;t+=n.x*c,i+=n.y*c,n.parentId=p,s&&(a||(a=this._map(o,!0)),s(a,this._map(n)))}o.parentId=p,r.push(g(t/h,i/h,p,h,a))}else if(r.push(o),h>1)for(const t of c){const n=l.points[t];n.zoom<=e||(n.zoom=e,r.push(n))}}return r}_getOriginId(t){return t-this.points.length>>5}_getOriginZoom(t){return(t-this.points.length)%32}_map(t,e){if(t.numPoints)return e?b({},t.properties):t.properties;const r=this.points[t.index].properties,n=this.options.map(r);return e&&n===r?b({},n):n}}function g(t,e,r,n,o){return{x:p(t),y:p(e),zoom:1/0,id:r,parentId:-1,numPoints:n,properties:o}}function d(t,e){const[r,n]=t.geometry.coordinates;return{x:p(v(r)),y:p(w(n)),zoom:1/0,index:e,parentId:-1}}function y(t){return{type:"Feature",id:t.id,properties:k(t),geometry:{type:"Point",coordinates:[(e=t.x,360*(e-.5)),M(t.y)]}};var e}function k(t){const e=t.numPoints,r=e>=1e4?`${Math.round(e/1e3)}k`:e>=1e3?Math.round(e/100)/10+"k":e;return b(b({},t.properties),{cluster:!0,cluster_id:t.id,point_count:e,point_count_abbreviated:r})}function v(t){return t/360+.5}function w(t){const e=Math.sin(t*Math.PI/180),r=.5-.25*Math.log((1+e)/(1-e))/Math.PI;return r<0?0:r>1?1:r}function M(t){const e=(180-360*t)*Math.PI/180;return 360*Math.atan(Math.exp(e))/Math.PI-90}function b(t,e){for(const r in e)t[r]=e[r];return t}function x(t){return t.x}function P(t){return t.y}
/*! *****************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */
function O(t,e){var r={};for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&e.indexOf(n)<0&&(r[n]=t[n]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var o=0;for(n=Object.getOwnPropertySymbols(t);o<n.length;o++)e.indexOf(n[o])<0&&Object.prototype.propertyIsEnumerable.call(t,n[o])&&(r[n[o]]=t[n[o]])}return r}class C{constructor({markers:t,position:e}){this.markers=t,e&&(e instanceof google.maps.LatLng?this._position=e:this._position=new google.maps.LatLng(e))}get bounds(){if(0!==this.markers.length||this._position)return this.markers.reduce(((t,e)=>t.extend(e.getPosition())),new google.maps.LatLngBounds(this._position,this._position))}get position(){return this._position||this.bounds.getCenter()}get count(){return this.markers.filter((t=>t.getVisible())).length}push(t){this.markers.push(t)}delete(){this.marker&&(this.marker.setMap(null),delete this.marker),this.markers.length=0}}class _{constructor({maxZoom:t=16}){this.maxZoom=t}noop({markers:t}){return I(t)}}const I=t=>t.map((t=>new C({position:t.getPosition(),markers:[t]})));class L extends _{constructor(t){var{maxZoom:e,radius:r=60}=t,n=O(t,["maxZoom","radius"]);super({maxZoom:e}),this.superCluster=new f(Object.assign({maxZoom:this.maxZoom,radius:r},n)),this.state={zoom:null}}calculate(t){let r=!1;if(!e()(t.markers,this.markers)){r=!0,this.markers=[...t.markers];const e=this.markers.map((t=>({type:"Feature",geometry:{type:"Point",coordinates:[t.getPosition().lng(),t.getPosition().lat()]},properties:{marker:t}})));this.superCluster.load(e)}const n={zoom:t.map.getZoom()};return r||this.state.zoom>this.maxZoom&&n.zoom>this.maxZoom||(r=r||!e()(this.state,n)),this.state=n,r&&(this.clusters=this.cluster(t)),{clusters:this.clusters,changed:r}}cluster({map:t}){return this.superCluster.getClusters([-180,-90,180,90],Math.round(t.getZoom())).map(this.transformCluster.bind(this))}transformCluster({geometry:{coordinates:[t,e]},properties:r}){if(r.cluster)return new C({markers:this.superCluster.getLeaves(r.cluster_id,1/0).map((t=>t.properties.marker)),position:new google.maps.LatLng({lat:e,lng:t})});{const t=r.marker;return new C({markers:[t],position:t.getPosition()})}}}class S{constructor(t,e){this.markers={sum:t.length};const r=e.map((t=>t.count)),n=r.reduce(((t,e)=>t+e),0);this.clusters={count:e.length,markers:{mean:n/e.length,sum:n,min:Math.min(...r),max:Math.max(...r)}}}}class j{render({count:t,position:e},r){const n=t>Math.max(10,r.clusters.markers.mean)?"#ff0000":"#0000ff",o=window.btoa(`\n  <svg fill="${n}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240">\n    <circle cx="120" cy="120" opacity=".6" r="70" />\n    <circle cx="120" cy="120" opacity=".3" r="90" />\n    <circle cx="120" cy="120" opacity=".2" r="110" />\n  </svg>`);return new google.maps.Marker({position:e,icon:{url:`data:image/svg+xml;base64,${o}`,scaledSize:new google.maps.Size(45,45)},label:{text:String(t),color:"rgba(255,255,255,0.9)",fontSize:"12px"},title:`Cluster of ${t} markers`,zIndex:Number(google.maps.Marker.MAX_ZINDEX)+t})}}class E{constructor(){!function(t,e){for(let r in e.prototype)t.prototype[r]=e.prototype[r]}(E,google.maps.OverlayView)}}var z;!function(t){t.CLUSTERING_BEGIN="clusteringbegin",t.CLUSTERING_END="clusteringend",t.CLUSTER_CLICK="click"}(z||(z={}));const Z=(t,e,r)=>{r.fitBounds(e.bounds)};class A extends E{constructor({map:t,markers:e=[],algorithm:r=new L({}),renderer:n=new j,onClusterClick:o=Z}){super(),this.markers=[...e],this.clusters=[],this.algorithm=r,this.renderer=n,this.onClusterClick=o,t&&this.setMap(t)}addMarker(t,e){this.markers.includes(t)||(this.markers.push(t),e||this.render())}addMarkers(t,e){t.forEach((t=>{this.addMarker(t,!0)})),e||this.render()}removeMarker(t,e){const r=this.markers.indexOf(t);return-1!==r&&(t.setMap(null),this.markers.splice(r,1),e||this.render(),!0)}removeMarkers(t,e){let r=!1;return t.forEach((t=>{r=this.removeMarker(t,!0)||r})),r&&!e&&this.render(),r}clearMarkers(t){this.markers.length=0,t||this.render()}render(){const t=this.getMap();if(t instanceof google.maps.Map&&this.getProjection()){google.maps.event.trigger(this,z.CLUSTERING_BEGIN,this);const{clusters:e,changed:r}=this.algorithm.calculate({markers:this.markers,map:t,mapCanvasProjection:this.getProjection()});(r||null==r)&&(this.reset(),this.clusters=e,this.renderClusters()),google.maps.event.trigger(this,z.CLUSTERING_END,this)}}onAdd(){this.idleListener=this.getMap().addListener("idle",this.render.bind(this)),this.render()}onRemove(){google.maps.event.removeListener(this.idleListener),this.reset()}reset(){this.markers.forEach((t=>t.setMap(null))),this.clusters.forEach((t=>t.delete())),this.clusters=[]}renderClusters(){const t=new S(this.markers,this.clusters),e=this.getMap();this.clusters.forEach((r=>{1===r.markers.length?r.marker=r.markers[0]:(r.marker=this.renderer.render(r,t),this.onClusterClick&&r.marker.addListener("click",(t=>{google.maps.event.trigger(this,z.CLUSTER_CLICK,r),this.onClusterClick(t,r,e)}))),r.marker.setMap(e)}))}}const T=Date.now||function(){return(new Date).getTime()};function F(t,e,r){var n,o,s,i,a,l=function(){var c=T()-o;e>c?n=setTimeout(l,e-c):(n=null,r||(i=t.apply(a,s)),n||(s=a=null))},c=function(t,e){return e=null==e?t.length-1:+e,function(){for(var r=Math.max(arguments.length-e,0),n=Array(r),o=0;o<r;o++)n[o]=arguments[o+e];switch(e){case 0:return t.call(this,n);case 1:return t.call(this,arguments[0],n);case 2:return t.call(this,arguments[0],arguments[1],n)}var s=Array(e+1);for(o=0;o<e;o++)s[o]=arguments[o];return s[e]=n,t.apply(this,s)}}((function(c){return a=this,s=c,o=T(),n||(n=setTimeout(l,e),r&&(i=t.apply(a,s))),i}));return c.cancel=function(){clearTimeout(n),n=s=a=null},c}function D(t,e){var r="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!r){if(Array.isArray(t)||(r=function(t,e){if(!t)return;if("string"==typeof t)return B(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return B(t,e)}(t))||e&&t&&"number"==typeof t.length){r&&(t=r);var n=0,o=function(){};return{s:o,n:function(){return n>=t.length?{done:!0}:{done:!1,value:t[n++]}},e:function(t){throw t},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var s,i=!0,a=!1;return{s:function(){r=r.call(t)},n:function(){var t=r.next();return i=t.done,t},e:function(t){a=!0,s=t},f:function(){try{i||null==r.return||r.return()}finally{if(a)throw s}}}}function B(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,n=new Array(e);r<e;r++)n[r]=t[r];return n}function G(t){return G="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},G(t)}function N(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function U(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?N(Object(r),!0).forEach((function(e){R(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):N(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function R(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}window.filamentGoogleMapsWidget=function(t,e){return{wire:null,map:null,bounds:null,infoWindow:null,mapEl:null,data:null,markers:[],layers:[],modelIds:[],mapIsFilter:!1,clusterer:null,center:null,isMapDragging:!1,isIdleSkipped:!1,config:{center:{lat:0,lng:0},clustering:!1,controls:{mapTypeControl:!0,scaleControl:!0,streetViewControl:!0,rotateControl:!0,fullscreenControl:!0,searchBoxControl:!1,zoomControl:!1},fit:!0,mapIsFilter:!1,gmaps:"",layers:[],zoom:12},loadGMaps:function(){if(document.getElementById("filament-google-maps-google-maps-js")){!function t(e,r){window[e]?r():setTimeout((function(){t(e,r)}),100)}("filamentGoogleMapsAPILoaded",function(){this.createMap()}.bind(this))}else{var t=document.createElement("script");t.id="filament-google-maps-google-maps-js",window.filamentGoogleMapsAsyncLoad=this.createMap.bind(this),t.src=this.config.gmaps+"&callback=filamentGoogleMapsAsyncLoad",document.head.appendChild(t)}},init:function(r,n){this.mapEl=document.getElementById(n)||n,this.data=r,this.wire=t,this.config=U(U({},this.config),e),this.loadGMaps()},callWire:function(t){},createMap:function(){window.filamentGoogleMapsAPILoaded=!0,this.infoWindow=new google.maps.InfoWindow({content:"",disableAutoPan:!0}),this.map=new google.maps.Map(this.mapEl,U({center:this.config.center,zoom:this.config.zoom},this.config.controls)),this.center=this.config.center,this.createMarkers(),this.createClustering(),this.createLayers(),this.idle(),this.show(!0)},show:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];this.config.fit?this.fitToBounds(t):this.markers.length>0&&this.map.setCenter(this.markers[0].getPosition())},createLayers:function(){var t=this;this.layers=this.config.layers.map((function(e){return new google.maps.KmlLayer({url:e,map:t.map})}))},createMarker:function(t){var e;t.icon&&"object"===G(t.icon)&&t.icon.hasOwnProperty("url")&&(e={url:t.icon.url},t.icon.hasOwnProperty("type")&&"svg"===t.icon.type&&t.icon.hasOwnProperty("scale")&&(e.scaledSize=new google.maps.Size(t.icon.scale[0],t.icon.scale[1])));var r=t.location,n=t.label,o=new google.maps.Marker(U({position:r,title:n,model_id:t.id},e&&{icon:e}));return-1===this.modelIds.indexOf(t.id)&&this.modelIds.push(t.id),o},createMarkers:function(){var t=this,e=this;this.markers=this.data.map((function(r){var n=t.createMarker(r);n.setMap(t.map);return google.maps.event.addListener(n,"click",(function(t){e.wire.mountTableAction("edit",n.model_id)})),n}))},removeMarker:function(t){t.setMap(null)},removeMarkers:function(){for(var t=0;t<this.markers.length;t++)this.markers[t].setMap(null);this.markers=[]},mergeMarkers:function(){var t=this,e=function(t,e){var r=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return t.filter((function(t){return r===e.some((function(e){return t.getPosition().lat()===e.getPosition().lat()&&t.getPosition().lng()===e.getPosition().lng()}))}))},r=e,n=function(t,e){return r(e,t)},o=this.data.map((function(e){var r=t.createMarker(e);return r.addListener("click",(function(){t.infoWindow.setContent(e.label),t.infoWindow.open(t.map,r)})),r}));this.config.mapIsFilter||function(){for(var e=n(o,t.markers),r=function(r){e[r].setMap(null);var n=t.markers.findIndex((function(t){return t.getPosition().lat()===e[r].getPosition().lat()&&t.getPosition().lng()===e[r].getPosition().lng()}));t.markers.splice(n,1)},s=e.length-1;s>=0;s--)r(s)}();for(var s=n(this.markers,o),i=0;i<s.length;i++)s[i].setMap(this.map),this.markers.push(s[i]);this.fitToBounds()},fitToBounds:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];if(this.config.fit&&(t||!this.config.mapIsFilter)){this.bounds=new google.maps.LatLngBounds;var e,r=D(this.markers);try{for(r.s();!(e=r.n()).done;){var n=e.value;this.bounds.extend(n.getPosition())}}catch(t){r.e(t)}finally{r.f()}this.map.fitBounds(this.bounds)}},createClustering:function(){this.config.clustering&&(this.clusterer=new A({map:this.map,markers:this.markers}))},updateClustering:function(){this.config.clustering&&(this.clusterer.clearMarkers(),this.clusterer.addMarkers(this.markers))},moved:function(){console.log("moved");var e,r,n=this.map.getBounds(),o=this.markers.filter((function(t){return n.contains(t.getPosition())})).map((function(t){return t.model_id}));e=this.modelIds,r=o,e.length===r.length&&e.every((function(t,e){return t===r[e]}))||(this.modelIds=o,console.log(o),t.set("mapFilterIds",o))},idle:function(){if(this.config.mapIsFilter){self;var t=F(this.moved,1e3).bind(this);google.maps.event.addListener(this.map,"idle",(function(e){self.isMapDragging?self.idleSkipped=!0:(self.idleSkipped=!1,t())})),google.maps.event.addListener(this.map,"dragstart",(function(t){self.isMapDragging=!0})),google.maps.event.addListener(this.map,"dragend",(function(e){self.isMapDragging=!1,!0===self.idleSkipped&&(t(),self.idleSkipped=!1)})),google.maps.event.addListener(this.map,"bounds_changed",(function(t){self.idleSkipped=!1}))}},update:function(t){this.data=t,this.mergeMarkers(),this.updateClustering(),this.show()},recenter:function(t){this.map.panTo({lat:t.lat,lng:t.lng}),this.map.setZoom(t.zoom)}}}})()})();
//# sourceMappingURL=filament-google-maps-widget.js.map