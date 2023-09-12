function filamentGoogleGeocomplete({setStateUsing,debug,statePath,gmaps,filterName,reverseGeocodeFields,latLngFields,types,countries,isLocation,placeField,reverseGeocodeUsing,hasReverseGeocodeUsing=!1}){return{geocoder:null,mapEl:null,symbols:{"%n":["street_number"],"%z":["postal_code"],"%S":["street_address","route"],"%A1":["administrative_area_level_1"],"%A2":["administrative_area_level_2"],"%A3":["administrative_area_level_3"],"%A4":["administrative_area_level_4"],"%A5":["administrative_area_level_5"],"%a1":["administrative_area_level_1"],"%a2":["administrative_area_level_2"],"%a3":["administrative_area_level_3"],"%a4":["administrative_area_level_4"],"%a5":["administrative_area_level_5"],"%L":["locality","postal_town"],"%D":["sublocality"],"%C":["country"],"%c":["country"],"%p":["premise"],"%P":["premise"]},loadGMaps:function(){if(document.getElementById("filament-google-maps-google-maps-js")){let waitForGlobal=function(key,callback){window[key]?callback():setTimeout(function(){waitForGlobal(key,callback)},100)};waitForGlobal("filamentGoogleMapsAPILoaded",function(){this.createAutocomplete()}.bind(this))}else{let script=document.createElement("script");script.id="filament-google-maps-google-maps-js",window.filamentGoogleMapsAsyncLoad=this.createAutocomplete.bind(this),script.src=gmaps+"&callback=filamentGoogleMapsAsyncLoad",document.head.appendChild(script)}},init:function(mapEl){console.log("geocomplete init"),this.mapEl=mapEl,this.loadGMaps()},createAutocomplete:function(){window.filamentGoogleMapsAPILoaded=!0;let fields=["address_components","formatted_address","geometry","name"];fields.includes(placeField)||fields.push(placeField);let geocompleteOptions={fields,strictBounds:!1,types},geocompleteEl=isLocation?statePath+"-fgm-address":statePath,geoComplete=document.getElementById(geocompleteEl);if(geoComplete){window.addEventListener("keydown",function(e){if((e.key==="U+000A"||e.key==="Enter"||e.code==="Enter")&&e.target.nodeName==="INPUT"&&e.target.type==="text")return e.preventDefault(),!1},!0);let autocomplete=new google.maps.places.Autocomplete(geoComplete,geocompleteOptions);autocomplete.setComponentRestrictions({country:countries}),autocomplete.addListener("place_changed",()=>{let place=autocomplete.getPlace();if(!place.geometry||!place.geometry.location){window.alert("No details available for input: '"+place.name+"'");return}this.setLocation(place),this.updateReverseGeocode(place),this.updateLatLng(place)});let geoLocate=document.getElementById(statePath+"-geolocate");geoLocate&&(this.geocoder=new google.maps.Geocoder,geoLocate.addEventListener("click",event=>{"geolocation"in navigator&&navigator.geolocation.getCurrentPosition(position=>{var currentLatitude=position.coords.latitude,currentLongitude=position.coords.longitude,currentLocation={lat:currentLatitude,lng:currentLongitude};this.geocoder.geocode({location:currentLocation}).then(response=>{response.results[0]&&(geoComplete.setAttribute("value",response.results[0].formatted_address),this.setLocation(response.results[0]),this.updateReverseGeocode(response.results[0]),this.updateLatLng(response.results[0]))})})}))}},setLocation:async function(place){if(isLocation){let old=place.geometry.location,foo={lat:place.geometry.location.lat(),lng:place.geometry.location.lng(),formatted_address:place[placeField]};await setStateUsing(statePath,foo)}else await setStateUsing(statePath,place[placeField]);if(filterName){let latPath=filterName+".latitude",lngPath=filterName+".longitude",lat=document.getElementById(latPath),lng=document.getElementById(lngPath);lat&&lng&&(lat.setAttribute("value",place.geometry.location.lat().toString()),lng.setAttribute("value",place.geometry.location.lng().toString()),await setStateUsing(latPath,place.geometry.location.lat().toString()),await setStateUsing(lngPath,place.geometry.location.lng().toString()))}},updateReverseGeocode:async function(place){if(this.hasReverseGeocode()){if(place.address_components){let replacements=this.getReplacements(place.address_components);for(let field in reverseGeocodeFields){let replaced=reverseGeocodeFields[field];for(let replacement in replacements)replaced=replaced.split(replacement).join(replacements[replacement]);for(let symbol in this.symbols)replaced=replaced.split(symbol).join("");replaced=replaced.trim(),await setStateUsing(field,replaced)}}hasReverseGeocodeUsing&&reverseGeocodeUsing(place)}},updateLatLng:async function(place){Object.keys(latLngFields).length>0&&place.geometry&&(await setStateUsing(latLngFields.lat,place.geometry.location.lat().toString()),await setStateUsing(latLngFields.lng,place.geometry.location.lng().toString()))},getReplacements:function(address_components){let replacements={};return address_components.forEach(component=>{for(let symbol in this.symbols)this.symbols[symbol].indexOf(component.types[0])!==-1&&(symbol===symbol.toLowerCase()?replacements[symbol]=component.short_name:replacements[symbol]=component.long_name)}),debug&&console.log(replacements),replacements},hasReverseGeocode:function(){return Object.keys(reverseGeocodeFields).length>0||hasReverseGeocodeUsing}}}export{filamentGoogleGeocomplete as default};
