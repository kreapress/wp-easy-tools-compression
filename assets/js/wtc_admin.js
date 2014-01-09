var compress_interval;
var restore_interval;
var wtc_media_interval;

jQuery(function() {
  jQuery( "#wtc_tabs" ).tabs();  
  jQuery( "#wtc_tabs" ).tabs({ active: jQuery("#current_tab").val() });  
});

jQuery(document).ready(function() {
	$ = jQuery.noConflict();
		
	$("#wtc_tabs").tabs({
      activate: function (e, ui) {
        currentTabIndex =ui.newTab.index().toString();
        $("#current_tab").val(currentTabIndex);
      }
    });
	
	$("#frm_wtc_provider").submit(function( event ) {
        event.preventDefault();
        wtc_form_submit('frm_wtc_provider');  
    });    
        
    $("#frm_wtc_compress").submit(function( event ) {
        event.preventDefault();
        wtc_form_submit('frm_wtc_compress');  
    });    
    
    //if( $('#wtc_list_file').is(':visible') ) {	        
    	if ( $("#current_folder").val()!=""){
    	    wtc_form_list('wtc_list_file',"folder="+ $("#current_folder").val() );  	
    	} else {
    		wtc_form_list('wtc_list_file');  
    	}        
    //}
    
    $( ".wtc_directory" ).live( "click", function() {
    	$("#wtc_chek_all_parent").attr("checked",false);
    	$("#current_folder").val( $(this).attr('rel') );
    	wtc_form_list('wtc_list_file', "folder="+$(this).attr('rel') );
    });
    
    $( "#wtc_chek_all_parent" ).live( "click", function() {
        var c=$(this).attr("checked");
        if (typeof(c) == 'undefined' || c == null){
        	$(".wtc_chek_all_child").attr("checked",false);        	
        } else {
        	$(".wtc_chek_all_child").attr("checked",true);        	
        }        
        
        var chk = $('.wtc_chek_all_child:checked').length;
    	if (chk<=0){
    		wtc_toogle('wtc_compress_img',true,'Compress Image');
    	} else {
    		wtc_toogle('wtc_compress_img',false,'Compress Image');
    	}    	
    });
    
    $( ".wtc_chek_all_child" ).live( "click", function() {
    	var chk = $('.wtc_chek_all_child:checked').length;
    	if (chk<=0){
    		wtc_toogle('wtc_compress_img',true,'Compress Image');
    	} else {
    		wtc_toogle('wtc_compress_img',false,'Compress Image');
    	}    	
    });
    
    $( "#wtc_compress_img" ).live( "click", function() {
    	if ( $( ".wtc_chek_all_child" ).length <=0 ){
    		alert('No image is available to compress!');
    		return;
    	}    	
    	//setInterval(compress_image,10000);
    	compress_image();
    	compress_interval=setInterval(compress_image,2000);
    });
        
    $( "#wtc_restore_all_parent" ).live( "click", function() {
    	var c=$(this).attr("checked");
    	if (typeof(c) == 'undefined' || c == null){
        	$(".wtc_restore_chek_child").attr("checked",false);        	
        } else {
        	$(".wtc_restore_chek_child").attr("checked",true);        	
        }                
        var chk = $('.wtc_restore_chek_child:checked').length;
    	if (chk<=0){
    		wtc_toogle('wtc_restore_img',true,'Restore Image');
    	} else {  
    		wtc_toogle('wtc_restore_img',false,'Restore Image');
    	}    	
    });
    $( ".wtc_restore_chek_child" ).live( "click", function() {
    	var chk = $('.wtc_restore_chek_child:checked').length;
    	if (chk<=0){
    		wtc_toogle('wtc_restore_img',true,'Restore Image');
    	} else {
    		wtc_toogle('wtc_restore_img',false,'Restore Image');
    	}    	
    });
    
    $( "#wtc_restore_img" ).live( "click", function() {
    	if ( $( ".wtc_restore_chek_child" ).length <=0 ){
    		alert('No image is available to compress!');
    		return;
    	}    	       
    	restore_image();
    	restore_interval=setInterval(restore_image,2000); 	
    });
        
    /*MEDIA IMAGE STARTS HERE*/    
    
    wtc_media_list('wtc_media_list');      
    $( "#wtc_compress_all" ).live( "click", function() {
        var c=$(this).attr("checked");
        if (typeof(c) == 'undefined' || c == null){
        	$(".wtc_media_images").attr("checked",false);        	
        } else {
        	$(".wtc_media_images").attr("checked",true);        	
        }                
        var chk = $('.wtc_media_images:checked').length;
    	if (chk<=0){
    		$("#compress_btn").attr("disabled",true);
    	} else {
    		$("#compress_btn").attr("disabled",false);
    	}    	
    });
    $( ".wtc_media_images" ).live( "click", function() {
    	var chk = $('.wtc_media_images:checked').length;
    	if (chk<=0){
    		$("#compress_btn").attr("disabled",true);
    	} else {
    		$("#compress_btn").attr("disabled",false);
    	}    
    });
    $( "#compress_btn" ).live( "click", function() {
    	if ( $( ".wtc_media_images" ).length <=0 ){
    		alert('No image is available to compress!');
    		return;
    	}    	       
    	wtc_process_media('compress_btn','wtc_media_images','compress_single_image'); 
    	wtc_media_interval=setInterval("wtc_process_media('compress_btn','wtc_media_images','compress_single_image')",2000); 	
    });
    
    /*RESTORE*/
    $( "#wtc_restore_all" ).live( "click", function() {
        var c=$(this).attr("checked");
        if (typeof(c) == 'undefined' || c == null){
        	$(".wtc_media_images_restore").attr("checked",false);        	
        } else {
        	$(".wtc_media_images_restore").attr("checked",true);        	
        }                
        var chk = $('.wtc_media_images_restore:checked').length;
    	if (chk<=0){
    		$("#restore_btn").attr("disabled",true);
    	} else {
    		$("#restore_btn").attr("disabled",false);
    	}    	
    });
    $( ".wtc_media_images_restore" ).live( "click", function() {
    	var chk = $('.wtc_media_images_restore:checked').length;
    	if (chk<=0){
    		$("#restore_btn").attr("disabled",true);
    	} else {
    		$("#restore_btn").attr("disabled",false);
    	}    
    });
    $( "#restore_btn" ).live( "click", function() {
    	if ( $( ".wtc_media_images_restore" ).length <=0 ){
    		alert('No image is available to compress!');
    		return;
    	}    	       
    	wtc_process_media('restore_btn','wtc_media_images_restore','restore_single_image'); 
    	wtc_media_interval=setInterval("wtc_process_media('restore_btn','wtc_media_images_restore','restore_single_image')",2000); 	
    });
    
    /*MEDIA IMAGE ENDS HERE*/
    
    /* SETTINGS HTML */
    $( "#wtc_compress_js" ).live( "click", function() {
    	var c=$(this).attr("checked");
    	if (typeof(c) == 'undefined' || c == null){        	
        } else {
        	$("#wtc_compress_html").attr("checked",true);        	
        }                
    });
    $( "#wtc_compress_css" ).live( "click", function() {
    	var c=$(this).attr("checked");    	
    	if (typeof(c) == 'undefined' || c == null){        	
        } else {
        	$("#wtc_compress_html").attr("checked",true);        	
        }                
    });
    $( "#wtc_compress_html" ).live( "click", function() {
    	var c=$(this).attr("checked");    	
    	if (typeof(c) == 'undefined' || c == null){        	
    		$("#wtc_compress_js").attr("checked",false); 
    		$("#wtc_compress_css").attr("checked",false); 
        } else {        	
        }                
    });
    
    $("#frm_wtc_compress_main_css").submit(function( event ) {
        event.preventDefault();
        wtc_form_submit('frm_wtc_compress_main_css');  
    });    
    /* END SETTINGS HTML */
    
    //wtc_media
    $( ".wtc_media" ).live( "click", function() {    	
    	wtc_media( $(this).attr("rev"), $(this).attr("id") ); 	
    });
    $( ".wtc_media_restore" ).live( "click", function() {    	
    	var ans=confirm("Are you sure?");
    	if (ans){
    	    wtc_media_restore( $(this).attr("rev"), $(this).attr("id") ); 		
    	}    	
    });
    	
}); /*END DOCU*/

function wtc_busy(e)
{
    if (e) {
        $('body').css('cursor', 'wait');	
    } else $('body').css('cursor', 'auto');    
    /*if (e){
    	$.fancybox.showLoading();
    } else $.fancybox.hideLoading();*/
}

function wtc_scroll(id){
   if( $('#'+id).is(':visible') ) {	
      $('html,body').animate({scrollTop: $("#"+id).offset().top-100},'slow');
   }
}

function wtc_rm_notices()
{
	$(".wtc_success").remove();		
    $(".wtc_error").remove();    
}

function wtc_toogle(id , bool , caption)
{
    $('#'+id).attr("disabled", bool );
    $("#"+id).val(caption);
}

function addslashes (str){
   return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function wtc_form_submit(form_id)
{
	wtc_rm_notices();
    wtc_busy(true);     
    var btn=$('#'+form_id+' input[type="submit"]');    
    var btn_cap=btn.val();
    btn.attr("disabled", true );
    btn.val("processing.");
	var params=$("#"+form_id).serialize();
	params+="&action=wtc_ajax_admin";
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){ 
        	wtc_busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	if (data.code==1){       
        		$("#"+form_id).before("<div class=\"wtc_success\">"+data.msg+"</div>");        		        		
        	} else {      
        		$("#"+form_id).before("<div class=\"wtc_error\">"+data.msg+"</div>");
        	}        	
        	wtc_scroll(form_id);
        }, 
        error: function(){	        	
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	wtc_busy(false);
        	$("#"+form_id).before("<div class=\"wtc_error\">ERROR:</div>");
        	wtc_scroll(form_id);
        }		
    });
}

function wtc_form_list(form_id,param)
{
	wtc_rm_notices();
    wtc_busy(true);     
    var btn=$('#'+form_id+' input[type="submit"]');    
    var btn_cap=btn.val();
    btn.attr("disabled", true );
    btn.val("processing.");
	var params=$("#"+form_id).serialize()+"&"+param;
	params+="&action=wtc_ajax_admin";
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){ 
        	wtc_busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	if (data.code==1){    
        		if (typeof(param) == 'undefined' || param == null){
        			$("#wtc_list_file_table tr:last").after(data.msg);	
        		} else {
        			$("#wtc_list_file_table tr.wtc_data").remove();
        		    $("#wtc_list_file_table tr:last").after(data.msg);	
        		}        		
        		
        		wtc_toogle('wtc_compress_img',true,btn_cap);
        		wtc_toogle('wtc_restore_img',true,'Restore Image');
        		
        	} else {      
        		$("#"+form_id).before("<div class=\"wtc_error\">"+data.msg+"</div>");
        	}        	
        	wtc_scroll(form_id);
        }, 
        error: function(){	        	
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	wtc_busy(false);
        	$("#"+form_id).before("<div class=\"wtc_error\">ERROR:</div>");
        	wtc_scroll(form_id);
        }		
    });
}

function compress_image()
{
	/*var check_image=$(".wtc_chek_all_child:first").attr("checked",true);
	console.debug( check_image.val() );
	check_image.attr("checked",false);*/	
	//console.debug('running');
	$("#wtc_compress_img").attr("disabled",true);
	$( ".wtc_chek_all_child" ).each(function( index ) {         
         if ( $(this).attr("checked") ){         	          	
         	//compress_single_image( $( this ).val(), $(this).parent().prev('td') );         	
         	$('html,body').animate({scrollTop: $(this).offset().top-100},'slow');         	
         	compress_single_image( $( this ).val(), $(this).parent('td') );           	
         	$(this).attr("checked",false);         	
         	return false;
         } 
    });
    check_compress_image_finish();
}

function check_compress_image_finish()
{
    var chk = $('.wtc_chek_all_child:checked').length;
    if (chk<=0){
    	//console.debug('stop');    	
    	clearInterval(compress_interval);    	
    	$("#wtc_compress_img").attr("disabled",true);
    }
}

function compress_single_image(file_path,index)
{			 
	 //$("#wtc_list_file_table .index"+index).html("<div class=\"wtc_loading\"></div>");
	 index.html("<div class=\"wtc_loading\"></div>");
	 var params="&action=wtc_ajax_admin&do=compress_single_image";
	 params+="&file_path="+file_path;
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){
        	if (data.code==1){
        	    //$("#wtc_list_file_table .index"+index).html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	    index.html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	} else {
        		//$("#wtc_list_file_table .index"+index).html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");	
        		index.html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");        		
        	}        	
        }, 
        error: function(){	        	        	
        }		
    });
}


function restore_image()
{
	//console.debug('running');
	$("#wtc_restore_img").attr("disabled",true);
	$( ".wtc_restore_chek_child" ).each(function( index ) {         
         if ( $(this).attr("checked") ){   
         	$('html,body').animate({scrollTop: $(this).offset().top-100},'slow');        	          	
         	restore_single_image( $( this ).val(), $(this).parent("td") );
         	$(this).attr("checked",false);         	
         	return false;
         } 
    });
    check_restore_finish();
}

function restore_single_image(file_path,index)
{
	 index.html("<div class=\"wtc_loading\"></div>");
	 var params="&action=wtc_ajax_admin&do=restore_single_image";
	 params+="&file_path="+file_path;
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){
        	if (data.code==1){        	    
        	    index.html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	} else {        		
        		index.html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");        		
        	}        	
        }, 
        error: function(){	        	        	
        	index.html("<div class=\"wtc_error wtc_small\">ERROR</div>");        		
        }		
    });
}

function check_restore_finish()
{
    var chk = $('.wtc_restore_chek_child:checked').length;
    if (chk<=0){
    	//console.debug('stop');    	
    	clearInterval(restore_interval);  
    	$("#wtc_restore_img").attr("disabled",true);
    }
}

/* MEDIA */

function wtc_media_list(form_id,param)
{
    wtc_rm_notices();
    wtc_busy(true);     
    var btn=$('#'+form_id+' input[type="submit"]');    
    var btn_cap=btn.val();
    btn.attr("disabled", true );
    btn.val("processing.");
	var params=$("#"+form_id).serialize()+"&"+param;
	params+="&action=wtc_ajax_admin";
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){ 
        	wtc_busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	if (data.code==1){    
        		if (typeof(param) == 'undefined' || param == null){
        			$("#wtc_media_list_table tr:last").after(data.msg);	
        		} else {
        			$("#wtc_media_list_table tr.wtc_data").remove();
        		    $("#wtc_media_list_table tr:last").after(data.msg);	
        		}        		
        		        		        		
        	} else {      
        		$("#"+form_id).before("<div class=\"wtc_error\">"+data.msg+"</div>");
        	}        	
        	
        	$("#"+form_id).find("#compress_btn").attr("disabled",true);
            $("#"+form_id).find("#restore_btn").attr("disabled",true);
            $("#"+form_id).find("#restore_btn").val('Restore Image');
        	wtc_scroll(form_id);
        }, 
        error: function(){	        	
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	wtc_busy(false);
        	$("#"+form_id).before("<div class=\"wtc_error\">ERROR:</div>");
        	wtc_scroll(form_id);
        }		
    });
}


function wtc_process_media(btn_id,checkbox_id,dos)
{	
	//console.debug('running');
	$("#"+btn_id).attr("disabled",true);
	$( "."+checkbox_id ).each(function( index ) {         
         if ( $(this).attr("checked") ){         	     
         	$('html,body').animate({scrollTop: $(this).offset().top-100},'slow');          	         	
         	compress_media_image( $( this ).val(), $(this).parent('td') , dos , $(this).attr("id") );         	
         	$(this).attr("checked",false);         	
         	return false;
         } 
    });
    check_compress_media_finish(btn_id,checkbox_id);
}

function check_compress_media_finish(btn_id,checkbox_id)
{
	var chk = $('.'+checkbox_id+':checked').length;
    if (chk<=0){
    	//console.debug('stop');    	
    	clearInterval(wtc_media_interval);  
    	$("#"+btn_id).attr("disabled",true);
    }
}

function compress_media_image(file_path,index,dos,img_id)
{			 	 
	 index.html("<div class=\"wtc_loading\"></div>");
	 var params="&action=wtc_ajax_admin&do="+dos;
	 params+="&file_path="+file_path+"&img_id="+img_id;
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){
        	if (data.code==1){        	    
        	    index.html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	} else {        		
        		index.html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");        		
        	}        	
        }, 
        error: function(){	        	        	
        	index.html("<div class=\"wtc_error wtc_small\">ERROR</div>");  
        }		
    });
}

function wtc_media(file_path, div_id)
{
	wtc_busy(true);  
	var params="&action=wtc_ajax_admin&do=compress_single_image&file_path="+file_path+"&img_id="+div_id;
	
	$("#"+div_id).html("<div class=\"wtc_loading\"></div>");
		
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){ 
        	wtc_busy(false);
        	if (data.code==1){        	    
        	    $("#"+div_id).html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	} else {        		
        		$("#"+div_id).html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");        		
        	}  
        }, 
        error: function(){	        	        	
        	wtc_busy(false);        	
        	$("#"+div_id).before("<div class=\"wtc_error\">ERROR:</div>");
        	wtc_scroll(form_id);
        }		
    });
}

function wtc_media_restore(file_path, div_id)
{
	wtc_busy(true);  
	var params="&action=wtc_ajax_admin&do=restore_single_image&file_path="+file_path+"&img_id="+div_id;
	
	$("#"+div_id).html("<div class=\"wtc_loading\"></div>");
			
	 $.ajax({    
        type: "POST",
        url: ajaxurl,
        data: params,
        dataType: 'json',        
        success: function(data){ 
        	wtc_busy(false);
        	if (data.code==1){        	    
        	    $("#"+div_id).html("<div class=\"wtc_success wtc_small\">"+data.msg+"</div>");	
        	} else {        		
        		$("#"+div_id).html("<div class=\"wtc_error wtc_small\">"+data.msg+"</div>");        		
        	}  
        }, 
        error: function(){	        	        	
        	wtc_busy(false);        	
        	$("#"+div_id).before("<div class=\"wtc_error\">ERROR:</div>");
        	wtc_scroll(form_id);
        }		
    });	
}