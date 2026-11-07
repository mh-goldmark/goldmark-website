/*********************************************************
* Copyright © 2023 Engr. Dom Sahagun. All rights reserved.
*********************************************************/

$(function(){

  'use strict'

  var $host   = window.location.host;
  var $path   = "/" // Change this to the path relative to your domain or host (www.yourdomian.com)

  $(document).on('contextmenu', function(event) {
    //event.preventDefault();
  });

  // $('body').bind("copy",function(event) {
  //   event.preventDefault();
  // });
  //
  // $(window).on('keydown',function(event) {
  //   if(event.keyCode==123) {
  //     return false;
  //   } else if(event.ctrlKey && event.shiftKey && event.keyCode==73) {
  //     return false;  //Prevent from ctrl+shift+i
  //   } else if(event.ctrlKey && event.keyCode==73) {
  //     return false;  //Prevent from ctrl+shift+i
  //   }
  // });

  function getCookie(name) {
		var re = new RegExp(name + "=([^;]+)");
		var value = re.exec(document.cookie);
		return (value != null) ? unescape(value[1]) : null;
	}

  /* ------- Smooth scroll ------- */
  $("a.pagescroll").on("click", function (event) {
    event.preventDefault();
    $("html,body").animate({
      scrollTop: $(this.hash).offset().top - 100
    }, 300);
  });

  // Toggle Sharer
  $(".sharer-btn").click(function(event) {
    event.preventDefault();
    $(".sharing-option-buttons").slideToggle("fast","swing");
  });

  $(document).mouseup(function(e) {
    var $sharer = $(".sharer-btn");
    if(!$sharer.is(e.target) 					      // if the target of the click isn't the container...
    && $sharer.has(e.target).length === 0) { // if the target container is visible
      $(".sharing-option-buttons").fadeOut("slow");
    }
  });

  $(document).on('click','.copy-link',function (e) {
     e.preventDefault();
     var copyText = $(this).attr('href');
     document.addEventListener('copy', function(e) {
        e.clipboardData.setData('text/plain', copyText);
        e.preventDefault();
     }, true);
     document.execCommand('copy');
   });

   $("form[name=advSearch]").on("change","select",function() {
     if($(this).val() != '') {
       $(this).parent().find('button[type=button]').css({
         "border-bottom-color" : "#eeb81d"
       });
     } else {
       $(this).parent().find('button[type=button]').css({
         "border-bottom-color" : "#fff"
       });
     }
   });

  // Registration Form
  $("form[name=registerForm] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=registerForm]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Processing');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.registration.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your request successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Subscribe');
        $row.find("input.required").css({
          'border-color' : '#FFF'
        });
			}
		});
		execute_captcha();
  });

  // Request Call-Back
  $("form[name=requestCallBack] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent().parent().parent().parent();
    var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=requestCallBack]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending request');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.callback.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
        document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

        document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your request successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Send Request <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#DDDDDD'
        });
			}
		});
		execute_captcha();
  });

  $("body").on("click",".email-agent",function() {
    var $refno      = $(this).data("refno");
    var $user       = $(this).data("user");
    var $agent      = $(this).data("agent");
    var $source     = $(this).data("source");
    var $sub_source = $(this).data("subsource");
    var $title      = $(this).data("title");

    $("#contactAgentToggleLabel").html('<span class="flaticon-email"></span> '+$agent);
    $("form[name=contactAgent]").find("input[name=refno]").val($refno);
    $("form[name=contactAgent]").find("input[name=user]").val($user);
    $("form[name=contactAgent]").find("input[name=source]").val($source);
    $("form[name=contactAgent]").find("input[name=sub_source]").val($sub_source);
    if($refno != '') {
      $("form[name=contactAgent]").find("textarea[name=message]").html('Hello '+$agent+', I found this property '+$title+' [Refno: '+$refno+'] on Gold Mark Real Estate website and I\'m interested in learning more. Please contact me at your earliest convenience. Thank you!');
    } else if($user != '') {
      $("form[name=contactAgent]").find("textarea[name=message]").html('Hello '+$agent+', I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!');
    } else {
      $("form[name=contactAgent]").find("textarea[name=message]").html('Hello Gold Mark, I found this project '+$title+' on Gold Mark Real Estate website and I\'m interested in learning more. Please contact me at your earliest convenience. Thank you!');
    }
  });

  // Agent Form
  $("form[name=contactAgent] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent().parent().parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required, textarea.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=contactAgent]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending inquiry');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.inquiry.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your inquiry successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Inquire Now <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#DDDDDD'
        });
        $row.find("textarea.required").css({
          'border-color' : '#DDDDDD'
        });

        $('#contactAgentToggle').modal('hide');
			}
		});
		execute_captcha();
  });

  $("body").on("click",".download-brochure",function() {
    var $refno      = $(this).data("refno");
    var $source     = $(this).data("source");
    var $sub_source = $(this).data("subsource");

    $("form[name=downloadBrochure]").find("input[name=refno]").val($refno);
    $("form[name=downloadBrochure]").find("input[name=source]").val($source);
    $("form[name=downloadBrochure]").find("input[name=sub_source]").val($sub_source);
  });

  // Download Brochure
  $("form[name=downloadBrochure] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent().parent().parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=downloadBrochure]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending request');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.brochure.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your request successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Send Request <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#DDDDDD'
        });

        $('#downloadToggle').modal('hide');
			}
		});
		execute_captcha();
  });

  // General Inquiry
  $("form[name=inquiryForm] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required, textarea.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-bottom-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=inquiryForm]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending inquiry');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.contact.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your inquiry successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Inquire Now <i class="fal fa-arrow-right-long"></i>');
        $row.find("textarea[name=message]").text('');
        $row.find("input.required").css({
          'border-bottom-color' : '#ccc'
        });
        $row.find("textarea.required").css({
          'border-bottom-color' : '#ccc'
        });
			}
		});
		execute_captcha();
  });

  // Register Interest
  $("form[name=registerInterest] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent().parent().parent().parent();
    var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=registerInterest]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending request');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.interest.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
        document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

        document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your registration successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your registration cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Register Now <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#DDDDDD'
        });
			}
		});
		execute_captcha();
  });

  // External Request
  $("form[name=requestForm] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required, textarea.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-bottom-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=requestForm]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending inquiry');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.request.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your inquiry successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Submit Inquiry <i class="fal fa-arrow-right-long"></i>');
        $row.find("textarea[name=message]").text('');
        $row.find("input.required").css({
          'border-bottom-color' : '#ccc'
        });
        $row.find("textarea.required").css({
          'border-bottom-color' : '#ccc'
        });
			}
		});
		execute_captcha();
  });

  // Career Application
  $("form[name=careerForm] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required, textarea.required, select.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-bottom-color' : '#CA211B'
					});
          $(this).parent().find("button.dropdown-toggle").css({
            'border-bottom-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=careerForm]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending application');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.application.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your application successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 3) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $row.find("input[type=file]").css({
            'border-bottom-color' : '#CA211B'
					});
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Attachment must not exceed 5MB.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 4) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $row.find("input[type=file]").css({
            'border-bottom-color' : '#CA211B'
					});
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Invalid attachment type, preferably PDF file only.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Submit Application <i class="fal fa-arrow-right-long"></i>');
        $row.find("input[type=file]").val('');
        // if($row.find("input[name=vacancy]").val('')) {
        //   $row.find("input[name=vacancy]").niceSelect();
        // }
        $row.find('select[name=vacancy]').val('');
        $row.find('select[name=vacancy').selectpicker('update');
        $row.find("input.required").css({
          'border-bottom-color' : '#ccc'
        });
			}
		});
		execute_captcha();
  });

  // Submit Property
  $("form[name=propertyForm] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent();
		var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=propertyForm]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending property');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.property.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
				document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

				document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your property successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 3) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $row.find("input[type=file]").css({
            'border-color' : '#CA211B'
					});
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Documents must not exceed 3 files.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 4) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $row.find("input[type=file]").css({
            'border-color' : '#CA211B'
					});
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Documents must not exceed 10MB.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 5) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $row.find("input[type=file]").css({
            'border-color' : '#CA211B'
					});
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Invalid documents type, preferably PDF file only.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Submit Property <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#ccc'
        });
			}
		});
		execute_captcha();
  });

  $("body").on("click",".service-call",function() {
    var $source     = $(this).data("source");
    var $sub_source = $(this).data("subsource");
    var $title      = $(this).data("title");

    $("form[name=scheduleCall]").find("input[name=subject]").val($title);
    $("form[name=scheduleCall]").find("input[name=source]").val($source);
    $("form[name=scheduleCall]").find("input[name=sub_source]").val($sub_source);
  });

  // Schedule a Call-Back
  $("form[name=scheduleCall] button[type=submit]").click(function(event) {
    event.preventDefault();
    var $row      = $(this).parent().parent().parent().parent();
    var $name 	  = $row.find("input[name=name]").val();
		var $email 	  = $row.find("input[name=email]").val();
		var $phone 	  = $row.find("input[name=phone]").val();
    var $empty    = 0;

    // Validate mandatory fields
    $row.find("input.required").each(function() {
      if(!$.trim($(this).val()) && $(this).val() != '.') {
        $empty++;
      }
    });

		if($empty){
			$row.find(".required").each(function() {
        if($(this).val() == '') {
					$(this).css({
            'border-color' : '#CA211B'
					});
				}
			});
			return;
		}

    var $dataString = new FormData($("form[name=scheduleCall]")[0]);

		$(this).attr('disabled','disabled');
		$(this).html('<i class="fas fa-spinner fa-pulse"></i> Sending request');

		$.ajax({
			type		   : 'POST',
			dataType	 : 'html',
			url			   : 'process/process.callschedule.php',
      data		   : $dataString,
			contentType: false,
			processData: false,
			success		 : function(result){
        document.cookie = "name=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "email=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;
				document.cookie = "phone=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path="+$path;

				var $twelvehours = 1000 * 60 * 60 * 12;
				var $expires 	   = new Date((new Date()).valueOf() + $twelvehours);

        document.cookie = "name="+$name+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "email="+$email+";expires="+$expires.toUTCString()+";path="+$path;
				document.cookie = "phone="+$phone+";expires="+$expires.toUTCString()+";path="+$path;

        if(result == 1) {
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-check'></i> SUCCESS",
            text				      : "Your request successfully submitted!",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#219519",
            confirmButtonText	: "<i class='fas fa-check'></i> OK",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        } else if(result == 2) {
          $row.find("button[type=submit]").removeAttr("disabled");
          $("body").addClass("swal2-active");
          swal({
            title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
            text				      : "Your request cannot be authenticated.",
            customClass       : "sweet-alert2-custom",
            confirmButtonColor: "#2185d0",
            confirmButtonText	: "<i class='fas fa-long-arrow-left'></i> Back",
            allowOutsideClick : false,
            onClose           : function() {
              $("body").removeClass("swal2-active");
            }
          }).catch(swal.noop);
        }

        $row.find("button[type=submit]").html('Send Request <i class="fal fa-arrow-right-long"></i>');
        $row.find("input.required").css({
          'border-color' : '#DDDDDD'
        });
			}
		});
		execute_captcha();
  });

  $("form.white-borders").find("input.required, textarea.required, select.required").change(function() {
    if($(this).val() != "") {
      $(this).css({
        "border-color" : "#FFF",
      });
    } else {
      $(this).css({
        "border-color" : "#CA211B",
      });
    }
  });
  $("form.gray-borders").find("input.required, textarea.required, select.required").change(function() {
    if($(this).val() != "") {
      $(this).css({
        "border-color" : "#DDDDDD",
      });
    } else {
      $(this).css({
        "border-color" : "#CA211B",
      });
    }
  });
  $("form.transparent-borders").find("input.required, textarea.required, select.required").change(function() {
    if($(this).val() != "") {
      $(this).css({
        "border-bottom-color" : "#ccc",
      });
      $(this).parent().find("button.dropdown-toggle").css({
        "border-bottom-color" : "#ccc",
      });
    } else {
      $(this).css({
        "border-bottom-color" : "#CA211B",
      });
      $(this).parent().find("button.dropdown-toggle").css({
        "border-bottom-color" : "#CA211B",
      });
    }
  });

  $("body").on("click", ".slider-search", function (event) {
    event.preventDefault();
    $(".side-search").addClass("side-search-active");
  }), $("#btn_sideSearchClose").on("click", function (event) {
    event.preventDefault();
    $(".side-search").removeClass("side-search-active");
  });

  $("form[name=advSearch]").on("change", "select[name=category]", function(event) {
    event.preventDefault();
    var $category = $(this).val();
    if($category == 'Commercial') {
      $(".search-bedroom").fadeOut();
      $("form[name=advSearch]").find("select[name=minbed]").attr("disabled","disabled");
      $("form[name=advSearch]").find("select[name=maxbed]").attr("disabled","disabled");
      $("form[name=advSearch]").find(".selectpicker.bedroom").selectpicker();
    } else if($category == 'Residential') {
      $(".search-bedroom").fadeIn();
      $("form[name=advSearch]").find("select[name=minbed]").removeAttr("disabled");
      $("form[name=advSearch]").find("select[name=maxbed]").removeAttr("disabled");
      $("form[name=advSearch]").find(".selectpicker.bedroom").selectpicker();
    }
    $.ajax({
      type	      : "POST",
      dataType    : "html",
      url         : "ajax/property.types.php",
      data        :   {
        category : $category
      },
      success:function(html){
        $("form[name=advSearch]").find(".search-property-type").html(html);
        $("form[name=advSearch]").find(".selectpicker.proptype").selectpicker();
      }
    });
  });

  $("form[name=advSearch]").on("change", ".min-max", function(event) {
    event.preventDefault();
    if($(this).val() != '') {
      var $value 	= parseInt($(this).val().replace(/,/g,''));
      var $type 	= $(this).data("type");
      var $range 	= $(this).data("range");
      if($range == "Min") {
        if($type == "Size") {
          if($("input[name=maxsize]").val() != '') {
            var $max = parseInt($("input[name=maxsize]").val().replace(/,/g,''));
            if($value >= $max) {
              $("input[name=minsize]").val('')
            }
          }
        } else if($type == "Price") {
          if($("input[name=maxprice]").val() != '') {
            var $max = parseInt($("input[name=maxprice]").val().replace(/,/g,''));
            if($value >= $max) {
              $("input[name=minprice]").val('')
            }
          }
        }
      } else if($range == "Max") {
        if($type == "Size") {
          if($("input[name=minsize]").val() != '') {
            var $min = parseInt($("input[name=minsize]").val().replace(/,/g,''));
            if($value <= $min) {
              $("input[name=maxsize]").val('')
            }
          }
        } else if($type == "Price") {
          if($("input[name=minprice]").val() != '') {
            var $min = parseInt($("input[name=minprice]").val().replace(/,/g,''));
            if($value <= $min) {
              $("input[name=maxprice]").val('')
            }
          }
        }
      }
    }
  });

  $("form[name=advSearch]").on("change", "select[name=minbed]", function(event) {
    event.preventDefault();
    var $val 			= parseInt($(this).val());
    var $options 	= $('select[name=maxbed] option');
    $options.each(function() {
      if($(this).val() != '') {
        var $value = parseInt($(this).val());
        if($value <= $val){
          $(this).attr('disabled','disabled');
        } else {
          $(this).removeAttr('disabled');
        }
      }
    });
    $('select[name=maxbed]').val('');
    $('select[name=maxbed]').selectpicker('update');
  });

  if($('.caption-link-carousel').length) {
    var myCarousel = $('.caption-link-carousel');
    var singleItem = '.slider-slide-item';
    // dynamic count for carousel
    myCarousel.owlCarousel({
      loop: false,
      items: 1,
      margin: 0,
      dots: true,
      nav: false,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      smartSpeed: 1000,
      autoplay: false,
      autoplayHoverPause: true
    });
    // making caption to owl dots
    var captionCount = myCarousel.find('.owl-dot').length;
    for(var i = 0; i < captionCount; i++) {
      var newIdx = i + 1;
      var itemCaption = myCarousel.find(singleItem).eq(i).data('caption');
      myCarousel.find('.owl-dot').eq(i).find('span').html(itemCaption+'<sup>'+newIdx+'</sup>');
    }
    $(".owl-dots").addClass("container");

    $(".caption-link-carousel").on("mouseenter",".owl-dots button", function(event) {
      event.preventDefault();
      $(this).trigger("click");
    });
  }

  // Number comma
  $("body").on("keyup", ".number-comma", function(event, args) {
    if(event.which >= 37 && event.which <= 40) {
      event.preventDefault();
    }
    var position	       = args ? args.position : this.selectionStart;
    var part 			       = $(this).val().split(".");
    var parts 		       = part[0];
    var commaCountBefore = parts.match(/,/g) ? parts.match(/,/g).length : 0;
    var num 				     = parts.replace(/[^0-9]/g, '');
    var result 				   = part.length == 1 ? num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") : num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +"."+ part[1].replace(/[^0-9.]/g,"");
    $(this).val(result);
    var commaCountAfter = $(this).val().match(/,/g) ? $(this).val().match(/,/g).length : 0;
    var position 				= position + (commaCountAfter - commaCountBefore);
    this.setSelectionRange(position, position);
  });

  // Validate email address
  $(document).on("change", "input[name=email]",function(){
    var $email   = $(this).val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(!emailReg.test($email)){
      $("body").addClass("swal2-active");
      swal({
        title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
        text				      : "Invalid email format.",
        customClass       : "sweet-alert2-custom",
        confirmButtonText : "<i class='fa fa-long-arrow-left'></i> Go Back",
        confirmButtonColor: "#2185d0",
        allowOutsideClick : false,
        onClose           : function() {
          $("body").removeClass("swal2-active");
        }
      }).catch(swal.noop);
      $(this).val("");
      return;
    }
  });

  // Validate phone numbers
  $(document).on("change", "input[name=phone]",function(){
    var $phone   = $(this).val();
    var phoneReg = /^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm;
    if(!phoneReg.test($phone)){
      $("body").addClass("swal2-active");
      swal({
        title				      : "<i class='fa fa-exclamation-triangle'></i> ATTENTION",
        text				      : "Invalid telephone number format.",
        customClass       : "sweet-alert2-custom",
        confirmButtonText : "<i class='fa fa-long-arrow-left'></i> Go Back",
        confirmButtonColor: "#2185d0",
        allowOutsideClick : false,
        onClose           : function() {
          $("body").removeClass("swal2-active");
        }
      }).catch(swal.noop);
      $(this).val("");
      return;
    }
  });
});
