(function($){
  // очищаем select
  $.fn.clearSelect = function() {
	  return this.each(function(){
		  if(this.tagName=='SELECT') {
		      this.options.length = 0;
		      $(this).attr('disabled','disabled');
		  }
	  });
  }
  // заполняем select
  $.fn.fillSelect = function(dataArray) {
	  return this.clearSelect().each(function(){ 
		  if(this.tagName=='SELECT') {
			  var currentSelect = this;
			  $.each((dataArray),function(index,data){				  
//					currentSelect.add(data.text,data.value);
				//alert();
				  var option = new Option(data.text,data.value);				 
				  if($.support.cssFloat) {
					  currentSelect.add(option,null);
				  } else {
					  currentSelect.add(option);
				  }
			  });
		  }
	  });
  }
})(jQuery);