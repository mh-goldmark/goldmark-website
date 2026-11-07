//global infoBox
var infoBox;
//global map
var map;
// global list properties
var gmarkers = [];
// global cureent properties index
var gmarker_index = 1;
// global map search box
var mapSearchBox;
// global MarkerClusterer
var mcluster;

(function($){
  "use strict";
  $.fn.nooLoadmore = function(options,callback){
    var defaults = {
      agentID:0,
      contentSelector: null,
      contentWrapper:null,
      nextSelector: "div.navigation a:first",
      navSelector: "div.navigation",
      itemSelector: "div.post",
      dataType: 'html',
      finishedMsg: "<em>Congratulations, you've reached the end of the internet.</em>",
      loading:{
        speed:'fast',
        start: undefined
      },
      state: {
        isDuringAjax: false,
        isInvalidPage: false,
        isDestroyed: false,
        isDone: false, // For when it goes all the way through the archive.
        isPaused: false,
        isBeyondMaxPage: false,
        currPage: 1
      }
    };
    var options = $.extend(defaults, options);

    return this.each(function(){
      var self = this;
      var $this = $(this),
      wrapper = $this.find('.loadmore-wrap'),
      action = $this.find('.loadmore-action'),
      btn = action.find(".btn-loadmore"),
      loading = action.find('.loadmore-loading');

      options.contentWrapper = options.contentWrapper || wrapper;



      var _determinepath = function(path){
        if (path.match(/^(.*?)\b2\b(.*?$)/)) {
          path = path.match(/^(.*?)\b2\b(.*?$)/).slice(1);
        } else if (path.match(/^(.*?)2(.*?$)/)) {
          if (path.match(/^(.*?page=)2(\/.*|$)/)) {
            path = path.match(/^(.*?page=)2(\/.*|$)/).slice(1);
            return path;
          }
          path = path.match(/^(.*?)2(.*?$)/).slice(1);

        } else {
          if (path.match(/^(.*?page=)1(\/.*|$)/)) {
            path = path.match(/^(.*?page=)1(\/.*|$)/).slice(1);
            return path;
          } else {
            options.state.isInvalidPage = true;
          }
        }
        return path;
      }
      var path = $(options.nextSelector).attr('href');
      path = _determinepath(path);

      // callback loading
      options.callback = function(data, url) {
        if (callback) {
          callback.call($(options.contentSelector)[0], data, options, url);
        }
      };

      options.loading.start = options.loading.start || function() {
        btn.hide();
        $(options.navSelector).hide();
        loading.show(options.loading.speed, $.proxy(function() {
          loadAjax(options);
        }, self));
      };

      var loadAjax = function(options){
        var callback=options.callback,
        desturl,frag,box,children,data;

        options.state.currPage++;
        // Manually control maximum page
        if ( options.maxPage !== undefined && options.state.currPage > options.maxPage ){
          options.state.isBeyondMaxPage = true;
          return;
        }
        desturl = path.join(options.state.currPage);
        $.post(nooGmapL10n.ajax_url,{
          action:'noo_agent_ajax_property',
          page:options.state.currPage,
          agent_id:options.agentID
        },function(res){

          if(res.content != '' && res.content !=null && res.content != undefined){
            $(options.contentWrapper).append(res.content);
            loading.hide();
            btn.show(options.loading.speed);
          }else{
            btn.hide();
            action.append('<div style="margin-top:5px;">' + options.finishedMsg + '</div>').animate({ opacity: 1 }, 2000, function () {
              action.fadeOut(options.loading.speed);
            });
            return ;
          }
        },'json');
      }


      btn.on('click',function(e){
        e.stopPropagation();
        e.preventDefault();
        options.loading.start.call($(options.contentWrapper)[0],options);
      });
    });
  };

  function noo_price(price){
    var $currency_position = nooGmapL10n.currency_position,
    $format;
    switch ( $currency_position ) {
      case 'left' :
      $format = '%1$s%2$s';
      break;
      case 'right' :
      $format = '%2$s%1$s';
      break;
      case 'left_space' :
      $format = '%1$s&nbsp;%2$s';
      break;
      case 'right_space' :
      $format = '%2$s&nbsp;%1$s';
      break;
    }
    price = noo_number_format(price,nooGmapL10n.num_decimals,nooGmapL10n.decimal_sep,nooGmapL10n.thousands_sep)
    return $format.replace('%1$s',nooGmapL10n.currency).replace('%2$s',price);
  }


  function search_initialize(){
    mapSearchBox = $('.noo-map');

    var mapBox = mapSearchBox.find('#gmap'),
    latitude = nooGmapL10n.latitude,
    longitude = nooGmapL10n.longitude;
    if(mapSearchBox.length && mapBox.length){
      var myPlace    = new google.maps.LatLng(latitude,longitude);
      var myOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(nooGmapL10n.zoom),
        scrollwheel: true,
        streetViewControl:true,
        disableDefaultUI: true,
        draggable: true,
        gestureHandling: "greedy",
        center: myPlace,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
          {
            featureType: "poi.business",
            stylers: [{
                visibility: "off"
              }]
          }, {
            featureType: "poi.attraction",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.park",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.school",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.sports_complex",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.medical",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.place_of_worship",
            stylers: [{
              visibility: "off"
            }]
          }, {
            featureType: "poi.government",
            stylers: [{
              visibility: "off"
            }]
          }
        ]
      };

      // if(Modernizr.touch) {
      //   myOptions = {
      //     flat:false,
      //     noClear:false,
      //     zoom: parseInt(nooGmapL10n.zoom),
      //     scrollwheel: true,
      //     streetViewControl:true,
      //     disableDefaultUI: true,
      //     panControl: false,
      //     mapTypeControl: false,
      //     draggable: true,
      //     center: myPlace,
      //     mapTypeId: google.maps.MapTypeId.ROADMAP,
      //     styles: [
      //       {
      //         featureType: "poi.business",
      //         stylers: [{
      //             visibility: "off"
      //           }]
      //       }, {
      //         featureType: "poi.attraction",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.park",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.school",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.sports_complex",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.medical",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.place_of_worship",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }, {
      //         featureType: "poi.government",
      //         stylers: [{
      //           visibility: "off"
      //         }]
      //       }
      //     ]
      //   };
      // }

      map = new google.maps.Map(mapBox.get(0),myOptions );
      google.maps.visualRefresh = true;

      google.maps.event.addListener(map, 'tilesloaded', function() {
        mapSearchBox.find('.gmap-loading').hide();
      });

      var input = document.getElementById('gmap_search_input');
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
      var searchBox = new google.maps.places.SearchBox(input);
      google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          // Create a marker for each place.
          var _marker = new google.maps.Marker({
            map: map,
            zoom:parseInt(nooGmapL10n.zoom),
            title: place.name,
            position: place.geometry.location
          });
          bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
        map.setZoom(parseInt(nooGmapL10n.zoom));
      });

      // if($(window).width() <= 992) {
      //   var $offsetY = -65;
      // } else {
      //   var $offsetY = -130;
      // }

      var $offsetY = -130;

      var infoboxOptions = {
        content: document.createElement("div"),
        disableAutoPan: true,
        maxWidth: 0,
        boxClass:"myinfobox",
        zIndex: null,
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        alignBottom: true,
        enableEventPropagation: true,
        position: markerPlace,
        pixelOffset: new google.maps.Size(50,$offsetY)
      };
      infoBox = new InfoBox(infoboxOptions);

      //create markers
      // var markers = $.parseJSON(nooGmapL10n.markers);
      var markers = nooGmapL10n.markers;
      if(markers.length){
        for(var i = 0; i < markers.length ; i ++){
          var marker = markers[i];
          var markerPlace = new google.maps.LatLng(marker.latitude,marker.longitude);
          var gmarker = new google.maps.Marker({
            position: markerPlace,
            map: map,
            image:	marker.image,
            caption:	marker.caption,
            refno:	marker.refno,
            price:	marker.price,
            size_price:	marker.size_price,
            class:	marker.class,
            type:	marker.type,
            category:	marker.category,
            developer:	marker.developer,
            completion:	marker.completion,
            bedroom:	marker.bedroom,
            bathroom:	marker.bathroom,
            size:	marker.size,
            title: marker.title,
            location: marker.location,
            url: marker.url
          });
          if(marker.icon != ''){
            gmarker.setIcon(marker.icon);
          }
          gmarkers.push(gmarker);
          google.maps.event.addListener(gmarker, 'click', function(e) {
            if(this.category == 'Residential') {
            var infoContent = '<div class="gmap-infobox">\
            	<a class="info-close" onclick="infoBox.close(); return false;" href="#">\
            		<i class="fal fa-close"></i>\
            	</a>\
            	<div class="row my-gmap-properties">\
            		<div class="col-lg-12">\
            			<div class="listing-style1">\
            				<div class="list-thumb" style="background-image: url('+this.image+');">\
            					<div class="d-flex list-tag">\
                        <div class="list-class">\
                          '+this.type+' '+this.class+'\
                        </div>\
                        <div class="listing-price">\
            						  '+this.price+'\
                         </div>\
            					</div>\
            				</div>\
            				<div class="list-content">\
            					<h2 class="list-title">\
            						<a href="'+this.url+'" title="'+this.title+'" target="Map Listing">\
            							'+this.title+'\
            						</a>\
            					</h2>\
            					<h3 class="list-location">\
            						'+this.location+'\
            					</h3>\
                      <div class="list-meta">\
            						<div class="list-details mr10">\
            							<span class="flaticon-bed mr5"></span>\
            							'+this.bedroom+'\
            						</div>\
            						<div class="list-details mr10">\
            							<span class="flaticon-shower mr5"></span>\
            							'+this.bathroom+'\
            						</div>\
            						<div class="list-details">\
            							<span class="flaticon-expand mr5"></span>\
            							'+this.size+'\
            						</div>\
            					</div>\
            				</div>\
            			</div>\
            		</div>\
            	</div>\
            </div>';
            } else if(this.category == 'Commercial') {
            var infoContent = '<div class="gmap-infobox">\
            	<a class="info-close" onclick="infoBox.close(); return false;" href="#">\
            		<i class="fal fa-close"></i>\
            	</a>\
            	<div class="row my-gmap-properties">\
            		<div class="col-lg-12">\
            			<div class="listing-style1">\
            				<div class="list-thumb" style="background-image: url('+this.image+');">\
            					<div class="d-flex list-tag">\
                        <div class="list-class">\
                          '+this.type+' '+this.class+'\
                        </div>\
                        <div class="listing-price">\
            						  '+this.price+'\
                         </div>\
            					</div>\
            				</div>\
            				<div class="list-content">\
            					<h2 class="list-title">\
            						<a href="'+this.url+'" title="'+this.title+'" target="Map Listing">\
            							'+this.title+'\
            						</a>\
            					</h2>\
            					<h3 class="list-location">\
            						'+this.location+'\
            					</h3>\
                      <div class="list-meta">\
                        <div class="list-details mr10">\
                          <span class="mr0"></span>\
            							'+this.size_price+'\
            						</div>\
            						<div class="list-details">\
            							<span class="flaticon-expand mr5"></span>\
            							'+this.size+'\
            						</div>\
            					</div>\
            				</div>\
            			</div>\
            		</div>\
            	</div>\
            </div>';
            } else {
            var infoContent = '<div class="gmap-infobox project-infobox">\
            	<a class="info-close" onclick="infoBox.close(); return false;" href="#">\
            		<i class="fal fa-close"></i>\
            	</a>\
            	<div class="row my-gmap-properties">\
            		<div class="col-lg-12">\
            			<div class="listing-style1">\
            				<div class="list-thumb" style="background-image: url('+this.image+');">\
                      <div class="row row-bottom-area">\
                        <div class="col-8 col-developer">\
                          <span class="flaticon-corporation"></span>\
                          '+this.developer+'\
                        </div>\
                        <div class="col-4 col-completion">\
                          <span class="flaticon-clock"></span>\
                          '+this.completion+'\
                        </div>\
                      </div>\
            				</div>\
            				<div class="list-content">\
            					<h2 class="list-title">\
            						<a href="'+this.url+'" title="'+this.title+'" target="Map Listing">\
            							'+this.title+'\
            						</a>\
            					</h2>\
            					<h3 class="list-location">\
            						'+this.location+'\
            					</h3>\
                      <h4 class="list-sub-type mt15 mb10">\
            						'+this.type+'\
            					</h4>\
            				</div>\
            			</div>\
            		</div>\
            	</div>\
            </div>';
            }
            map.setCenter(this.position);
            map.panBy(0,-225);
            infoBox.setContent(infoContent);
            infoBox.open(map,this);
          });
        }
      }

      google.maps.event.addListener(map, "click", function(event) {
        infoBox.close();
      });

      //MarkerClustererPlus
      var clusterStyles = [{
        textColor: '#ffffff',
        opt_textColor: '#ffffff',
        // url: nooGmapL10n.theme_uri+'/assets/images/cloud.png',
        url:'https://maps.gstatic.com/mapfiles/transparent.png',
        height: 40,
        width: 40,
        textSize:13
      }
    ];
    mcluster = new MarkerClusterer(map, gmarkers,{
      gridSize: 30,
      ignoreHidden:true,
      styles: clusterStyles,
      maxZoom: 14
    });
    mcluster.setIgnoreHidden(true);


    //zoom in action
    if(mapSearchBox.find('.zoom-in').length){
      google.maps.event.addDomListener(mapSearchBox.find('.zoom-in').get(0), 'click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var current= parseInt( map.getZoom(),10);
        current++;
        if(current>20){
          current=20;
        }
        map.setZoom(current);
      });

    }

    // zoom out action
    if(mapSearchBox.find('.zoom-out').length){
      google.maps.event.addDomListener(mapSearchBox.find('.zoom-out').get(0), 'click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var current= parseInt( map.getZoom(),10);
        current--;
        if(current<0){
          current=0;
        }
        map.setZoom(current);
      });

    }
  }
}

google.maps.event.addDomListener(window, 'load', search_initialize);

function mylocationCallback(pos){
  var shape = {
    coord: [1, 1, 1, 38, 38, 59, 59 , 1],
    type: 'poly'
  };
  if(map.getZoom() != 13){
    map.setZoom(13);
  }
  var myLocation =  new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
  map.setCenter(myLocation);
  var marker = new google.maps.Marker({
    position: myLocation,
    map: map,
    icon: 'images/icons/my-location.png',
    shape: shape,
    zIndex: 9999,
    infoWindowIndex : 9999,
    radius: 2000
  });

  //marker.setVisible(false); // hide the marker

  var circleOptions = {
    strokeColor: '#000',
    strokeOpacity: 0.3,
    strokeWeight: 1,
    fillColor: '#000',
    fillOpacity: 0.1,
    map: map,
    center: myLocation,
    radius: 2500
  };
  var cityCircle = new google.maps.Circle(circleOptions);

}
function mylocationError(){
  alert(nooGmapL10n.no_geolocation_pos);
}

$(document).on('click','.gmap-mylocation',function(e){
  e.stopPropagation();
  e.preventDefault();
  if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(mylocationCallback,mylocationError,{timeout:10000});
  }
  else{
    alert(nooGmapL10n.no_geolocation_msg);
  }
});

$(document).on('click','.gmap-full',function(e){
  e.stopPropagation();
  e.preventDefault();
  if($(this).closest('.noo-map').hasClass('fullscreen')){
    $(this).closest('.noo-map').removeClass('fullscreen');
    if($(window).width() <= 992) {
      $(this).closest('.noo-map').css({
        'margin-top' : '65px'
      });
    } else {
      $(this).closest('.noo-map').css({
        'margin-top' : '90px'
      });
    }
    $(".header-nav.menu-home4").show();
    $(this).empty().html('<i class="fa fa-expand"></i> '+nooGmapL10n.fullscreen_label);
  }else{
    $(this).closest('.noo-map').addClass('fullscreen');
    if($(window).width() <= 992) {
      $(this).closest('.noo-map').css({
        'margin-top' : '0px'
      });
    } else {
      $(this).closest('.noo-map').css({
        'margin-top' : '0px'
      });
    }
    $(".header-nav.menu-home4").hide();
    $(this).empty().html('<i class="fa fa-compress"></i> '+nooGmapL10n.default_label);
  }
  google.maps.event.trigger(map, "resize");
});

$(document).on('click','.gmap-prev',function(e){
  e.stopPropagation();
  e.preventDefault();
  gmarker_index -- ;
  if (gmarker_index < 1){
    gmarker_index = gmarkers.length;
  }
  while(gmarkers[gmarker_index - 1].visible === false){
    gmarker_index--;
    if (gmarker_index > gmarkers.length){
      gmarker_index = 1;
    }
  }

  if( map.getZoom() <14 ){
    map.setZoom(14);
  }
  google.maps.event.trigger(gmarkers[gmarker_index - 1], 'click');
});

$(document).on('click','.gmap-next',function(e){
  e.stopPropagation();
  e.preventDefault();
  gmarker_index ++;
  if (gmarker_index > gmarkers.length){
    gmarker_index = 1;
  }
  while(gmarkers[gmarker_index - 1].visible === false){
    gmarker_index++;
    if (gmarker_index > gmarkers.length){
      gmarker_index = 1;
    }
  }

  if( map.getZoom() < 14 ){
    map.setZoom(14);
  }
  google.maps.event.trigger(gmarkers[gmarker_index - 1], 'click');
});

function single_initialize(){
  var mapBox = $('.property-map-box'),
  searchMarker,
  latitude = mapBox.data('latitude'),
  longitude = mapBox.data('longitude');
  if(mapBox.length){

    var myPlace    = new google.maps.LatLng(latitude,longitude);
    var map = new google.maps.Map(mapBox.get(0), {
      flat:false,
      noClear:false,
      zoom: 14,
      scrollwheel: false,
      draggable: true,
      center: myPlace,
      streetViewControl:false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
      icon:  'images/icon/marker-icon.png',
      position: myPlace,
      map: map
    });
    var input = /** @type {HTMLInputElement} */(
      document.getElementById('property_map_search_input'));
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      var searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */(input));

        google.maps.event.addListener(searchBox, 'places_changed', function() {
          if(searchMarker != null)
          searchMarker.setMap(null);

          var geocoder = new google.maps.Geocoder();
          var getAddress = function(Latlng) {
            geocoder.geocode({'latLng': Latlng}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                  return results[0].formatted_address;
                }
              }
            });
          }
          var myAddress = getAddress(myPlace);
          console.log(myAddress)
          geocoder.geocode( {
            'address': input.value
          }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              searchMarker = new google.maps.Marker({
                position: results[0].geometry.location,
                map:map,
                draggable: false,
                animation: google.maps.Animation.DROP
              });
              var start = input.value;
              var end = myPlace;
              var directionsService = new google.maps.DirectionsService();
              var directionsDisplay = new google.maps.DirectionsRenderer();
              directionsDisplay.setMap(map);
              var request = {
                origin:start,
                destination:end,
                travelMode: google.maps.TravelMode.DRIVING
              };

              directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
                }
              });
            } else {
              alert("Geocode was not successful for the following reason: " + status);
            }
          });
        });
      }
      //$(".gmap-mylocation").trigger("click");
    }
    google.maps.event.addDomListener(window, 'load', single_initialize);
  })(jQuery);
