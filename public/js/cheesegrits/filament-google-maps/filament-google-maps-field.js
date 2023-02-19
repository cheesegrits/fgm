(()=>{var e,t={825:()=>{function e(e,t){var o=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),o.push.apply(o,a)}return o}function t(t){for(var a=1;a<arguments.length;a++){var n=null!=arguments[a]?arguments[a]:{};a%2?e(Object(n),!0).forEach((function(e){o(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):e(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function o(e,t,o){return t in e?Object.defineProperty(e,t,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[t]=o,e}window.filamentGoogleMaps=function(e,o){return{map:null,geocoder:null,marker:null,markerLocation:null,layers:null,mapEl:null,pacEl:null,config:{debug:!1,autocomplete:"",autocompleteReverse:!1,draggable:!0,clickable:!1,defaultLocation:{lat:0,lng:0},statePath:"",controls:{mapTypeControl:!0,scaleControl:!0,streetViewControl:!0,rotateControl:!0,fullscreenControl:!0,searchBoxControl:!1,zoomControl:!1},layers:[],reverseGeocodeFields:{},defaultZoom:8,gmaps:""},symbols:{"%n":["street_number"],"%z":["postal_code"],"%S":["street_address","route"],"%A1":["administrative_area_level_1"],"%A2":["administrative_area_level_2"],"%A3":["administrative_area_level_3"],"%A4":["administrative_area_level_4"],"%A5":["administrative_area_level_5"],"%a1":["administrative_area_level_1"],"%a2":["administrative_area_level_2"],"%a3":["administrative_area_level_3"],"%a4":["administrative_area_level_4"],"%a5":["administrative_area_level_5"],"%L":["locality"],"%D":["sublocality"],"%C":["country"],"%c":["country"]},loadGMaps:function(){if(document.getElementById("filament-google-maps-google-maps-js")){!function e(t,o){window[t]?o():setTimeout((function(){e(t,o)}),100)}("filamentGoogleMapsAPILoaded",function(){this.createMap()}.bind(this))}else{var e=document.createElement("script");e.id="filament-google-maps-google-maps-js",window.filamentGoogleMapsAsyncLoad=this.createMap.bind(this),e.src=this.config.gmaps+"&callback=filamentGoogleMapsAsyncLoad",document.head.appendChild(e)}},init:function(e,a){this.mapEl=e,this.pacEl=a,this.config=t(t({},this.config),o),this.loadGMaps()},createMap:function(){var e=this;if(window.filamentGoogleMapsAPILoaded=!0,(this.config.autocompleteReverse||Object.keys(this.config.reverseGeocodeFields).length>0)&&(this.geocoder=new google.maps.Geocoder),this.map=new google.maps.Map(this.mapEl,t({center:this.getCoordinates(),zoom:this.config.defaultZoom},this.config.controls)),this.marker=new google.maps.Marker({draggable:this.config.draggable,map:this.map}),this.marker.setPosition(this.getCoordinates()),this.config.clickable&&this.map.addListener("click",(function(t){e.markerLocation=t.latLng.toJSON(),e.setCoordinates(e.markerLocation),e.updateAutocomplete(e.markerLocation),e.updateGeocode(e.markerLocation),e.map.panTo(e.markerLocation)})),this.config.draggable&&google.maps.event.addListener(this.marker,"dragend",(function(t){e.markerLocation=t.latLng.toJSON(),e.setCoordinates(e.markerLocation),e.updateAutocomplete(e.markerLocation),e.updateGeocode(e.markerLocation),e.map.panTo(e.markerLocation)})),this.config.controls.searchBoxControl){var o=this.pacEl,a=new google.maps.places.SearchBox(o);this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(o),a.addListener("places_changed",(function(){o.value="",e.markerLocation=a.getPlaces()[0].geometry.location}))}if(this.config.autocomplete){var n=document.getElementById(this.config.autocomplete);if(n){window.addEventListener("keydown",(function(e){if(("U+000A"===e.key||"Enter"===e.key||"Enter"===e.code)&&"INPUT"===e.target.nodeName&&"text"===e.target.type)return e.preventDefault(),!1}),!0);var r=new google.maps.places.Autocomplete(n,{fields:["formatted_address","geometry","name"],strictBounds:!1,types:["geocode"]});r.addListener("place_changed",(function(){var t=r.getPlace();t.geometry&&t.geometry.location?(t.geometry.viewport?e.map.fitBounds(t.geometry.viewport):e.map.setCenter(t.geometry.location),e.marker.setPosition(t.geometry.location),e.markerLocation=t.geometry.location,e.setCoordinates(t.geometry.location)):window.alert("No details available for input: '"+t.name+"'")}))}}this.config.layers&&(this.layers=this.config.layers.map((function(t){return new google.maps.KmlLayer({url:t,map:e.map})})))},updateMapFromAlpine:function(){var e=this.getCoordinates(),t=this.marker.getPosition();e.lat===t.lat()&&e.lng===t.lng()||(this.updateAutocomplete(e),this.updateMap(e))},updateMap:function(e){this.marker.setPosition(e),this.map.panTo(e)},updateGeocode:function(t){var o=this;Object.keys(this.config.reverseGeocodeFields).length>0&&this.geocoder.geocode({location:t}).then((function(t){if(t.results[0]){var a=o.getReplacements(t.results[0].address_components);for(var n in o.config.reverseGeocodeFields){var r=o.config.reverseGeocodeFields[n];for(var i in a)r=r.split(i).join(a[i]);for(var s in o.symbols)r=r.split(s).join("");r=r.trim(),e.set(n,r)}}})).catch((function(e){console.log(e.message)}))},updateAutocomplete:function(t){var o=this;this.config.autocomplete&&this.config.autocompleteReverse&&this.geocoder.geocode({location:t}).then((function(t){t.results[0]&&e.set(o.config.autocomplete,t.results[0].formatted_address)})).catch((function(e){console.log(e.message)}))},setCoordinates:function(t){e.set(this.config.statePath,t)},getCoordinates:function(){var t=e.get(this.config.statePath);return null!==t&&t.hasOwnProperty("lat")||(t={lat:this.config.defaultLocation.lat,lng:this.config.defaultLocation.lng}),t},getReplacements:function(e){var t=this,o={};return e.forEach((function(e){for(var a in t.symbols)-1!==t.symbols[a].indexOf(e.types[0])&&(a===a.toLowerCase()?o[a]=e.short_name:o[a]=e.long_name)})),this.config.debug&&console.log(o),o}}}},3:()=>{}},o={};function a(e){var n=o[e];if(void 0!==n)return n.exports;var r=o[e]={exports:{}};return t[e](r,r.exports,a),r.exports}a.m=t,e=[],a.O=(t,o,n,r)=>{if(!o){var i=1/0;for(m=0;m<e.length;m++){for(var[o,n,r]=e[m],s=!0,l=0;l<o.length;l++)(!1&r||i>=r)&&Object.keys(a.O).every((e=>a.O[e](o[l])))?o.splice(l--,1):(s=!1,r<i&&(i=r));if(s){e.splice(m--,1);var c=n();void 0!==c&&(t=c)}}return t}r=r||0;for(var m=e.length;m>0&&e[m-1][2]>r;m--)e[m]=e[m-1];e[m]=[o,n,r]},a.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={471:0,822:0};a.O.j=t=>0===e[t];var t=(t,o)=>{var n,r,[i,s,l]=o,c=0;if(i.some((t=>0!==e[t]))){for(n in s)a.o(s,n)&&(a.m[n]=s[n]);if(l)var m=l(a)}for(t&&t(o);c<i.length;c++)r=i[c],a.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return a.O(m)},o=self.webpackChunkfilament_google_maps=self.webpackChunkfilament_google_maps||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})(),a.O(void 0,[822],(()=>a(825)));var n=a.O(void 0,[822],(()=>a(3)));n=a.O(n)})();
//# sourceMappingURL=filament-google-maps.js.map