jQuery(document).ready(function(){"use strict";var e=!!bdaia.is_rtl;if(jQuery(document).on("click",".bdaia-post-read-down",function(e){return e.preventDefault(),jQuery("html, body").animate({scrollTop:jQuery(".bd_single_template_10 article").offset().top-jQuery("#wpadminbar").height()-jQuery(".fixed-enabled").height()},500),!1}),bdaia.click_to_comments&&(jQuery(".bdaia-load-comments-btn").fadeIn("fast"),jQuery("#comments.comments-container").hide(),jQuery("#respond.comment-respond").hide(),jQuery(".bdaia-load-comments-btn a").on("click",function(){jQuery(".bdaia-load-comments-btn").hide(),jQuery("#comments.comments-container").fadeIn("fast"),jQuery("#respond.comment-respond").fadeIn("fast")})),jQuery(".post-style10-cover").on("click",function(e){e.preventDefault(),jQuery(".post-style10-head .bdaia-post-featured-video").append(jQuery(".post-style10-head textarea.embed-code").val()).fitVids(),jQuery(".post-style10-head textarea.embed-code, .post-style10-cover").remove(),jQuery(".post-style10-head .post-style10-cover-bg .post-style10-cover").slideDown(1e3,function(){jQuery(this).css("height","100%")})}),jQuery(window).width()>900&&bdaia.is_singular&&bdaia.post_reading_position_indicator){var o=jQuery(".bd-content-wrap .post");o.length>0&&o.imagesLoaded(function(){var e=o.height(),t=jQuery(window).height();jQuery(window).scroll(function(){var n=0,i=o.offset().top,r=jQuery(window).scrollTop();r>i&&(n=100*(r-i)/(e-t)),jQuery("#reading-position-indicator").css("width",n+"%")})})}var t=jQuery("#bdCheckAlso"),n=jQuery(".bdCheckAlso-right"),i=jQuery("article.hentry");if(jQuery(window).width()>900&&bdaia.is_singular&&t.length>0){var r=i.offset().top+i.outerHeight()/2,a=!1;jQuery(window).width()<=1120?t.hide():t.show(),jQuery(window).resize(function(){jQuery(window).width()<=1120?t.hide():t.show()}),jQuery(window).scroll(function(){a||(jQuery(window).scrollTop()>r?(n.length,t.addClass("bdCheckAlsoShow")):jQuery(window).scrollTop()<=r&&(n.length,t.removeClass("bdCheckAlsoShow")))}),jQuery("#check-also-close").on("click",function(){return t.removeClass("bdCheckAlsoShow"),a=!0,!1})}jQuery(document).on("click",".post-like a",function(e){var o=jQuery(this),t=o.data("post_id");return jQuery.ajax({type:"post",url:ajaxurl,data:"action=kolyoum_post_like&nonce="+bdaia.nonce+"&bdaia_post_like=&post_id="+t,success:function(e){"already"!=e&&(o.addClass("voted"),o.siblings(".count").text(e))}}),!1})});